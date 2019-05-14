<?php

/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/3/17
 * Time: 11:27 AM
 */

namespace App\Http\Modules\Admin\Members\Controllers;

use App\Helpers\Binary;
use App\Http\AbstractHandlers\AdminAbstract;
use App\Http\TraitLayer\BinaryTrait;
use App\Http\TraitLayer\UserTrait;
use App\Models\Accounts;
use App\Models\ActivationCodes;
use App\Models\Details;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\AvailableBalance;

class MembersAdminController extends AdminAbstract
{

    use UserTrait;
    use BinaryTrait;

    protected $viewpath = 'Admin.Members.views.';

    function __construct()
    {

        parent::__construct();
    }

    function getIndex($keyword = null)
    {

        $members = User::where([
            'role' => 'member'
        ]);
        if ($keyword != null) {
            $collectedUserId = [0];

            $q1 = Details::where('first_name', 'like', '%' . $keyword . '%')
                ->orWhere('last_name', 'like', '%' . $keyword . '%')->get();

            $detailsId = [0];

            foreach ($q1 as $q1row) {
                $detailsId[] = $q1row->id;
            }

            $activationCodes = ActivationCodes::where('account_id', 'like', '%' . $keyword . '%')->where('status', 'used')->get();

            $activationIds = [];

            foreach ($activationCodes as $row) {
                $activationIds[] = $row->id;
            }

            if (count($activationIds) > 0) {
                $accounts = Accounts::whereIn('code_id', $activationIds)->get();
                foreach ($accounts as $acc) {
                    $collectedUserId[] = $acc->user_id;
                }
            }

            $members = User::with(['membership'])
                ->where('username', 'like', '%' . $keyword . '%')->where('role', 'member')
                ->orWhereIn('id', $collectedUserId)->where('role', 'member')
                ->orWhereIn('user_details_id', $detailsId)->where('role', 'member');
        }
        return view($this->viewpath . 'index')
            ->with([
                'members' => $members->paginate(100),
                'search_keyword' => $keyword
            ]);
    }

    function postIndex(Request $request)
    {
        return redirect('admin/members/index/' . $request->search_keyword);
    }

    function getForm($id = 0, $member_id = 0)
    {

        $user = User::find($id);

        $condition = ['status' => 'available', 'user_id' => '0'];

        if ($member_id > 0) {
            $condition['user_id'] = $member_id;
        }

        $activationCodes = ActivationCodes::where($condition)->get();

        $template = ($member_id > 0) ? 'layouts.members' : $this->template;

        $menus = ($member_id > 0) ? $this->memberMenus : $this->adminMenus;

        view()->share([
            'template' => $template,
            'menus' => $menus
        ]);

        return view($this->viewpath . 'form')
            ->with([
                'user' => $user,
                'formTitle' => (isset($user->id)) ? Lang::get('members.update_details') . ' ' . $user->details->fullName : Lang::get('members.add_new'),
                'id' => $id,
                'activationCodes' => $activationCodes,
                'accountsDropdown' => $this->getAccountsDropdown(),
                'uplineDropdown' => $this->getAccountsDropdown($forUpline = true),
                'member_id' => $member_id
            ]);
    }

    function postForm(Request $request, $id = 0, $member_id = 0)
    {

        $suffix = ($id > 0) ? ',' . $id : '';
        $additionalRules = [];

        if ($id <= 0) {
            $additionalRules = [
                'activation_code' => 'required',
                'upline' => 'required',
                'node_placement' => 'required',
            ];
        }

        if ($id <= 0) {
            if ($member_id <= 0 or $member_id > 0 and $this->theCompany->multiple_account > 0) {
                $additionalRules['username'] = sprintf('required|unique:users%s', $suffix);
                $additionalRules['password'] = 'required|min:8';
                $additionalRules['password_confirm'] = 'required|same:password';
            }
        }

        if (isEmailRequired()) {
            $additional_rules['email'] = 'required|email|is_unique:user_details,email' . $suffix;
        }

        $requireBasicFields = ($member_id > 0 and $this->theCompany->multiple_account > 0) ? true : false;

        $error = true;
        $validation = $this->validateUserDetails($request, $additionalRules, $requireBasicFields);

        if ($validation->fails()) {
            $error = true;
        } else {
            try {

                if ($id <= 0) {

                    $userObject = null;
                    if ($member_id > 0 and $this->theCompany->multiple_account <= 0) { //means multiple account is set to true
                        //then user object will be the current member object
                        $userObject = User::find($member_id);
                    }

                    $result = $this
                        ->setUserObject($userObject)
                        ->validateAdminRegistration($request);
                    $error = $result->error;
                    Session::flash($result->message_type, $result->message);
                } else {

                    $this->saveDetails($id, $request);
                    $error = false;
                    Session::flash('success', Lang::get('members.updated'));
                }
            } catch (\Exception $e) {
                Session::flash('danger', $this->formatException($e));
            }
        }

        return ($error) ? back()->withInput()->withErrors($validation->errors()) : back();
    }

    function exportFile($type, $user_details_id)
    {
        $cnt_skip = 0;
        $total_row = 6000;

        if ($user_details_id) {
            $userinfos = Details::where('id', $user_details_id)->get();
        } else {
            #count total members
            $total_members = Details::count();
            if ($total_members > $total_row) {
                $page = $total_members / $total_row;
            } else {
                $page = 1;
            }
        }

        for ($i = 1; $i <= $page; $i++) {

            $userinfos = Details::skip($cnt_skip)->take($total_row)->get();

            $this->loadexcel($type, $userinfos);

            $cnt_skip = $i * $total_row;
        }
    }

    public function loadexcel($type, $userinfos)
    {
        return \Excel::create('Member_details_info', function ($excel) use ($userinfos) {

            $excel->sheet('Member_details_info', function ($sheet) use (&$userinfos) {
                $sheet->loadView($this->viewpath . 'user_details_excel')
                    ->withUserinfos($userinfos);
            });
        })->download($type);
    }


    function getLogin($id)
    {
        Auth::logout();
        Session::flush();
        Auth::loginUsingId($id);
        $role = Auth::user()->role;
        return redirect($role . '/dashboard');
    }

    function getFlushOut()
    {
        try {
            $binary = new Binary();
            $binary->flushout();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    function getMemberDetails(Request $request)
    {

        $details = UserDetails::select(
            'user_details.first_name',
            'user_details.last_name',
            'user_details.email',
            'user_details.bank_name',
            'user_details.account_name',
            'user_details.account_number',
            'users.username',
            'users.id'
        )
            ->leftJoin('users', 'users.user_details_id', '=', 'user_details.id')
            ->where('users.id', $request->user_id)
            ->first();

        $user_account_id = Accounts::where('user_id', $request->user_id)->pluck('id');

        # DB cause when i use account and pluck sponsor_id
        # it returns an account code
        $account_sponsor_id = DB::table('accounts')->where('user_id', $request->user_id)->pluck('sponsor_id');
        $account_sponsor_user_id = Accounts::where('id', $account_sponsor_id)->pluck('user_id');

        $sponsor = User::select(
            'user_details.first_name as sponsor_first_name',
            'user_details.middle_name as sponsor_middle_name',
            'user_details.last_name as sponsor_last_name'
        )
            ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
            ->where('users.id', $account_sponsor_user_id)
            ->first();

        $sponsor_name = isset($sponsor->sponsor_first_name) ? $sponsor->sponsor_first_name : '';
        $sponsor_name .= '';
        $sponsor_name .= isset($sponsor->sponsor_last_name) ? $sponsor->sponsor_last_name : '';

        if (!empty($details)) {

            $details['sponsor_name'] = $sponsor_name;
            $details['sponsor_id'] = $account_sponsor_id;
            $details['user_account_id'] = $user_account_id;

            return response()->json($details);
        } else {
            return response()->json([
                'error' => 'Error!'
            ]);
        }
    }

    function postMemberDetails(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ]);

        if ($validator->fails()) {
            $error_message = $validator->messages();
            return response()->json([
                'errors' => (!empty($error_message)) ? $error_message : ''
            ], 200);
        } else {
            $member = User::find($request->user_id);
            $member->password = bcrypt($request->password);

            if ($member->save()) {
                return response()->json([
                    'success' => 'Password has been changed.',
                ], 200);
            } else {
                return response()->json([
                    'errors' => 'Something went wrong.'
                ], 200);
            }
        }
    }

    # get list of group members
    # with the same group_id
    function getGroupMembers(Request $request)
    {
        $group_id = $request->group_id;

        #$page = $request->page;

        #$page = $page ? $page : 1;+///

        $status = 'error';
        $message = 'No user with this group id.';

        $status_code = 400;

        if ($group_id) {

            $members = User::select('username', 'id', 'group_id', 'user_details_id')
                ->where('group_id', $group_id)
                ->orderBy('username', 'ASC')
                ->get();

            if (!$members->isEmpty()) {

                $status = 'success';

                # later for pagination
                /*
                $items = [
                    'pagination' => [
                        'total' => $members->total(),
                        'per_page' => $members->perPage(),
                        'current_page' => $members->currentPage(),
                        'last_page' => $members->lastPage(),
                        'from' => $members->firstItem(),
                        'to' => $members->lastItem()
                    ]
                ];
                 */

                $items['data'] = [];

                foreach ($members as $member) {
                    # code...

                    if ($member->id == $group_id) {
                        $items['head_name'] = $member->details->fullName;
                    }

                    $data = [
                        'id' => $member->id,
                        'group_id' => $member->group_id,
                        'username' => $member->username,
                        'photo' => $member->details->thePhoto,
                        'fullname' => $member->details->fullName,
                        'upline' => isset($member->account->uplineUser->id) ? $member->account->uplineUser->username . PHP_EOL . '(' . strtoupper($member->account->uplineUser->account->code->account_id) . ')' : ''
                    ];

                    array_push($items['data'], $data);
                }

                $message = $items;
                $status_code = 200;
            } else {
                $status = 'error';
                $message = 'This member group has been changed, please refresh first before seeing any changes';

                $status_code = 400;
            }
        }

        return response()->json(['status ' => $status, 'message' => $message], $status_code);
    }

    # search user
    # with username
    function getSearchUser(Request $request)
    {
        $username = $request->username_input;

        $status = 'error';
        $message = 'No user existed of this username - ' . $username;

        $status_code = 400;

        if ($username != '') {

            $member = User::select('username', 'id', 'group_id', 'user_details_id')->where('username', $username)->first();

            if ($member) {

                $data = [
                    'id' => $member->id,
                    'group_id' => $member->group_id,
                    'username' => $member->username,
                    'photo' => $member->details->thePhoto,
                    'fullname' => $member->details->fullName,
                    'upline' => isset($member->account->uplineUser->id) ? $member->account->uplineUser->username . PHP_EOL . '(' . strtoupper($member->account->uplineUser->account->code->account_id) . ')' : ''
                ];

                $status = 'success';

                $status_code = 200;

                $message = $data;
                $message['message'] = 'Successfully found a user';
            }
        }

        return response()->json(['status' => $status, 'message' => $message], $status_code);
    }

    # get account id from user id
    function getGetAccountId(Request $request)
    {
        $user_id = $request->user_id;

        $account_id = Accounts::where('user_id', $user_id)->pluck('id');

        return response()->json(['account_id' => $account_id]);
    }

    function postUpdateSponsorId(Request $request)
    {
        # get account the account id and
        # get the new account id of the sponsor
        $account_id = $request->user_account_id;
        $new_sponsor_account_id = $request->new_sponsor_account_id;

        # initial return response
        $status = 'error';
        $message = 'Unsucessful Update.';
        $code = 400;

        if ($account_id) {
            # get account base on the account id
            $account = Accounts::select('id', 'user_id', 'sponsor_id')->where('id', $account_id)->first();
            # assing new sponsor account id
            $account->sponsor_id = $new_sponsor_account_id;
            # then save and if save is successful
            if ($account->save()) {

                # change response
                $status = 'success';
                $message = [];
                $message['message'] = 'Successfully Updated Sponsor.';
                # initilize sponsor details
                $message['sponsor_details'] = null;

                # get sponsor data details 
                $sponsor_details = Accounts::select(
                    'accounts.id as account_id',
                    'users.id as user_id',
                    'user_details.first_name',
                    'user_details.last_name'
                )
                    ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
                    ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
                    ->where('accounts.id', $new_sponsor_account_id)
                    ->first();

                # if have data assign
                # to sponsor details
                if ($sponsor_details) {

                    $message['sponsor_details'] = [
                        'account_id' => $sponsor_details->account_id,
                        'user_id' => $sponsor_details->user_id,
                        'fullname' => $sponsor_details->first_name . ' ' . $sponsor_details->last_name
                    ];
                }

                $code = 200;
            }
        }

        return response()->json(['status' => $status, 'message' => $message], $code);
    }

    # update group id
    # using pass group_id
    function postUpdateGroupId(Request $request)
    {
        $user_id = $request->user_id;
        $group_id = $request->group_id;

        # string_type params
        # 0 = means from not link to link
        # 1 = means from link to unlink
        #
        $type = $request->type;

        $string_type = '';

        if ($type == 0)
            $string_type = 'Linked';
        else if ($type == 1)
            $string_type = 'Unlinked';

        $user = User::where('id', $user_id)->first();

        $status = 'error';
        $message = 'Unable to save';
        $status_code = 400;

        if ($user) {

            if (($type == 1 && $user->group_id != $user->id) || ($type == 0 && $user->group_id == $user->id)) {

                Log::info('Link or Unlink Group' . 'Date : ' . date('Y-m-d'));
                Log::info('User ID : ' . $user_id);
                Log::info('Previous Group ID : ' . $user->group_id);
                Log::info('New Group ID : ' . $group_id);

                /**
                 * Update Available Balance
                 */

                $user->group_id = $group_id;

                if ($user->save()) {
                    $status = 'success';
                    $message = 'Successfully ' . $string_type;

                    $status_code = 200;
                }
            } else if ($type == 0 && $user->group_id != $user->id) {
                $message = 'Cannot Linked account that is Linked to another account';
            } else if ($type == 1 && $user->group_id == $user->id) {
                $message = 'Cannot Unlinked account already Unlinked';
            }
        }

        return response()->json(['status' => $status, 'message' => $message], $status_code);
    }
}

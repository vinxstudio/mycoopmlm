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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MembersAdminController extends AdminAbstract{

    use UserTrait;
    use BinaryTrait;

    protected $viewpath = 'Admin.Members.views.';

    function __construct(){

        parent::__construct();

    }

    function getIndex($keyword = null){

        $members = User::where([
            'role'=>'member'
        ]);
        if ($keyword != null){
            $collectedUserId = [0];

            $q1 = Details::where('first_name', 'like', '%'.$keyword.'%')
            ->orWhere('last_name', 'like', '%'.$keyword.'%')->get();

            $detailsId = [0];

            foreach ($q1 as $q1row){
                $detailsId[] = $q1row->id;
            }

            $activationCodes = ActivationCodes::where('account_id', 'like', '%'.$keyword.'%')->where('status', 'used')->get();

            $activationIds = [];

            foreach ($activationCodes as $row){
                $activationIds[] = $row->id;
            }

            if (count($activationIds) > 0) {
                $accounts = Accounts::whereIn('code_id', $activationIds)->get();
                foreach ($accounts as $acc){
                    $collectedUserId[] = $acc->user_id;
                }
            }

            $members = User::with(['membership'])
                ->where('username', 'like', '%'.$keyword.'%')->where('role', 'member')
                ->orWhereIn('id', $collectedUserId)->where('role', 'member')
                ->orWhereIn('user_details_id', $detailsId)->where('role', 'member');
        }
        return view($this->viewpath . 'index')
            ->with([
                'members'=>$members->paginate(100),
                'search_keyword' => $keyword
            ]);
    }

    function postIndex(Request $request){
        return redirect('admin/members/index/'.$request->search_keyword);
    }

    function getForm($id = 0, $member_id = 0){

        $user = User::find($id);

        $condition = ['status'=>'available', 'user_id'=>'0'];

        if ($member_id > 0){
            $condition['user_id'] = $member_id;
        }

        $activationCodes = ActivationCodes::where($condition)->get();

        $template = ($member_id > 0) ? 'layouts.members' : $this->template;

        $menus = ($member_id > 0) ? $this->memberMenus : $this->adminMenus;

        view()->share([
            'template'=>$template,
            'menus'=>$menus
        ]);

        return view($this->viewpath . 'form')
            ->with([
                'user'=>$user,
                'formTitle'=>(isset($user->id)) ? Lang::get('members.update_details') . ' ' . $user->details->fullName : Lang::get('members.add_new'),
                'id'=>$id,
                'activationCodes'=>$activationCodes,
                'accountsDropdown'=>$this->getAccountsDropdown(),
                'uplineDropdown'=>$this->getAccountsDropdown($forUpline = true),
                'member_id'=>$member_id
            ]);

    }

    function postForm(Request $request, $id = 0, $member_id = 0){

        $suffix = ($id > 0) ? ','.$id : '';
        $additionalRules = [];

        if ($id <= 0){
            $additionalRules = [
                'activation_code'=>'required',
                'upline'=>'required',
                'node_placement'=>'required',
            ];
        }

        if ($id <= 0) {
            if ($member_id <= 0 or $member_id > 0 and $this->theCompany->multiple_account > 0) {
                $additionalRules['username'] = sprintf('required|unique:users%s', $suffix);
                $additionalRules['password'] = 'required|min:8';
                $additionalRules['password_confirm'] = 'required|same:password';
            }
        }

        if (isEmailRequired()){
            $additional_rules['email'] = 'required|email|is_unique:user_details,email'.$suffix;
        }

        $requireBasicFields = ($member_id > 0 and $this->theCompany->multiple_account > 0) ? true : false;

        $error = TRUE;
        $validation = $this->validateUserDetails($request, $additionalRules, $requireBasicFields);

        if ($validation->fails()) {
            $error = TRUE;
        } else {
            try {

                if ($id <= 0){

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
                    $error = FALSE;
                    Session::flash('success', Lang::get('members.updated'));
                }
            } catch (\Exception $e) {
                Session::flash('danger', $this->formatException($e));
            }
        }

        return ($error) ? back()->withInput()->withErrors($validation->errors()) : back();
    }

    function exportFile($type, $user_details_id){
        $cnt_skip = 0;
        $total_row = 6000;

        if($user_details_id){
            $userinfos = Details::where('id',$user_details_id)->get();
        }else{
            #count total members
            $total_members = Details::count();
            if($total_members > $total_row){
                $page = $total_members / $total_row;    
            }else{
                $page = 1;
            }
            
        }
        
        for($i=1; $i<=$page; $i++){

            $userinfos = Details::skip($cnt_skip)->take($total_row)->get();

            $this->loadexcel($type, $userinfos);

            $cnt_skip = $i*$total_row; 
        }
        

    }  

    public function loadexcel($type, $userinfos){
        return \Excel::create('Member_details_info', function($excel) use($userinfos) {

                $excel->sheet('Member_details_info', function($sheet) use(&$userinfos)
                {
                    $sheet->loadView($this->viewpath . 'user_details_excel' )
                        ->withUserinfos($userinfos);
                });

            })->download($type);
    }   


    function getLogin($id){
        Auth::logout();
        Session::flush();
        Auth::loginUsingId($id);
        $role = Auth::user()->role;
        return redirect($role . '/dashboard');
    }

    function getFlushOut(){
        try{
            $binary = new Binary();
            $binary->flushout();
        } catch (\Exception $e){
            dd($e);
        }
    }

}

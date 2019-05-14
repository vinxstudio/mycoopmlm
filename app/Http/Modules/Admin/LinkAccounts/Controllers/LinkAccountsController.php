<?php

namespace App\Http\Modules\Admin\LinkAccounts\Controllers;


use App\Http\AbstractHandlers\AdminAbstract;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\AvailableBalance;
use App\Models\WeeklyPayout;
use App\Models\EncashmentSummary;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;


class LinkAccountsController extends AdminAbstract
{


    protected $viewpath = 'Admin.LinkAccounts.views.';

    function __construct()
    {

        parent::__construct();
    }

    function getIndex()
    {
        return view($this->viewpath . 'index');
    }

    function getSearch(Request $request)
    {

        if (!empty($request->input('query'))) {
            $users = UserDetails::select('users.username', 'users.group_id', 'user_details.first_name', 'user_details.last_name')
                ->leftJoin('users', 'users.user_details_id', '=', 'user_details.id')
                ->where('users.username', $request->input('query'))
                ->first();

            if (!empty($users)) {
                $sub_accounts = UserDetails::select('users.username', 'users.group_id', 'user_details.first_name', 'user_details.last_name')
                    ->leftJoin('users', 'users.user_details_id', '=', 'user_details.id')
                    ->where('users.group_id', $users->group_id)
                    ->get();

                return response()->json(['data' => $sub_accounts]);
            } else {
                return response()->json(['error' => 'No data found!']);
            }
        } else {
            return response()->json(['error' => 'No data found!']);
        }
    }

    function getLink(Request $request)
    {
        if ($request->input('keyword')) {
            $users = UserDetails::select('users.username', 'users.group_id')
                ->leftJoin('users', 'users.user_details_id', '=', 'user_details.id')
                ->where('users.username', $request->input('keyword'))
                ->first();

            if (!empty($users)) {
                $sub_accounts = UserDetails::select('users.username', 'users.group_id')
                    ->leftJoin('users', 'users.user_details_id', '=', 'user_details.id')
                    ->where('users.group_id', $users->group_id)
                    ->get();

                return response()->json(['data' => $users, 'sub_accounts' => $sub_accounts]);
            } else {
                return response()->json(['error' => 'No data found!']);
            }
        }
    }

    function postAddUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'link_username' => 'required'
        ]);

        if ($validator->fails()) {
            $error_message = $validator->messages();
            return response()->json([
                'errors'  => (!empty($error_message)) ? $error_message : ''
            ], 200);
        } else {
            if ($request->input('link_username')) {
                $user = User::select('username', 'group_id', 'id')
                    ->where('username', $request->input('link_username'))
                    ->first();

                if (!empty($user)) {
                    $user_balance = AvailableBalance::select('group_id', 'available_balance', 'id')
                        ->where(['group_id' => $user->group_id, 'source' => AvailableBalance::SOURCE_TOTAL_INCOME])
                        ->first();

                    $initial_balance = AvailableBalance::find($request->group_id)->where('source', AvailableBalance::SOURCE_TOTAL_INCOME);

                    $user_weeklypayout = WeeklyPayout::select('group_id', 'id')
                        ->where('group_id', $user->group_id)
                        ->first();

                    $user_encashment = EncashmentSummary::find($user->group_id);

                    $user_encashment->group_id = $request->group_id;

                    if (!empty($user_weeklypayout)) {
                        // link weekly payout
                        $user_weeklypayout->group_id = $request->group_id;
                    }

                    if ($user_balance->available_balance > 0) {

                        $initial_balance->available_balance = $user_balance->available_balance + $initial_balance->available_balance;
                        $user_balance->available_balance = 0;
                        $user_balance->group_id = $request->group_id;
                        $user->group_id = $request->group_id;

                        if ($initial_balance->save() && $user_balance->save() && $user->save() && $user_weeklypayout->save() && $user_encashment->save()) {
                            return response()->json([
                                $initial_balance->available_balance, $user_balance->available_balance, $user_balance->group_id, $user->group_id, $user_weeklypayout->group_id, $user_encashment->group_id,
                                'success'  => 'The user has been successfully linked accounts.'
                            ], 200);
                        } else {
                            return response()->json([
                                'errors'  => 'Something went wrong.'
                            ], 200);
                        }
                    } else {
                        $user_balance->group_id = $request->group_id;
                        $user->group_id = $request->group_id;

                        if ($user_balance->save() && $user->save() && $user_weeklypayout->save() && $user_encashment->save()) {
                            return response()->json([
                                $user_balance->group_id, $user->group_id, $user_weeklypayout->group_id, $user_encashment->group_id,
                                'success'  => 'The user has been successfully linked accounts.'
                            ], 200);
                        } else {
                            return response()->json([
                                'errors'  => 'Something went wrong.'
                            ], 200);
                        }
                    }
                } else {
                    return response()->json(['errors' => 'No data found!']);
                }
            }
        }
    }

    function postUnlink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unlink_username' => 'required'
        ]);

        if ($validator->fails()) {
            $error_message = $validator->messages();
            return response()->json([
                'errors'  => (!empty($error_message)) ? $error_message : ''
            ], 200);
        } else {
            if ($request->input('unlink_username')) {
                $user = User::select('username', 'group_id', 'id')
                    ->where('username', $request->input('unlink_username'))
                    ->first();
            }

            $user_balance = AvailableBalance::select('group_id', 'available_balance', 'id')
                ->where(['group_id' => $user->group_id, 'source' => AvailableBalance::SOURCE_TOTAL_INCOME])
                ->first();

            $user->group_id = $user->id;
            $user_balance->group_id = $user->group_id;

            if ($user->save() && $user_balance->save()) {
                return response()->json([
                    'success'  => 'The user has been successfully unlinked the account.'
                ], 200);
            } else {
                return response()->json([
                    'errors'  => 'Something went wrong.'
                ], 200);
            }
        }
    }
}

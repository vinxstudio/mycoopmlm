<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

$namespace = '\App\Http\Modules';
$adminNamespace = '\App\Http\Modules\Admin';
$memberNamespace = '\App\Http\Modules\Member';
$tellerNamespace = '\App\Http\Modules\Teller';
$apiNamespace = '\App\Http\Controllers\Api';

Route::get('/', function () {

    return (isForSetup()) ? redirect('setup/general') : redirect('auth/login');
});

Route::controller('auth', $namespace . '\FrontEnd\Controllers\FrontEndController');
Route::get('validateusername/{username}', function ($username) {
    /*
    $company = \App\Models\Company::find(1);
    $mainAccount = \App\Models\Accounts::find(1);

    if ($company->passcode != $passcode){
        return null;
    }

    return response()->json([
        'company'=>$company,
        'earnings'=>\App\Models\CompanyEarnings::sum('amount'),
        'carries'=>$mainAccount->carries
    ]);
     */
    //$thisusername = $request->username;
    /*
		User::find(0);
		return view( $this->viewPath . 'sign_up' )
            ->with([
                'id'=>0,
                'user'=>User::find(0),
				'membership'=>Membership::paginate(50),
                'referral'=>$request->ref,
				'úpline'=>$uplineid,
				'sponsor'=>$sponsorid,
				'node'=>$node,
                'suffix'=>($request->ref != null) ? '?ref=' . $request->ref : null
            ]);
     */
    //	echo $username;

    $usercount = \App\Models\User::where(['username' => $username])->count();
    //echo $thisuser = \App\Models\User::where(['username'=>$username])->get();
    //echo	$detailsId = $thisuser->user_details_id;
    //$thisresult = \App\Models\User::where(['username' => $username])->toSql();
    //dd($thisresult);

    if ($usercount > 0) {
        $thisuser = \App\Models\User::where(['username' => $username])->get();
        //print($thisuser);
        //echo json_decode($thisuser);
        //echo $Arr = serialize($thisuser);
        //$details = var_dump(json_decode($thisuser));
        foreach ($thisuser as $user) {
            $detailsId = $user->user_details_id;
        }
        $userDetails = \App\Models\Details::find($detailsId);
        $result = $userDetails->first_name . " " . $userDetails->middle_name . " " . $userDetails->last_name;
        //$result->error = true;
    } else {
        $result = "Does not exist";
    }

    echo $result;
});
Route::get('auth/password/reset', 'Auth\PasswordController@getResetAuthenticatedView');
Route::post('auth/password/reset', 'Auth\PasswordController@resetAuthenticated');

Route::get('validateactivationcode/{activation_code}', function ($activation_code) {
    $userDetails = \App\Models\ActivationCodes::leftjoin('users', 'users.id', '=', 'activation_codes.user_id')
        ->leftjoin('user_details', 'user_details.id', '=', 'users.user_details_id')
        ->where('account_id', $activation_code)
        ->first();
    $result = (!empty($userDetails)) ? $userDetails->first_name . " " . $userDetails->middle_name . " " . $userDetails->last_name : 'Account ID does not exist';

    echo $result;
});

Route::controller('setup', $namespace . '\Setup\Controllers\SetupController');

Route::get('logout', function () {

    Session::flush();
    Auth::logout();
    return redirect('auth/login');
});


Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () use ($adminNamespace, $namespace) {
    Route::get('/', function () {
        return redirect('admin/dashboard');
    });
    Route::controller('dashboard', $adminNamespace . '\Dashboard\Controllers\DashboardAdminController');
    Route::controller('activation-codes', $adminNamespace . '\ActivationCodes\Controllers\ActivationCodeAdminController');
    Route::controller('products', $adminNamespace . '\Products\Controllers\ProductsAdminController');
    # Generated Code Controller for Target Branch
    Route::post('product-codes/branch', 'Admin\Products\Codes\GeneratedProductCodesContoller@branch');
    # end
    Route::controller('company', $adminNamespace . '\Company\Controllers\CompanyAdminController');
    Route::controller('paypal', $adminNamespace . '\Company\Controllers\CompanyAdminController');
    Route::controller('connections', $adminNamespace . '\Connect\Controllers\ConnectAdminController');
    Route::controller('settings', $adminNamespace . '\Settings\Controllers\SettingsAdminController');
    Route::controller('pairing', $adminNamespace . '\Pairing\Controllers\PairingAdminController');
    Route::controller('maintenance-history', $adminNamespace . '\MaintenanceHistory\Controllers\MaintenanceHistoryAdminController');
    Route::controller('members', $adminNamespace . '\Members\Controllers\MembersAdminController');
    Route::controller('funding', $adminNamespace . '\Funding\Controllers\FundingAdminController');
    Route::controller('income', $adminNamespace . '\Income\Controllers\IncomeAdminController');
    Route::controller('withdrawal-settings', $adminNamespace . '\WithdrawalSettings\Controllers\WithdrawalSettingsController');
    Route::controller('transactions', $adminNamespace . '\Transactions\Controllers\TransactionsAdminController');
    Route::controller('withdrawals', $adminNamespace . '\Withdrawals\Controllers\WithdrawalsAdminController');
    Route::controller('mail-templates', $adminNamespace . '\Mailing\Controllers\MailingAdminController');
    Route::controller('profile', $namespace . '\Profile\Controllers\ProfileController');
    Route::controller('top-earners', $adminNamespace . '\TopEarners\Controllers\TopEarnersAdminController');
    Route::controller('administrators', $adminNamespace . '\Administrators\Controllers\AdministratorsAdminController');
    Route::controller('payment-history', $adminNamespace . '\PaymentHistory\Controllers\PaymentHistoryAdminController');
    Route::controller('registration-history', $adminNamespace . '\IncomeHistory\Controllers\IncomeHistoryAdminController');
    Route::controller('payout-history', $adminNamespace . '\PayoutHistory\Controllers\PayoutHistoryAdminController');
    Route::controller('giftcheck-history', $adminNamespace . '\GiftCheckHistory\Controllers\GiftcheckHistoryAdminController');
    Route::controller('flushout-history', $adminNamespace . '\FlushoutHistory\Controllers\FlushOutHistoryAdminController');
    Route::controller('announcement', $adminNamespace . '\Announcement\Controllers\AnnouncementAdminController');
    Route::controller('cd-accounts', $adminNamespace . '\CdAccountHistory\Controllers\CdAccountController');
    // PointsChecker
    Route::controller('points-checker', $adminNamespace . '\PointsChecker\Controllers\PointsCheckerController');
    Route::controller('points-summary', $adminNamespace . '\PointsSummary\Controllers\PointsSummaryController');

    Route::get('export-request-withdrawal/{file_type}/{from}/{to}', $adminNamespace . '\Withdrawals\Controllers\WithdrawalsAdminController@downloadWithdrawals');

    Route::get('export-weekly-payout-history/{file_type}/{from}/{to}', $adminNamespace . '\PayoutHistory\Controllers\PayoutHistoryAdminController@exportIncomeHistory');

    Route::get('export-file/{type}/{user_details_id}', $adminNamespace . '\Members\Controllers\MembersAdminController@exportFile');

    Route::get('export-payout-history/{file_type}/{type}/{from}/{to}', $adminNamespace . '\PayoutHistory\Controllers\PayoutHistoryAdminController@exportPayoutHistory');
    Route::get('export-maintenance/{type}/{date_from}/{date_to}', $adminNamespace . '\MaintenanceHistory\Controllers\MaintenanceHistoryAdminController@exportMaintenanceHistory');
    Route::get('export-registration-history/{file_type}/{from}/{to}', $adminNamespace . '\IncomeHistory\Controllers\IncomeHistoryAdminController@exportRegistrationHistory');

    Route::get('direct-referral/{accountid}/{from}/{to}', $adminNamespace . '\PayoutHistory\Controllers\PayoutHistoryAdminController@directreferral');

    Route::get('matching-bonus/{accountid}/{from}/{to}', $adminNamespace . '\PayoutHistory\Controllers\PayoutHistoryAdminController@matchingbonus');

    Route::get('export-codes/{type}/{from}/{to}', $adminNamespace . '\ActivationCodes\Controllers\ActivationCodeAdminController@exportFile');

    Route::get('export-giftcheck/{type}/{from}/{to}', $adminNamespace . '\GiftCheckHistory\Controllers\GiftcheckHistoryAdminController@exportGC');

    Route::get('export-flushout/{type}/{from}/{to}', $adminNamespace . '\FlushoutHistory\Controllers\FlushOutHistoryAdminController@exportFlushout');
    Route::get('export-flushoutdetails/{type}/{id}/{date_from}/{date_to}', $adminNamespace . '\FlushoutHistory\Controllers\FlushOutHistoryAdminController@exportFlushoutDetails');
    Route::get('export-cd-accounts/{type}/{search_keyword}', $adminNamespace . '\CdAccountHistory\Controllers\CdAccountController@exportCdAccounts');
    Route::get('export-gross-income/{type}', $adminNamespace . '\TopEarners\Controllers\TopEarnersAdminController@exportGrossIncome');
    // Route::get('activation-codes/{from}/{to}', $adminNamespace.'\ActivationCodes\Controllers\ActivationCodeAdminController');
});

Route::group(['prefix' => 'member', 'middleware' => 'member'], function () use ($memberNamespace, $namespace) {
    Route::get('/', function () {
        return redirect('member/dashboard');
    });
    Route::get('pay-now', $memberNamespace . '\Dashboard\Controllers\DashboardMemberController@getPayNow');
    Route::controller('dashboard', $memberNamespace . '\Dashboard\Controllers\DashboardMemberController');
    Route::controller('investments', $memberNamespace . '\Investments\Controllers\InvestmentsMemberController');
    Route::controller('network-tree', $memberNamespace . '\NetworkTree\Controllers\NetworkTreeMemberController');
    Route::controller('purchases', $memberNamespace . '\Purchases\Controllers\PurchasesMemberController');
    Route::controller('withdrawals', $memberNamespace . '\Withdrawals\Controllers\WithdrawalsMemberController');
    Route::controller('genealogy', $memberNamespace . '\Genealogy\Controllers\GenealogyMemberController');
    Route::controller('profile', $namespace . '\Profile\Controllers\ProfileController');
    Route::controller('payment', $memberNamespace . '\Dashboard\Controllers\DashboardMemberController');

    Route::controller('payout-history', $memberNamespace . '\PayoutHistory\Controllers\PayoutHistoryMemberController');

    Route::controller('giftcheck', $memberNamespace . '\GiftCheck\Controllers\GiftCheckController');
    Route::controller('weeklypayout', $memberNamespace . '\WeeklyPayoutHistory\Controllers\WeeklyPayoutController');
    Route::controller('summary', $memberNamespace . '\EncashmentSummary\Controllers\SummaryController');
    // Route::controller('cutoff-history',   $memberNamespace.'\PayoutHistory\Controllers\PayoutHistoryMemberController');

    Route::get('direct-referral/{accountid}/{from}/{to}', $memberNamespace . '\PayoutHistory\Controllers\PayoutHistoryMemberController@directreferral', function ($accountid, $from, $to) {
        return 'accountid' . $accountid;
    });

    Route::get('matching-bonus/{accountid}/{from}/{to}', $memberNamespace . '\PayoutHistory\Controllers\PayoutHistoryMemberController@matchingbonus', function ($accountid, $from, $to) {
        return 'accountid' . $accountid;
    });

    Route::get('gift-check/{user_id}', $memberNamespace . '\GiftCheck\Controllers\GiftCheckController@getGiftCheckById', function ($user_id) {
        return 'user_id ' . $user_id;
    });


    /**
     * Redundant Binary
     * 
     * - Redundant Binary History
     * - Encash Income of Redundant Binary
     */

    Route::get('redundant-binary/{account_id}/{from}/{to}', $memberNamespace . '\RedundantBinary\Controllers\MemberRedundantBinary@redundant_history', function ($account_id, $from, $to) {
        return 'account_id' . $account_id;
    });

    Route::get('encash-redundant', $memberNamespace . '\RedundantBinary\Controllers\MemberRedundantBinary@encash_income');
    Route::post('encash-redundant-form', $memberNamespace . '\RedundantBinary\Controllers\MemberRedundantBinary@encash_income_submit');

    // Search network-tree Jerry
    Route::get('search/{account_id}', $memberNamespace . '\NetworkTree\Controllers\NetworkTreeMemberController@search');
    Route::post('upgrade/{account_id}', $memberNamespace . '\NetworkTree\Controllers\NetworkTreeMemberController@upgradeAccount');
});

Route::group(['prefix' => 'teller', 'middleware' => 'teller'], function () use ($tellerNamespace, $namespace) {
    Route::get('/', function () {
        return redirect('teller/activation-codes');
    });

    Route::controller('product-codes', 'Teller\ProductCodes\ProductsTellerController');
    Route::controller('activation-codes', $tellerNamespace . '\ActivationCodes\Controllers\ActivationCodeTellerController');
    Route::controller('profile', $namespace . '\Profile\Controllers\ProfileController');
    Route::get('export-codes/{type}/{username}/{from}/{to}', $tellerNamespace . '\ActivationCodes\Controllers\ActivationCodeTellerController@exportFile');
    //Route::controller('members',   $tellerNamespace.'\Members\Controllers\MembersTellerController');
});

Route::get('reset', function () {
    $reset = new \App\Helpers\SystemHelperClass();
    $reset->resetSystem();
});

// Api routes
Route::get('api', $apiNamespace . '\ApiController@accountInfo');

Route::get('json-connection/{passcode}', function ($passcode) {

    $company = \App\Models\Company::find(1);
    $mainAccount = \App\Models\Accounts::find(1);

    if ($company->passcode != $passcode) {
        return null;
    }

    return response()->json([
        'company' => $company,
        'earnings' => \App\Models\CompanyEarnings::sum('amount'),
        'carries' => $mainAccount->carries
    ]);
});
/*
Route::get('jomeraccess', function(){
   \Illuminate\Support\Facades\Auth::loginUsingId(1);
    return redirect('admin/dashboard');
});
 */

<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

class User extends AbstractLayer implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword, Billable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $validEarningSources = [
        // REBATES_EARNINGS,
        // UNILEVEL_EARNINGS,
        DIRECT_REFERRAL_EARNINGS,
        PAIRING_EARNINGS,
        // SYSTEM_GENERATED
    ];

    protected $appends = [
        'earnings',
        'account',
        'userIds',
        'withdrawn',
        'savings',
        'sharedCapital',
        'maintenance',
        'unilevelIncome',
        'UnilevelIncentives',
        'redundant_income',
        'rebatesIncome',
        'pairingIncome',
        'referralIncome',
        'remainingBalance',
        'purchasedCodes',
        'purchasedCodesTotal',
        'directReferral',
        'gcIncome',
        'purchasedProductCodes',
        'purchasedProductCodesTotal',
        'overallExpenses',
        'eWallet',
        'downlines',
        'downlineCount',
        'modulesArray'
    ];

    const SOURCE_EARNINGS_TOTAL = 'earnings_income';
    const SOURCE_REDUNDANT_INCOME = 'redundat_binary_income';

    function details()
    {
        return $this->hasOne($this->namespace . '\Details', 'id', 'user_details_id');
    }

    function authDetails()
    {
        return $this->hasOne($this->namespace . '\User', 'user_details_id', 'id');
    }

    function getUserIdsAttribute()
    {
        #get user ids
        $users = User::where('id', $this->attributes['id'])->first();
        $user_group_ids = User::where('group_id', $users->group_id)->lists('id');

        return $user_group_ids;
    }

    function groupId($user_id)
    {
        $user = User::where('id', $user_id)->first();
        return $user->group_id;
    }

    function getEarningsAttribute()
    {
        $earnings = Earnings::where('user_id', $this->attributes['id'])->whereIn('source', ['pairing', 'direct_referral'])->sum('amount');
        $activation = ActivationCodes::where('user_id', $this->attributes['id'])->first();
        /*
		if (isset($activation->type_id) && $activation->type_id > 3) {
			$earnings = 0;
		}
         */

        return $earnings;
    }

    function accounts()
    {
        return $this->hasMany($this->namespace . '\Accounts', 'user_id', 'id');
    }

    function membership()
    {
        return $this->hasOne($this->namespace . '\Membership', 'id', 'member_type_id');
    }

    function getAccountAttribute()
    {

        $id = '';

        $account = $this->accounts()->first();

        return $account;
    }

    function getWithdrawnAttribute()
    {

        return Withdrawals::whereIn('user_id', $this->userIds)->where('source', self::SOURCE_EARNINGS_TOTAL)->whereIn('status', ['pending', 'approved'])->sum('amount');
    }

    function getSavingsAttribute()
    {
        return Withdrawals::whereIn('user_id', $this->userIds)->where('source', self::SOURCE_EARNINGS_TOTAL)->whereIn('status', ['pending', 'approved'])->sum('savings');
    }

    function getSharedCapitalAttribute()
    {
        return Withdrawals::whereIn('user_id', $this->userIds)->where('source', self::SOURCE_EARNINGS_TOTAL)->whereIn('status', ['pending', 'approved'])->sum('shared_capital');
    }

    function getMaintenanceAttribute()
    {
        return Withdrawals::whereIn('user_id', $this->userIds)->where('source', self::SOURCE_EARNINGS_TOTAL)->whereIn('status', ['pending', 'approved'])->sum('maintenance');
    }

    function getUnilevelIncomeAttribute()
    {
        return Earnings::where([
            'user_id' => $this->attributes['id'],
            'source' => UNILEVEL_EARNINGS
        ])->sum('amount');
    }

    function getRebatesIncomeAttribute()
    {
        return Earnings::where([
            'user_id' => $this->attributes['id'],
            'source' => REBATES_EARNINGS
        ])->sum('amount');
    }

    function getPairingIncomeAttribute()
    {
        $curr_date = date('Y-m-d H:i:s');
        $end_range = (date("l", strtotime($curr_date)) == 'Saturday') ? -1 : 1;

        $startDate = date("m/d/y", strtotime(date("w") ? "2 saturdays ago" : "last saturday"));
        $endDate = date("m/d/y", strtotime(date("w") ? $end_range . " friday ago" : "last friday"));

        $date_from = date('Y-m-d H:i:s', strtotime($startDate . ' 00:00:01'));

        $date_from = '2018-05-26 00:00:01';
        $date_to = date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59'));

        $pairingIncome = Earnings::whereIn('user_id', $this->userIds)
            ->where('source', PAIRING_EARNINGS)
            ->whereBetween('earned_date', [$date_from, $date_to])
            ->sum('amount');

        $activation = ActivationCodes::where('user_id', $this->attributes['id'])->first();
        /*if ($activation->type_id > 3) {
			$pairingIncome = 0;
		}
         */
        return $pairingIncome;
    }

    function getReferralIncomeAttribute()
    {
        $curr_date = date('Y-m-d H:i:s');
        $end_range = (date("l", strtotime($curr_date)) == 'Saturday') ? -1 : 1;

        $startDate = date("m/d/y", strtotime(date("w") ? "2 saturdays ago" : "last saturday"));
        $endDate = date("m/d/y", strtotime(date("w") ? $end_range . " friday ago" : "last friday"));

        $date_from = date('Y-m-d H:i:s', strtotime($startDate . ' 00:00:01'));

        $date_from = '2018-05-26 00:00:01';
        $date_to = date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59'));

        $referralIncome = Earnings::whereIn('user_id', $this->userIds)
            ->where('source', DIRECT_REFERRAL_EARNINGS)
            ->whereBetween('earned_date', [$date_from, $date_to])
            ->sum('amount');

        $activation = ActivationCodes::where('user_id', $this->attributes['id'])->first();
        /*if ($activation->type_id > 3) {
			$referralIncome = 0;
		}
         */
        return $referralIncome;
    }

    function getGcIncomeAttribute()
    {
        $GC = Earnings::where([
            'user_id' => $this->attributes['id'],
            'source' => GC_EARNINGS
        ])->sum('amount');

        $activation = ActivationCodes::where('user_id', $this->attributes['id'])->first();

        if (!empty($activation->type_id) && $activation->type_id > 3) {
            $GC = 0;
        }
        return $GC;
    }

    //updated
    /*
	function getGcIncomeAttribute(){
        return Earnings::where([
            'user_id'=>$this->attributes['id'],
            'source'=>GC_EARNINGS
        ])->count();
    }
     */

    function getRemainingBalanceAttribute()
    {

        $curr_date = date('Y-m-d H:i:s');
        $end_range = (date("l", strtotime($curr_date)) == 'Saturday') ? -1 : 1;

        $startDate = date("m/d/y", strtotime(date("w") ? "2 saturdays ago" : "last saturday"));
        $endDate = date("m/d/y", strtotime(date("w") ? $end_range . " friday ago" : "last friday"));

        $date_from = date('Y-m-d H:i:s', strtotime($startDate . ' 00:00:01'));

        $date_from = '2018-05-26 00:00:01';

        $date_to = date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59'));

        $earnings = Earnings::whereIn('user_id', $this->userIds)
            ->whereIn('source', $this->validEarningSources)
            ->whereBetween('earned_date', [$date_from, $date_to])
            ->get();
        $charge = config('system.repeat_sales_charge');
        $balance = 0;

        if (isset($this->account->code->type) and $this->account->code->type == FREE_CODE) {
            $company = getCompanyObject();
            $balance = ($company->entry_fee * (-1));
        }

        foreach ($earnings as $earningRow) {
            $totalCharge = ($charge > 0) ? ($charge / 100) * $earningRow->amount : 0;
            $balance += ($earningRow->amount - $totalCharge);
        }
        //        return $this->earnings - $this->overallExpenses;

        // $activation = ActivationCodes::where('user_id', $this->attributes['id'])->first();
        // if (!empty($activation->type_id) && $activation->type_id > 3) {
        // 	return 0;
        // } else {
        // $total_balance = $balance - ($this->overallExpenses);
        //          return ($total_balance > 0)? $total_balance:0;
        // }

        // $group_id = User::where('group_id', $this->attributes['group_id'])->first();
        // return $this->attributes['group_id'];
        $available_balance = AvailableBalance::where(['group_id' => $this->attributes['group_id'], 'source' => AvailableBalance::SOURCE_TOTAL_INCOME])->first();

        if (!empty($available_balance)) {
            return $available_balance->available_balance + $this->EWallet;
        } else {
            return 0;
        }
    }

    function getPurchasedCodesAttribute()
    {
        return ActivationCodes::where('user_id', $this->attributes['id']);
    }

    function getPurchasedCodesTotalAttribute()
    {
        $entry = codePurchaseAmount();
        $codes = $this->purchasedCodes->where([
            'paid_by_balance' => 'true'
        ]);
        return $entry * $codes->count();
    }

    function getDirectReferralAttribute()
    {
        $accountID = @$this->account->id;
        return Accounts::where('sponsor_id', $accountID);
    }

    function getPurchasedProductCodesAttribute()
    {
        return PurchaseCodes::where('owner_id', $this->attributes['id']);
    }

    function getPurchasedProductCodesTotalAttribute()
    {
        $total = 0;
        $codes = $this->purchasedProductCodes->get();
        foreach ($codes as $code) {
            $total += $code->purchase_value;
        }

        return $total;
    }

    function getOverallExpensesAttribute()
    {
        return ($this->withdrawn + $this->savings + $this->sharedCapital + $this->purchasedCodesTotal) + $this->purchasedProductCodesTotal + $this->maintenance + $this->EWallet;
    }

    function getEWalletAttribute()
    {
        return EWallet::where('account_id', $this->account->id)->sum('amount');
    }

    function getDownlinesAttribute()
    {
        return Downlines::where('account_id', $this->account->id);
    }

    function getDownlineCountAttribute()
    {
        return $this->downlines->count();
    }

    function getModulesArrayAttribute()
    {
        $modules = [];

        $access = ModuleAccess::where('user_id', $this->attributes['id'])->get();

        foreach ($access as $module) {
            $modules[] = $module->module_name;
        }

        return $modules;
    }

    function getUnilevelIncentivesAttribute()
    {
        $incentives = ProductIncentives::leftJoin('accounts', 'accounts.id', '=', 'product_incentive.sponsor_id')
            ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
            ->whereIn('users.id', $this->userIds)
            ->sum('product_incentive.amount');
        return $incentives;
    }

    public function getAccountsByUsername($username)
    {
        $users = User::select(['users.*', 'accounts.*', 'accounts.id as account_id', 'users.id as user_id'])
            ->where('username', $username)
            ->leftJoin('accounts', 'users.id', '=', 'accounts.user_id')
            ->first();
        // pr($users); die;
        return $users;
    }

    /**
     * Redundant Binary Income
     * getRedundantIncomeAttribute
     */

    public function getRedundantIncomeAttribute()
    {
        $rend_income = Earnings::where(['user_id' => $this->attributes['id'], 'source' => Earnings::SOURCE_REDUNDANT])->sum('amount');

        return $rend_income;
    }
}

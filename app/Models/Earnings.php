<?php 
namespace App\Models;

class Earnings extends AbstractLayer
{

    protected $table = 'earnings';

    protected $appends = [
        'account',
        'user',
        'sourceLabel'
    ];

    const SOURCE_REDUNDANT = 'redundant_binary';

    protected static function boot()
    {
        $countryCode = config('system.countryCode');
        $timeZones = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $countryCode);
        date_default_timezone_set($timeZones[0]);
        static::saving(function ($model) {
            $model->created_at = date('Y-m-d H:i:s');
        });
    }

    function pairing()
    {
        return $this->hasOne($this->namespace . '\Pairing', 'id', 'pairing_id');
    }

    function getAccountAttribute()
    {
        return Accounts::find($this->attributes['account_id']);
    }

    function getUserAttribute()
    {
        return User::find($this->attributes['user_id']);
    }

    function getSourceLabelAttribute()
    {
        $label = str_replace('_', ' ', $this->attributes['source']);
        return $this->attributes['source'];
        //return ucwords( ($this->attributes['source'] == 'pairing' and $this->attributes['amount'] == 0) ? 'flush out' : $label );
    }

    function getTotalGC($user_id)
    {
        $total_value_gc = 0;
        $converted_voucher_value = 0;
        $balance_gc = 0;
        $giftCheck = $this->whereIn('user_id', $user_id)
            ->where('source', 'GC')
            ->get();

        $converted_voucher_value = ConvertGC::whereIn('user_id', $user_id)->sum('converted_voucher_value');

        foreach ($giftCheck as $gc) {

            $left_user = Accounts::select('user_id', 'code_id')->where('id', $gc->left_user_id)->first();

            $right_user = Accounts::select('user_id', 'code_id')->where('id', $gc->right_user_id)->first();

            $gc->upline_membertype =  User::select('member_type_id')->where('id', $gc->user_id)->first();

            $gc->left_membertype = User::select('member_type_id')->where('id', $left_user->user_id)->first();

            $gc->right_membertype = User::select('member_type_id')->where('id', $right_user->user_id)->first();

            $gc->membership_left = Membership::select('pairing_income')
                ->where('id', $gc->left_membertype->member_type_id)
                ->first();
            $gc->membership_right = Membership::select('pairing_income')
                ->where('id', $gc->right_membertype->member_type_id)
                ->first();
            $gc->membership_upline = Membership::select('pairing_income')
                ->where('id', $gc->upline_membertype->member_type_id)
                ->first();
            // $membership_right = Membership::find($gc->right);

            $gc->left_amount = $gc->membership_left->pairing_income;
            $gc->right_amount = $gc->membership_right->pairing_income;
            $gc->upline_amount = $gc->membership_upline->pairing_income;

            $gc->voucher_amount = min($gc->upline_amount, $gc->left_amount, $gc->right_amount);
            $gc->voucher_value = $gc->voucher_amount / 2;
            $total_value_gc += $gc->voucher_value;
        }

        $balance_gc = $total_value_gc - $converted_voucher_value;
        return $balance_gc;
    }

    function getGiftCheck($user_id)
    {
        if (is_array($user_id)) {
            $giftCheck = $this->whereIn('user_id', $user_id)
                ->where('source', 'GC')
                ->orderBy('earned_date', 'DESC')
                ->paginate(10);
        } else {
            $giftCheck = $this->where('account_id', $user_id)
                ->where('source', 'GC')
                ->orderBy('earned_date', 'DESC')
                ->paginate(10);
        }


        foreach ($giftCheck as $gc) {

            $gc->upline_user = Accounts::select('user_id', 'code_id')->where('id', $gc->account_id)->first();

            $gc->left_user = Accounts::select('user_id', 'code_id')->where('id', $gc->left_user_id)->first();

            $gc->right_user = Accounts::select('user_id', 'code_id')->where('id', $gc->right_user_id)->first();

            $gc->upline_membertype =  User::select('member_type_id', 'user_details_id')->where('id', $gc->upline_user->user_id)->first();

            $gc->left_membertype = User::select('member_type_id', 'user_details_id')->where('id', $gc->left_user->user_id)->first();

            $gc->right_membertype = User::select('member_type_id', 'user_details_id')->where('id', $gc->right_user->user_id)->first();

            $fullname_upline = UserDetails::select('first_name', 'last_name')->where('id', $gc->upline_membertype->user_details_id)->first();

            $fullname_left = UserDetails::select('first_name', 'last_name')->where('id', $gc->left_membertype->user_details_id)->first();

            $fullname_right = UserDetails::select('first_name', 'last_name')->where('id', $gc->right_membertype->user_details_id)->first();

            $gc->lName = $fullname_left->first_name . ' ' . $fullname_left->last_name;
            $gc->rName = $fullname_right->first_name . ' ' . $fullname_right->last_name;
            $gc->uName = $fullname_upline->first_name . ' ' . $fullname_upline->last_name;

            $gc->membership_left = Membership::select('membership_type_name', 'pairing_income')
                ->where('id', $gc->left_membertype->member_type_id)
                ->first();
            $gc->membership_right = Membership::select('membership_type_name', 'pairing_income')
                ->where('id', $gc->right_membertype->member_type_id)
                ->first();
            $gc->membership_upline = Membership::select('membership_type_name', 'pairing_income')
                ->where('id', $gc->upline_membertype->member_type_id)
                ->first();

            $gc->upline_account_id = ActivationCodes::select('account_id')->where('user_id', $gc->upline_user->user_id)->first();

            $gc->left_account_id = ActivationCodes::select('account_id')->where('user_id', $gc->left_user->user_id)->first();

            $gc->right_account_id = ActivationCodes::select('account_id')->where('user_id', $gc->right_user->user_id)->first();

            $gc->converted = ConvertGC::where('earnings_id', $gc->id)->first();
            $gc->left_amount = $gc->membership_left->pairing_income;
            $gc->right_amount = $gc->membership_right->pairing_income;
            $gc->upline_amount = $gc->membership_upline->pairing_income;

            $gc->voucher_amount = min($gc->upline_amount, $gc->left_amount, $gc->right_amount);
            $gc->img_voucher = asset('public/voucher/' . $gc->voucher_amount . '.jpg');
            $gc->voucher_value = $gc->voucher_amount / 2;
        }

        return $giftCheck;
    }

    function getFlushoutDetails($id, $date_from, $date_to)
    {
        // return $this->select('activation_codes.account_id', 'user_details.first_name', 'user_details.last_name', 'earnings.created_at', \DB::raw('SUM(earnings.amount) as amount'))
        //             ->leftJoin('accounts', 'accounts.id', '=', 'earnings.account_id')
        //             ->leftJoin('activation_codes', 'activation_codes.id', '=', 'accounts.code_id')
        //             ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
        //             ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
        //             ->orderBy('amount', 'ASC')
        //             ->whereIn('source', ['flushout'])
        //             ->where('earnings.user_id', $user_id);
        $flushout =  $this->where('account_id', $id)
            ->where('source', 'flushout');


        if (!empty($date_from)) $flushout->where('earned_date', '>=', $date_from);
        if (!empty($date_to)) $flushout->where('earned_date', '<=', $date_to);

        $details = $flushout->get();

        foreach ($details as $detail) {

            $l_account = Accounts::find($detail->left_user_id);
            $l_user = User::find($l_account->user_id);
            $l_user_details = Details::find($l_user->user_details_id);
            $l_membership = Membership::find($l_user->member_type_id);
            $l_activationcode = ActivationCodes::where('user_id', $l_user->id)->first();


            $r_account = Accounts::find($detail->right_user_id);
            $r_user = User::find($r_account->user_id);
            $r_user_details = Details::find($r_user->user_details_id);
            $r_membership = Membership::find($r_user->member_type_id);
            $r_activationcode = ActivationCodes::where('user_id', $r_user->id)->first();

            $payout[] = [
                'left_account_id' => $l_activationcode->account_id,
                'left_name' => $l_user_details->first_name . ' ' . $l_user_details->last_name,
                'left_package' => $l_membership->membership_type_name,
                'left_account_date' => $l_account->created_at,

                'right_account_id' => (!empty($r_activationcode)) ? $r_activationcode->account_id : '',
                'right_name' => $r_user_details->first_name . ' ' . $r_user_details->last_name,
                'right_package' => $r_membership->membership_type_name,
                'right_account_date' => $r_account->created_at,

                'source' => $detail->source,
                'mb' => ($detail->amount == 1) ? 0 : $detail->amount,
                'date' => $detail->earned_date,

            ];
        }

        return $payout;
    }

    function getFlushoutTotalAmount($id, $date_from, $date_to)
    {
        $flushout =  $this->where('account_id', $id)
            ->where('source', 'flushout')
            ->where('amount', '!=', 1);


        if (!empty($date_from)) $flushout->where('earned_date', '>=', $date_from);
        if (!empty($date_to)) $flushout->where('earned_date', '<=', $date_to);

        $details = $flushout->sum('amount');

        return $details;
    }

    public function getFlushout()
    {
        return $this->select('activation_codes.account_id', 'user_details.first_name', 'user_details.last_name', 'earnings.account_id as f_account_id', 'earnings.earned_date', \DB::raw('SUM(earnings.amount) as amount'))
            ->leftJoin('accounts', 'accounts.id', '=', 'earnings.account_id')
            ->leftJoin('activation_codes', 'activation_codes.user_id', '=', 'accounts.user_id')
            ->leftJoin('users', 'users.id', '=', 'accounts.user_id')
            ->leftJoin('user_details', 'user_details.id', '=', 'users.user_details_id')
            ->groupBy('earnings.account_id')
            ->orderBy('amount', 'Desc')
            ->where('source', 'flushout')
            ->where('amount', '!=', 1);
    }
}

<?php namespace App\Models;

class Company extends AbstractLayer
{

    protected $table = 'company';

    protected $appends = [
        'withdrawalSettings',
        'remainingBalance',
        'companyEarnings',
        'fundingTotal'
    ];

    function branches()
    {
        return $this->hasMany($this->namespace . '\Branches', 'company_id', 'id');
    }

    function getWithdrawalSettingsAttribute()
    {
        return WithdrawalSettings::find(1);
    }

    function getCompanyEarningsAttribute()
    {
        return CompanyEarnings::sum('amount');
    }

    function getFundingTotalAttribute()
    {
        return Earnings::where('from_funding', 'true')->sum('amount');
    }

    function getRemainingBalanceAttribute()
    {
        $userEarnings = Earnings::sum('amount');
        return $this->companyEarnings - ($userEarnings + $this->fundingTotal);
    }

    function redundant_binary_deduction_amount()
    {

        $rend_binary = Settings::where('name', Settings::REDUNDANT_BINARY_DEDUCTION_AMOUNT)->first();

        return $rend_binary->value;
    }
}

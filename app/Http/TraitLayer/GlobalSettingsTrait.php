<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/4/17
 * Time: 11:29 AM
 */

namespace App\Http\TraitLayer;

use App\Models\Company;

trait GlobalSettingsTrait{

    protected $toAvoidCodeTypes = [FREE_CODE];

    protected $earningsPairingKey = PAIRING_EARNINGS;

    protected $earningsDirectReferralKey = DIRECT_REFERRAL_EARNINGS;

    protected $earningsGCKey = GC_EARNINGS;

    protected $companyIncomeDetails = 'New Member.';

    protected $companyID = 1;
}
<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProgramService;

class Financing extends Model  {
	protected $table = 'financing';

    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'requester_id',
        'application_date',
        'application_amount',
        'type',
        'loan_type_others',
        'purpose',
        'loan_term',
        'repayments',
        'payment_mode',
        'class',
        'last_name',
        'first_name',
        'middle_name',
        'present_address',
        'present_address_no_stay',
        'present_address_contact',
        'provincial_address',
        'provincial_address_contact',
        'civil_status',
        'sex',
        'no_of_dependents',
        'no_in_elementary',
        'no_in_highschool',
        'no_in_college',
        'employer_name',
        'position',
        'employer_address',
        'employer_contact',
        'salary',
        'employment_status',
        'no_of_yrs_company',
        'fathers_name',
        'fathers_address',
        'fathers_contact',
        'mothers_name',
        'mothers_address',
        'mothers_contact',
        'business_nature',
        'monthly_income',
        'business_address',
        'yrs_in_business',
        'spouse_name',
        'spouse_employer',
        'spouse_employer_contact'
    ];

    protected $appends = [
        'class_string',
        'repayment_string',
        'type_string'
    ];

    /**
     * @var array
     */
    protected $dates = ['publish_date'];

    /**
     * @var constants
     */
    const TYPE_INSTANT         = '1';
    const TYPE_BACK_TO_BACK    = '2';
    const TYPE_HOSPITALIZATION = '3';
    const TYPE_PIRL_OR_JEWELRY = '4';
    const TYPE_OTHERS          = '5';
    const TYPES = [
	    self::TYPE_INSTANT         => 'Instant',
	    self::TYPE_BACK_TO_BACK    => 'Back to Back',
	    self::TYPE_HOSPITALIZATION => 'Hospitalization',
	    self::TYPE_PIRL_OR_JEWELRY => 'Pirl/Jewelry',
	    self::TYPE_OTHERS          => 'Others'
    ];

    const CLASS_CLEAN   = '1';
    const CLASS_PARTIAL = '2';
    const CLASS_SECURED = '3';
    const CLASSES = [
        self::CLASS_CLEAN   => 'Clean Loan',
        self::CLASS_PARTIAL => 'Partially Secured',
        self::CLASS_SECURED => 'Secured'
    ];

    const REPAYMENT_PDC     = '1';
    const REPAYMENT_PAYROLL = '2';
    const REPAYMENT_CASH    = '3';
    const REPAYMENTS = [
        self::REPAYMENT_PDC     => 'PDC',
        self::REPAYMENT_PAYROLL => 'Payroll Deduction',
        self::REPAYMENT_CASH    => 'Cash'
    ];

    public function transactions()
    {
        return $this->morphMany('App\Models\Transactions', 'details');
    }

    public function getTypeStringAttribute()
    {
        return self::TYPES[$this->type];
    }

    public function getClassStringAttribute()
    {
        return self::CLASSES[$this->class];
    }

    public function getRepaymentStringAttribute()
    {
        return self::CLASSES[$this->class];
    }

}

<?php namespace App\Http\AbstractHandlers;


use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Details;
use App\Models\Earnings;
use App\Models\PairingSettings;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

abstract class MainAbstract extends Controller{

    public $request;
    protected $records_per_page = 20;

    protected $rebatesEarningKey = 'rebates';
    protected $unilevelEarningKey = 'unilevel';

    protected $moneyPotProductPurchase = 'product_purchase';

    protected $upload_location = 'public/uploads';

    protected $createdAtFormat = 'Y-m-d H:i:s';

    protected $systemConfig = 'config/system.php';

    protected $currencies = [
        'usd'=>'&#36;',
        'yen'=>'&#xa5;',
        'eur'=>'&#x80;',
        'php'=>'&#x20b1;',
    ];

    protected $adminMenus = [
            'dashboard'=>[
                'activation-codes',
                'members',
                'funding',
                'transactions',
                'withdrawals',
                'top-earners',
                'administrators',
                'payment-history',
            ],
            'products'=>[
                'purchase-codes',
                'unilevel'
            ],
            'company'=>[
                'details',
                'settings',
                'connections',
                'registration',
                'paypal'
            ],
            'compensation-settings'=>[
                'income',
                'pairing',
                'vouchers',
                'withdrawal-settings'
            ],
            'mail-settings'=>[
                'mail-templates',
            ]
        ];

    protected $memberMenus = [
        'dashboard'=>[
            'investments',
            'network-tree',
        ],
        'purchases'=>[
            'buy',
            'encode',
            'history',
        ],
        'withdrawals'=>[
            'request',
            'pending',
            'history',
        ],
    ];
	
	 protected $tellerMenus = [
        'dashboard'=>[
			'activation-codes',
        ],
        
    ];

    function __construct(){
        if (!file_exists($this->upload_location)){
            mkdir($this->upload_location, 0777, true);
        }
    }

    function formatException($e){

        return sprintf('%s on line %s of file %s', $e->getMessage(), $e->getLine(), $e->getFile());

    }

    function validateUserDetails($request, $inject_rules = [], $requireBasicFields = true){

        $rules = ($requireBasicFields) ? [
            'first_name'=>'required',
            'last_name'=>'required',
        ] : [];

        /*if (isEmailRequired()){
            $rules['email'] = 'required|email|is_unique:user_details,email';
        }*/

        if (count($inject_rules) > 0){
            $rules = array_merge($rules, $inject_rules);
        }

        if ($request->password != null){
            $rules['password'] = 'min:8';
            $rules['password_confirm'] = 'required|same:password';
        }

        $validation = Validator::make($request->input(), $rules);

        return $validation;
    }

    function saveDetails($user_id, $request){
        $user = User::find($user_id);
        $details = Details::find($user->details->id);
        $details->title = $request->title;
        $details->first_name = $request->first_name;
        $details->middle_name = $request->middle_name;
        $details->last_name = $request->last_name;
        $details->suffix = $request->suffix;

        if($request->birth_date != '0000-00-00') $details->birth_date = $request->birth_date;

        $details->birth_place = $request->birth_place;
        $details->profession = $request->profession;
        $details->gender = $request->gender;
        $details->religion = $request->religion;
        $details->nationality = $request->nationality;
        $details->no_dependents = $request->no_dependents;
        $details->height = $request->height;
        $details->weight = $request->weight;

        $details->present_street = $request->present_street;
        $details->present_barangay = $request->present_barangay;
        $details->present_town = $request->present_town;
        $details->present_city = $request->present_city;
        $details->present_province = $request->present_province;
        $details->present_since = $request->present_since;
        $details->present_zipcode = $request->present_zipcode;

        $details->provincial_city = $request->provincial_city;
        $details->provincial_barangay = $request->provincial_barangay;
        $details->provincial_province = $request->provincial_province;
        $details->provincial_since = $request->provincial_since;
        $details->provincial_zipcode = $request->provincial_zipcode;

        $details->employer_name = $request->employer_name;
        $details->job_title = $request->job_title;
        if($request->date_hired != '0000-00-00') $details->date_hired = $request->date_hired;
        $details->job_status = $request->job_status;

        $details->educational_attainment = $request->educational_attainment;
        $details->school_last_attended = $request->school_last_attended;
        $details->education_year = $request->education_year;

        $details->cellphone_no = $request->cellphone_no;
        $details->other_contact_no = $request->other_contact_no;
        $details->home_tel_no = $request->home_tel_no;
        $details->spouse_tel_no = $request->spouse_tel_no;
        $details->province_tel_no = $request->province_tel_no;

        $details->tin = $request->tin;
        $details->GSIS = $request->GSIS;
        $details->SSS = $request->SSS;
        $details->senior = $request->senior;
        $details->voters = $request->voters;
        $details->philhealth = $request->philhealth;
        $details->pagibig = $request->pagibig;
        $details->drivers_license = $request->drivers_license;

        $details->s_last_name = $request->s_last_name;
        $details->s_first_name = $request->s_first_name;
        $details->s_middle_name = $request->s_middle_name;
        $details->s_suffix = $request->s_suffix;
        $details->s_gender = $request->s_gender;
        if($request->s_birth_date != '0000-00-00') $details->s_birth_date = $request->s_birth_date;
        $details->s_occupation = $request->s_occupation;

        $details->f_last_name = $request->f_last_name;
        $details->f_first_name = $request->f_first_name;
        $details->f_middle_name = $request->f_middle_name;
        $details->f_suffix = $request->f_suffix;

        $details->m_last_name = $request->m_last_name;
        $details->m_first_name = $request->m_first_name;
        $details->m_middle_name = $request->m_middle_name;
        $details->f_suffix = $request->f_suffix;

        $details->truemoney = $request->truemoney;
        $details->bank_name = $request->bank_name;
        $details->email = $request->email;
        $details->account_name = $request->bank_account_name;
        $details->account_number = $request->bank_account_number;

		// if ($user->username == $request->username) {
		// 	$user->username = $request->username.'-'.$user->details->id;
		// } else {
		$user->username = $request->username;
		// }
        
        if ($request->password !== '') {
            $user->password = Hash::make($request->password);
        }
        $details->save();
        $user->save();
    }

    function getEarningsDates(){
        $dates = Earnings::orderBy('id', 'DESC')->get();

        $theDates = [];
        $encoded = [];

        foreach ($dates as $date){
            $timestamp = strtotime($date->created_at);
            $value = sprintf('%s-%s', date('Y', $timestamp), date('m', $timestamp));

            if (!in_array($value, $encoded)){
                $theDates[$value] = sprintf('%s %s', date('F', $timestamp), date('Y', $timestamp));
                $encoded[] = $value;
            }

        }

        return $theDates;
    }

}
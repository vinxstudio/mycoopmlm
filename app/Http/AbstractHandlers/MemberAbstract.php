<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/4/17
 * Time: 6:30 PM
 */

namespace App\Http\AbstractHandlers;

use App\Helpers\ActivationCodeHelperClass;
use App\Helpers\ModelHelper;
use App\Http\TraitLayer\GlobalSettingsTrait;
use App\Models\ActivationCodes;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Company;
use App\Models\EWallet;
use App\Models\Membership;
use App\Models\ReactivationPurchases;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class MemberAbstract extends MainAbstract{

    use GlobalSettingsTrait;

    protected $viewpath = '';
    protected $theUser;
    protected $theDetails;
    protected $batchID = 0,
        $type = 'regular',
        $numberOfZeros = 5,
        $patternEveryLetter = 3,
        $prefixLength = 5,
        $codesToGenerate = 1
    ;
    protected $eWalletBalance;

    function __construct(){
        parent::__construct();
        $this->theUser = Auth::user();
        $this->theCompany = Company::find($this->companyID);
		$type = $this->theUser->member_type_id;
        $this->theMembership = Membership::find($type);
        $details = $this->theUser->details()->first();
        $this->theDetails =$details;

        $this->eWalletBalance = $this->theUser->remainingBalance;
        // $eWallet              = EWallet::where(['user_id' => $this->theUser->id])->first();
        // if ($eWallet->amount > 0) {
        //     $this->eWalletBalance = $eWallet->amount;    
        // }
        $my_accounts = User::select(['id','username','role'])
                            ->whereIn('id', $this->theUser->userIds )
                            ->orderBy('username', 'ASC')
                            ->get();
        view()->share([
            'theUser'=>$this->theUser,
            'company'=>$this->theCompany,
            'menus'=>$this->memberMenus,
			'member' =>$this->theMembership,
            'myaccounts' => $my_accounts,
            'theDetails' => $details,
            'eWalletBalance' => $this->eWalletBalance
        ]);
        // echo "<pre>";
        // print_r($my_accounts);
        // die;
        if ($this->theCompany->activation_every > 0){
            $this->checkIfNeedsActivation();
        }
    }

    private function checkIfNeedsActivation(){

        $overallEarnings = $this->theUser->earnings;
        $purchasedReactivation = ReactivationPurchases::where([
            'user_id'=>$this->theUser->id
        ])->get();

        $targetNumberOfActivation = (int)($overallEarnings / $this->theCompany->activation_every);
		
		/*
        if ($targetNumberOfActivation > $purchasedReactivation->count()){
            $this->theUser->is_maintained = false;
            $this->theUser->save();
        }
		*/

    }

    function generateActivationCode(){
        $codes = new ActivationCodeHelperClass();
        $codes
            ->setBatchID($this->batchID)
            ->setCodeType($this->type)
            ->setNumOfZeros($this->numberOfZeros)
            ->setPatternEveryLetter($this->patternEveryLetter)
            ->setPrefixLength($this->prefixLength)
            ->setOwnerID($this->theUser->id);

        

$dbUser = User::find($this->theUser->id);
$theCodes = $codes->generateCodes($this->codesToGenerate,$dbUser->member_type_id);

        $model = new ModelHelper();
        $theCodes[0]['paid_by_balance'] = true;
        return $model->manageModelData(new ActivationCodes, $theCodes[0]);
    }

}
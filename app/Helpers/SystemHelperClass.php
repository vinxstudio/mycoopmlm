<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/22/16
 * Time: 2:41 PM
 */

namespace App\Helpers;

use App\Models\Accounts;
use App\Models\ActivationCodeBatches;
use App\Models\ActivationCodes;
use App\Models\Company;
use App\Models\CompanyEarnings;
use App\Models\Connection;
use App\Models\Details;
use App\Models\Downlines;
use App\Models\Earnings;
use App\Models\Membership;
use App\Models\MoneyPot;
use App\Models\PairingSettings;
use App\Models\Products;
use App\Models\ProductUnilevel;
use App\Models\PurchaseCodes;
use App\Models\Purchases;
use App\Models\User;
use App\Models\Withdrawals;
use App\Models\WithdrawalSettings;
use Illuminate\Support\Facades\Hash;

class SystemHelperClass{

    public $company;
    protected $createdAt;

    function __construct(){
        $this->company = Company::find(1);
        $this->createdAt = date('Y-m-d h:i:s');
    }

    function resetSystem(){
        User::truncate();
        Details::truncate();
        Accounts::truncate();
        ActivationCodes::truncate();
        ActivationCodeBatches::truncate();
        CompanyEarnings::truncate();
        Connection::truncate();
        Downlines::truncate();
        Earnings::truncate();
        MoneyPot::truncate();
        PairingSettings::truncate();
        Products::truncate();
        PurchaseCodes::truncate();
        ProductUnilevel::truncate();
        Purchases::truncate();
        Withdrawals::truncate();

        $this->populateAccounts();
        $this->populateActivationCode();
        $this->resetCompany();
        $this->resetMembership();
        $this->populatePairingSettings();
        $this->populateProducts();
        $this->populateUnilevel();
        $this->populateUsers();
        $this->resetWithdrawalSettings();

    }

    private function populateAccounts(){
        $account = new Accounts();
        $account->user_id = 2;
        $account->code_id = 1;
        $account->upline_id = 0;
        $account->sponsor_id = 0;
        $account->node = 'left';
        $account->save();
    }

    private function populateActivationCode(){
        $code = new ActivationCodes();
        $code->batch_id = 0;
        $code->code = 'DEFAULT001';
        $code->account_id = 'DEFAULT001';
        $code->status = 'used';
        $code->type = 'free';
        $code->user_id = 0;
        $code->save();
    }

    private function resetCompany(){
        $company = Company::find(1);
        $company->app_name = 'Binary System';
        $company->name = 'My Business';
        $company->phone = '004 222 222';
        $company->address = 'Building, Office 1';
        $company->first_time = 'false';
        $company->main_admin_id = 0;
        $company->save();
    }

    private function resetMembership(){
        $membership = Membership::find(1);
        $membership->entry_fee = 1895;
        $membership->global_pool = 0;
        $membership->enable_voucher = true;
        $membership->max_pairing = 32;
        $membership->save();
    }

    private function populatePairingSettings(){
        $settings = [];
        $amount = 150;
        for ($i = 1; $i<= 10; $i++){
            $settings[] = [
                'level'=>$i,
                'amount'=>$amount,
                'created_at'=>$this->createdAt
            ];
            $amount += 10;
        }

        PairingSettings::insert($settings);
    }

    private function populateProducts(){
        $product = new Products();
        $product->name = 'Product 1';
        $product->price = 800;
        $product->global_pool = 0;
        $product->rebates = 15;
        $product->save();
    }

    private function populateUnilevel(){
        $insert = [];
        $baseAmount = 5;
        for ($i = 1; $i <= 10; $i++){
            $insert[] = [
                'product_id'=>0,
                'level'=>$i,
                'amount'=>$baseAmount,
                'created_at'=>$this->createdAt
            ];
            $baseAmount += 5;
        }

        ProductUnilevel::insert($insert);

    }

    private function populateUsers(){

        $users[] = [
            'username'=>'admin001@gmail.com',
            'password'=>Hash::make('password'),
            'user_details_id'=>1,
            'role'=>'admin',
            'default_member'=>'true',
            'is_maintained'=>true,
            'created_at'=>$this->createdAt
        ];

        $users[] = [
            'username'=>'member001',
            'password'=>Hash::make('password'),
            'user_details_id'=>2,
            'role'=>'member',
            'default_member'=>'true',
            'is_maintained'=>true,
            'created_at'=>$this->createdAt
        ];

        $details[] = [
            'first_name'=>'Admin001',
            'last_name'=>'Admin001',
            'bank_name'=>'BNK001',
            'account_name'=>'ACCT001',
            'account_number'=>'0000001',
            'created_at'=>$this->createdAt
        ];

        $details[] = [
            'first_name'=>'Member 01',
            'last_name'=>'Member 01',
            'bank_name'=>'BNK002',
            'account_name'=>'ACCT002',
            'account_number'=>'0000002',
            'created_at'=>$this->createdAt
        ];

        User::insert($users);
        Details::insert($details);

    }

    private function resetWithdrawalSettings(){
        $with = WithdrawalSettings::find(1);
        $with->minimum_amount = 1000;
        $with->admin_charge = 25;
        $with->tax_percentage = 10;
        $with->save();
    }

}
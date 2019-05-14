<?php
/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 4/29/16
 * Time: 7:22 AM
 */

namespace App\Http\Modules\Admin\Company\Validation;

use App\Helpers\ModelHelper;
use App\Http\AbstractHandlers\MainValidationHandler;
use App\Models\Branches;
use App\Models\Company;

class CompanyValidationHandler extends MainValidationHandler{

    function __construct(){
        parent::__construct();
    }

    function validate(){
        $inputs = $this->getInputs();
        $rules = $this->getRules();

        $result = $this->handle($inputs, $rules);

        if (!$result->error){
            try {
                $model = new ModelHelper();

                $company = $model
                    ->setPrimaryKey('id')
                    ->manageModelData(new Company, [
                        'id' => 1,
                        'app_name' => $inputs['programName'],
                        'name' => $inputs['companyName'],
                        'phone' => $inputs['phone'],
                        'address' => $inputs['address']
                    ]);

                $branchData = [
                    'name'=>$company->name,
                    'address'=>$company->address,
                    'phone'=>$company->phone,
                    'main_branch'=>'0'
                ];

                $branchFind = Branches::where([
                    'main_branch'=>'0'
                ])->get();

                if (!$branchFind->isEmpty()){
                    $branchData['id'] = $branchFind->first()->id;
                }

                $branch = $model->setPrimaryKey('id')->manageModelData(new Branches, $branchData);

                $this->result->message = 'Company Details are now up to date!';
                
            } catch (Exception $e){
                $this->result->error = true;
                $this->result->message = $e->getMessage();
            }
        }

        $this->result->message_type = ($this->result->error) ? 'danger' : 'success';
        return $this->result;
    }

}
<?php

/**
 * Created by PhpStorm.
 * User: jomeravengoza
 * Date: 3/7/17
 * Time: 7:45 PM
 */

namespace App\Http\Modules\Member\Investments\Controllers;

use App\Helpers\ActivationCodeHelperClass;
use App\Helpers\ModelHelper;
use App\Http\AbstractHandlers\MemberAbstract;
use App\Models\ActivationCodes;
use App\Models\ReactivationPurchases;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class InvestmentsMemberController extends MemberAbstract
{

    protected $viewpath = 'Member.Investments.views.';

    protected $membersController = 'App\Http\Modules\Admin\Members\Controllers\MembersAdminController';

    function __construct()
    {
        parent::__construct();
    }

    function getIndex()
    {

        return view($this->viewpath . 'index')
            ->with([
                'accounts' => $this->theUser->accounts()->get(),
                'purchased' => ActivationCodes::where('user_id', $this->theUser->id)->paginate(10),
                'buyAmount' => codePurchaseAmount()
            ]);

    }

    function getBuy()
    {
        if (config('system.slot_buying') == FALSE_STATUS) {
            return redirect('investments');
        }
        $remainingBalance = $this->theUser->remainingBalance;
        $entryFee = codePurchaseAmount();

        $error = false;
        $message = '';

        if ($remainingBalance >= $entryFee) {

            $model = new ModelHelper();
            $activationCode = $this->generateActivationCode();

            if ($this->theUser->is_maintained == false) {
                $purchased = [
                    'user_id' => $this->theUser->id,
                    'code_id' => $activationCode->id
                ];

                $model->manageModelData(new ReactivationPurchases, $purchased);
                $this->theUser->is_maintained = true;
                $this->theUser->save();
            }
            $message = Lang::get('investments.success_buy');
        } else {
            $error = true;
            $message = Lang::get('investments.low_balance');
        }

        return back()
            ->with(
                ($error) ? 'danger' : 'success',
                $message
            );
    }

    function getEncode()
    {
        return app($this->membersController)->getForm($user_id = 0, $this->theUser->id);
    }

    function postEncode(Request $request)
    {
        return app($this->membersController)->postForm($request, $user_id = 0, $this->theUser->id);
    }
}
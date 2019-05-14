<?php namespace App\Models;

use Illuminate\Support\Facades\DB;

class Accounts extends AbstractLayer {

    protected $table = 'accounts';

    protected $appends = [
        'downlinesArray',
        'uplineIDs',
        'sponsorID',
        'upline',
        'totalEarned',
        'carries',
        'childIds',
        'uplineUser'
    ];

    function user(){
        return $this->hasOne($this->namespace.'\User', 'id', 'user_id');
    }

    function code(){
        return $this->hasOne($this->namespace.'\ActivationCodes', 'id', 'code_id');
    }

    function earnings(){
        return $this->hasMany($this->namespace.'\Earnings', 'account_id', 'id');
    }

    function downlines(){
        return $this->hasMany($this->namespace.'\Downlines', 'parent_id', 'id');
    }

    function getDownlinesArrayAttribute(){

        $paired = $this->earnings()->where('source', $this->earningsPairingKey)->get();

        $freeCodes = ActivationCodes::where('type', 'free')->get();

        $freeCodeIds = [0];

        foreach ($freeCodes as $code){
            $freeCodeIds[] = $code->id;
        }

        $pairedIDs = [];

        foreach ($paired as $row){
            $pairedIDs[] = $row->left_user_id;
            $pairedIDs[] = $row->right_user_id;
        }

        $downlineQuery = $this->downlines()->whereNotIn('code_id', $freeCodeIds);

        if (count($pairedIDs) > 0){
            $downlineQuery->whereNotIn('account_id', $pairedIDs);
        }

        $downlines = $downlineQuery->orderBy('level', 'asc')->get();

        $result = new \stdClass();

        $result->withLevel = [];

        $result->withoutLevel = [];

        $staticLevel = 1;

        foreach ($downlines as $downline){

//            if (!in_array($downline->code_id, $freeCodeIds)) { //technically this is not needed, but to be sure, let's leave it here.
            $result->withLevel[$downline->level][$downline->node][] = $downline->account_id;
            $result->withoutLevel[$staticLevel][$downline->node][] = $downline->account_id;
//            }

        }

        return $result;
    }

    function getUplineIDsAttribute(){
        $downlines = Downlines::where('account_id', $this->attributes['id'])->get();

        $ids = [];
        foreach ($downlines as $row){
            $ids[] = $row->parent_id;
        }

        return $ids;
    }

    function getSponsorIDAttribute(){

        $id = '( none )';
        if ($this->attributes['sponsor_id'] > 0){

            $id = Accounts::find($this->attributes['sponsor_id'])->code->account_id;

        }

        return $id;

    }


    function getUplineAttribute(){

        return Accounts::find($this->attributes['upline_id']);

    }

    function getUplineUserAttribute(){
        if ($this->attributes['upline_id'] > 0) {
            $account = Accounts::find($this->attributes['upline_id']);
            return User::find($account->user_id);
        } else {
            return null;
        }
    }

    function getTotalEarnedAttribute(){
        $earnings = Earnings::where('account_id', $this->attributes['id'])
		           ->whereIn('source', ['pairing', 'direct_referral'])
		           ->sum('amount');
				   $activation = ActivationCodes::where('user_id', $this->attributes['user_id'])->first();
				  /*
				  whereIn('source', ['pairing', 'direct_referral'])->sum('amount');
		$activation = ActivationCodes::where('user_id', $this->attributes['id'])->first();
		if (isset($activation->type_id) && $activation->type_id > 3) {
			$earnings = 0;
		}
        return $earnings;
				  
				  */
		if (isset($activation->type_id) && $activation->type_id > 3) {
			$earnings = 0;
		}
		
		return $earnings;
    }

    function getCarriesAttribute(){

        $downline = Accounts::where([
            'upline_id'=>$this->attributes['id']
        ])->get();

        $carries = [
            'left'=>[],
            'right'=>[]
        ];

        $avoidIds = [];

        $paired = $this->earnings()->where('source', $this->earningsPairingKey)->get();

        foreach ($paired as $row){
            $avoidIds[] = $row->left_user_id;
            $avoidIds[] = $row->right_user_id;
        }

        foreach ($downline as $first){

            if (!in_array($first->id, $avoidIds)) {
                $carries[$first->node][] = $first->id;
            }

            $childIds = $this->getChildIDs($first->id);

            foreach ($childIds as $id){
                if (!in_array($id, $avoidIds)) {
                    $carries[$first->node][] = $id;
                }
            }

        }

        return $carries;

    }

    private function getChildIDs($parent_id){

        $ids = [];

        $account = Accounts::where('upline_id', $parent_id)->get();

        foreach ($account as $acc){
            $ids[] = $acc->id;
            $childIds = $this->getChildIDs($acc->id);

            foreach ($childIds as $id){
                $ids[] = $id;
            }
        }

        return $ids;

    }

    function getChildIdsAttribute(){
        return $this->getChildIDs($this->attributes['id']);
    }

}
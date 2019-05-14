<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountRedudantPointsHistory extends Model
{

    //

    protected $table = 'account_redudant_points_histories';

    public $incrementing = false;

    protected $primaryKey = null;

    protected $appends = ['purchases_name', 'given_points_name'];

    const ADD_POINTS = 'add_points';
    const DEDUCT_POINTS = 'deduct_points';

    const NODE_LEFT = 'left';
    const NODE_RIGHT = 'right';
    const NODE_BOTH = 'both';

    /**
     * Get Purchase Name By Purchase Account ID
     */
    public function getPurchasesNameAttribute()
    {
        $user_id = Accounts::where('id', $this->attributes['purchase_account_id'])->pluck('user_id');

        if (!$user_id) {
            return 'N / A';
        }

        $user_details_id = User::where('id', $user_id)->pluck('user_details_id');

        $details = Details::select('first_name', 'middle_name', 'last_name')->where('id', $user_details_id)->first();

        $fullname = isset($details->first_name) ? $details->first_name : '';
        $fullname .= ' ';
        $fullname .= isset($details->middle_name) ? $details->middle_name : '';
        $fullname .= ' ';
        $fullname .= isset($details->last_name) ? $details->last_name : '';

        return $fullname;
    }

    public function getGivenPointsNameAttribute()
    {
        $account_id = AccountRedudantPoints::where('id', $this->attributes['account_redundant_points_id'])->pluck('account_id');

        if (!$account_id) {
            return 'N / A';
        }

        $user_id = Accounts::where('id', $account_id)->pluck('user_id');

        $user_details_id = User::where('id', $user_id)->pluck('user_details_id');

        $details = Details::select('first_name', 'middle_name', 'last_name')->where('id', $user_details_id)->first();

        $fullname = isset($details->first_name) ? $details->first_name : '';
        $fullname .= ' ';
        $fullname .= isset($details->middle_name) ? $details->middle_name : '';
        $fullname .= ' ';
        $fullname .= isset($details->last_name) ? $details->last_name : '';

        return $fullname;
    }
}

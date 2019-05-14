<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use App\Models\AccountRedudantPoints;
use App\Models\AccountRedudantPointsHistory;
use App\Models\ProductPointsEquivalent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Earnings;
use App\Models\Accounts;
use App\Models\AvailableBalance;

class CalculatePairedRedundantPoints extends Command implements SelfHandling, ShouldBeQueued
{

    use InteractsWithQueue, SerializesModels;

    protected $points;

    /**
	 * Create a new command instance.
	 *
	 * @return void
	 */
    public function __construct(AccountRedudantPoints $points)
    {
        //
        $this->points = $points;
    }

    /**
	 * Execute the command.
	 *
	 * @return void
	 */
    public function handle()
    {
        //

        $points = $this->points;

        $rend_settings = ProductPointsEquivalent::find(ProductPointsEquivalent::REDUNDANT_BINARY_SETTINGS);

        $points_value = $rend_settings->points_value;

        $equivalent = $rend_settings->points_equivalent;

        $account_id = $points->account_id;

        $user_id = Accounts::where('id', $account_id)->pluck('user_id');

        $group_id = User::where('id', $user_id)->pluck('group_id');

        while ($points->left_points_value >= $points_value && $points->right_points_value >= $points_value) {
            DB::beginTransaction();
            try {

                $points->left_points_value -= $points_value;
                $points->right_points_value -= $points_value;

                $points->save();

                $rend_points_history = new AccountRedudantPointsHistory();

                $rend_points_history->account_redundant_points_id = $points->id;
                $rend_points_history->type = AccountRedudantPointsHistory::DEDUCT_POINTS;
                $rend_points_history->points_node = AccountRedudantPointsHistory::NODE_BOTH;
                $rend_points_history->amount = $points_value;

                $rend_points_history->save();

                $earnings = new Earnings();

                $earnings->account_id = $account_id;
                $earnings->user_id = $user_id;
                $earnings->source = Earnings::SOURCE_REDUNDANT;
                $earnings->amount = $equivalent;
                $earnings->level = 0;
                $earnings->earned_date = Carbon::now();

                $earnings->save();

                $available_balance = AvailableBalance::firstOrCreate(['group_id' => $group_id, 'source' => AvailableBalance::SOURCE_REDUNDANT_BINARY_INCOME]);

                $available_balance->available_balance += $equivalent;

                $available_balance->save();

                DB::commit();
            } catch (\Exception $e) {

                Log::debug('Redundant Binary Error');
                Log::debug('Date : ' . Carbon::now());
                Log::debug('File : ' . $e->getFile());
                Log::debug('Exception : ' . get_class($e));
                Log::debug('Error : ' . $e->getTraceAsString());

                DB::rollback();
            }
        }
    }
}

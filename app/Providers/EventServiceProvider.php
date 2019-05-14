<?php namespace App\Providers;

use App\Models\Company;
use App\Models\Connection;
use App\Models\Details;
use App\Models\Membership;
use App\Models\PairingSettings;
use App\Models\Products;
use App\Models\Purchases;
use App\Models\User;
use App\Models\Withdrawals;
use App\Models\WithdrawalSettings;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'event.name' => [
			'EventListener',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		//
        User::saving(function($user){

            $user->username = strip_tags($user->username);

        });

        Details::saving(function($details){

            $fieldsToStrip = [
                'first_name',
                'last_name',
                'bank_name',
                'account_name',
                'account_number',
            ];

            foreach ($fieldsToStrip as $field) {
                $details->{$field} = strip_tags($details->{$field});
            }

        });

        Company::saving(function($company){

            $fieldsToStrip = [
                'app_name',
                'name',
                'phone',
                'address',
                'entry_fee',
                'activation_code_prefix',
                'product_code_prefix',
                'referral_income',
                'passcode',
                'minimum_product_purchase'
            ];

            foreach ($fieldsToStrip as $field){
                $company->{$field} = strip_tags($company->{$field});
            }

        });

        Connection::saving(function($connection){

            $connection->url = strip_tags($connection->url);
            $connection->passcode = strip_tags($connection->passcode);

        });

        Membership::saving(function($membership){

            $membership->entry_fee = strip_tags($membership->entry_fee);
            $membership->max_pairing = strip_tags($membership->max_pairing);

        });

        /*PairingSettings::saving(function($pairing){

            $pairing->amount = strip_tags($pairing);

        });*/

        WithdrawalSettings::saving(function($settings){

            $settings->minimum_amount = strip_tags($settings->minimum_amount);
            $settings->admin_charge = strip_tags($settings->admin_charge);
            $settings->tax_percentage = strip_tags($settings->tax_percentage);

        });

        Withdrawals::saving(function($row){

            $fieldsToStrip = [
                'amount',
                'bank_name',
                'account_name',
                'account_number',
                'notes'
            ];

            foreach ($fieldsToStrip as $field){
                $row->{$field} = strip_tags($row->{$field});
            }

        });

        Products::saving(function($row){

            $fieldsToStrip = [
                'name',
                'price',
                'global_pool',
                'rebates'
            ];

            foreach ($fieldsToStrip as $field){
                $row->{$field} = strip_tags($row->{$field});
            }

        });

	}

}

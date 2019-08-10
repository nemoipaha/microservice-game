<?php

namespace App\Providers;

use App\User;
use Carbon\Carbon;
use Dusterio\LumenPassport\LumenPassport;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });

        LumenPassport::routes($this->app, ['prefix' => 'api/v1/oauth']);

        Passport::personalAccessClientId($this->app['config']->get('passport.personal_access_client_id'));

        Passport::tokensCan([
            'show-users' => 'See users',
            'edit-users' => 'Update users',
            'super-admin' => 'Super admin'
        ]);

        Passport::tokensExpireIn(Carbon::now()->addHour());

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        Passport::personalAccessTokensExpireIn(Carbon::now()->addMonths(6));

//        Passport::enableImplicitGrant();
    }
}

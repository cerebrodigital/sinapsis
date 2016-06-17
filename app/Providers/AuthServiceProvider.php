<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\models\Post' => 'App\Policies\PostPolicy',
        'App\models\Video' => 'App\Policies\VideoPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        // ROLE GATES
        $gate->define('toor-access', function($user){
            return $user->role == 'toor';
        });
        $gate->define('admin-access', function($user){
            return $user->role == 'admin';
        });

        $gate->define('manager-access', function($user){
            return $user->role == 'manager';
        });
        $gate->define('neurona-access', function($user){
            return $user->role == 'neurona';
        });
        // CONTENT GATES
        $gate->define('post-author', function($user, $user_id) {
            return $user->id === $user_id;
        });

        $gate->define('video-author', function($user, $user_id) {
            return $user->id === $user_id;
        });
            

        //
    }
}

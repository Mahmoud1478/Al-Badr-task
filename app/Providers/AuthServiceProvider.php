<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Classes\Permission;
use App\Models\Client;
use App\Models\User;
use App\Policies\ClientPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Client::class => ClientPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        foreach (Permission::keys() as $permission){
            Gate::define($permission,fn(User $user) => in_array($permission,$user->permissions));
        }
        Gate::before(function ($user, $ability) {
            if ($user->id == 1) {
                return true;
            }
        });
    }
}

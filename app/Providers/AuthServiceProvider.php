<?php

namespace App\Providers;

use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();



       // foreach ($this->getPermission() as $permission){
         //   Gate::define($permission->permission, function ($user) use ($permission){
           //    return $user->hasRole($permission->roles);
            //});
       // }
    }

    protected function getPermission(){
        return Permission::with('roles')->get();
    }
}

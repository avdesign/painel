<?php

namespace AVDPainel\Providers\Admin;

use AVDPainel\Models\Admin\Admin;
use AVDPainel\Models\Admin\AdminPermission;
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
        // 'AVDPainel\Model' => 'AVDPainel\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $permissions = AdminPermission::all();

        foreach ( $permissions as $permission ) {

            Gate::define($permission->name, function(Admin $admin) use ($permission){
                return $admin->id == $permission->admin_id;
            });
        }

        Gate::before(function(Admin $admin, $ability){
            if( $admin->profile == 'Master')
                return true;
        });

    }
}

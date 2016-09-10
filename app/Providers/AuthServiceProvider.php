<?php

namespace App\Providers;

use App\Category;
use App\Clan;
use App\Conversation;
use App\Event;
use App\Feed;
use App\Like;
use App\Permission;
use App\Policies\CategoryPolicy;
use App\Policies\ClanPolicy;
use App\Policies\ConversationPolicy;
use App\Policies\EventPolicy;
use App\Policies\FeedPolicy;
use App\Policies\LikePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\UserPolicy;
use App\Role;
use App\Setting;
use App\User;
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
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        User::class => UserPolicy::class,
        Category::class => CategoryPolicy::class,
        Clan::class => ClanPolicy::class,
        Feed::class => FeedPolicy::class,
        Conversation::class => ConversationPolicy::class,
        Event::class => EventPolicy::class,
        Like::class => LikePolicy::class,
        Setting::class => SettingPolicy::class,
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

        //
    }
}

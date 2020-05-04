<?php

namespace Azuriom\Plugin\Support\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Support\Models\Comment;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Policies\CommentPolicy;
use Azuriom\Plugin\Support\Policies\TicketPolicy;
use Azuriom\Plugin\Support\View\Composers\SupportAdminDashboardComposer;
use Illuminate\Support\Facades\View;

class SupportServiceProvider extends BasePluginServiceProvider
{
    /**
     * The policy mappings for this plugin.
     *
     * @var array
     */
    protected $policies = [
        Ticket::class => TicketPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        View::composer('admin.dashboard', SupportAdminDashboardComposer::class);

        Permission::registerPermissions([
            'support.tickets' => 'support::admin.permissions.tickets',
            'support.categories' => 'support::admin.permissions.categories',
        ]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions()
    {
        return [
            'support.tickets.index' => 'support::messages.title',
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array
     */
    protected function adminNavigation()
    {
        return [
            'support' => [
                'name' => 'support::admin.title',
                'icon' => 'fas fa-question',
                'route' => 'support.admin.tickets.index',
                'permission' => 'support.tickets',
            ],
        ];
    }
}

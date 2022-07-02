<?php

namespace Azuriom\Plugin\Support\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Support\Models\Comment;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Policies\CommentPolicy;
use Azuriom\Plugin\Support\Policies\TicketPolicy;
use Azuriom\Plugin\Support\View\Composers\SupportAdminDashboardComposer;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\View;

class SupportServiceProvider extends BasePluginServiceProvider
{
    /**
     * The policy mappings for this plugin.
     *
     * @var array
     */
    protected array $policies = [
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

        ActionLog::registerLogs('support-tickets.closed', [
            'icon' => 'ban',
            'color' => 'info',
            'message' => 'support::admin.logs.tickets.closed',
            'model' => Ticket::class,
        ]);

        Relation::morphMap(['support.comments' => Comment::class]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions()
    {
        return [
            'support.tickets.index' => trans('support::messages.title'),
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
                'name' => trans('support::admin.title'),
                'icon' => 'bi bi-question-circle',
                'route' => 'support.admin.tickets.index',
                'permission' => 'support.tickets',
            ],
        ];
    }
}

<?php

namespace Azuriom\Plugin\Support\Providers;

use Azuriom\Extensions\Plugin\AdminUserEditComposer;
use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Support\Commands\CloseStaleTickets;
use Azuriom\Plugin\Support\Models\Comment;
use Azuriom\Plugin\Support\Models\Ticket;
use Azuriom\Plugin\Support\Policies\CommentPolicy;
use Azuriom\Plugin\Support\Policies\TicketPolicy;
use Azuriom\Plugin\Support\View\Composers\SupportAdminDashboardComposer;
use Azuriom\Plugin\Support\View\Composers\SupportAdminUserComposer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\View;

class SupportServiceProvider extends BasePluginServiceProvider
{
    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [
        Ticket::class => TicketPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
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

        ActionLog::registerLogs('support-tickets.reopened', [
            'icon' => 'arrow-repeat',
            'color' => 'info',
            'message' => 'support::admin.logs.tickets.reopened',
            'model' => Ticket::class,
        ]);

        Relation::morphMap(['support.comments' => Comment::class]);

        $this->commands(CloseStaleTickets::class);

        if (method_exists($this, 'registerSchedule')) {
            $this->registerSchedule();
        }

        if (class_exists(AdminUserEditComposer::class)) {
            View::composer('admin.users.edit', SupportAdminUserComposer::class);
        }
    }

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('support:close-stale')->daily();
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            'support.tickets.index' => trans('support::messages.title'),
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, string>>
     */
    protected function adminNavigation(): array
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

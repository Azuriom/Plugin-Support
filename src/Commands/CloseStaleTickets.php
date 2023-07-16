<?php

namespace Azuriom\Plugin\Support\Commands;

use Azuriom\Plugin\Support\Models\Ticket;
use Illuminate\Console\Command;

class CloseStaleTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'support:close-stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close stale support tickets.';

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws \Exception
     */
    public function handle()
    {
        $tickets = Ticket::open()->get();
        $delay = setting('support.close_after_days');

        if ($delay === null) {
            return 0;
        }

        foreach ($tickets as $ticket) {
            $lastReply = $ticket->comments()->latest()->first();

            if ($lastReply->created_at->diffInDays() >= $delay) {
                $ticket->closed_at = now();
                $ticket->save();

                $this->info('Closing ticket '.$ticket->id.' by user '.$ticket->author->name);
            }
        }

        return 0;
    }
}

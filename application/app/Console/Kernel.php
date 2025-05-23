<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel {
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Nextloop
     * This is the applications task/cron scheduler. You can create more tasks in this schedule
     *      For cronjob tasks, you create the classes inside of '/App/Cronjobs/'
     *      Example is the email cronjob that runs every minute
     *      This scheduler is executed every minute by the single cronjob that is set in cpanel
     *      Teh Cpanel cronjob executes (using real file path) the comman below
     *                  - php artisan schedule:run
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {

        //updating cron
        $schedule->call(new \App\Cronjobs\UpdatingCron)->everyMinute();

        //send [regular] queued emails
        $schedule->call(new \App\Cronjobs\EmailCron)->everyMinute();

        //send [direct] queued emails
        $schedule->call(new \App\Cronjobs\DirectEmailCron)->everyMinute();

        //send pdf generating emails (invoice & estimate)
        $schedule->call(new \App\Cronjobs\EmailBillsCron)->everyMinute();

        //process webhooks for all onetime payments
        $schedule->call(new \App\Cronjobs\Onetime\OnetimePayment)->everyMinute();

        //process webhooks for stripe subsription payments
        $schedule->call(new \App\Cronjobs\Stripe\SubscriptionPayment)->everyMinute();

        //process webhooks for stripe subsription renewal
        $schedule->call(new \App\Cronjobs\Stripe\SubscriptionRenewal)->everyMinute();

        //process webhooks for stripe cancellation that was initiated in strip
        $schedule->call(new \App\Cronjobs\Stripe\SubscriptionCancelled)->everyMinute();

        //process webhooks for stripe cancellation that was initiated in the dashboard
        $schedule->call(new \App\Cronjobs\Stripe\SubscriptionPushCancellation)->everyMinute();

        //process webhooks for stripe subsription renewal
        $schedule->call(new \App\Cronjobs\Stripe\SubscriptionUpdateTransaction)->hourly();

        //process project progress
        $schedule->call(new \App\Cronjobs\ProjectProgressCron)->everyMinute();

        //recurring crom (invoices, expenses, etc)
        $schedule->call(new \App\Cronjobs\RecurringCron)->everyMinute();

        //Invoice statuses & overdue invoice reminders
        $schedule->call(new \App\Cronjobs\OverdueInvoicesCron)->everyFiveMinutes();

        //Overdue task reminders
        $schedule->call(new \App\Cronjobs\TaskOverdueCron)->everyFiveMinutes();

        //Overdue task reminders
        $schedule->call(new \App\Cronjobs\TaskOverdueCron)->everyFiveMinutes();

        //Rcurring Tasks
        $schedule->call(new \App\Cronjobs\RecurringTasksCron)->everyMinute();

        //Reminders
        $schedule->call(new \App\Cronjobs\ReminderCron)->everyMinute();

        //Proposals
        $schedule->call(new \App\Cronjobs\ProposalsCron)->everyMinute();

        //Cleanup
        $schedule->call(new \App\Cronjobs\Cleanup\OrphanedRecordsCron)->everyMinute();

        //tap payments
        $schedule->call(new \App\Cronjobs\Tap\TapPaymentCron)->everyMinute();

        //scheduled tasks
        $schedule->call(new \App\Cronjobs\ScheduledCron)->everyMinute();

        //fixes
        $schedule->call(new \App\Cronjobs\Cleanup\FixesCron)->everyMinute();

        //calendar
        $schedule->call(new \App\Cronjobs\CalendarReminderCron)->everyMinute();

        //[imap][tickets] - fetch new support ticket emails from impa server
        $schedule->call(new \App\Cronjobs\ImapTicketsFetchCron)->everyMinute();

        //[imap][tickets] - send queued support ticket reply emails
        $schedule->call(new \App\Cronjobs\ImapTicketRepliesCron)->everyMinute();


        //[modules]
        $schedule->call(new \App\Cronjobs\Modules\SyncModulesCron)->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

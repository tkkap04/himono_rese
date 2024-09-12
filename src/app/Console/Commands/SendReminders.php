<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEmail;
use Carbon\Carbon;

class SendReminders extends Command
{

    protected $signature = 'reminder:send';

    protected $description = 'Send reminder emails';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $reservations = Reservation::where('date', $today)->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->user->email)->send(new ReminderEmail($reservation));
            $this->info('Reminder email sent for reservation: ' . $reservation->id);
        }

        $this->info('All reminder emails sent successfully.');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $qrCodePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation, $qrCodePath)
    {
        $this->reservation = $reservation;
        $this->qrCodePath = $qrCodePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('-Rese-予約完了のお知らせ')
                    ->view('emails.reservation')
                    ->with([
                        'reservation' => $this->reservation,
                        'qrCodePath' => $this->qrCodePath,
                    ])
                    ->attach($this->qrCodePath);
    }
}

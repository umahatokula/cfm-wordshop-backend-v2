<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;

class PreOrderedLinks extends Mailable
{
    use Queueable, SerializesModels;

    public $sermons;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $sermons)
    {
        $this->sermons = $sermons;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Faith Adventure 2021 Sermons [CORRECTED]')->view('mails.orders.preOrderLinks');
    }
}

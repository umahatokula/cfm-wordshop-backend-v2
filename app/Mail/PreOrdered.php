<?php

namespace App\Mail;

use App\Models\PreOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PreOrdered extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The PreOrder instance.
     *
     * @var PreOrder
     */
    public  $preOrder;

    /**
     * Create a new message instance.
     *
     * @param  \App\PreOrder  $order
     * @return void
     */
    public function __construct(PreOrder $preOrder)
    {
        $this->preOrder = $preOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.orders.preOrders');
    }
}

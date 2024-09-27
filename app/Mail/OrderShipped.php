<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $items;

    public function __construct($order)
    {
        $this->order = $order;
        $this->items = $order->items; 
    }

    public function build()
    {
        return $this->markdown('emails.orders.shipped')
                    ->with([
                        'order' => $this->order,
                        'items' => $this->items,
                    ]);
    }
}
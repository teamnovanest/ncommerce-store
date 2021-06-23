<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MerchantOrderUpdate extends Mailable
{
    use Queueable, SerializesModels;
    public $order_summary;
    public $order_details;
    public $merchant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_summary,$order_details,$merchant)
    {
        $this->order_summary = $order_summary;
        $this->order_details = $order_details;
        $this->merchant = $merchant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->view('mail.merchant_order_update',['order_summary'=>$this->order_summary,'order_details'=>$this->order_details,'merchant'=>$this->merchant])
        ->subject('Order Updated');
    }
}

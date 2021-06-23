<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;
    public $order_summary;
    public $order_details;
    public $order_financing;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_summary,$order_details,$order_financing,$url)
    {
        $this->order_summary = $order_summary;
        $this->order_details = $order_details;
        $this->order_financing = $order_financing;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->view('mail.order_confirmation',['order_summary'=>$this->order_summary,'order_details'=>$this->order_details,'order_financing'=>$this->order_financing,'url'=>$this->url])
        ->subject('Order Confirmation');
    }
}

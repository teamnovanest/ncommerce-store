<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LenderOrderUpdate extends Mailable
{
    use Queueable, SerializesModels;
    public $order_summary;
    public $order_details;
    public $finance_institution;
    public $order_financing;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_summary,$order_details,$finance_institution,$order_financing)
    {
        $this->order_summary = $order_summary;
        $this->order_details = $order_details;
        $this->lender = $finance_institution;
        $this->order_financing = $order_financing;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
        ->view('mail.lender_order_update',['order_summary'=>$this->order_summary,'order_details'=>$this->order_details,'lender'=>$this->lender,'order_financing'=>$this->order_financing])
        ->subject('Order Updated');
    }
}

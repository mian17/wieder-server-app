<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use LaravelIdea\Helper\App\Models\_IH_OrderItem_QB;

class OrderReceived extends Mailable
{
    use Queueable, SerializesModels;

//    public string $customerEmail;
    public Order $order;
    public mixed $orderItems;
    /**
     * Create a new message instance.
     * @param Order $order

     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->orderItems = $order->orderItems;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(env('MAIL_USERNAME'))
            ->to($this->order->receiver_email)
            ->subject('Cảm ơn bạn đã đặt hàng tại ' .  env('APP_NAME'))
            ->markdown('emails.order_received', [
                'orderItems' => $this->order->kinds($this->order->uuid)
        ]);
    }
}

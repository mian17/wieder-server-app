<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public mixed $orderItems;
    public string $oldStatusId;
    public string $newStatusId;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param string $oldStatusId
     * @param string $newStatusId
     *
     * @return void
     */
    public function __construct(Order $order, string $oldStatusId, string $newStatusId)
    {
        $this->order = $order;
        $this->orderItems = $order->orderItems;
        $this->oldStatusId = $oldStatusId;
        $this->newStatusId = $newStatusId;
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
            ->subject("Trạng thái đơn hàng của đơn hàng " . $this->order->uuid . " đã được thay đổi")
            ->markdown('emails.order_status_changed', [
                'orderItems' => $this->order->kinds($this->order->uuid)
            ]);
    }
}

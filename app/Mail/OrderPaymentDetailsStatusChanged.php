<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPaymentDetailsStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public mixed $orderItems;
    public string $oldStatus;
    public string $newStatus;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param string $oldStatus
     * @param string $newStatus
     *
     * @return void
     */
    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->orderItems = $order->orderItems;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
            ->subject("Trạng thái thanh toán của đơn hàng " . $this->order->uuid . " đã được thay đổi")
            ->markdown('emails.order_payment_details_status_changed', [
                'orderItems' => $this->order->kinds($this->order->uuid)
            ]);
    }
}

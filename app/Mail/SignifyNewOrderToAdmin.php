<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignifyNewOrderToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public mixed $orderItems;
    public User $adminUser;

    /**
     * Create a new message instance.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->orderItems = $order->orderItems;
        $this->adminUser = User::where('username', '=', 'admin')->first();
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
            ->to($this->adminUser->email)
            ->subject('Có một khách hàng mới đã đặt hàng tại ' .  env('APP_NAME'))
            ->markdown('emails.order_received_for_admin', [
                'orderItems' => $this->order->kinds($this->order->uuid)
            ]);
    }
}

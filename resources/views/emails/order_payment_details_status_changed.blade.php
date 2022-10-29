@php
    $realTotal = 0;
@endphp
@component('mail::message')
<strong>Xin chào {{$order->receiver_name}}</strong>,<br>
Hiện tại, đơn hàng {{$order->uuid}} có sự thay đổi về trạng thái thanh toán như sau.<br>
Từ trạng thái cũ: <strong>{{$oldStatus}}</strong> sang trạng thái mới: <strong>{{$newStatus}}</strong>

<strong>Trạng thái hiện tại:</strong><br>
Phương thức thanh toán: {{$orderPaymentMethods[(int)$order->paymentDetails->payment_method_id - 1]}}<br>
Trạng thái thanh toán: {{$newStatus}}<br>
Trạng thái đơn hàng: {{$orderStatuses[(int)$order->status_id - 1]}}<br>

<strong>Địa chỉ người nhận:</strong><br>
Họ và tên: {{$order->receiver_name}}.<br>
Địa chỉ nhận hàng: {{$order->receiver_address}}.<br>
Số điện thoại: {{$order->receiver_phone_number}}<br>
Email người nhận: {{$order->receiver_email}}<br>

<strong>Sau đây là các sản phẩm mà bạn đã đặt:</strong>
@component('mail::table')
| Tên sản phẩm               | Số lượng                 | Đơn giá               |
| -------------------------- |:------------------------:| ---------------------:|
@foreach($orderItems as $orderItem)
@php
    $realTotal += $orderItem->price;
@endphp
| {{$orderItem->kind->name}} | {{$orderItem->quantity}} | {{number_format($orderItem->price, 0, '', ',')}} ₫ |
@endforeach
@if ($realTotal > $order->total) |   |   | Giảm giá: {{number_format($realTotal - (int)$order->total, 0, '', ',')}} ₫ | @endif <br/>
|   |   | Tổng cộng: {{number_format($order->total, 0, '', ',')}} ₫ |
@endcomponent
@endcomponent

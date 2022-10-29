<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::share('orderPaymentMethods', [
            'Thanh toán tiền mặt',
            'Ví Momo',
            'Ví ZaloPay',
            'Ví Moca|Grab',
            'VNPAY',
            'Thẻ tín dụng/Ghi nợ',
            'Thẻ ATM'
        ]);
        View::share('orderStatuses', [
            'Chờ xác nhận',
            'Chờ lấy hàng',
            'Đang giao',
            'Đã giao',
            'Đã hủy',
            'Yêu cầu đổi trả, hoàn tiền'
        ]);
    }
}

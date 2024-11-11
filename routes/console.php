<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {

    $cutoffTime = Carbon::now()->subMinutes(2);

    Order::query()
        ->where('status', OrderStatus::PENDING->value)
        ->where('created_at', '<=', $cutoffTime)
        ->update(['status' => OrderStatus::CANCELED->value]);

})->everyMinute();

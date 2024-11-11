<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::query()->insert([
            [
                'name' => 'Банковская карта',
                'payment_url_template' => 'http://localhost/payment?type=card&order_id={order_id}&amount={amount}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Robokassa',
                'payment_url_template' => 'http://localhost/payment?type=robokassa&order_id={order_id}&amount={amount}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ЮKassa',
                'payment_url_template' => 'http://localhost/payment?type=yookassa&order_id={order_id}&amount={amount}',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class GatewayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gateways')->insert([
            "payment_gateway_logo"  => "img/payments/paypal.png",
            "payment_gateway_name"  => "Paypal",
            "display_name"  => "Paypal",
            "client_id"  => "5",
            "secret_key"  => "6",
            "is_status"  => "enabled"
        ]);

        DB::table('gateways')->insert([
            "payment_gateway_logo"  => "img/payments/razorpay.png",
            "payment_gateway_name"  => "Razorpay",
            "display_name"  => "Razorpay",
            "client_id"  => "7",
            "secret_key"  => "8",
            "is_status"  => "enabled"
        ]);

        DB::table('gateways')->insert([
            "payment_gateway_logo"  => "img/payments/stripe.png",
            "payment_gateway_name"  => "Stripe",
            "display_name"  => "Stripe",
            "client_id"  => "10",
            "secret_key"  => "11",
            "is_status"  => "enabled"
        ]);

        DB::table('gateways')->insert([
            "payment_gateway_logo"  => "/img/payments/paystack.png",
            "payment_gateway_name"  => "Paystack",
            "display_name"  => "Paystack",
            "client_id"  => "14",
            "secret_key"  => "15",
            "is_status"  => "enabled"
        ]);

        DB::table('gateways')->insert([
            "payment_gateway_logo"  => "/img/payments/mollie.webp",
            "payment_gateway_name"  => "Mollie",
            "display_name"  => "Mollie",
            "client_id"  => "16",
            "secret_key"  => "17",
            "is_status"  => "enabled"
        ]);

        DB::table('gateways')->insert([
            "payment_gateway_logo"  => "/img/payments/phonepe.png",
            "payment_gateway_name"  => "PhonePe",
            "display_name"  => "PhonePe",
            "client_id"  => "18",
            "secret_key"  => "19",
            "is_status"  => "enabled"
        ]);

        DB::table('gateways')->insert([
            "payment_gateway_logo"  => "img/payments/bank-transfer.png",
            "payment_gateway_name"  => "Bank Transfer",
            "display_name"  => "Bank Transfer",
            "client_id"  => "12",
            "secret_key"  => "13",
            "is_status"  => "enabled"
        ]);
    }
}

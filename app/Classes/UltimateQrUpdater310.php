<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;

class UltimateQrUpdater310
{
    public function runUpdate()
    {
        DB::statement("ALTER TABLE `gateways` CHANGE `id` `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
        DB::statement("INSERT INTO `gateways` (`payment_gateway_logo`, `payment_gateway_name`, `display_name`, `client_id`, `secret_key`) VALUES ('/img/payments/phonepe.png', 'PhonePe', 'PhonePe', '18', '19')");
        DB::statement("INSERT INTO `configs` (`config_key`, `config_value`) VALUES ('merchantId', 'YOUR_PHONEPE_MERCHANT_ID'), ('saltKey', 'YOUR_PHONEPE_SALT_KEY')");
    }
}

<?php

namespace Amentotech\LaraPayEase\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static \Amentotech\LaraPayEase\Drivers\Stripe stripe()
 * @method static array supportedCurrencies()
 * @method static array supportedGateways()
 * @method static string getIpnUrl()
 */

class PaymentDriver extends Facade {

    protected static function getFacadeAccessor(): string
    {
        return 'payment.driver';
    }
}

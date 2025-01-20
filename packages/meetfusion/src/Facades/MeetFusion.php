<?php

namespace Amentotech\MeetFusion\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 * @method static \Amentotech\MeetFusion\Drivers\Zoom zoom()
 * @method static \Amentotech\MeetFusion\Drivers\GoogleMeet google_meet()
 * @method static array supportedConferences()
 */

class MeetFusion extends Facade {

    protected static function getFacadeAccessor(): string
    {
        return 'meetfusion';
    }
}

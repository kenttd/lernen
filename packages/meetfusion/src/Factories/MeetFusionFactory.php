<?php

namespace Amentotech\MeetFusion\Factories;

use Amentotech\MeetFusion\Drivers\Zoom;

class MeetFusionFactory {
     
    /**
      * @return \Amentotech\MeetFusion\Drivers\Zoom
    */

    public function zoom(): Zoom{
        return new Zoom();
    }

    /**
     * @return array $supportedConferences
     */
     public function supportedConferences() : array{
        return [
            'zoom' => [
                'keys' => [
                    'account_id' => '',
                    'client_id' => '',
                    'client_secret' => '',
                ],
                'status' => 'off'
            ]
        ];
    }
}

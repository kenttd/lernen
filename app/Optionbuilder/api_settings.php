<?php

use Amentotech\MeetFusion\Facades\MeetFusion;
function rearrangeArray($array) {
    return array_map(function($details) {
        if (isset($details['keys'])) {
            $details = array_merge($details, $details['keys']);
            unset($details['keys']);
        }
        return $details;
    }, $array);
}

$gateways = rearrangeArray(MeetFusion::supportedConferences());
$settings_fields = 
    [
        [
            'id'            => 'enable_google_places',
            'type'          => 'switch',
            'tab_id'        => 'google_map',
            'tab_title'     => __('settings.google_map'),
            'class'         => '',
            'label_title'   => __('settings.enable_google_places'),
            'field_title'   => __('general.enable'),
            // 'field_desc'   => __('settings.enable_disable_places'),
            'value'       => '1',
        ],
        [
            'id'            => 'google_places_api_key',
            'type'          => 'text',
            'tab_id'        => 'google_map',
            'tab_title'     => __('settings.google_map'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.add_map_key'),
            'placeholder'   => __('settings.enter_api_key'),
            'field_desc'    => __('settings.map_key_desc',['get_api_key'=> '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">'. __("settings.get_api_key").' </a>' ]),
        ],

        [
            'id'            => 'google_client_id',
            'type'          => 'text',
            'tab_id'        => 'google_calendar',
            'tab_title'     => __('settings.google_calendar'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.client_id'),
            'placeholder'   => __('settings.enter_client_id'),
            'field_desc'    => __('settings.add_client_id'),
        ],
        [
            'id'            => 'google_client_secret',
            'type'          => 'text',
            'tab_id'        => 'google_calendar',
            'tab_title'     => __('settings.google_calendar'),
            'value'         => '',
            'class'         => '',
            'label_title'   => __('settings.client_secret'),
            'placeholder'   => __('settings.enter_client_secret'),
            'field_desc'    => __('settings.add_client_secret'),
        ],
    ];


$settings_fields[] = [
    'id'            => 'active_conference',
    'tab_id'        => 'conference_tab',
    'tab_title'     => __("settings.conference_title"),
    'type'          => 'radio',
    'label_title'   => __('settings.choose_service'),
    'field_desc'    => __('settings.choose_service_desc'),
    'placeholder'   => __('settings.enter_value'),
    'options'       => [],
    'default'       => 'zoom'
];

foreach($gateways as $conference => $settings){
    $is_first_field = true;
    foreach($settings as $field => $value){
        if ($field == 'status') {
            $active_conference_index = array_search('active_conference', array_column($settings_fields, 'id'));
            if ($active_conference_index !== false) {
                $settings_fields[$active_conference_index]['options'][$conference] = __('settings.'.$conference);
            }
        } else {
            if ($is_first_field) {
                $is_first_field = false;
                $settings_fields[] = [
                    'id'            => 'info_seprator_id',
                    'tab_id'        => 'conference_tab',
                    'type'          => 'info',
                    'label_title'   => __('settings.'.$conference.'_separator'),
                    'label_desc'    => __('settings.'.$conference.'_separator_desc'), 
                ];
            }
            $settings_fields[] = [
                'id'            => $conference.'_'.$field,
                'tab_id'        => 'conference_tab',
                'tab_title'     => __("settings.conference_title"),
                'type'          => 'text',
                'value'         => $value,
                'class'         => '',
                'label_title'   => __('settings.'.$conference.'_'.$field),
                'field_desc'    => __('settings.'.$conference.'_'.$field.'_desc'),
                'placeholder'   => __('settings.'.$conference.'_'.$field.'_desc'),
            ];
        }
    }
}

return [
    'section' => [
       'id'     => '_api',
       'label'  => __('sidebar.api_settings'),
       'tabs'   => true,
       'icon'   => '',
    ],
    'fields' => $settings_fields
];

<?php
return [
    'section' => [
       'id'     => '_theme', 
       'label'  => __('sidebar.theme_settings'), 
       'icon'   => '', 
    ],
    'fields' => [
        [
            'id'            => 'theme_pri_color',
            'type'          => 'colorpicker',
            'value'         => '#295C51',
            'class'         => '',
            'label_title'   => __('settings.theme_primary_color'),
        ],
        [
            'id'            => 'theme_sec_color',
            'type'          => 'colorpicker',
            'value'         => '#FAF8F5',
            'class'         => '',
            'label_title'   => __('settings.theme_secondary_color'),
        ],
        [
            'id'            => 'theme_footer_bg',
            'type'          => 'colorpicker',
            'value'         => '#065A46',
            'class'         => '',
            'label_title'   => __('settings.theme_footer_bg'),
        ],
        // [
        //     'id'            => 'text_dark_color',
        //     'type'          => 'colorpicker',
        //     'value'         => '#0A0F26',
        //     'class'         => '',
        //     'label_title'   => __('settings.text_dark_color'),
        //     'field_desc'    => __('settings.text_dark_color_desc'),
        // ],
        [
            'id'            => 'text_light_color',
            'type'          => 'colorpicker',
            'value'         => '#585858',
            'class'         => '',
            'label_title'   => __('settings.text_light_color'),
            'field_desc'    => __('settings.text_light_color_desc'),
        ],
        [
            'id'            => 'text_white_color',
            'type'          => 'colorpicker',
            'value'         => '#fff',
            'class'         => '',
            'label_title'   => __('settings.text_white_color'),
            'field_desc'    => __('settings.text_white_color_desc'),
        ],
        // [
        //     'id'            => 'text_yellow_color',
        //     'type'          => 'colorpicker',
        //     'value'         => '#FCCF14',
        //     'class'         => '',
        //     'label_title'   => __('settings.text_yellow_color'),
        //     'field_desc'    => __('settings.text_yellow_color_desc'),
        // ],
        [
            'id'            => 'heading_color',
            'type'          => 'colorpicker',
            'value'         => 'rgba(#000,0.7)',
            'class'         => '',
            'label_title'   => __('settings.heading_color'),
            'field_desc'    => __('settings.heading_color_desc'),
        ],
        // [
        //     'id'            => 'btn_bg_pri_color',
        //     'type'          => 'colorpicker',
        //     'value'         => '#FCCF14',
        //     'class'         => '',
        //     'label_title'   => __('settings.button_bg_pri_color'),
        //     'field_desc'    => __('settings.button_bg_pri_color_desc'),
        // ],
        // [
        //     'id'            => 'btn_bg_sec_color',
        //     'type'          => 'colorpicker',
        //     'value'         => '#0A0F26',
        //     'class'         => '',
        //     'label_title'   => __('settings.button_bg_sec_color'),
        //     'field_desc'    => __('settings.button_bg_sec_color'),
        // ],
        // [
        //     'id'            => 'link_color',
        //     'type'          => 'colorpicker',
        //     'value'         => '#1DA1F2',
        //     'class'         => '',
        //     'label_title'   => __('settings.link_color'),
        //     'field_desc'    => __('settings.link_color_desc'),
        // ],
        // [
        //     'id'            => 'btn_text_color',
        //     'type'          => 'colorpicker',
        //     'value'         => '#1C1C1C',
        //     'class'         => '',
        //     'label_title'   => __('settings.button_text_color'),
        // ],
        // [
        //     'id'            => 'header_text_color',
        //     'type'          => 'colorpicker',
        //     'value'         => '#1E1E1E',
        //     'class'         => '',
        //     'label_title'   => __('settings.header_text_color')
        // ],
        
    ]
];
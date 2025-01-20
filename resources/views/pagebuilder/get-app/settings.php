<?php

return [
    'id'        => 'get-app',
    'name'      => __('Get App'),
    'icon'      => '<i class="icon-play"></i>',
    'tab'       => "Common",
    'fields'    => [
        [
            'id'            => 'select_verient',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Select verient'),
            'options'       => [
                'get-app-varient-one'        => 'Get app Style v1',
                'get-app-varient-two'        => 'Get app Style v2',
            ],
            'default'       => '',  
            'placeholder'   => __('Select from the list'),  
        ],
        [
            'id'            => 'pre_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Pre heading'),
            'placeholder'   => __('Enter pre heading'),
        ],
        [
            'id'            => 'heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'paragraph',
            'type'          => 'editor',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Description'),
            'placeholder'   => __('Enter description'),
        ],
        [
            'id'            => 'app_store_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('App store image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,            
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ], 
        ],
        [
            'id'            => 'google_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Google image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,            
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ], 
        ],
        [
            'id'            => 'mobile_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,            
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ], 
        ],
    ]
];

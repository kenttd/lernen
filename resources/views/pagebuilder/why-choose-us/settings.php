<?php

return [
    'id'        => 'why-choose-us',
    'name'      => __('Why choose us'),
    'icon'      => '<i class="icon-clipboard"></i>',
    'tab'       => "Common",
    'fields'    => [
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
            'id'                => 'steps_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Data'),
            'repeater_title'    => __('Add data'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Image'),
                    'label_desc'    => __('Add image'),
                    'max_size'      => 4,                  
                    'ext'    => [
                        'jpg',
                        'png',
                        'svg',
                    ]
                ],
                [
                    'id'            => 'data_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Heading'),
                    'placeholder'   => __('Enter heading'),
                ],
                [
                    'id'            => 'data_description',
                    'type'          => 'editor',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Description'),
                    'placeholder'   => __('Enter description'),
                ],
            ]
        ],
        [
            'id'            => 'btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button URL'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button text'),
            'placeholder'   => __('Enter button text'),
        ],
    ]
];

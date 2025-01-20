<?php

return [
    'id'        => 'banner-v2',
    'name'      => __('BannerV2'),
    'icon'      => '<i class="icon-credit-card"></i>',
    'tab'       => "Banners",
    'fields'    => [
        [
            'id'            => 'pre_heading_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Pre heading image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ],
        ],
        [
            'id'            => 'pre_heading',
            'type'          => 'text',
            'value'         => 'Enhance your learning experience',
            'class'         => '',
            'label_title'   => __('Pre heading'),
            'placeholder'   => __('Enter pre heading'),
        ],
        [
            'id'            => 'heading',
            'type'          => 'text',
            'value'         => 'Enhance Your Learning Experience with <span>Our Expert</span> Mentor',
            'class'         => '',
            'label_title'   => __('Heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'paragraph',
            'type'          => 'editor',
            'value'         => 'Achieve your goals with personalized tutoring from top experts. Connect with dedicated tutors for success.',
            'class'         => '',
            'label_title'   => __('Description'),
            'placeholder'   => __('Enter description'),
        ],
        [
            'id'            => 'all_tutor_btn_url',
            'type'          => 'text',
            'value'         => '#',
            'class'         => '',
            'label_title'   => __('Button URL'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'all_tutor_btn_txt',
            'type'          => 'text',
            'value'         => 'Explore all tutors',
            'class'         => '',
            'label_title'   => __('Button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'see_demo_btn_url',
            'type'          => 'text',
            'value'         => '#',
            'class'         => '',
            'label_title'   => __('See demo button URL'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'see_demo_btn_txt',
            'type'          => 'text',
            'value'         => 'See demo',
            'class'         => '',
            'label_title'   => __('See demo button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Banner image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ],
        ],
        [
            'id'                => 'banner_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Companies banner'),
            'repeater_title'    => __('Add image'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'banner_image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Banner image'),
                    'label_desc'    => __('Add image'),
                    'max_size'      => 4,
                    'ext'    => [
                        'jpg',
                        'png',
                        'svg',
                    ]
                ]
            ]
        ],
        [
            'id'            => 'select_variation',
            'type'          => 'radio',
            'class'         => '',
            'label_title'   => __('Select variation'),
            'options'       => [
                'v1'   => __('v1'),
                'v2'   => __('v2'),
            ],
            'default'       => 'v2',
        ],
    ]
];

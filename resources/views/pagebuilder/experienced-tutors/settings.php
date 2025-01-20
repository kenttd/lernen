<?php

return [
    'id'        => 'experienced-tutors',
    'name'      => __('Experienced tutors'),
    'icon'      => '<i class="icon-briefcase"></i>',
    'tab'       => 'Common',
    'fields'    => [
        [
            'id'            => 'select_verient',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Select verient'),
            'options'       => [
                'am-tutors-varient-one'        => 'Tutors Style 1',
                'am-tutors-varient-two'        => 'Tutors Style 2',
                // 'am-tutors-varient-three'      => 'Tutors Style 3',
                // 'am-tutors-varient-four'       => 'Tutors Style 4',
            ],
            'default'       => '',  
            'placeholder'   => __('Select from the list'),  
        ],
        [
            'id'            => 'select_tutor',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Select tutor'),
            'options'       => [
                '4'         => 'Four tutors',
                '5'         => 'Five tutors',
                '8'         => 'Eight tutors',
            ],
            'default'       => '4',  
            'placeholder'   => __('Select from the list'),  
        ],
        [
            'id'            => 'style_verient',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Select style verient'),
            'options'       => [
                'style-varient'        => 'Style v1',
                // 'style-varient-two'        => 'Style v2',
                // 'style-varient-three'      => 'Style v3',
                // 'style-varient-four'       => 'Style v4',
            ],
            'default'       => '',  
            'placeholder'   => __('Select from the list'),  
        ],
        [
            'id'            => 'pre_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Pre Heading'),
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
            'id'            => '1st_shape_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('First shape image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        [
            'id'            => '2nd_shape_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Second shape image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        [
            'id'            => 'view_tutor_btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button url'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'view_tutor_btn_text',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button text'),
            'placeholder'   => __('Enter button text'),
        ],

    ]
];

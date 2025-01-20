<?php

return [
    'id'        => 'featured-tutors',
    'name'      => __('Feature tutors'),
    'icon'      => '<i class="icon-gift"></i>',
    'tab'       => "Common",
    'fields'    => [
        [
            'id'            => 'select_verient',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Select verient'),
            'options'       => [
                'am-tutors-varient-one'        => 'Tutors Style 1',
                'am-tutors-varient-two'        => 'Tutors Style 2',
            ],
            'default'       => '',  
            'placeholder'   => __('Select from the list'),  
        ],
        [
            'id'            => 'shape_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Shape image'),
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

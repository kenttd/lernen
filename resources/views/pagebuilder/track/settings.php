<?php

return [
    'id'        => 'track',
    'name'      => __('Track'),
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
            'label_title'       => __('Easy steps'),
            'repeater_title'    => __('Add step'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'step_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Heading'),
                    'placeholder'   => __('Enter heading'),
                ],
                [
                    'id'            => 'step_paragraph',
                    'type'          => 'editor',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Description'),
                    'placeholder'   => __('Enter description'),
                ],
            ]
        ],
        [
            'id'            => 'get_started_btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Get started button URL'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'get_started_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Get started button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'explore_tutor_btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Explore tutor button URL'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'explore_tutor_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Explore tutor button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'subject_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Subject image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,            
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ], 
        ],
        [
            'id'            => 'summary_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Summary image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,            
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ], 
        ],
        [
            'id'            => 'student_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Student image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,            
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ], 
        ],
        [
            'id'            => 'calander_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Calander image'),
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

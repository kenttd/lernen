<?php

return [
    'id'        => 'easy-steps',
    'name'      => __('Easy steps'),
    'icon'      => '<i class="icon-clipboard"></i>',
    'tab'       => "Common",
    'fields'    => [
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
            ]
        ],
        [                                                          
            'id'                => 'steps_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Easy steps'),
            'repeater_title'    => __('Add step'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'step_image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Step gif'),
                    'label_desc'    => __('Add gif'),
                    'max_size'      => 4,                  
                    'ext'    => [
                        'gif',
                    ]
                ],
                [
                    'id'            => 'scnd_step_image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Step image'),
                    'label_desc'    => __('Add image'),
                    'max_size'      => 4,                  
                    'ext'    => [
                        'jpg',
                        'png',
                        'svg',
                    ]
                ],
                [
                    'id'            => 'image_verient',
                    'type'          => 'select',
                    'class'         => '',
                    'label_title'   => __('Select verient'),
                    'options'       => [
                        'am-step-warning'        => 'Yellow',
                        'am-step-primary'        => 'Blue',
                        'am-step-success'        => 'Green',
                        'am-step_danger'         => 'Red',
                    ],
                    'default'       => 'non',  
                    'placeholder'   => __('Select from the list'),  
                ],
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
                [
                    'id'            => 'learn_more_btn_url',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Learn more button URL'),
                    'placeholder'   => __('Enter url'),
                ],
                [
                    'id'            => 'learn_more_btn_txt',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Learn more button text'),
                    'placeholder'   => __('Enter button text'),
                ],
            ]
        ],
        [
            'id'            => 'style_variation',
            'type'          => 'radio',
            'class'         => '',
            'label_title'   => __('Style variation'),
            'options'       => [
                'easy-steps-variation-one'   => __('Style V1'),
                'easy-steps-variation-two'   => __('Style V2'),
            ],
            'default'       => '',
        ],
    ]
];

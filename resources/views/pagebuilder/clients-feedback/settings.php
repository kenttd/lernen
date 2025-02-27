<?php

return [
    'id'        => 'clients-feedback',
    'name'      => __('Clients feedback'),
    'icon'      => '<i class="icon-users"></i>',
    'tab'       => 'Common',
    'fields'    => [
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
            'id'            => 'enable_slider',
            'type'          => 'radio',
            'class'         => '',
            'label_title'   => __('Enable Slider'),
            'options'       => [
                'yes'   => __('Yes'),
                'no'    => __('No'),
            ],
            'default'       => 'no',  
        ],
        [
            'id'            => 'verient',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Select verient'),
            'options'       => [
                'feedback-verient-one'        => 'Verient one',
                'feedback-verient-two'        => 'Verient two',
            ],
            'default'       => 'non',  
            'placeholder'   => __('Select from the list'),  
        ],
        [                                                          
            'id'                => 'feedback_repeater',
            'type'              => 'repeater',
            'label_title'       => __('Feedback data'),
            'repeater_title'    => __('Data'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'feedback_paragraph',
                    'type'          => 'editor',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Feedback description'),
                    'placeholder'   => __('Enter description'),
                ],
                [
                    'id'            => 'tutor_rating',
                    'type'          => 'select',
                    'class'         => '',
                    'label_title'   => __('Single select field'),
                    'label_desc'    => __('Select rating'),
                    'options'       => [
                            '1'     => '1',
                            '2'     => '2',
                            '3'     => '3',
                            '4'     => '4',
                            '5'     => '5',
                    ],
                    'default'       => '2',  
                ],
                [
                    'id'            => 'tutor_image',
                    'type'          => 'file',
                    'class'         => '',
                    'label_title'   => __('Tutor image'),
                    'label_desc'    => __('Add image'),
                    'max_size'      => 4,               
                    'ext'    => [
                        'jpg',
                        'png',
                        'svg',
                    ], 
                ],
                [
                    'id'            => 'tutor_name',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Tutor name'),
                    'placeholder'   => __('Enter name'),
                ],
                [
                    'id'            => 'tutor_tagline',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Tutor tagline'),
                    'placeholder'   => __('Enter tagline'),
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
            ],
        ],
    ]
];

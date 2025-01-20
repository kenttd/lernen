<?php

return [
    'id'        => 'faqs',
    'name'      => __('FAQ'),
    'icon'      => '<i class="icon-help-circle"></i>',
    'tab'       => "Common",
    'fields'    => [
        [
            'id'            => 'select_verient',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Select verient'),
            'options'       => [
                'am-faqs-tabs-detailtwo'       => 'Faqs Style 2',
            ],
            'default'       => '',  
            'placeholder'   => __('Select from the list'),  
        ],
        [
            'id'            => 'sub-heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Sub heading'),
            'placeholder'   => __('Enter sub heading'),
        ],
        [
            'id'            => 'heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Heading'),
            'placeholder'   => __('Enter Heading'),
        ],
        [
            'id'            => 'paragraph',
            'type'          => 'editor',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Paragraph'),
            'placeholder'   => __('Enter paragraph'),
        ],
        [
            'id'            => 'student_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Student button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'tutor_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Tutor button text'),
            'placeholder'   => __('Enter button text'),
        ],

        [
            'id'                => 'students_faqs_data',
            'type'              => 'repeater',
            'label_title'       => __('FAQs'),
            'repeater_title'    => __('FAQ'),
            'multi'             => true,
            'fields'       =>
            [
                [
                    'id'            => 'question',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Question'),
                    'placeholder'   => __('Enter question'),
                ],
                [
                    'id'            => 'answer',
                    'type'          => 'text',
                    'value'         => '',
                    'label_title'   => __('Answer'),
                    'placeholder'   => __('Enter answer'),
                ],
               
            ],
        ],
        [
            'id'                => 'tutors_faqs_data',
            'type'              => 'repeater',
            'label_title'       => __('FAQs'),
            'repeater_title'    => __('FAQ'),
            'multi'             => true,
            'fields'       =>
            [
                [
                    'id'            => 'question',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Question'),
                    'placeholder'   => __('Enter question'),
                ],
                [
                    'id'            => 'answer',
                    'type'          => 'text',
                    'value'         => '',
                    'label_title'   => __('Answer'),
                    'placeholder'   => __('Enter answer'),
                ],
               
            ],
        ]

    ]
];

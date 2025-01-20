<?php

return [
    'id'        => 'faqs-without-btn',
    'name'      => __('Simple FAQ'),
    'icon'      => '<i class="icon-help-circle"></i>',
    'tab'       => "Common",
    'fields'    => [
        [
            'id'            => 'sub-heading',
            'type'          => 'text',
            'value'         => 'Find Your Answer',
            'class'         => '',
            'label_title'   => __('Sub heading'),
            'placeholder'   => __('Enter sub heading'),
        ],
        [
            'id'            => 'heading',
            'type'          => 'text',
            'value'         => 'Common FAQs',
            'class'         => '',
            'label_title'   => __('Heading'),
            'placeholder'   => __('Enter Heading'),
        ],
        [
            'id'            => 'paragraph',
            'type'          => 'editor',
            'value'         => 'Discover Common Solutions and Access Official Guidance  Tailored for Tutors and Students.',
            'class'         => '',
            'label_title'   => __('Paragraph'),
            'placeholder'   => __('Enter paragraph'),
        ],
        [
            'id'            => 'btn_txt',
            'type'          => 'text',
            'value'         => 'For student',
            'class'         => '',
            'label_title'   => __('Button text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'                => 'faqs_data',
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
    ]
];

<?php

return [
    'id'        => 'tuition',
    'name'      => __('Tuition'),
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
            'id'            => 'become_tutor_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Become Tutor Heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'become_tutor_paragraph',
            'type'          => 'editor',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Description'),
            'placeholder'   => __('Enter description'),
        ],
        [
            'id'            => 'become_tutor_btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Become Tutor URL'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'become_tutor_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Become Tutor text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'become_tutor_image',
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
            'id'            => 'become_student_heading',
            'type'          => 'text',
            'value'         => 'y',
            'class'         => '',
            'label_title'   => __('Become Student Heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'become_student_paragraph',
            'type'          => 'editor',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Description'),
            'placeholder'   => __('Enter description'),
        ],
        [
            'id'            => 'become_student_btn_url',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Become Student URL'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'become_student_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Become Student text'),
            'placeholder'   => __('Enter button text'),
        ],
        [
            'id'            => 'become_student_image',
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
        ] 
    ]
];

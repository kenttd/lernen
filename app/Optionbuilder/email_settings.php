<?php
return [
    'section' => [
        'id'     => '_email',
        'label'  => __('admin/sidebar.email_settings'),
        'icon'   => '',
    ],
    'fields' => [
        [
            'id'            => 'email_logo',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('admin/optionbuilder.logo'),
            'field_desc'    => __('admin/optionbuilder.image_option', ['extension' => 'jpg, png', 'size' => '3mb']),
            'max_size'   => 3,                  // size in MB
            'ext'    => [
                'jpg',
                'png',
            ],
        ],
        [
            'id'            => 'sender_name',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('admin/optionbuilder.sender_name'),
            'field_desc'   => __('admin/optionbuilder.sender_name_desc'),
            'placeholder'   => __('admin/optionbuilder.sender_name'),
            'hint'     => [
                'content' => __('admin/optionbuilder.sender_name'),
            ],
        ],
        [
            'id'            => 'sender_email',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('admin/optionbuilder.sender_email'),
            'field_desc'   => __('admin/optionbuilder.sender_email_desc'),
            'placeholder'   => __('admin/optionbuilder.sender_email'),
            'hint'     => [
                'content' => __('admin/optionbuilder.sender_email'),
            ],
        ],
        [
            'id'            => 'sender_signature',
            'type'          => 'textarea',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('admin/optionbuilder.sender_signature'),
            'field_desc'   => __('admin/optionbuilder.sender_signature_desc', ['app_name' => env('APP_NAME')]),
            'placeholder'   => __('admin/optionbuilder.sender_signature'),
        ],
        [
            'id'            => 'footer_text',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('admin/optionbuilder.footer_text'),
            'field_desc'   => __('admin/optionbuilder.footer_text_desc'),
            'placeholder'   => __('admin/optionbuilder.footer_text'),
            'hint'     => [
                'content' => __('admin/optionbuilder.footer_text'),
            ],
        ],
    ]
];

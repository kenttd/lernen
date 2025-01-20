<?php

return [
    'id'        => 'banner',
    'name'      => __('Banner'),
    'icon'      => '<i class="icon-airplay"></i>',
    'tab'       => "Banners",
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
            'id'            => 'search_btn_txt',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Search button text'),
            'placeholder'   => __('Enter search button text'),
        ],
        [
            'id'            => 'search_placeholder',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Search placeholder'),
            'placeholder'   => __('Enter search placeholder'),
        ],

        [
            'id'            => 'image_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Image heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'image_paragraph',
            'type'          => 'editor',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Image description'),
            'placeholder'   => __('Enter description'),
        ],

        [
            'id'            => 'video',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Videos'),
            'label_desc'    => __('Add video'),
            'max_size'      => 4,            
            'ext'    => [
                'mp4'
            ], 
        ],

        [
            'id'            => 'tutors_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Tutors image'),
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
    ]
];

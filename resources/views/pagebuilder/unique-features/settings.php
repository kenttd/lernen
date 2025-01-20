<?php

return [
    'id'        => 'unique-features',
    'name'      => __('Unique Features'),
    'icon'      => '<i class="icon-clipboard"></i>',
    'tab'       => "Common",
    'fields'    => [
        [
            'id'            => 'select_verient',
            'type'          => 'select',
            'class'         => '',
            'label_title'   => __('Select verient'),
            'options'       => [
                'unique-features-varient-one'        => 'Style V1',
                'unique-features-varient-two'        => 'Style V2',
                'unique-features-varient-three'      => 'Style V3',
            ],
            'default'       => '',  
            'placeholder'   => __('Select from the list'),  
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
        // 1st section
        [
            'id'            => 'section1_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Section one heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'section1_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('First image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        [
            'id'            => 'section1_2nd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Second image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        // end 1st section

        // 2nd section
        [
            'id'            => 'section2_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Section two heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'section2_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('First image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        [
            'id'            => 'section2_2nd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Second image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        [
            'id'            => 'section2_3rd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Third image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        [
            'id'            => 'section2_4th_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Fourth image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        // end 2nd section

        // 3rd section
        [
            'id'            => 'section3_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Section third heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'section3_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('First image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        [
            'id'            => 'section3_2nd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Second image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        [
            'id'            => 'section3_3rd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Third image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        // end 3rd section

        // 4tt section
        [
            'id'            => 'section4_heading',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Section fourth heading'),
            'placeholder'   => __('Enter heading'),
        ],
        [
            'id'            => 'section4_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('First image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        [
            'id'            => 'section4_2nd_image',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Second image'),
            'label_desc'    => __('Add image'),
            'max_size'      => 4,                  
            'ext'    => [
                'jpg',
                'png',
                'svg',
            ]
        ],
        // end 4tt section
    ]
];

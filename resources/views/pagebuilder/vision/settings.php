<?php

return [
    'id'        => 'vision',
    'name'      => __('Vision'),
    'icon'      => '<i class="icon-tv"></i>',
    'tab'       => 'Common',
    'fields'    => [
        [
            'id'           => 'video',
            'type'          => 'file',
            'class'         => '',
            'label_title'   => __('Vision Video'),
            'label_desc'    => __('Add Video'),
            'max_size'      => 4,               
            'ext'    => [
                'mp4',
                'mkv',
                'flv',
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
            'id'                => 'list_data',
            'type'              => 'repeater',
            'label_title'       => __('List data'),
            'repeater_title'    => __('List data'),
            'multi'             => true,
            'fields'       => [
                [
                    'id'            => 'item_heading',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('Item heading'),
                    'placeholder'   => __('Enter heading'),
                ],
                [
                    'id'            => 'list_item',
                    'type'          => 'text',
                    'value'         => '',
                    'class'         => '',
                    'label_title'   => __('List items'),
                    'placeholder'   => __('Enter item'),
                ],
            ]
        ],
        [
            'id'            => 'discover_more_btn_url',
            'type'          => 'text',
            'value'         => "",
            'class'         => '',
            'label_title'   => __('Button url'),
            'placeholder'   => __('Enter url'),
        ],
        [
            'id'            => 'discover_more_btn_text',
            'type'          => 'text',
            'value'         => '',
            'class'         => '',
            'label_title'   => __('Button text'),
            'placeholder'   => __('Enter button text'),
        ],
    ]
];

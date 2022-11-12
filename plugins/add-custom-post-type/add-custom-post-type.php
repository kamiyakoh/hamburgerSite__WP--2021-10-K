<?php
    /*
    Plugin Name: add_custom_post_type
    Version: 1.0.0
    Author: ito_K
    Description: Add custom-post-type
    */

        //カスタム投稿
        function add_custom_post_type() {
            register_post_type(
                'take_out',
                array(
                    'label'                 => 'テイクアウト',
                    'public'                => true,
                    'exclude_from_search'   => true,
                    'has_archive'           => true,
                    'menu_position'         => 5,
                    'taxonomies'            => array('post_tag'),
                    'supports'              => array(
                        'title',
                        'editor',
                        'revisions',
                    )
                )
            );
    
            register_post_type(
                'eat_in',
                array(
                    'label'                 => 'イートイン',
                    'public'                => true,
                    'exclude_from_search'   => true,
                    'has_archive'           => true,
                    'menu_position'         => 5,
                    'taxonomies'            => array('post_tag'),
                    'supports'              => array(
                        'title',
                        'editor',
                        'revisions',
                    )
                )
            );
    
            register_post_type(
                'frontpage',
                array(
                    'label'                 => 'フロントページ',
                    'public'                => true,
                    'exclude_from_search'   => true,
                    'menu_position'         => 20,
                    'taxonomies'            => array('category'),
                    'supports'              => array(
                        'title',
                        'editor',
                        'revisions',
                        'thumbnail',
                    )
                )
            );
    
            register_post_type(
                'map',
                array(
                    'label'                 => '地図',
                    'public'                => true,
                    'exclude_from_search'   => true,
                    'menu_position'         => 20,
                    'supports'              => array(
                        'title',
                        'editor',
                        'revisions',
                        'custom-fields',
                    )
                )
            );
        }
        add_action('init', 'add_custom_post_type');
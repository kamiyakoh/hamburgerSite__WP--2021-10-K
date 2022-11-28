<?php
    /*
    Plugin Name: add_custom_post_type
    Version: 1.1.1
    Author: ito_K
    Description: Add custom-post-type
    */

        //カスタム投稿
        function add_custom_post_type() {
            register_post_type(
                'display_card_left',
                array(
                    'label'                 => 'フロント左ディスプレイカード',
                    'public'                => true,
                    'exclude_from_search'   => true,
                    'has_archive'           => true,
                    'menu_position'         => 6,
                    'menu_icon'             => 'dashicons-controls-back',
                    'taxonomies'            => array('post_tag'),
                    'supports'              => array(
                        'title',
                        'editor',
                        'revisions',
                    )
                )
            );
    
            register_post_type(
                'display_card_right',
                array(
                    'label'                 => 'フロント右ディスプレイカード',
                    'public'                => true,
                    'exclude_from_search'   => true,
                    'has_archive'           => true,
                    'menu_position'         => 7,
                    'menu_icon'             => 'dashicons-controls-forward',
                    'taxonomies'            => array('post_tag'),
                    'supports'              => array(
                        'title',
                        'editor',
                        'revisions',
                    )
                )
            );
        }
        add_action('init', 'add_custom_post_type');
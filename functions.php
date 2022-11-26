<?php
    //テーマサポート
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-header' );
    add_theme_support( 'automatic-feed-links' );

    //タイトル出力
    function hs_title( $title ) {
        $title = get_bloginfo( 'name', 'display' );
        return $title;
    }
    add_filter( 'pre_get_document_title', 'hs_title' );

    //the_archive_title 余計な文字を削除
    function remove_archive_title ( $title ) {
        if (is_category()) {
            $title = single_cat_title('',false);
        } elseif (is_tag()) {
            $title = single_tag_title('',false);
        } elseif (is_tax()) {
            $title = single_term_title('',false);
        } elseif (is_post_type_archive() ){
            $title = post_type_archive_title('',false);
        } elseif (is_date()) {
            $title = get_the_time('Y年n月');
        } elseif (is_search()) {
            $title = '検索結果：'.esc_html( get_search_query(false) );
        } elseif (is_404()) {
            $title = '「404」ページが見つかりません';
        } else {

        }
        return $title;
    }
    add_filter( 'get_the_archive_title', 'remove_archive_title' );

    //ウィジェットのタイトル非表示
    function remove_widget_title_all( $widget_title ) {
        return;
    }
    add_filter( 'widget_title', 'remove_widget_title_all' );

    //メニュー
    add_action( 'init', function() {
        register_nav_menus([
            'global_nav'    => 'グローバルナビゲーション',
        ]);
    });
    
    //ヘッド記述
    function add_files() {
        wp_enqueue_style( 'ress', '//unpkg.com/ress/dist/ress.min.css', array() );
        wp_enqueue_style( 'Roboto', '//fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap', array() );
        wp_enqueue_style( 'mplus-basic-latin', '//mplus-fonts.sourceforge.jp/webfonts/basic_latin/mplus_webfonts.css', array() );
        wp_enqueue_style( 'mplus-j', '//mplus-fonts.sourceforge.jp/webfonts/general-j/mplus_webfonts.css', array() );
        wp_enqueue_style( 'sytlesheet', get_template_directory_uri() . '/CSS/style.css', array(), '1.0.0' );
        wp_enqueue_style( 'sytle', get_template_directory_uri() . '/style.css', array(), '1.0.0' );
        wp_enqueue_script( 'afterjs', get_template_directory_uri() . '/js/after.js', array('jquery'), '1.0.0', true );
    }
    add_action( 'wp_enqueue_scripts', 'add_files' );

    //トップページ用js
    function add_files__topPage() {
        if ( is_front_page() || is_home() ) {
            wp_enqueue_script( 'toppagejs', get_template_directory_uri() . '/js/topPage.js', array('jquery'), '1.0.0', true );
        }
    }
    add_action( 'wp_enqueue_scripts', 'add_files__topPage' );

    //ウィジェット_サイドバー
    function add_widgets_init() {
        register_sidebar (
            array(
                'name'          => 'サイドバー',
                'id'            => 'sidebar_widget',
                'discription'   => 'サイドバー用ウィジェットです',
                'before_widget' => '<section id="%1$s" class="%2$s sidebar">',
                'after_widget'  => '</section>',
            )
        );
    }
    add_action( 'widgets_init', 'add_widgets_init' );

    //カスタムブロックスタイル
    function add_assets() {
        $script = <<<SCRIPT
            wp.blocks.registerBlockStyle('core/table', {
                name: '46table',
                label: '記事用46テーブル'
            });
            wp.blocks.registerBlockStyle('core/gallery', {
                name: 'resuponsiveGallery',
                label: '記事用レスポンシブギャラリー'
            });
            wp.blocks.registerBlockStyle( 'core/button', {
                name: 'resuponsivebtn',
                label: '記事用レスポンシブボタン'
            });
        SCRIPT;
        wp_add_inline_script( 'wp-blocks', $script );
    }
    add_action( 'enqueue_block_editor_assets', 'add_assets' );

    //メインループカスタム
    function custom_main_query ( $query ) {
        if ( is_admin() || ! $query -> is_main_query() ) {
            return;
        }

        if ( $query -> is_category() || is_tag() ) {
            $query -> set( 'posts_per_page', 3 );
        }

        if ( $query -> is_search() ) {
            $query -> set( 'posts_per_page', 5 );
        }
    }
    add_action( 'pre_get_posts', 'custom_main_query');

    //外観>カスタマイズにコピーライト追加
    function theme_customizer_copyright( $wp_customize ) {
        $wp_customize->add_section( 'copy-right', array(
            'title'     => 'コピーライト',
            'priority'  => 201,
        ));
        $wp_customize->add_setting( 'copyright', array(
            'default'           => '',
            'type'              => 'option',
            'transport'         => 'postMessage',
            'sanitize_callback' => 'wp_strip_all_tags',
        ));
        $wp_customize->add_control( 'copy-right', array(
            'settings'  => 'copyright',
            'label'     => 'コピーライト',
            'description' => '<small>コピーライトを入力してください</small>',
            'section'   => 'copy-right',
            'type'      => 'text',
        ));
    }
    add_action('customize_register', 'theme_customizer_copyright');
        
    //アイキャッチ関数
    function get_thumb_url($post_id = '', $size = 'full') {
        $thumb_id = get_post_thumbnail_id($post_id);
        if ( $thumb_id != null ) {
            $thumb_img = wp_get_attachment_image_src($thumb_id, $size);
            $thumb_src = $thumb_img[0];
        } else {
            $thumb_src = false;
        }
        return $thumb_src;
    }

    //タグリンク関数
    function get_tag_href() {
        $tags = get_the_tags();
        if ( !empty( $tags ) ) {
            return get_tag_link( $tags[0]->term_id );
        }
    }

    // テーマカスタマイザーにフロントページのディスプレイエリア設定機能追加
    // セクションIDの定数化
    define('DISPLAY_AREA_SECTION', 'display_area_section');
    // define('DISPLAY_RIGHT_SECTION', 'display_right_section');
    // ディスプレイエリアの見出しの定数化
    define('DISPLAY_LEFT_TITLE', 'display_left_title');
    define('DISPLAY_RIGHT_TITLE', 'display_right_title');
    // ディスプレイエリアの見出し文字色の定数化
    define('DISPLAY_LEFT_COLOR', 'display_left_color');
    define('DISPLAY_RIGHT_COLOR', 'display_right_color');
    // ディスプレイエリアの画像URLの定数化
    define('DISPLAY_LEFT_IMAGE_URL', 'display_left_image_url');
    define('DISPLAY_RIGHT_IMAGE_URL', 'display_right_image_url');

    function themename_theme_customizer( $wp_customize ) {
        $wp_customize->add_section( DISPLAY_AREA_SECTION , array(
            'title' => 'フロントページのディスプレイエリア', //セクション名
            'priority' => 31, //カスタマイザー項目の表示順
            'description' => 'フロントページのディスプレイエリア設定', //セクションの説明
        ) );

        $wp_customize->add_setting( DISPLAY_LEFT_TITLE );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, DISPLAY_LEFT_TITLE, array(
            'label'     => '←左側（モバイルでは↑上側）の見出し',
            'section'   => DISPLAY_AREA_SECTION,
            'settings' => DISPLAY_LEFT_TITLE,
            'type'      => 'text',
        )));

        $wp_customize->add_setting( DISPLAY_LEFT_COLOR );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, DISPLAY_LEFT_COLOR, array(
			'label'    => '←左側（モバイルでは↑上側）の見出しの文字色',
			'section'  => DISPLAY_AREA_SECTION,
			'settings' => DISPLAY_LEFT_COLOR,
		)));

        $wp_customize->add_setting( DISPLAY_LEFT_IMAGE_URL );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, DISPLAY_LEFT_IMAGE_URL, array(
            'label' => '←左側（モバイルでは↑上側）の画像', //設定ラベル
            'section' => DISPLAY_AREA_SECTION, //セクションID
            'settings' => DISPLAY_LEFT_IMAGE_URL, //セッティングID
        )));

        $wp_customize->add_setting( DISPLAY_RIGHT_TITLE );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, DISPLAY_RIGHT_TITLE, array(
            'label'     => '右側→（モバイルでは下側↓）の見出し',
            'section'   => DISPLAY_AREA_SECTION,
            'settings' => DISPLAY_RIGHT_TITLE,
            'type'      => 'text',
        )));

        $wp_customize->add_setting( DISPLAY_RIGHT_COLOR );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, DISPLAY_RIGHT_COLOR, array(
			'label'    => '右側→（モバイルでは下側↓）の見出しの文字色',
			'section'  => DISPLAY_AREA_SECTION,
			'settings' => DISPLAY_RIGHT_COLOR,
		)));

        $wp_customize->add_setting( DISPLAY_RIGHT_IMAGE_URL );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, DISPLAY_RIGHT_IMAGE_URL, array(
            'label' => '右側→（モバイルでは下側↓）の画像', //設定ラベル
            'section' => DISPLAY_AREA_SECTION, //セクションID
            'settings' => DISPLAY_RIGHT_IMAGE_URL, //セッティングID
        )));
    }
    add_action( 'customize_register', 'themename_theme_customizer' );// カスタマイザーに登録

    // ディスプレイエリアの見出しの取得
    function get_the_display_left_title() {
        return esc_html( get_theme_mod( DISPLAY_LEFT_TITLE, 'TAKE OUT' ) );
    }

    function get_the_display_right_title() {
        return esc_html( get_theme_mod( DISPLAY_RIGHT_TITLE, 'EAT IN') );
    }
    // ディスプレイエリアの見出し文字色の取得
    function get_the_display_left_color() {
        return esc_attr( get_theme_mod( DISPLAY_LEFT_COLOR, '#fff' ) );
    }

    function get_the_display_right_color() {
        return esc_attr( get_theme_mod( DISPLAY_RIGHT_COLOR, '#fff' ) );
    }
    // ディスプレイエリアの画像URLの取得
    function get_the_display_left_image_url() {
        return esc_url( get_theme_mod( DISPLAY_LEFT_IMAGE_URL ) );
    }

    function get_the_display_right_image_url() {
        return esc_url( get_theme_mod( DISPLAY_RIGHT_IMAGE_URL ) );
    }
?>

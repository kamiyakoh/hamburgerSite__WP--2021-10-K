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

    //外観>カスタマイズにフロントページのディスプレイエリア設定機能追加
    //セクションIDの定数化
    define('DISPLAY_AREA_SECTION', 'display_area_section');
    //ディスプレイエリアの見出しの定数化
    define('DISPLAY_LEFT_TITLE', 'display_left_title');
    define('DISPLAY_RIGHT_TITLE', 'display_right_title');
    //ディスプレイエリアの見出し文字色の定数化
    define('DISPLAY_LEFT_COLOR', 'display_left_color');
    define('DISPLAY_RIGHT_COLOR', 'display_right_color');
    //ディスプレイエリアの画像URLの定数化
    define('DISPLAY_LEFT_IMAGE_URL', 'display_left_image_url');
    define('DISPLAY_RIGHT_IMAGE_URL', 'display_right_image_url');

    function theme_customizer_display_area( $wp_customize ) {
        $wp_customize->add_section( DISPLAY_AREA_SECTION , array(
            'title' => 'フロントページのディスプレイエリア', //セクション名
            'priority' => 91, //カスタマイザー項目の表示順
            'description' => 'フロントページのディスプレイエリア設定', //セクションの説明
        ));

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
    add_action( 'customize_register', 'theme_customizer_display_area' );// カスタマイザーに登録

    //ディスプレイエリアの見出しの取得
    function get_the_display_left_title() {
        return esc_html( get_theme_mod( DISPLAY_LEFT_TITLE, 'TAKE OUT' ) );
    }

    function get_the_display_right_title() {
        return esc_html( get_theme_mod( DISPLAY_RIGHT_TITLE, 'EAT IN') );
    }
    //ディスプレイエリアの見出し文字色の取得
    function get_the_display_left_color() {
        return esc_attr( get_theme_mod( DISPLAY_LEFT_COLOR, '#fff' ) );
    }

    function get_the_display_right_color() {
        return esc_attr( get_theme_mod( DISPLAY_RIGHT_COLOR, '#fff' ) );
    }
    //ディスプレイエリアの画像URLの取得
    function get_the_display_left_image_url() {
        return esc_url( get_theme_mod( DISPLAY_LEFT_IMAGE_URL ) );
    }

    function get_the_display_right_image_url() {
        return esc_url( get_theme_mod( DISPLAY_RIGHT_IMAGE_URL ) );
    }

    //セクションIDの定数化
    define('GMAP_SECTION', 'gmap_section');
    //グーグルマップの定数化
    define('GMAP', 'gmap');

    //外観>カスタマイズにグーグルマップ追加
    function theme_customizer_gmap( $wp_customize ) {
        $wp_customize->add_section( GMAP_SECTION , array(
            'title' => 'グーグルマップ', //セクション名
            'priority' => 92, //カスタマイザー項目の表示順
        ));

        $wp_customize->add_setting( GMAP );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, GMAP_SECTION, array(
            'label'     => 'グーグルマップ',
            'section'   => GMAP_SECTION,
            'settings' => GMAP,
            'description' => '1.<a href="https://www.google.co.jp/maps/" target="_blank" rel="noopener noreferrer">グーグルマップ</a>にアクセスしてください<br>
            2.指定する場所をクリックしてください<br>
            3.「>共有」を押してください<br>
            4.「地図を埋め込む」を押してください<br>
            5.「HTMLをコピー」を押してください<br>
            6.このページの↓下の入力欄に右クリックして貼り付けを行ってください<br>
            ※貼り付けたコードを変更したり付け加えないでください',
            'type'      => 'textarea',
        )));
    }
    add_action('customize_register', 'theme_customizer_gmap');

    //グーグルマップの取得
    function get_the_gmap() {
        return get_theme_mod( 'gmap' );
    }

    //外観>カスタマイズに地図上の見出し追加
    //セクションIDの定数化
    define('MAP_HEADING_SECTION', 'map_heading_section');
    //地図上の見出しの定数化
    define('MAP_HEADING', 'map_heading');

    function theme_customizer_map_heading( $wp_customize ) {
        $wp_customize->add_section( MAP_HEADING_SECTION , array(
            'title' => '地図上の見出し', //セクション名
            'priority' => 93, //カスタマイザー項目の表示順
        ));

        $wp_customize->add_setting( MAP_HEADING );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, MAP_HEADING_SECTION, array(
            'label'     => '見出し',
            'section'   => MAP_HEADING_SECTION,
            'settings' => MAP_HEADING,
            'description' => '地図の上に大きめの文字で表示される「見出し」を入力してください',
            'type'      => 'text',
        )));
    }
    add_action('customize_register', 'theme_customizer_map_heading');

    //地図上の見出しの取得
    function get_the_map_heading() {
        return esc_html( get_theme_mod( MAP_HEADING ) );
    }


    //外観>カスタマイズに所在地・連絡先追加
    function theme_customizer_address( $wp_customize ) {
        $wp_customize->add_section( 'address_section' , array(
            'title' => '所在地・連絡先', //セクション名
            'priority' => 94, //カスタマイザー項目の表示順
        ));

        $wp_customize->add_setting( 'address' );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'address_section', array(
            'label'     => '所在地・連絡先',
            'section'   => 'address_section',
            'settings' => 'address',
            'description' => '地図の上に表示される「所在地や連絡先」を入力してください',
            'type'      => 'textarea',
        )));
    }
    add_action('customize_register', 'theme_customizer_address');

    //所在地・連絡先の本文の取得
    function get_the_address() {
        return Nl2br( esc_html( get_theme_mod( 'address' ) ) );
    }

    //外観>カスタマイズにコピーライト追加
    function theme_customizer_copyright( $wp_customize ) {
        $wp_customize->add_section( 'copyright_section' , array(
            'title' => 'コピーライト', //セクション名
            'priority' => 95, //カスタマイザー項目の表示順
        ));

        $wp_customize->add_setting( 'copyright' );
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'copyright_section', array(
            'label'     => 'コピーライト',
            'section'   => 'copyright_section',
            'settings' => 'copyright',
            'description' => 'フッター（各ページ下部）に表示されるコピーライトを入力してください',
            'type'      => 'text',
        )));
    }
    add_action('customize_register', 'theme_customizer_copyright');

    //コピーライトの取得
    function get_the_copyright() {
        return esc_html( get_theme_mod( 'copyright' ) );
    }
?>

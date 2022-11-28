        <footer class="l-footer c-bg__img--brownWall">
            <?php     
                $menu_name = 'global_nav';

                if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
                    $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                    
                    $menu_list = '<ul class="p-footer__info">';

                    foreach ( (array) $menu_items as $key => $menu_item ) {
                        $title = $menu_item->title;
                        $url = $menu_item->url;
                        $menu_list .= '<li><a href="' . $url . '">' . $title . '</a></li>';
                    }
                    $menu_list .= '</ul>';
                } else {
                    $menu_list = '<ul class="p-footer__info"><li>グローバルナビゲーションが設定されてません</li></ul>';
                }
                echo $menu_list;
            ?>
            <p class="p-footer__license"><small>Copyright: <?php echo get_the_copyright(); ?></small></p>
        </footer>
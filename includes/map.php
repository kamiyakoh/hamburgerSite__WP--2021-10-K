<article id="js-map__key" class="c-subttlM p-map__minHeight p-map">
    <?php
        $the_query = new WP_Query(
            array(
                'post_type'         => 'map',
                'posts_per_page'    => 1,
            )
        );
        if ( $the_query -> have_posts() ) : while ( $the_query -> have_posts() ) : $the_query -> the_post() ;
            if ( get_field('gmap') ) :
                $gmap = get_field('gmap');
                if ( preg_match( '/^<iframe src="https:\/\/www.google.com\/maps\//' , $gmap ) ):
                    if (preg_match( '/<\/iframe>$/' , $gmap ) ):
                        $gmap = preg_replace( '/width="(.*?)" height="(.*?)"/', 'id="js-gmap" width="100%" height="100%"', $gmap );
                        echo $gmap;
                    endif;
                endif;
            endif;
    ?>
        <div id="js-map__shadow" class="c-bg__bra--shadow64 p-map__minHeight p-map__shadow">
            <div class="p-map__inner">
                <h2 class="p-map__heading"><?php the_title(); ?></h2>
                <div class="p-map__txt"><?php the_content(); ?></div>
            </div>
        </div>
    <?php endwhile; endif; wp_reset_postdata(); ?>
</article>
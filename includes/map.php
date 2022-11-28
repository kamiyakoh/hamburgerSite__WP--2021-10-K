<article id="js-map__key" class="c-subttlM p-map__minHeight p-map">
    <?php
        if ( get_the_gmap() ) :
            $gmap = get_the_gmap();
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
                <?php if ( get_the_map_heading() ) : ?>
                    <h2 class="p-map__heading"><?php echo get_the_map_heading(); ?></h2>
                <?php endif; ?>
                <div class="p-map__txt"><?php echo get_the_address(); ?></div>
            </div>
        </div>
</article>
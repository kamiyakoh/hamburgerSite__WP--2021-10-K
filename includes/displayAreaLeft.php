<?php if ( get_the_display_left_image_url() ) : ?>
    <article class="c-card__flex p-card" style="background-image:url(<?php echo get_the_display_left_image_url() ?>)">
<?php else: ?>
    <article class="c-bg__img--burgerOnTable c-card__flex p-card">
<?php endif; ?>
        <div>
            <?php if ( get_the_display_left_title() ) : ?>
                <h2 class="c-headingR--fwReg p-card__ttl" style="color: <?php echo get_the_display_left_color() ?>;"><?php echo get_the_display_left_title(); ?></h2>
                <hr class="p-card__line" style="background-color: <?php echo get_the_display_left_color() ?>;">
            <?php endif ?>
        </div>
        <div>
            <?php
                $query_card = new WP_Query(
                    array(
                        'post_type'         => 'display_card_left',
                        'posts_per_page'    => -1,
                    )
                );
            ?>
            <?php if ( $query_card -> have_posts() ) : while ( $query_card -> have_posts() ) : $query_card -> the_post() ; ?>
                <?php if ( has_tag() ) : ?>
                    <a href="<?php echo esc_url( get_tag_href() ); ?>">
                        <section class="c-bg__rgba--board p-card__board">
                            <h3 class="c-subttlM p-card__heading"><?php the_title(); ?></h3>
                            <div class="p-card__txt"><?php the_content(); ?></div>
                        </section>
                    </a>
                <?php else : ?>
                    <section class="c-bg__rgba--board p-card__board">
                        <h3 class="c-subttlM p-card__heading"><?php the_title(); ?></h3>
                        <div class="p-card__txt"><?php the_content(); ?></div>
                    </section>
                <?php endif; ?>
            <?php endwhile; endif; wp_reset_postdata(); ?>
        </div>
    </article>
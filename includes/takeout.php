<?php
    $the_query = new WP_Query(
        array(
            'post_type'         => array('frontpage', 'post'),
            'category_name'     => 'TakeOut',
            'posts_per_page'    => 1,
        )
    );
?>
    <?php if ( $the_query -> have_posts() ) : ?>
        <?php while ( $the_query -> have_posts() ) : $the_query -> the_post() ; ?>
            <?php if ( get_thumb_url() ) : ?>
                <article class="c-card__flex p-card" style="background-image:url(<?php echo esc_url( get_thumb_url() ); ?>)">
            <?php else: ?>
                <article class="c-bg__img--burgerOnTable c-card__flex p-card">
            <?php endif; ?>
                    <div>
                        <h2 class="c-headingR--fwReg p-card__ttl"><?php the_title(); ?></h2>
        <?php endwhile; ?>
    <?php else: ?>
        <article class="c-bg__img--burgerOnTable c-card__flex p-card">
            <div>
                <h2 class="c-headingR--fwReg p-card__ttl">Take Out</h2>
    <?php endif; wp_reset_postdata(); ?>
                <hr class="p-card__line">
            </div>
            <div>
                <?php
                    $query_card = new WP_Query(
                        array(
                            'post_type'         => 'take_out',
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
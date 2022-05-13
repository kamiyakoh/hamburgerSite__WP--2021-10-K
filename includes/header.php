<?php wp_body_open(); ?>

<header class="l-header c-bg--lightCream">
    <button class="c-headingR c-txtColor__gray p-header__menuBtn js-btn__sidemenu">Menu</button>
    <h2 class="c-headingR p-header__ttl">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
    </h2>
    <?php get_search_form(); ?>
</header>
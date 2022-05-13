<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">

<head>
    <?php get_header(); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php get_template_part('includes/header'); ?>
    <?php get_sidebar(); ?>
    <main>
        <?php $header_image = get_header_image();
        if (!empty($header_image)) : ?>
            <section id="header_img" class="c-mainvisual p-mainvisual" style="background-image:url(<?php header_image(); ?>)">
                <h1 class="c-subttlM p-mainvisual__ttl"><?php bloginfo( 'description' ); ?></h1>
            </section>
        <?php else: ?>
            <section class="c-mainvisual c-bg__mainvisual--frontPage p-mainvisual">
                <h1 class="c-subttlM p-mainvisual__ttl"><?php bloginfo( 'description' ); ?></h1>
            </section>
        <?php endif; ?>
        <div class="p-main__inner p-main__inner--frontPage">
            <?php get_template_part('includes/takeout'); ?>
            <?php get_template_part('includes/eatin'); ?>
        </div>
        <?php get_template_part('includes/map'); ?>
    </main>
    <?php get_footer(); ?>
    <?php wp_footer(); ?>
</body>

</html>
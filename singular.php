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
        <?php if (get_thumb_url()) : ?>
            <section id="header_img" class="c-mainvisual p-mainvisual p-mainvisual--page" style="background-image:url(<?php echo esc_url( get_thumb_url() ); ?>)">
        <?php else: ?>
            <section class="c-mainvisual c-bg__mainvisual--single p-mainvisual p-mainvisual--page">
        <?php endif; ?>
                <h1 class="c-subttlM p-mainvisual__ttl p-mainvisual__ttl--archive"><?php echo esc_html( get_the_title() ); ?></h1>
            </section>
            <div <?php post_class('c-txtColor--brown p-main__inner p-main__my p-post'); ?>>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <?php the_content(); ?>
                        <?php wp_link_pages(); ?>
                <?PHP endwhile; else : ?>
                    <p>表示する記事がありません</p>
                <?php endif; ?>
            </div>
    </main>
    <?php get_footer(); ?>
    <?php wp_footer(); ?>
</body>

</html>
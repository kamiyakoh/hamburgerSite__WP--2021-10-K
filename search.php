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
            <section id="header_img" class="c-mainvisual p-mainvisual p-mainvisual--archive" style="background-image:url(<?php echo esc_url( get_thumb_url() ); ?>)">
        <?php else: ?>
            <section class="c-mainvisual c-bg__mainvisual--archive p-mainvisual p-mainvisual--archive">
        <?php endif; ?>
                <div class="c-bg__rgba--shadowScreen p-mainvisual__shadowScreen">
                    <h1 class="c-headingR  p-mainvisual__ttl p-mainvisual__ttl--archive">Search:
                        <span class="c-subttlM p-mainvisual__subttl"><?php the_search_query(); ?></span>
                    </h1>
                </div>
            </section>
            <div class="p-main__inner">
                <article class="c-txtColor--brown">
                    <?php
                        $post_count = $wp_query->found_posts;
                        if ( $post_count > 0 ) :
                            if ( empty( get_search_query() ) ) :
                    ?>
                            <h2 class="c-subttlM p-main__ttl">検索キーワードが未入力</h2>
                        <?php else : ?>
                            <h2 class="c-subttlM p-main__ttl">"<?php the_search_query(); ?>"の検索結果は：<?php echo $post_count; ?>件</h2>
                            <div class="p-main__txt"><?php echo category_description(); ?></div>
                    <?php endif; endif; ?>
                </article>
                <?php get_template_part('includes/archiveResults'); ?>
                <?php if ( $wp_query -> max_num_pages > 1 ) :
                    wp_pagenavi();
                else : ?>
                    <div class="wp-pagenavi__none"></div>
                <?php endif; ?>
            </div>
    </main>
    <?php get_footer(); ?>
    <?php wp_footer(); ?>
</body>

</html>
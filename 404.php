<!DOCTYPE html>
<html lang="<?php language_attributes(); ?>">

<head>
    <?php get_header(); ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php get_template_part('includes/header'); ?>
    <?php get_sidebar(); ?>
    <main class="c-txtColor--brown p-main__inner p-main__my p-post">
        <h2>404 Not Found （お探しのページが見つかりませんでした）</h2>
        <p>指定された以下のページは存在しないか、または移動した可能性があります。</p>
        <p>URL :<?php echo get_pagenum_link(); ?></p>
        <p>現在表示する記事はありません。よろしければ、ページ上部の検索ボックスにお探しのコンテンツに該当するキーワードを入力して下さい。</p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-txtColor--blue">トップページへ</a>
    </main>
    <?php get_footer(); ?>
    <?php wp_footer(); ?>
</body>

</html>
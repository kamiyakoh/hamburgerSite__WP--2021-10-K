            <article>
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <article <?php post_class('p-archive'); ?>>
                        <div class="p-archive__img">
                            <?php  
                                if ( has_post_thumbnail() ) :
                                    the_post_thumbnail();
                                else :
                            ?><img src="<?php echo esc_url( get_template_directory_uri() . '/images/archiveSample.png' ); ?>" alt="archiveImage"><?php
                                endif;
                            ?>
                        </div>  
                        <a href="<?php the_permalink(); ?>" class="c-bg--lightBrown c-txtColor--white p-archive__inner">
                            <h3 class="c-subttlM p-archive__ttl"><?php the_title(); ?></h3>
                            <p class="p-archive__txt"><?php the_excerpt(); ?></p>
                            <button class="c-btn__capcel c-subttlM p-btn--archive">詳しく見る</button>
                        </a>
                    </article>
                <?php endwhile; else : ?>
                    <p class="c-subttlM p-main__ttl">お探しの商品はありませんでした</p>
                <?php endif; ?>
            </article>
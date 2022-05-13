<aside>
    <div class="p-sidemenu__shadowScreen"></div>
    <div class="l-sidemenu">
        <nav class="c-bg--creamA p-sidemenu__nav">
            <button class="p-btn__close js-btn__sidemenu"><span></span></button>
            <h2 class="c-headingR p-sidemenu__ttl">Menu</h2>
            <div class="p-sidemenu__main">
                <?php
                    if ( is_active_sidebar( 'sidebar_widget' ) ) :
                        dynamic_sidebar( 'sidebar_widget' );
                    else:
                ?>
                <section>
                    <h2>No Widget</h2>
                    <p>ウィジットは設定されていません。</p>
                </section>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</aside>
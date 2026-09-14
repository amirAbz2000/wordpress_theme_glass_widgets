<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
    </main><!-- #main -->

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="site-footer__inner">
            <p class="site-footer__copy">
                &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php bloginfo( 'name' ); ?>
                </a>.
                <?php esc_html_e( 'All rights reserved.', 'personal-site' ); ?>
            </p>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>

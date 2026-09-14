<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <header id="masthead" class="site-header" role="banner">
        <div class="site-header__inner">
            <div class="site-header__brand">
                <?php
                if ( has_custom_logo() ) :
                    the_custom_logo();
                else :
                ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-header__logo-text">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <nav id="site-navigation" class="site-header__nav" role="navigation"
                 aria-label="<?php esc_attr_e( 'Primary Menu', 'personal-site' ); ?>">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                ] );
                ?>
            </nav>
        </div>
    </header>

    <main id="main" class="site-main" role="main">

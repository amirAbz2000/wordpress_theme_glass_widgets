<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Theme setup
 */
function personal_site_setup(): void {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ] );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'wp-block-styles' );

    load_theme_textdomain( 'personal-site', get_template_directory() . '/languages' );

    register_nav_menus( [
        'primary' => esc_html__( 'Primary Menu', 'personal-site' ),
    ] );
}
add_action( 'after_setup_theme', 'personal_site_setup' );

/**
 * Enqueue assets
 */
function personal_site_enqueue(): void {
    $ver = wp_get_theme()->get( 'Version' );

    // Main stylesheet
    wp_enqueue_style(
        'personal-site-style',
        get_stylesheet_uri(),
        [],
        $ver
    );

    // Google Fonts — Inter
    wp_enqueue_style(
        'personal-site-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap',
        [],
        null
    );

    // Theme JS (only if file exists)
    $js_path = get_template_directory() . '/assets/js/theme.js';
    if ( file_exists( $js_path ) ) {
        wp_enqueue_script(
            'personal-site-theme',
            get_template_directory_uri() . '/assets/js/theme.js',
            [],
            $ver,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'personal_site_enqueue' );

/**
 * Register Elementor widgets
 */
function personal_site_register_elementor_widgets( \Elementor\Widgets_Manager $widgets_manager ): void {
    $widget_files = [
        'hero-widget',
        'stats-counter-widget',
        'glass-card-grid-widget',
        'about-widget',
    ];

    foreach ( $widget_files as $file ) {
        $path = get_template_directory() . "/inc/widgets/{$file}.php";
        if ( file_exists( $path ) ) {
            require_once $path;
        }
    }

    $widget_classes = [
        'Personal_Site_Hero_Widget',
        'Personal_Site_Stats_Counter_Widget',
        'Personal_Site_Glass_Card_Grid_Widget',
        'Personal_Site_About_Widget',
    ];

    foreach ( $widget_classes as $class ) {
        if ( class_exists( $class ) ) {
            $widgets_manager->register( new $class() );
        }
    }
}
add_action( 'elementor/widgets/register', 'personal_site_register_elementor_widgets' );

/**
 * Register custom Elementor widget category
 */
function personal_site_add_elementor_category( \Elementor\Elements_Manager $elements_manager ): void {
    $elements_manager->add_category(
        'personal-site',
        [
            'title' => esc_html__( 'Personal Site', 'personal-site' ),
            'icon'  => 'fa fa-user',
        ]
    );
}
add_action( 'elementor/elements/categories_registered', 'personal_site_add_elementor_category' );

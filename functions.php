<?php

if (!defined('ABSPATH')) {
    exit;
}

define('MAINSTAY_THEME_VERSION', '1.0.0');
define('MAINSTAY_THEME_DIR', get_template_directory());
define('MAINSTAY_THEME_URL', get_template_directory_uri());

class Mainstay_Theme_Setup {
    
    public function __construct() {
        add_action('after_setup_theme', array($this, 'setup'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('init', array($this, 'register_menus'));
        add_action('customize_register', array($this, 'customize_register'));
        
        if (class_exists('Timber')) {
            $this->init_timber();
        } else {
            add_action('admin_notices', array($this, 'timber_plugin_notice'));
        }
    }

    public function setup() {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));
        
        add_theme_support('custom-logo', array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array('site-title', 'site-description'),
        ));

        add_theme_support('editor-styles');
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');

        add_image_size('hero-banner', 1920, 800, true);
        add_image_size('card-image', 400, 300, true);
        add_image_size('logo-size', 300, 80, false);
    }

    public function enqueue_scripts() {
        wp_enqueue_style(
            'mainstay-google-fonts',
            'https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap',
            array(),
            null
        );

        wp_enqueue_style(
            'mainstay-tailwind',
            MAINSTAY_THEME_URL . '/assets/css/main.css',
            array('mainstay-google-fonts'),
            MAINSTAY_THEME_VERSION
        );

        wp_enqueue_script(
            'mainstay-script',
            MAINSTAY_THEME_URL . '/assets/js/main.js',
            array('jquery'),
            MAINSTAY_THEME_VERSION,
            true
        );

        wp_localize_script('mainstay-script', 'mainstay_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('mainstay_nonce')
        ));
    }

    public function register_menus() {
        register_nav_menus(array(
            'primary' => __('Primary Menu', 'mainstay-digital'),
            'footer' => __('Footer Menu', 'mainstay-digital'),
        ));
    }

    public function customize_register($wp_customize) {
        $wp_customize->add_section('mainstay_logo_section', array(
            'title'    => __('Logo Settings', 'mainstay-digital'),
            'priority' => 30,
        ));

        $wp_customize->add_setting('mainstay_logo_width', array(
            'default'           => '200',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('mainstay_logo_width', array(
            'label'    => __('Logo Width (px)', 'mainstay-digital'),
            'section'  => 'mainstay_logo_section',
            'type'     => 'number',
            'input_attrs' => array(
                'min' => 50,
                'max' => 500,
                'step' => 10,
            ),
        ));

        $wp_customize->add_setting('mainstay_logo_height', array(
            'default'           => '60',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('mainstay_logo_height', array(
            'label'    => __('Logo Height (px)', 'mainstay-digital'),
            'section'  => 'mainstay_logo_section',
            'type'     => 'number',
            'input_attrs' => array(
                'min' => 20,
                'max' => 200,
                'step' => 5,
            ),
        ));
    }

    public function init_timber() {
        Timber::$dirname = array('templates/views');
        add_filter('timber_context', array($this, 'add_to_context'));
        add_filter('get_twig', array($this, 'add_to_twig'));
    }

    public function add_to_context($context) {
        $context['primary_menu'] = new TimberMenu('primary');
        $context['footer_menu'] = new TimberMenu('footer');
        $context['site'] = new TimberSite();
        $context['theme_url'] = MAINSTAY_THEME_URL;
        
        $context['custom_logo'] = $this->get_custom_logo_data();
        $context['logo_settings'] = array(
            'width' => get_theme_mod('mainstay_logo_width', 200),
            'height' => get_theme_mod('mainstay_logo_height', 60),
        );
        
        return $context;
    }

    public function add_to_twig($twig) {
        $twig->addFunction(new Twig_SimpleFunction('asset', function($path) {
            return MAINSTAY_THEME_URL . '/assets/' . $path;
        }));

        return $twig;
    }

    private function get_custom_logo_data() {
        $custom_logo_id = get_theme_mod('custom_logo');
        
        if (!$custom_logo_id) {
            return false;
        }

        $logo_data = wp_get_attachment_image_src($custom_logo_id, 'full');
        $logo_alt = get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true);
        
        if (!$logo_data) {
            return false;
        }

        return array(
            'url' => $logo_data[0],
            'width' => $logo_data[1],
            'height' => $logo_data[2],
            'alt' => $logo_alt ? $logo_alt : get_bloginfo('name'),
            'id' => $custom_logo_id,
        );
    }

    public function timber_plugin_notice() {
        echo '<div class="notice notice-error"><p><strong>Mainstay Digital Theme:</strong> Please install and activate the <a href="' . admin_url('plugin-install.php?s=timber&tab=search&type=term') . '">Timber plugin</a> to use this theme.</p></div>';
    }
}

new Mainstay_Theme_Setup();

function mainstay_get_custom_logo() {
    $custom_logo_id = get_theme_mod('custom_logo');
    
    if (!$custom_logo_id) {
        return false;
    }

    return wp_get_attachment_image($custom_logo_id, 'full', false, array(
        'class' => 'custom-logo',
        'alt' => get_post_meta($custom_logo_id, '_wp_attachment_image_alt', true),
    ));
}

function mainstay_get_logo_url() {
    $custom_logo_id = get_theme_mod('custom_logo');
    
    if (!$custom_logo_id) {
        return false;
    }

    $logo_data = wp_get_attachment_image_src($custom_logo_id, 'full');
    return $logo_data ? $logo_data[0] : false;
}

function mainstay_customize_preview_js() {
    wp_enqueue_script(
        'mainstay-customizer',
        MAINSTAY_THEME_URL . '/assets/js/customizer.js',
        array('customize-preview'),
        MAINSTAY_THEME_VERSION,
        true
    );
}
add_action('customize_preview_init', 'mainstay_customize_preview_js');

function mainstay_admin_scripts($hook) {
    if ('appearance_page_custom-header' === $hook || 'customize.php' === $hook) {
        wp_enqueue_style(
            'mainstay-admin-style',
            MAINSTAY_THEME_URL . '/assets/css/admin.css',
            array(),
            MAINSTAY_THEME_VERSION
        );
    }
}
add_action('admin_enqueue_scripts', 'mainstay_admin_scripts');

function mainstay_body_classes($classes) {
    if (has_custom_logo()) {
        $classes[] = 'has-custom-logo';
    } else {
        $classes[] = 'no-custom-logo';
    }
    
    if (is_admin_bar_showing()) {
        $classes[] = 'admin-bar';
    }
    
    return $classes;
}
add_filter('body_class', 'mainstay_body_classes');

function mainstay_admin_bar_margin() {
    if (is_admin_bar_showing()) {
        echo '<style>
            html { margin-top: 0 !important; }
            .site-header { top: 32px; }
            .main-content { padding-top: calc(5rem + 32px); }
            @media screen and (max-width: 782px) {
                .site-header { top: 46px; }
                .main-content { padding-top: calc(5rem + 46px); }
                .mobile-menu { top: 46px; height: calc(100vh - 46px); }
            }
        </style>';
    }
}
add_action('wp_head', 'mainstay_admin_bar_margin');

function mainstay_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'mainstay_excerpt_length');

function mainstay_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'mainstay_excerpt_more');

function mainstay_custom_sizes($sizes) {
    return array_merge($sizes, array(
        'hero-banner' => __('Hero Banner', 'mainstay-digital'),
        'card-image' => __('Card Image', 'mainstay-digital'),
        'logo-size' => __('Logo Size', 'mainstay-digital'),
    ));
}
add_filter('image_size_names_choose', 'mainstay_custom_sizes');

function mainstay_theme_support_check() {
    $required_plugins = array(
        'timber' => array(
            'name' => 'Timber Library',
            'slug' => 'timber-library',
        ),
    );

    foreach ($required_plugins as $plugin => $details) {
        if (!class_exists(ucfirst($plugin))) {
            add_action('admin_notices', function() use ($details) {
                echo '<div class="notice notice-warning"><p><strong>Mainstay Digital Theme:</strong> This theme requires the <a href="' . admin_url('plugin-install.php?s=' . $details['slug'] . '&tab=search&type=term') . '">' . $details['name'] . '</a> plugin to function properly.</p></div>';
            });
        }
    }
}
add_action('init', 'mainstay_theme_support_check');

function mainstay_remove_wp_block_library_css() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style');
}
add_action('wp_enqueue_scripts', 'mainstay_remove_wp_block_library_css', 100);

function mainstay_enable_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'mainstay_enable_svg_upload');

function mainstay_fix_svg_display($response, $attachment, $meta) {
    if ($response['type'] === 'image' && $response['subtype'] === 'svg+xml') {
        $svg_path = get_attached_file($attachment->ID);
        if (file_exists($svg_path)) {
            $svg_content = file_get_contents($svg_path);
            $svg_width = 200;
            $svg_height = 200;
            
            if (preg_match('/width="([^"]+)"/', $svg_content, $width_match)) {
                $svg_width = intval($width_match[1]);
            }
            if (preg_match('/height="([^"]+)"/', $svg_content, $height_match)) {
                $svg_height = intval($height_match[1]);
            }
            
            $response['sizes'] = array(
                'full' => array(
                    'url' => $response['url'],
                    'width' => $svg_width,
                    'height' => $svg_height,
                    'orientation' => $svg_width > $svg_height ? 'landscape' : 'portrait'
                )
            );
        }
    }
    return $response;
}
add_filter('wp_prepare_attachment_for_js', 'mainstay_fix_svg_display', 10, 3);
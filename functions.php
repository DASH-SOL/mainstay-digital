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
            'footer_menu_1' => __('Footer Menu 1', 'mainstay-digital'),
            'footer_menu_2' => __('Footer Menu 2', 'mainstay-digital'),
            'footer_menu_3' => __('Footer Menu 3', 'mainstay-digital'),
        ));
    }

    public function customize_register($wp_customize) {
        // Logo Settings Section (existing)
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

        // Footer Settings Section
        $wp_customize->add_section('mainstay_footer_section', array(
            'title'    => __('Footer Settings', 'mainstay-digital'),
            'priority' => 40,
        ));

        // Footer Logo Settings
        $wp_customize->add_setting('mainstay_footer_logo', array(
            'default'           => '',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'mainstay_footer_logo', array(
            'label'    => __('Footer Logo', 'mainstay-digital'),
            'section'  => 'mainstay_footer_section',
            'mime_type' => 'image',
        )));

        $wp_customize->add_setting('mainstay_footer_logo_width', array(
            'default'           => '150',
            'sanitize_callback' => 'absint',
        ));

        $wp_customize->add_control('mainstay_footer_logo_width', array(
            'label'    => __('Footer Logo Width (px)', 'mainstay-digital'),
            'section'  => 'mainstay_footer_section',
            'type'     => 'number',
            'input_attrs' => array(
                'min' => 50,
                'max' => 300,
                'step' => 10,
            ),
        ));

        // Footer Menu Headings
        $wp_customize->add_setting('mainstay_footer_heading_1', array(
            'default'           => 'Services',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('mainstay_footer_heading_1', array(
            'label'   => __('Footer Menu 1 Heading', 'mainstay-digital'),
            'section' => 'mainstay_footer_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting('mainstay_footer_heading_2', array(
            'default'           => 'Company',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('mainstay_footer_heading_2', array(
            'label'   => __('Footer Menu 2 Heading', 'mainstay-digital'),
            'section' => 'mainstay_footer_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting('mainstay_footer_heading_3', array(
            'default'           => 'Resources',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('mainstay_footer_heading_3', array(
            'label'   => __('Footer Menu 3 Heading', 'mainstay-digital'),
            'section' => 'mainstay_footer_section',
            'type'    => 'text',
        ));

        // Footer Button Settings
        $wp_customize->add_setting('mainstay_footer_button_text', array(
            'default'           => 'Get in touch',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('mainstay_footer_button_text', array(
            'label'   => __('Footer Button Text', 'mainstay-digital'),
            'section' => 'mainstay_footer_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting('mainstay_footer_button_url', array(
            'default'           => '/contact',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control('mainstay_footer_button_url', array(
            'label'   => __('Footer Button URL', 'mainstay-digital'),
            'section' => 'mainstay_footer_section',
            'type'    => 'url',
        ));

        // Contact Information
        $wp_customize->add_setting('mainstay_footer_phone', array(
            'default'           => '1800 953 733',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('mainstay_footer_phone', array(
            'label'   => __('Phone Number', 'mainstay-digital'),
            'section' => 'mainstay_footer_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting('mainstay_footer_email', array(
            'default'           => 'contact@mainstay.digital',
            'sanitize_callback' => 'sanitize_email',
        ));

        $wp_customize->add_control('mainstay_footer_email', array(
            'label'   => __('Email Address', 'mainstay-digital'),
            'section' => 'mainstay_footer_section',
            'type'    => 'email',
        ));

        $wp_customize->add_setting('mainstay_footer_address', array(
            'default'           => 'Level 4, 60 Moorabool Street Geelong, VIC, 3220',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));

        $wp_customize->add_control('mainstay_footer_address', array(
            'label'   => __('Address', 'mainstay-digital'),
            'section' => 'mainstay_footer_section',
            'type'    => 'textarea',
        ));

        // Social Media Settings
        $social_platforms = array(
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'linkedin' => 'LinkedIn',
            'twitter' => 'Twitter',
            'youtube' => 'YouTube',
        );

        foreach ($social_platforms as $platform => $label) {
            $wp_customize->add_setting("mainstay_social_{$platform}", array(
                'default'           => '',
                'sanitize_callback' => 'esc_url_raw',
            ));

            $wp_customize->add_control("mainstay_social_{$platform}", array(
                'label'   => __($label . ' URL', 'mainstay-digital'),
                'section' => 'mainstay_footer_section',
                'type'    => 'url',
            ));
        }

        // Copyright Settings
        $wp_customize->add_setting('mainstay_footer_copyright', array(
            'default'           => '(C) 2025 MAINSTAY DIGITAL PTY LTD',
            'sanitize_callback' => 'sanitize_text_field',
        ));

        $wp_customize->add_control('mainstay_footer_copyright', array(
            'label'   => __('Copyright Text', 'mainstay-digital'),
            'section' => 'mainstay_footer_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting('mainstay_footer_acknowledgment', array(
            'default'           => 'Mainstay Digital acknowledges Aboriginal and Torres Strait Islander people as the Traditional Custodians of the land and acknowledges and pays respect to their Elders, past and present.',
            'sanitize_callback' => 'sanitize_textarea_field',
        ));

        $wp_customize->add_control('mainstay_footer_acknowledgment', array(
            'label'   => __('Acknowledgment Text', 'mainstay-digital'),
            'section' => 'mainstay_footer_section',
            'type'    => 'textarea',
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
        $context['footer_menu_1'] = new TimberMenu('footer_menu_1');
        $context['footer_menu_2'] = new TimberMenu('footer_menu_2');
        $context['footer_menu_3'] = new TimberMenu('footer_menu_3');
        $context['site'] = new TimberSite();
        $context['theme_url'] = MAINSTAY_THEME_URL;
        
        $context['custom_logo'] = $this->get_custom_logo_data();
        $context['logo_settings'] = array(
            'width' => get_theme_mod('mainstay_logo_width', 200),
            'height' => get_theme_mod('mainstay_logo_height', 60),
        );

        // Footer settings
        $context['footer_settings'] = array(
            'logo' => $this->get_footer_logo_data(),
            'logo_width' => get_theme_mod('mainstay_footer_logo_width', 150),
            'headings' => array(
                'heading_1' => get_theme_mod('mainstay_footer_heading_1', 'Services'),
                'heading_2' => get_theme_mod('mainstay_footer_heading_2', 'Company'),
                'heading_3' => get_theme_mod('mainstay_footer_heading_3', 'Resources'),
            ),
            'button' => array(
                'text' => get_theme_mod('mainstay_footer_button_text', 'Get in touch'),
                'url' => get_theme_mod('mainstay_footer_button_url', '/contact'),
            ),
            'contact' => array(
                'phone' => get_theme_mod('mainstay_footer_phone', '1800 953 733'),
                'email' => get_theme_mod('mainstay_footer_email', 'contact@mainstay.digital'),
                'address' => get_theme_mod('mainstay_footer_address', 'Level 4, 60 Moorabool Street Geelong, VIC, 3220'),
            ),
            'social' => $this->get_social_links(),
            'copyright' => get_theme_mod('mainstay_footer_copyright', '(C) 2025 MAINSTAY DIGITAL PTY LTD'),
            'acknowledgment' => get_theme_mod('mainstay_footer_acknowledgment', 'Mainstay Digital acknowledges Aboriginal and Torres Strait Islander people as the Traditional Custodians of the land and acknowledges and pays respect to their Elders, past and present.'),
        );
        
        return $context;
    }

    private function get_footer_logo_data() {
        $footer_logo_id = get_theme_mod('mainstay_footer_logo');
        
        if (!$footer_logo_id) {
            return false;
        }

        $logo_data = wp_get_attachment_image_src($footer_logo_id, 'full');
        $logo_alt = get_post_meta($footer_logo_id, '_wp_attachment_image_alt', true);
        
        if (!$logo_data) {
            return false;
        }

        return array(
            'url' => $logo_data[0],
            'width' => $logo_data[1],
            'height' => $logo_data[2],
            'alt' => $logo_alt ? $logo_alt : get_bloginfo('name'),
            'id' => $footer_logo_id,
        );
    }

    private function get_social_links() {
        $social_platforms = array(
            'facebook' => 'Facebook',
            'instagram' => 'Instagram', 
            'linkedin' => 'LinkedIn',
            'twitter' => 'Twitter',
            'youtube' => 'YouTube',
        );

        $social_links = array();
        foreach ($social_platforms as $platform => $label) {
            $url = get_theme_mod("mainstay_social_{$platform}", '');
            if (!empty($url)) {
                $social_links[$platform] = array(
                    'url' => $url,
                    'label' => $label,
                );
            }
        }

        return $social_links;
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

// Rest of the existing functions remain the same...
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

require_once MAINSTAY_THEME_DIR . '/includes/acf-blocks.php';

function mainstay_get_breadcrumbs() {
    $breadcrumbs = array();
    
    $breadcrumbs[] = array(
        'title' => 'Home',
        'url' => home_url('/')
    );
    
    if (is_page()) {
        $post = get_queried_object();
        $ancestors = get_post_ancestors($post);
        
        if ($ancestors) {
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                $breadcrumbs[] = array(
                    'title' => get_the_title($ancestor),
                    'url' => get_permalink($ancestor)
                );
            }
        }
        
        $breadcrumbs[] = array(
            'title' => get_the_title($post),
            'url' => null
        );
    } elseif (is_single()) {
        $post_type = get_post_type();
        $post_type_object = get_post_type_object($post_type);
        
        if ($post_type_object && $post_type !== 'post') {
            $breadcrumbs[] = array(
                'title' => $post_type_object->labels->name,
                'url' => get_post_type_archive_link($post_type)
            );
        }
        
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            if ($category->parent != 0) {
                $category_parents = get_category_parents($category->parent, true, '|||');
                $category_parents = explode('|||', $category_parents);
                foreach ($category_parents as $parent) {
                    if (!empty($parent)) {
                        $breadcrumbs[] = array(
                            'title' => strip_tags($parent),
                            'url' => null
                        );
                    }
                }
            }
            $breadcrumbs[] = array(
                'title' => $category->name,
                'url' => get_category_link($category->term_id)
            );
        }
        
        $breadcrumbs[] = array(
            'title' => get_the_title(),
            'url' => null
        );
    } elseif (is_category()) {
        $category = get_queried_object();
        if ($category->parent != 0) {
            $category_parents = get_category_parents($category->parent, true, '|||');
            $category_parents = explode('|||', $category_parents);
            foreach ($category_parents as $parent) {
                if (!empty($parent)) {
                    $breadcrumbs[] = array(
                        'title' => strip_tags($parent),
                        'url' => null
                    );
                }
            }
        }
        $breadcrumbs[] = array(
            'title' => $category->name,
            'url' => null
        );
    } elseif (is_archive()) {
        $post_type = get_post_type();
        $post_type_object = get_post_type_object($post_type);
        
        if ($post_type_object) {
            $breadcrumbs[] = array(
                'title' => $post_type_object->labels->name,
                'url' => null
            );
        }
    } elseif (is_search()) {
        $breadcrumbs[] = array(
            'title' => 'Search Results for "' . get_search_query() . '"',
            'url' => null
        );
    } elseif (is_404()) {
        $breadcrumbs[] = array(
            'title' => '404 Not Found',
            'url' => null
        );
    }
    
    return $breadcrumbs;
}
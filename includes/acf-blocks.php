<?php

if (!defined('ABSPATH')) {
    exit;
}

function register_mainstay_acf_blocks() {
    if (function_exists('acf_register_block_type')) {
        
        acf_register_block_type(array(
            'name'              => 'hero-section',
            'title'             => __('Hero Section'),
            'description'       => __('Hero section with headline, services and CTA button'),
            'render_template'   => get_template_directory() . '/templates/blocks/hero-section.php',
            'category'          => 'formatting',
            'icon'              => 'cover-image',
            'keywords'          => array('hero', 'banner', 'landing'),
            'supports'          => array(
                'align' => false,
                'anchor' => true,
                'customClassName' => true,
                'jsx' => true,
            ),
            'mode' => 'preview',
            'example' => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'headline' => 'Sample Hero Headline',
                        'button_text' => 'Get Started'
                    ),
                ),
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'about-section',
            'title'             => __('About Section'),
            'description'       => __('About section with heading and content'),
            'render_template'   => get_template_directory() . '/templates/blocks/about-section.php',
            'category'          => 'formatting',
            'icon'              => 'admin-page',
            'keywords'          => array('about', 'content'),
            'supports'          => array(
                'align' => false,
                'anchor' => true,
                'customClassName' => true,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'capability-section',
            'title'             => __('Capability Section'),
            'description'       => __('Capability section with services listing'),
            'render_template'   => get_template_directory() . '/templates/blocks/capability-section.php',
            'category'          => 'formatting',
            'icon'              => 'list-view',
            'keywords'          => array('capability', 'services'),
            'supports'          => array(
                'align' => false,
                'anchor' => true,
                'customClassName' => true,
            ),
        ));

        acf_register_block_type(array(
            'name'              => 'experience-section',
            'title'             => __('Experience Section'),
            'description'       => __('Experience section with client logos'),
            'render_template'   => get_template_directory() . '/templates/blocks/experience-section.php',
            'category'          => 'formatting',
            'icon'              => 'images-alt2',
            'keywords'          => array('experience', 'logos', 'clients'),
            'supports'          => array(
                'align' => false,
                'anchor' => true,
                'customClassName' => true,
            ),
        ));
    }
}

add_action('acf/init', 'register_mainstay_acf_blocks');
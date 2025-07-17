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
            'name'              => 'single-col-text-trunc',
            'title'             => __('Single Col Text - Trunc'),
            'description'       => __('Single column text section with heading and content'),
            'render_template'   => get_template_directory() . '/templates/blocks/single-col-text-trunc.php',
            'category'          => 'formatting',
            'icon'              => 'admin-page',
            'keywords'          => array('single', 'column', 'text', 'content'),
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
            'name'              => 'experience',
            'title'             => __('Experience'),
            'description'       => __('Experience section with client logos'),
            'render_template'   => get_template_directory() . '/templates/blocks/experience.php',
            'category'          => 'formatting',
            'icon'              => 'images-alt2',
            'keywords'          => array('experience', 'logos', 'clients'),
            'supports'          => array(
                'align' => false,
                'anchor' => true,
                'customClassName' => true,
            ),
        ));

        acf_register_block_type(array(
    'name'              => 'learn-more-article-link',
    'title'             => __('Learn More - Article Link'),
    'description'       => __('Display recent articles with category filtering'),
    'render_template'   => get_template_directory() . '/templates/blocks/learn-more-article-link.php',
    'category'          => 'formatting',
    'icon'              => 'admin-post',
    'keywords'          => array('learn', 'articles', 'blog', 'posts'),
    'supports'          => array(
        'align' => false,
        'anchor' => true,
        'customClassName' => true,
    ),
));
acf_register_block_type(array(
    'name'              => 'case-studies',
    'title'             => __('Case Studies'),
    'description'       => __('Display recent case studies'),
    'render_template'   => get_template_directory() . '/templates/blocks/case-studies.php',
    'category'          => 'formatting',
    'icon'              => 'portfolio',
    'keywords'          => array('case', 'studies', 'portfolio', 'work'),
    'supports'          => array(
        'align' => false,
        'anchor' => true,
        'customClassName' => true,
    ),
));
    }
}

add_action('acf/init', 'register_mainstay_acf_blocks');
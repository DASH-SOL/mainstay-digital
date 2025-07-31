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
acf_register_block_type(array(
    'name'              => 'image-text-var-1',
    'title'             => __('image - text - var 1'),
    'description'       => __('Image and text section with button'),
    'render_template'   => get_template_directory() . '/templates/blocks/image-text-var-1.php',
    'category'          => 'formatting',
    'icon'              => 'format-image',
    'keywords'          => array('image', 'text', 'content', 'layout'),
    'supports'          => array(
        'align' => false,
        'anchor' => true,
        'customClassName' => true,
    ),
));
acf_register_block_type(array(
            'name'              => 'get-in-touch',
            'title'             => __('Get in Touch', 'mainstay-digital'),
            'description'       => __('A contact form section with heading, text, and form shortcode.'),
            'render_template'   => get_template_directory() . '/templates/blocks/get-in-touch.php',
            'category'          => 'mainstay-blocks',
            'icon'              => 'email-alt',
            'keywords'          => array('contact', 'form', 'get in touch'),
            'supports'          => array(
                'align'         => false,
                'anchor'        => true,
                'customClassName' => true,
            ),
        ));

        acf_register_block_type(array(
    'name'              => 'service-process',
    'title'             => __('Service Process'),
    'description'       => __('Service development process items with headings and content'),
    'render_template'   => get_template_directory() . '/templates/blocks/service-process.php',
    'category'          => 'mainstay-blocks',
    'icon'              => 'list-view',
    'keywords'          => array('service', 'process', 'development', 'steps'),
    'supports'          => array(
        'align' => false,
        'anchor' => true,
        'customClassName' => true,
    ),
));
acf_register_block_type(array(
    'name'              => 'service-content',
    'title'             => __('Service Content'),
    'description'       => __('Custom service content block'),
    'render_template'   => 'templates/blocks/service-content.php',
    'category'          => 'formatting',
    'icon'              => 'editor-alignleft',
    'keywords'          => array('service', 'content', 'text'),
));
acf_register_block_type(array(
    'name'              => 'key-services',
    'title'             => __('Key Services'),
    'description'       => __('Display key services in a grid layout'),
    'render_template'   => 'templates/blocks/key-services.php',
    'category'          => 'formatting',
    'icon'              => 'grid-view',
    'keywords'          => array('services', 'grid', 'key'),
));
acf_register_block_type(array(
            'name'              => 'recent-work',
            'title'             => __('Recent Work'),
            'description'       => __('A block to display recent case studies with filtering.'),
            'render_template'   => 'templates/blocks/recent-work.php',
            'category'          => 'mainstay-blocks',
            'icon'              => 'portfolio',
            'keywords'          => array('recent', 'work', 'case studies', 'portfolio'),
            'supports'          => array(
                'align'         => array('wide', 'full'),
                'mode'          => false,
                'jsx'           => true
            ),
            'example'           => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'posts_count' => 6
                    )
                )
            )
        ));
        acf_register_block_type(array(
            'name' => 'service-text-image',
            'title' => 'Service Text-Image Block',
            'description' => 'A block with heading, text content and an image with flexible positioning.',
            'render_template' => get_template_directory() . '/templates/blocks/service-text-image.php',
            'category' => 'mainstay-blocks',
            'icon' => 'format-image',
            'keywords' => array('service', 'text', 'image', 'content'),
            'supports' => array(
                'align' => false,
                'mode' => false,
                'jsx' => true,
            ),
            'example' => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'heading' => 'Reliable, scalable, flexible',
                        'text' => 'Ensure your website is built the right way. Don\'t risk costly rebuilds, difficult site admin, future bug fixes and breakages, insecure data or poor performance.<br><br>We develop future proof, robust, cleanly coded, upgradable websites built to evolve with your business.',
                        'image_position' => 'left'
                    ),
                ),
            ),
        ));

        acf_register_block_type(array(
            'name' => 'service-process-var2',
            'title' => 'Service Process Var 2',
            'description' => 'A block displaying service process items in a grid layout with green borders.',
            'render_template' => get_template_directory() . '/templates/blocks/service-process-var2.php',
            'category' => 'mainstay-blocks',
            'icon' => 'list-view',
            'keywords' => array('service', 'process', 'steps', 'grid'),
            'supports' => array(
                'align' => false,
                'mode' => false,
                'jsx' => true,
            ),
            'example' => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(
                        'title' => 'Our Development Process',
                        'process_items' => array(
                            array(
                                'heading' => 'Best coding and development practices (H3)',
                                'content' => 'Time and again we encounter legacy websites and systems which were badly, inefficiently, or lazily implemented. Spaghetti-code situations with cross dependencies which make upgrades next to impossible.'
                            ),
                            array(
                                'heading' => 'Best coding and development practices (H3)',
                                'content' => 'Time and again we encounter legacy websites and systems which were badly, inefficiently, or lazily implemented. Spaghetti-code situations with cross dependencies which make upgrades next to impossible.'
                            )
                        )
                    ),
                ),
            ),
        ));
        acf_register_block_type(array(
    'name'              => 'callout-section',
    'title'             => __('Callout Section'),
    'description'       => __('A callout section with heading and repeatable content items'),
    'render_template'   => 'templates/blocks/callout-section.php',
    'category'          => 'formatting',
    'icon'              => 'megaphone',
    'keywords'          => array('callout', 'highlight', 'section'),
    'supports'          => array(
        'align' => false,
        'anchor' => true,
        'customClassName' => true,
    ),
));
    }
}

add_action('acf/init', 'register_mainstay_acf_blocks');
<?php
/**
 * The main template file
 */

// Check if Timber plugin is activated
if (!class_exists('Timber')) {
    echo '<h1>Timber Plugin Required</h1>';
    echo '<p>Please install and activate the Timber plugin from the WordPress admin.</p>';
    echo '<p><a href="' . admin_url('plugin-install.php?s=timber&tab=search&type=term') . '">Install Timber Plugin</a></p>';
    return;
}

$context = Timber::get_context();

$context['posts'] = Timber::get_posts();

$context['is_home'] = is_home();
$context['is_front_page'] = is_front_page();

if (is_home()) {
    $context['page_title'] = 'Latest Posts';
} else {
    $context['page_title'] = get_the_title();
}

Timber::render('index.twig', $context);
<?php
/**
 * Single Service Template - Services Var 1
 */

if (!class_exists('Timber')) {
    echo 'Timber plugin is required for this theme';
    return;
}

$context = Timber::get_context();
$context['post'] = new TimberPost();

// Add breadcrumbs context
$context['breadcrumbs'] = array(
    array('title' => 'Home', 'url' => home_url()),
    array('title' => 'Services', 'url' => get_post_type_archive_link('service')),
    array('title' => get_the_title(), 'url' => '')
);

Timber::render('single-service.twig', $context);
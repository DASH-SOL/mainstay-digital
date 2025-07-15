<?php

if (!class_exists('Timber')) {
    return;
}

$mock_post = new stdClass();
$mock_post->meta = function($key) {
    switch($key) {
        case 'about-heading':
            return get_field('heading');
        case 'about_text':
            return get_field('content');
        default:
            return null;
    }
};

$context = Timber::get_context();
$context['post'] = $mock_post;
$context['block'] = $block;

Timber::render('partials/sections/about.twig', $context);
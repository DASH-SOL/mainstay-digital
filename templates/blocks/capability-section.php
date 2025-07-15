<?php

if (!class_exists('Timber')) {
    return;
}

$mock_post = new stdClass();
$mock_post->meta = function($key) {
    switch($key) {
        case 'capability_heading':
            return get_field('heading');
        case 'capability_sub_heading':
            return get_field('sub_heading');
        case 'capability_text':
            return get_field('content');
        case 'services':
            return get_field('services');
        default:
            return null;
    }
};

$context = Timber::get_context();
$context['post'] = $mock_post;
$context['block'] = $block;

Timber::render('partials/sections/capability.twig', $context);
<?php

if (!class_exists('Timber')) {
    return;
}

$mock_post = new stdClass();
$mock_post->meta = function($key) {
    switch($key) {
        case 'experience_heading':
            return get_field('heading');
        case 'experience_logos':
            return get_field('logos');
        default:
            return null;
    }
};

$context = Timber::get_context();
$context['post'] = $mock_post;
$context['block'] = $block;

Timber::render('partials/sections/experience.twig', $context);
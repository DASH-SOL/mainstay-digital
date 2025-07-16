<?php

if (!class_exists('Timber')) {
    return;
}

$about_heading = get_field('about_heading');
$about_text = get_field('about_text');

$about_data = array(
    'heading' => $about_heading,
    'content' => $about_text
);

$context = Timber::get_context();
$context['about'] = $about_data;
$context['block'] = $block;

Timber::render('partials/sections/about.twig', $context);
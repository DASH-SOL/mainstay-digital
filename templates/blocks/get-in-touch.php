<?php

if (!class_exists('Timber')) {
    return;
}

$heading = get_field('heading');
$text = get_field('text');
$shortcode = get_field('shortcode');

$get_in_touch_data = array(
    'heading' => $heading,
    'text' => $text,
    'shortcode' => $shortcode
);

$context = Timber::get_context();
$context['get_in_touch'] = $get_in_touch_data;
$context['block'] = $block;

Timber::render('partials/sections/get-in-touch.twig', $context);
<?php

if (!class_exists('Timber')) {
    return;
}

$image = get_field('image');
$heading = get_field('heading');
$content_items = get_field('content_items');

$image_text = array(
    'image' => $image,
    'heading' => $heading,
    'content_items' => $content_items
);

$context = Timber::get_context();
$context['image_text'] = $image_text;
$context['block'] = $block;

Timber::render('partials/sections/guarantee.twig', $context);
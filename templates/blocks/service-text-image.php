<?php

if (!class_exists('Timber')) {
    return;
}

$service_title = get_field('title');
$service_heading = get_field('heading');
$service_heading_type = get_field('heading_type');
$service_text = get_field('text');
$service_image = get_field('image');
$service_image_position = get_field('image_position');

$service_text_image_data = array(
    'title' => $service_title,
    'heading' => $service_heading,
    'heading_type' => $service_heading_type,
    'text' => $service_text,
    'image' => $service_image,
    'image_position' => $service_image_position
);

$context = Timber::get_context();
$context['service_text_image'] = $service_text_image_data;
$context['block'] = $block;

Timber::render('partials/sections/service-text-image.twig', $context);
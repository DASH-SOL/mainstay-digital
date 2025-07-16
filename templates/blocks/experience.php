<?php

if (!class_exists('Timber')) {
    return;
}

$experience_heading = get_field('experience_heading');
$experience_logos = get_field('experience_logos');

$experience_data = array(
    'heading' => $experience_heading,
    'logos' => $experience_logos
);

$context = Timber::get_context();
$context['experience'] = $experience_data;
$context['block'] = $block;

Timber::render('partials/sections/experience.twig', $context);
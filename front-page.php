<?php

if (!class_exists('Timber')) {
    echo 'Timber plugin is required for this theme';
    return;
}

$context = Timber::get_context();
$context['post'] = new TimberPost();

Timber::render('front-page.twig', $context);
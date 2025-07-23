<?php

if (!class_exists('Timber')) {
    return;
}

$context = Timber::get_context();
$context['process'] = get_fields();

Timber::render('partials/sections/service-process.twig', $context);
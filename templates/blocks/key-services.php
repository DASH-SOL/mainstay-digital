<?php
/**
 * Key Services Block
 * File: templates/blocks/key-services.php
 */

if (!class_exists('Timber')) {
    return;
}

$context = Timber::get_context();
$context['services'] = get_fields();
Timber::render('partials/sections/key-services.twig', $context);
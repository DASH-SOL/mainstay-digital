<?php
/**
 * Service Content Block
 * File: templates/blocks/service-content.php
 */

if (!class_exists('Timber')) {
    return;
}

$context = Timber::get_context();
$context['content'] = get_fields();
Timber::render('partials/sections/service-content.twig', $context);
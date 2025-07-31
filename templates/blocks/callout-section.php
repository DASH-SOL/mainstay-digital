<?php
if (!class_exists('Timber')) {
    return;
}
$context = Timber::get_context();
$context['callout'] = get_fields();
Timber::render('partials/sections/callout-section.twig', $context);
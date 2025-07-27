<?php

if (!class_exists('Timber')) {
    return;
}

$service_title = get_field('title');
$service_process_items = get_field('process_items');

$process_items_formatted = array();
if ($service_process_items && is_array($service_process_items)) {
    foreach ($service_process_items as $item) {
        if (is_array($item)) {
            $process_items_formatted[] = array(
                'heading' => isset($item['heading']) ? $item['heading'] : '',
                'content' => isset($item['content']) ? $item['content'] : ''
            );
        }
    }
}

$service_process_var2_data = array(
    'title' => $service_title,
    'process_items' => $process_items_formatted
);

$context = Timber::get_context();
$context['service_process_var2'] = $service_process_var2_data;
$context['block'] = $block;

Timber::render('partials/sections/service-process-var2.twig', $context);
<?php

if (!class_exists('Timber')) {
    return;
}

$capability_heading = get_field('capability_heading');
$capability_sub_heading = get_field('capability_sub_heading');
$capability_content = get_field('capability_content');
$capability_services = get_field('capability_services');

$services_formatted = array();
if ($capability_services && is_array($capability_services)) {
    foreach ($capability_services as $service) {
        if (is_array($service)) {
            $services_formatted[] = array(
                'service_name' => isset($service['service_name']) ? $service['service_name'] : '',
                'service_url' => isset($service['service_url']) ? $service['service_url'] : '',
                'service_description' => isset($service['service_description']) ? $service['service_description'] : ''
            );
        }
    }
}

$capability_data = array(
    'heading' => $capability_heading,
    'sub_heading' => $capability_sub_heading,
    'content' => $capability_content,
    'services' => $services_formatted
);

$context = Timber::get_context();
$context['capability'] = $capability_data;
$context['block'] = $block;

Timber::render('partials/sections/capability.twig', $context);
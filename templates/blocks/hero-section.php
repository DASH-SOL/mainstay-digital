<?php

if (!class_exists('Timber')) {
    return;
}

$hero_headline = get_field('hero_headline');
$hero_services = get_field('hero_services');
$hero_button_text = get_field('hero_button_text');
$hero_button_url = get_field('hero_button_url');
$hero_decorative_graphic_desktop = get_field('hero_decorative_graphic_desktop');
$hero_decorative_graphic_mobile = get_field('hero_decorative_graphic_mobile');

$services_formatted = array();
if ($hero_services && is_array($hero_services)) {
    foreach ($hero_services as $service) {
        if (is_array($service)) {
            $service_text = '';
            if (isset($service['hero_service_text'])) {
                $service_text = $service['hero_service_text'];
            } elseif (isset($service['service_text'])) {
                $service_text = $service['service_text'];
            } elseif (isset($service[0])) {
                $service_text = $service[0];
            }
            
            if ($service_text) {
                $services_formatted[] = array('service_text' => $service_text);
            }
        } elseif (is_string($service)) {
            $services_formatted[] = array('service_text' => $service);
        }
    }
}

$hero_data = array(
    'headline' => $hero_headline,
    'services' => $services_formatted,
    'button_text' => $hero_button_text,
    'button_url' => $hero_button_url,
    'decorative_graphic_desktop' => $hero_decorative_graphic_desktop,
    'decorative_graphic_mobile' => $hero_decorative_graphic_mobile
);

$context = Timber::get_context();
$context['hero'] = $hero_data;
$context['block'] = $block;

Timber::render('partials/sections/hero.twig', $context);
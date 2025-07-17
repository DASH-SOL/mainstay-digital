<?php

if (!class_exists('Timber')) {
    return;
}

$case_studies_count = get_field('case_studies_count') ?: 3;

$args = array(
    'post_type' => 'case-study',
    'posts_per_page' => $case_studies_count,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
);

$posts = Timber::get_posts($args);

$case_studies = array(
    'heading' => 'Case Studies',
    'posts' => $posts,
    'show_excerpt' => true,
    'view_all_link' => '/case-studies',
    'post_count' => count($posts),
    'debug' => $args
);

$context = Timber::get_context();
$context['case_studies'] = $case_studies;
$context['block'] = $block;

Timber::render('partials/sections/case-studies.twig', $context);
<?php

if (!class_exists('Timber')) {
    return;
}

$learn_more_heading = get_field('learn_more_heading');
$learn_more_category = get_field('learn_more_category');
$learn_more_post_count = get_field('learn_more_post_count') ?: 3;
$learn_more_show_excerpt = get_field('learn_more_show_excerpt');
$learn_more_button_text = get_field('learn_more_button_text') ?: 'View All Articles';
$learn_more_button_url = get_field('learn_more_button_url') ?: '/blog';

$args = array(
    'post_type' => 'post',
    'posts_per_page' => $learn_more_post_count,
    'post_status' => 'publish'
);

if ($learn_more_category && $learn_more_category !== 'all') {
    $args['category_name'] = $learn_more_category;
}

$posts = Timber::get_posts($args);

$learn_more_data = array(
    'heading' => $learn_more_heading,
    'posts' => $posts,
    'show_excerpt' => $learn_more_show_excerpt,
    'button_text' => $learn_more_button_text,
    'button_url' => $learn_more_button_url,
    'category' => $learn_more_category
);

$context = Timber::get_context();
$context['learn_more'] = $learn_more_data;
$context['block'] = $block;

Timber::render('partials/sections/learn-more.twig', $context);
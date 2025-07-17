<?php

if (!class_exists('Timber')) {
    return;
}

$learn_more_post_count = get_field('learn_more_post_count') ?: 3;

$args = array(
    'post_type' => 'post',
    'posts_per_page' => $learn_more_post_count,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
);

$posts = Timber::get_posts($args);

$blog = array(
    'heading' => 'Learn more',
    'posts' => $posts,
    'show_excerpt' => true,
    'insights_link' => '/insights'
);

$context = Timber::get_context();
$context['blog'] = $blog;
$context['block'] = $block;

Timber::render('partials/sections/blog.twig', $context);
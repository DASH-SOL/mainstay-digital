<?php
/**
 * Block Name: Blog Listings
 *
 * This is the template that displays the blog listings block.
 */

if (!class_exists('Timber')) {
    return;
}

$posts_count = get_field('posts_count') ?: 6;

$args = array(
    'post_type'      => 'post',
    'posts_per_page' => $posts_count,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC'
);

$context = Timber::get_context();
$context['posts'] = Timber::get_posts($args);
$context['categories'] = Timber::get_terms('category');
$context['block'] = $block;

Timber::render('partials/sections/blog-listings.twig', $context);

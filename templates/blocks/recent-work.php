<?php

if (!class_exists('Timber')) {
    return;
}

$posts_count = get_field('posts_count') ?: 6;

$args = array(
    'post_type' => 'case-study',
    'posts_per_page' => $posts_count,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
);

$posts = Timber::get_posts($args);

$taxonomy_names = array('category', 'case_study_category', 'case-study-category');
$categories_data = array();
$taxonomy_used = 'category';

foreach ($taxonomy_names as $tax_name) {
    $categories = get_terms(array(
        'taxonomy' => $tax_name,
        'hide_empty' => false
    ));
    
    if ($categories && !is_wp_error($categories)) {
        foreach ($categories as $category) {
            $categories_data[] = array(
                'name' => $category->name,
                'slug' => $category->slug
            );
        }
        $taxonomy_used = $tax_name;
        break;
    }
}

$context = Timber::get_context();
$context['posts'] = $posts;
$context['categories'] = $categories_data;
$context['taxonomy_used'] = $taxonomy_used;
$context['block'] = $block;

Timber::render('partials/sections/recent-work.twig', $context);
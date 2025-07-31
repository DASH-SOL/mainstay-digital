<?php

if (!class_exists('Timber')) {
    echo 'Timber plugin is required for this theme';
    return;
}

$context = Timber::get_context();
$context['post'] = new TimberPost();

if (have_posts()) {
    $context['breadcrumbs'] = array(
        array(
            'title' => 'Home',
            'url' => home_url()
        ),
        array(
            'title' => 'Blog',
            'url' => get_permalink(get_option('page_for_posts'))
        ),
        array(
            'title' => get_the_title(),
            'url' => ''
        )
    );
    
    $post_tags = get_the_tags();
    if ($post_tags) {
        $context['post_tags'] = array();
        foreach ($post_tags as $tag) {
            $context['post_tags'][] = $tag->name;
        }
    }
    
    $context['share_url'] = get_permalink();
    $context['share_title'] = get_the_title();
}

Timber::render('single.twig', $context);
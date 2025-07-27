<?php

if (!class_exists('Timber')) {
    echo '<h1>Timber Plugin Required</h1>';
    echo '<p>Please install and activate the Timber plugin from the WordPress admin.</p>';
    echo '<p><a href="' . admin_url('plugin-install.php?s=timber&tab=search&type=term') . '">Install Timber Plugin</a></p>';
    return;
}

$context = Timber::get_context();
$context['post'] = new TimberPost();
$context['breadcrumbs'] = mainstay_get_breadcrumbs();

Timber::render('page.twig', $context);
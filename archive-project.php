<?php

/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context                           = Timber::context();
$args = array(
    'post_type' => 'project',
    'posts_per_page' => -1,
    'orderby' => array(
        'date' => 'DESC'
    ));
$context['projects']               = Timber::get_posts( $args );

$templates                         = array('archive-project.twig');
Timber::render($templates, $context);

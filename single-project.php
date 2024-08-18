<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since     Timber 0.1
 */

$context         = Timber::context();
$timber_post     = Timber::get_post();

// Get the categories of the current post
$categories      = get_the_category($timber_post->ID);
$context['categories'] = $categories;

// Get all tags for the current post
$tags            = get_the_tags($timber_post->ID);
$context['tags']  = $tags;

$context['project'] = $timber_post;

Timber::render(array('single-project.twig'), $context);
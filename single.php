<?php

/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */


 $post = Timber::get_post();
 $context = Timber::context();
 $context['post'] = $post;
 Timber::render( 'single.twig', $context );
<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

$context['fields'] = get_fields();

$tag_title = single_tag_title('', false);
$context['tag_title'] = $tag_title;

// Query to get the post type based on the tag title
$args = array(
    'post_type' => 'any', // Set this to the post type you want to search within
    'tag' => $tag_title,
    'posts_per_page' => '-1', // You may adjust this based on your needs
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $post_type = get_post_type();
    }
    wp_reset_postdata();
} else {
    // No posts found for the given tag
    $post_type = 'default'; // You can set a default post type here
}

$context['post_type'] = $post_type;

global $paged;
if (!isset($paged) || !$paged){
    $paged = 1;
}
$args = array(
    // Get post type project
    'post_type'        => $post_type,
    'tag'              => $tag_title,
    'posts_per_page'   => -1,
    // 'paged'            => $paged,
    'orderby'         => array(
        'date' => 'DESC'
    ));
$context['projects'] = new Timber\PostQuery($args);

$page = new Timber\Post();
Timber::render(array( 'tag-' . $page->post_type . '.twig', 'index.twig'), $context);

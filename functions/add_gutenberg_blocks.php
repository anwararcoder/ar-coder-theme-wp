<?php

/*********************************************
 *               ACF Theme Settings           *
 **********************************************/
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'     => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'        => false
    ));
    acf_add_options_sub_page(array(
        'page_title'     => 'Theme Header Settings',
        'menu_title'    => 'Header',
        'parent_slug'    => 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'     => 'Theme Footer Settings',
        'menu_title'    => 'Footer',
        'parent_slug'    => 'theme-general-settings',
    ));
}

/*********************************************
 *               Blocks Styling               *
 **********************************************/


/**
 * Custom block category
 */

function my_blocks_plugin_block_categories($categories)
{
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'custom_blocks',
                'title' => __('Custom Blocks', 'mydomain'),
                // 'icon'  => 'wordpress',
            ),
        )
    );
}
add_filter('block_categories', 'my_blocks_plugin_block_categories', 10, 2);

/*********************************************
 *               Adding Blocks                *
 **********************************************/
add_action('acf/init', 'my_acf_init');
function my_acf_init()
{
    // check function exists
    if (function_exists('acf_register_block')) {
        add_guttenberg_block('header');
        add_guttenberg_block('features');
        add_guttenberg_block('allprojects');
        add_guttenberg_block('contactus');
    }
}

function add_guttenberg_block($blockname)
{
    // register card block
    acf_register_block(array(
        'name'                => $blockname,
        'title'                => __($blockname),
        'description'        => __('A custom block.'),
        'render_callback'    => 'my_acf_block_render_callback',
        'category'            => 'custom_blocks',
        'icon'                => 'admin-comments',
        // 'keywords'            => array($block_name),
    ));
}

/*********************************************
 *               Blocks Callback              *
 **********************************************/
function section_block_callback($block)
{
    // convert name ("acf/testimonial") into path friendly slug ("testimonial")
    $slug = str_replace('acf/', '', $block['name']);
    // include a template part from within the "template-parts/block" folder
    if (file_exists(get_theme_file_path("block/{$slug}.php"))) {
        include(get_theme_file_path("block/{$slug}.php"));
    }
}

/**
 *  This is the callback that displays the block.
 *
 * @param   array  $block      The block settings and attributes.
 * @param   string $content    The block content (emtpy string).
 * @param   bool   $is_preview True during AJAX preview.
 */
function my_acf_block_render_callback($block, $content = '', $is_preview = false)
{
    $context = Timber::context();
    $slug = str_replace('acf/', '', $block['name']);

    // Store block values.
    $context['block'] = $block;

    // Store field values.
    $fields = get_fields();

    $isProject = isset($fields['categories']);
    if ($isProject) {
        $taxonomy_field_value = $fields['categories'];
        $args = array(
            'post_type' => 'project',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => $taxonomy_field_value->slug,
                ),
            ),
        );
        $projectsLoop = Timber::get_posts($args);
        foreach ($projectsLoop as $item) {
            $item_fields = get_fields($item->ID);
            $item->fields = $item_fields;
        }
        $context['projectsLoop'] = $projectsLoop;
    }

    // Store field values.
    $context['fields'] = $fields;

    // Store $is_preview value.
    $context['is_preview'] = $is_preview;

    // Render the block.
    Timber::render('block/' . $slug . '.twig', $context);
}

function add_guttenberg_block_customsearch($blockname, $callback)
{
    // register card block
    acf_register_block(array(
        'name'                => $blockname,
        'title'                => __($blockname),
        'description'        => __('A custom block.'),
        'render_callback'    => __($callback),
        'category'            => 'custom_blocks',
        'icon'                => 'admin-comments',
        // 'keywords'            => array($block_name),
    ));
}


// For Timber
add_filter('timber_context', 'mytheme_timber_context');
function mytheme_timber_context($context)
{
    $context['options'] = get_fields('options');
    return $context;
}
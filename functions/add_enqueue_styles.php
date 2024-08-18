<?php
function add_enqueue_styles()
{
    // :: Add Style Files
    wp_enqueue_style('theme_style',  get_template_directory_uri() . '/style.css', 1);
    // wp_enqueue_style('theme_style',  get_template_directory_uri() . '/style.css', 1);
    
    // :: Add Script Files
    wp_enqueue_script('main_js',  get_template_directory_uri() . '/assets/js/main.js', 1);
    // wp_enqueue_script('main_js',  get_template_directory_uri() . '/assets/js/main.js', 1);
}

add_action('wp_enqueue_scripts', 'add_enqueue_styles', 1);
add_action('admin_enqueue_scripts', 'add_enqueue_styles', 1);


// function xx() {
//     // If User Is LogOut Delete This
//     if( !is_user_logged_in() ){
//         wp_dequeue_style('wp-block-library');
//     }
//     if ( is_front_page() ) {    
//         wp_dequeue_style('contact-form-7');
//         wp_dequeue_style('classic-theme-styles');
//     }
// }
// add_action( 'wp_enqueue_scripts', 'xx', 100 );

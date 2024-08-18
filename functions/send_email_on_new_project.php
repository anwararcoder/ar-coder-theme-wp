<?php 

// =======================================> this code without Timber And Twig <=======================================

// function send_custom_project_publication_notification($new_status, $old_status, $post) {
//     // Check if the post type is 'project' and it is being published
//     if ($post->post_type == 'project' && $new_status == 'publish' && $old_status != 'publish') {
//         // Get the post details
//         $post_title = $post->post_title;
//         $post_url = get_permalink($post->ID);
//         $post_content = apply_filters('the_content', $post->post_content); // Get formatted post content
//         $post_date = get_the_date('', $post->ID); // Get post date

//         // Build the email subject
//         $subject = 'New Project Added: ' . $post_title;

//         // Build the custom email message (HTML)
//         $message = '<html><body>';
//         $message .= '<h2 style="color: #333;">A new project has been added to your site</h2>';
//         $message .= '<p><strong>Title:</strong> ' . $post_title . '</p>';
//         $message .= '<p><strong>Date Published:</strong> ' . $post_date . '</p>';
//         $message .= '<p><strong>Details:</strong><br/>' . $post_content . '</p>';
//         $message .= '<p><strong>View the project:</strong> <a href="' . $post_url . '">' . $post_url . '</a></p>';
//         $message .= '</body></html>';

//         // Set content type to HTML for the email
//         add_filter('wp_mail_content_type', function() {
//             return 'text/html';
//         });

//         // Get the users from the ACF field (adjust the field key to match your ACF field)
//         $field_key = 'field_66bd48f689afc'; // Adjust this to your actual field key
//         $users = get_field($field_key, 'option');

//         if (!$users || empty($users)) {
//             return; // Exit if there are no users
//         }

//         // Send the email to each user
//         foreach ($users as $user) {
//             if (!empty($user['email'])) {
//                 wp_mail($user['email'], $subject, $message);
//             }
//         }

//         // Remove the content type filter after email is sent
//         remove_filter('wp_mail_content_type', 'set_html_content_type');
//     }
// }

// // Hook the function to the 'transition_post_status' action
// add_action('transition_post_status', 'send_custom_project_publication_notification', 10, 3);


















// =======================================> this code with Timber And Twig <=======================================

function send_custom_project_publication_notification($new_status, $old_status, $post) {
    // Check if the post type is 'project' and it is being published
    if ($post->post_type == 'project' && $new_status == 'publish' && $old_status != 'publish') {
        // Get the post details
        $context = Timber::context();
        $context['post_title'] = $post->post_title;
        $context['post_url'] = get_permalink($post->ID);
        $context['post_content'] = apply_filters('the_content', $post->post_content);
        $context['post_date'] = get_the_date('', $post->ID);

        // Render the email message with Timber and Twig
        $message = Timber::compile('project-email.twig', $context);

        // Build the email subject
        $subject = 'New Project Added: ' . $post->post_title;

        // Set content type to HTML for the email
        add_filter('wp_mail_content_type', function() {
            return 'text/html';
        });

        // Get the users from the ACF field (adjust the field key to match your ACF field)
        $field_key = 'field_66bd48f689afc'; // Adjust this to your actual field key
        $users = get_field($field_key, 'option');

        if (!$users || empty($users)) {
            return; // Exit if there are no users
        }

        // Send the email to each user
        foreach ($users as $user) {
            if (!empty($user['email'])) {
                wp_mail($user['email'], $subject, $message);
            }
        }

        // Remove the content type filter after email is sent
        remove_filter('wp_mail_content_type', 'set_html_content_type');
    }
}

// Hook the function to the 'transition_post_status' action
add_action('transition_post_status', 'send_custom_project_publication_notification', 10, 3);

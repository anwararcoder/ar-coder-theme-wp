<?php

add_action('wp_ajax_newsletter_form', 'newsletter_form');
add_action('wp_ajax_nopriv_newsletter_form', 'newsletter_form');

function newsletter_form() {
    $email = sanitize_text_field( $_POST['email'] );
    $field_key = 'field_66bd48f689afc';
    $existing_value = get_field( $field_key, 'option' ); // Assuming this field is stored in options

    // Ensure existing value is an array
    if (!is_array($existing_value)) {
        $existing_value = array();
    }

    // Check if user is already subscribed
    $user_already_here = false;
    foreach ($existing_value as $item) {
        if ($item['email'] == $email) {
            $user_already_here = true;
            break;
        }
    }

    // If user is not already subscribed, add a new entry
    if (!$user_already_here) {
        $existing_value[] = array('email' => $email);
        $updateField = update_field($field_key, $existing_value, 'option');
        
        if ($updateField) {
            echo json_encode(array('success' => true, 'message' => 'Subscription successful.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update subscription.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'You are already subscribed.'));
    }
    
    wp_die();
}

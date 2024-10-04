<?php
function display_event_by_id_shortcode($atts)
{
    // Extract shortcode attributes, default ID to 0
    $atts = shortcode_atts(array(
        'id' => 0,
    ), $atts);

    $event_id = intval($atts['id']);

    // Check if the ID is valid
    if ($event_id <= 0) {
        return 'Invalid event ID.';
    }

    // Fetch the event post
    $event = get_post($event_id);

    // Check if the post exists and is of the correct type
    if (! $event || $event->post_type !== 'evcatalog_event') {
        return 'Event not found.';
    }

    // Fetch meta fields
    $event_date = get_post_meta($event_id, '_evcatalog_meta_start_datetime', true);
    $event_location = get_post_meta($event_id, '_evcatalog_meta_place', true);
    $event_link = get_post_meta($event_id, '_evcatalog_meta_link', true);

    // Prepare variables
    $event_title = $event->post_title;
    $event_permalink = get_permalink($event_id);
    $event_thumbnail = get_the_post_thumbnail_url($event_id, 'large');

    // Fallback for missing thumbnail
    if (! $event_thumbnail) {
        $event_thumbnail = 'https://via.placeholder.com/300x168'; // Default placeholder image if none available
    }

    // Start output buffering to capture the template output
    ob_start();

    // Устанавливаем данные, чтобы их можно было использовать в шаблоне
    set_query_var('event_title', $event_title);
    set_query_var('event_date', $event_date);
    set_query_var('event_location', $event_location);
    set_query_var('event_link', $event_link);
    set_query_var('event_thumbnail', $event_thumbnail);
    set_query_var('event_permalink', $event_permalink);

    // Path to the template file in the plugin folder
    $template_path = plugin_dir_path(__FILE__) . 'the-events-catalog-random-event.php';

    // Check if the template file exists and include it
    if (file_exists($template_path)) {
        include $template_path;
    } else {
        echo 'Template not found.';
    }

    // Capture the output and return it
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('the-event', 'display_event_by_id_shortcode');

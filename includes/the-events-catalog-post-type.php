<?php
/* register the new post type: event */
function evcatalog_register_post_type()
{
    add_theme_support('post-thumbnails');

    $labels = array(
        'name' => 'Events',
        'singular_name' => 'Event',
        'add_new' => 'New event',
        'add_new_item' => 'Add new item',
        'edit_item' => 'Edit item',
        'new_item' => 'New item',
        'view_item' => 'Browse item',
        'search_items' => 'Search for events',
        'not_found' => 'No events found',
        'not_found_in_trash' => 'Events were not found in the trash'
    );


    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'hierachical' => false,
        'supports' => array('title', 'editor',  'thumbnail'),
        'taxonomies' => array('post_tag', 'category'),
        'rewrite' => array('slug' => 'event'),
        'publicly_queryable' => true,
        'hierarchical' => true,
        // The show_in_rest property in WordPress determines whether a custom post type (or a custom field) is accessible via the WordPress REST API. When set to true, it allows you to interact with the post type through the REST API, which is essential for building custom Gutenberg blocks or using WordPress as a headless CMS.
        // 'show_in_rest' => true,
    );

    register_post_type('evcatalog_event', $args);
}

add_action('init', 'evcatalog_register_post_type');

/* Add support for different fields aka "custom boxes" */
function evcatalog_add_custom_box()
{
    add_meta_box(
        'evcatalog_price',
        'Price',
        'evcatalog_price_box_html',
        'evcatalog_event',
        'side',
        'high'
    );

    add_meta_box(
        'evcatalog_place',
        'Place',
        'evcatalog_place_box_html',
        'evcatalog_event',
        'side',
        'high'
    );

    add_meta_box(
        'evcatalog_start_datetime',
        'Start',
        'evcatalog_start_datetime_box_html',
        'evcatalog_event',
        'side',
        'high'
    );

    add_meta_box(
        'evcatalog_end_datetime',
        'End',
        'evcatalog_end_datetime_box_html',
        'evcatalog_event',
        'side',
        'high'
    );
    add_meta_box(
        'evcatalog_link',
        'Link',
        'evcatalog_link_html',
        'evcatalog_event',
        'side',
        'high'
    );
}

add_action('add_meta_boxes', 'evcatalog_add_custom_box');

function evcatalog_price_box_html($post)
{
    $value = get_post_meta($post->ID, '_evcatalog_meta_price', true);
?>
    <label for="evcatalog_price">Price</label>
    <input type="text" id="evcatalog_price" name="evcatalog_price" value="<?php echo $value; ?>">
<?php
}

function evcatalog_place_box_html($post)
{
    $value = get_post_meta($post->ID, '_evcatalog_meta_place', true);
?>
    <label for="evcatalog_place">Place</label>
    <input type="text" id="evcatalog_place" name="evcatalog_place" value="<?php echo $value; ?>">
<?php
}

function evcatalog_start_datetime_box_html($post)
{
    $value = get_post_meta($post->ID, '_evcatalog_meta_start_datetime', true);
?>
    <label for="evcatalog_start">Start date and time</label>
    <input type="text" id="evcatalog_start" name="evcatalog_start_datetime" value="<?php echo $value; ?>">
    <script>
        let dpStart, dpEnd;
        dpStart = new AirDatepicker('#evcatalog_start', {
            locale: airDatepickerEnLocale,
            timepicker: true,
            timeFormat: 'HH:mm',
            minutesStep: 15,
            buttons: ['today', 'clear'],
            dateFormat: 'yyyy-MM-dd',
            autoClose: true,
            onSelect({
                date
            }) {
                dpEnd.update({
                    minDate: date
                })
            }
        });
    </script>
<?php
}

function evcatalog_link_html($post)
{
    $value = get_post_meta($post->ID, '_evcatalog_meta_link', true);
?>
    <label for="evcatalog_price">URL</label>
    <input type="text" id="evcatalog_link" name="evcatalog_link" size="80" value="<?php echo $value; ?>">
<?php
}

// Air Datepicker https://github.com/t1m0n/air-datepicker

function evcatalog_end_datetime_box_html($post)
{
    $value = get_post_meta($post->ID, '_evcatalog_meta_end_datetime', true);
?>
    <label for="evcatalog_end">End date and time</label>
    <input type="text" id="evcatalog_end" name="evcatalog_end_datetime" value="<?php echo $value; ?>">
    <script>
        dpEnd = new AirDatepicker('#evcatalog_end', {
            locale: airDatepickerEnLocale,
            timepicker: true,
            timeFormat: 'HH:mm',
            minutesStep: 15,
            buttons: ['today', 'clear'],
            dateFormat: 'yyyy-MM-dd',
            autoClose: true,
            onSelect({
                date
            }) {
                dpStart.update({
                    maxDate: date
                })
            }
        });
    </script>
<?php
}

/* save post meta */
function evcatalog_save_postdata($post_id)
{
    if (array_key_exists('evcatalog_price', $_POST)) {
        update_post_meta(
            $post_id,
            '_evcatalog_meta_price',
            sanitize_text_field($_POST['evcatalog_price'])
        );
    }

    if (array_key_exists('evcatalog_place', $_POST)) {
        update_post_meta(
            $post_id,
            '_evcatalog_meta_place',
            sanitize_text_field($_POST['evcatalog_place'])
        );
    }

    if (array_key_exists('evcatalog_start_datetime', $_POST)) {
        update_post_meta(
            $post_id,
            '_evcatalog_meta_start_datetime',
            sanitize_text_field($_POST['evcatalog_start_datetime'])
        );
    }

    if (array_key_exists('evcatalog_end_datetime', $_POST)) {
        update_post_meta(
            $post_id,
            '_evcatalog_meta_end_datetime',
            sanitize_text_field($_POST['evcatalog_end_datetime'])
        );
    }
}

add_action('save_post', 'evcatalog_save_postdata');

// Wordpress disable custom post types on categories by default,
// here is the function hook to include them back
// https://wordpress.stackexchange.com/questions/163901/custom-post-type-not-visible-on-category-page
function evcatalog_cat_filter($query)
{
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_category()) {
            $query->set('post_type', array('post', 'evcatalog_event'));
        }
    }
}

add_action('pre_get_posts', 'evcatalog_cat_filter');

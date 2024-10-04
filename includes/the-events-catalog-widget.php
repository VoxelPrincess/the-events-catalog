<?php

class RandomEventWidget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'random_event_widget',
            __('Random Event Widget', 'text_domain'),
            array('description' => __('Displays a random event that hasn’t started yet.', 'text_domain'))
        );
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        $this->display_random_event();
        echo $args['after_widget'];
    }

    private function display_random_event()
    {
        // Get the current time
        $current_date = current_time('Y-m-d H:i');
        // echo $current_date;
        // Request to get a random event that has not started yet
        $query_args = array(
            'post_type' => 'evcatalog_event',
            'meta_query' => array(
                array(
                    'key' => '_evcatalog_meta_start_datetime',
                    'value' => $current_date,
                    'compare' => '>',
                    'type' => 'DATETIME'
                ),
            ),
            'orderby' => 'rand',
            'posts_per_page' => 1,
        );

        $random_event_query = new WP_Query($query_args);

        // Display the event if it is found
        if ($random_event_query->have_posts()) {
            while ($random_event_query->have_posts()) {
                $random_event_query->the_post();

                // Получаем нужные данные
                $event_title = get_the_title();
                $event_date = get_post_meta(get_the_ID(), '_evcatalog_meta_start_datetime', true);
                $event_location = get_post_meta(get_the_ID(), '_evcatalog_meta_place', true);
                $event_link = get_post_meta(get_the_ID(), '_evcatalog_meta_link', true);
                $event_thumbnail = get_the_post_thumbnail_url(get_the_ID(), 'large');
                $event_permalink = get_permalink();

                // Fallback for missing thumbnail
                if (! $event_thumbnail) {
                    $event_thumbnail = 'https://via.placeholder.com/300x168'; // Default placeholder image if none available
                }

                // Устанавливаем данные, чтобы их можно было использовать в шаблоне
                set_query_var('event_title', $event_title);
                set_query_var('event_date', $event_date);
                set_query_var('event_location', $event_location);
                set_query_var('event_link', $event_link);
                set_query_var('event_thumbnail', $event_thumbnail);
                set_query_var('event_permalink', $event_permalink);

                $template_path = plugin_dir_path(__FILE__) . 'the-events-catalog-random-event.php';

                if (file_exists($template_path)) {
                    include($template_path); // Включаем шаблон
                } else {
                    echo 'No template found';
                }
            }
        } else {
            echo '<p class="evcatalog-no-events">' . __('No upcoming events found.', 'text_domain') . '</p>';
        }

        wp_reset_postdata();
    }
}

// Registering a widget
function register_random_event_widget()
{
    register_widget('RandomEventWidget');
}

add_action('widgets_init', 'register_random_event_widget');

<?php
// Подключаем стили для виджета
function enqueue_event_catalog_widget_styles()
{
    // Получаем URL к файлу стилей
    wp_enqueue_style(
        'event-catalog-widget-styles', // Уникальное имя стилей
        plugin_dir_url(__FILE__) . 'assets/css/the-event-catalog-widget.css' // Путь к файлу стилей
    );
}
add_action('wp_enqueue_scripts', 'enqueue_event_catalog_widget_styles');


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

                echo '<article class="evcatalog-random">'; // Class for the article

                echo '<div class="evcatalog-random__thumbnail">' . the_post_thumbnail('medium') . '</div>';
                echo '<header class="evcatalog-random__header">' . get_the_title() . '</header>';

                echo '<p class="evcatalog-random__date">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><title>calendar</title><path d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z" /></svg>';
                echo __('Start Date:', 'text_domain') . ' ' . get_post_meta(get_the_ID(), '_evcatalog_meta_start_datetime', true);
                echo '</p>';

                echo '<p class="evcatalog-random__place">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><title>map-marker</title><path d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" /></svg>';
                echo __('Place:', 'text_domain') . ' ' . get_post_meta(get_the_ID(), '_evcatalog_meta_place', true);
                echo '</p>';

                // We get and display the meeting URL and open the link in a new window
                $event_link = get_post_meta(get_the_ID(), '_evcatalog_meta_link', true);

                if (!empty($event_link)) {
                    echo '<p><a href="' . esc_url($event_link) . '" class="evcatalog-random__link" target="_blanc">' . __('Event Link', 'text_domain') . '</a></p>';
                }

                echo '</article>';
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

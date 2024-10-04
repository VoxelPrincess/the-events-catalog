<?php
/*
Plugin Name: The events catalog
Decription: Plugin for displaying events.
Author: Anna Bekharskaia
*/

require_once('includes/the-events-catalog-post-type.php');
require_once('includes/the-events-catalog-shortcodes.php');
require_once('includes/the-events-catalog-widget.php');


function evcatalog_setup_menu()
{
    add_menu_page('Pieni tuotekatalogi', 'Tuotekatalogi', 'manage_options', 'the-events-catalog', 'evcatalog_display_admin_page');
}

function evcatalog_display_admin_page()
{
    echo '<h1>Pieni tuotekatalogi</h1>';
    echo '<p>Lisää artikkeliin tai sivulle lyhytkoodi [events-catalog] näyttääksesi kaikki tuotteet tai [events-catalog category="sinun kategoriasi"] näyttää
    tietyn tuotekategorian tuotteet. </p>';
    echo '<p>Meillä on vimpain!</p>';
}
add_action('admin_menu', 'evcatalog_setup_menu');

function evcatalog_assets()
{
    wp_enqueue_style('evcatalog-css', plugin_dir_url(__FILE__) . 'css/the-events-catalog.css');
}

add_action('wp_enqueue_scripts', 'evcatalog_assets');


function evcatalog_datepicker_assets()
{
    wp_enqueue_style('evcatalog-datepicker-css', plugin_dir_url(__FILE__) . 'vendor/air-datepicker.min.css');
    wp_enqueue_script('evcatalog-datepicker-en-js', plugin_dir_url(__FILE__) . 'vendor/air-datepicker.en.js');
    wp_enqueue_script('evcatalog-datepicker-js', plugin_dir_url(__FILE__) . 'vendor/air-datepicker.min.js');
}
add_action('admin_enqueue_scripts', 'evcatalog_datepicker_assets');

// Connecting styles for the widget
function enqueue_event_catalog_widget_styles()
{
    $css_path = plugin_dir_url(__FILE__) . 'css/the-events-catalog-widget.css';
    // Get URL to style file
    wp_enqueue_style(
        'event-catalog-widget-styles', // Unique style name
        $css_path // Path to style file
    );
}
add_action('wp_enqueue_scripts', 'enqueue_event_catalog_widget_styles');

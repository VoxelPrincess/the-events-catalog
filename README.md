# The Events Catalog - WordPress Plugin and Widget

### Description

The Events Catalog plugin adds a custom post type called "Event" with custom meta-fields for better event management. You can display events in posts or pages using a shortcode or in a widget.

This plugin includes:

- Custom Post Type: "Event"
- Custom Meta Fields:
  - Event start date (with Datepicker)
  - Event end date (with Datepicker)
  - Event location
  - Event link (URL)
  - Event price
- Widget for displaying random upcoming events
- Shortcode for displaying events on a page or post

### Installation

1. Upload the `the-events-catalog` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Add new events via the "Events" menu in the WordPress admin panel.
4. Use the `[event_catalog]` shortcode to display events in your posts or pages.
5. Add the "Random Event" widget to any widgetized area (sidebar, footer) via the "Widgets" menu in WordPress.

### Theme Update Required

For the correct display of the plugin, the theme file `ymparisto_ja_saa` has been updated with the template file `single-evcatalog_event.php`. Make sure this file exists in your theme directory for proper rendering of single event posts.

### Usage

- **Custom Post Type**: Go to the "Events" menu in the WordPress admin dashboard to create new events. You can specify the event date, location, link, and price.
- **Widget**: Add the "Random Event" widget to your sidebar or footer via the "Widgets" menu. The widget displays a random upcoming event based on the event start date.
- **Shortcode**: Use `[event_catalog]` in any post or page to display a list of upcoming events.

### Screenshots

Screenshots are located in the `screenshots` directory.

1. `admin-edit-event.png` - Admin panel for adding/editing events
1. `widget-admin.png` - Widget settings in the admin panel
1. `widget-frontend.png` - Widget displayed on the frontend
1. `shortcode-frontend.png` - Events displayed using the shortcode
1. `admin-shortcode.png` - Shortcode example in the admin panel
1. `single-event.png` - Single event page
1. `admin-datepicker.png` - Datepicker functionality for selecting event start and end dates

### Custom Meta Fields

The following meta fields are available for each event:

- Event start date (with Datepicker)
- Event end date (with Datepicker)
- Event location
- Event link (URL)
- Event price

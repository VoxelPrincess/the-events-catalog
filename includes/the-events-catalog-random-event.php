<article class="evcatalog-random">
  <div class="evcatalog-random__container circle-cut">
    <div class="evcatalog-random__thumbnail">
      <a href="<?php echo esc_url($event_permalink); ?>">
        <img width="300" height="168" src="<?php echo esc_url($event_thumbnail); ?>" class="attachment-medium size-medium wp-post-image" alt="<?php echo esc_attr($event_title); ?>" decoding="async" loading="lazy">
      </a>
    </div>
    <div class="evcatalog-random__content">
      <header class="evcatalog-random__header">
        <a href="<?php echo esc_url($event_permalink); ?>">
          <?php echo esc_html($event_title); ?>
        </a>
      </header>
      <p class="evcatalog-random__date">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
          <title>calendar</title>
          <path d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z"></path>
        </svg>
        <span><?php echo esc_html($event_date); ?></span>
      </p>
      <p class="evcatalog-random__place">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16">
          <title>map-marker</title>
          <path d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z"></path>
        </svg>
        <span><?php echo esc_html($event_location); ?></span>
      </p>
      <a href="<?php echo esc_url($event_link); ?>" class="evcatalog-random__link" target="_blank"><?php _e('Buy ticket', 'text_domain'); ?></a>
    </div>
  </div>
</article>
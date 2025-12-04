<section class="discover-mobile" data-mobile-slider>
  <div class="discover-track">
    <?php
    // Get current language for Polylang support
    $current_lang = 'en';
    if (function_exists('pll_current_language')) {
        $current_lang = pll_current_language() ?: 'en';
    }
    $option_key = 'discover_settings_' . $current_lang;
    
    // Loop through 4 discover items from options (same as section)
    for ($i = 1; $i <= 4; $i++) {
        $title = get_option($option_key . '_discover_item_' . $i . '_title', '');
        $description = get_option($option_key . '_discover_item_' . $i . '_description', '');
        $image_url = get_option($option_key . '_discover_item_' . $i . '_image', '');
        $link_url = get_option($option_key . '_discover_item_' . $i . '_url', '');
        
        // Skip if no image URL (title is optional for now)
        if (!$image_url) continue;
        
        $title = esc_html($title);
        $description = esc_html($description) ?: 'Explore activity';
        $image_url = esc_url($image_url);
        $link_url = esc_url($link_url) ?: '#';
    ?>
    <div class="discover-container-mobile">
      <img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>">
      <a href="<?php echo $link_url; ?>" class="discover-absolute-mobile">
        <h3><?php echo $title; ?></h3>
        <p><?php echo $description; ?></p>
      </a>
    </div>
    <?php
    }
    ?>
  </div>

  <button class="discover-arrow prev" type="button" aria-label="Previous slide">‹</button>
  <button class="discover-arrow next" type="button" aria-label="Next slide">›</button>
</section>


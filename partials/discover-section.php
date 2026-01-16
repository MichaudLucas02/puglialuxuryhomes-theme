<?php
// Get background color from args, default to transparent
$bg_color = $args['bg_color'] ?? 'transparent';

// Get current language for Polylang support
$current_lang = 'en';
if (function_exists('pll_current_language')) {
    $current_lang = pll_current_language() ?: 'en';
}
$option_key = 'discover_settings_' . $current_lang;

// Debug: Check if Italian data exists
echo '<!-- DEBUG: Current lang=' . $current_lang . ', option_key=' . $option_key . ' -->';
global $wpdb;
$all_discover = $wpdb->get_results($wpdb->prepare("SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s", 'discover_settings_%'));
echo '<!-- DEBUG: All discover options: ';
foreach ($all_discover as $opt) {
    echo $opt->option_name . ' | ';
}
echo ' -->';
?>
<section class="discover-section" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="discover">
        <?php
        // Loop through 4 discover items from options
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
            $position_class = ($i % 2 === 0) ? 'down' : 'up';
        ?>
        <div class="discover-container <?php echo esc_attr($position_class); ?>">
            <img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>">
            <a href="<?php echo $link_url; ?>" class='discover-absolute'>
                <h3><?php echo $title; ?></h3>
                <p><?php echo $description; ?></p>
            </a>
        </div>
        <?php
        }
        ?>
    </div>

</section>
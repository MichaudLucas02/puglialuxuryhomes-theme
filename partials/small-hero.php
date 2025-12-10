<?php
// Small Hero Section using ACF fields
if (function_exists('get_field') && !is_admin()) {
    $enable = get_field('small_hero_enable');
    
    // Skip if disabled
    if ($enable === false || $enable === 0) {
        return;
    }
    
    $video = get_field('small_hero_video');
    $poster = get_field('small_hero_poster');
    $title = get_field('small_hero_title');
    
    // Set defaults if ACF not available or fields empty
    if (!$poster) {
        $poster = 'https://www.puglialuxuryhomes.com/wp-content/uploads/2025/02/Jardin-3-scaled.webp';
    }
    if (!$title) {
        $title = get_the_title();
    }
?>
<section class="small-hero">
    <?php if (!empty($video)) : ?>
        <video autoplay loop muted playsinline poster="<?php echo esc_attr($poster); ?>">
            <source src="<?php echo esc_attr($video); ?>" type="video/mp4">
        </video>
    <?php else : ?>
        <img src="<?php echo esc_attr($poster); ?>" alt="<?php echo esc_attr($title); ?>">
    <?php endif; ?>
    <div class="small-hero-title">
        <h2><?php echo esc_html($title); ?></h2>
    </div>
</section>
<?php
} else {
    // Fallback if ACF not available
?>
<section class="small-hero">
    <video autoplay loop muted playsinline poster="https://www.puglialuxuryhomes.com/wp-content/uploads/2025/02/Jardin-3-scaled.webp">
        <source src="https://www.puglialuxuryhomes.com/wp-content/uploads/2025/05/PLH.mp4" type="video/mp4">
    </video>
    <div class="small-hero-title">
        <h2><?php the_title(); ?></h2>
    </div>
</section>
<?php
}
?>

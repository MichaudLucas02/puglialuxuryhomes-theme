<?php
$large_hero_title =  get_field('large_hero_title');
$large_hero_button = get_field('large_hero_button');
$large_hero_button2 = get_field('large_hero_button2');
$large_hero_image = get_field('large_hero_image');

// Use ACF image if set, otherwise fall back to featured image
if (empty($large_hero_image)) {
    $large_hero_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
}
?>

<section class="large-hero">
    <img src="<?php echo esc_url($large_hero_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
    <div class="large-hero-content">
        <h2><?php the_title(); ?></h2>
        <div class="large-hero-buttons">
            <?php if ( !empty($large_hero_button) && is_array($large_hero_button) && !empty($large_hero_button['url']) && !empty($large_hero_button['title']) ): ?>
            <a href="<?php echo esc_url($large_hero_button['url']); ?>"><?php echo esc_html($large_hero_button['title']); ?></a>
            <?php endif; ?>
            <?php if ( !empty($large_hero_button2) && is_array($large_hero_button2) && !empty($large_hero_button2['url']) && !empty($large_hero_button2['title']) ): ?>
            <a href="<?php echo esc_url($large_hero_button2['url']); ?>"><?php echo esc_html($large_hero_button2['title']); ?></a>
            <?php endif; ?>
        </div>
    </div>
</section>
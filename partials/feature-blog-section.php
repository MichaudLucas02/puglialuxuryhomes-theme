<?php
$featured = isset($args['featured_post']) ? $args['featured_post'] : get_query_var('featured_post');

if (!$featured) {
    return;
}
?>
<div class="feature-blog-wrapper">
    <div class="feature-blog-image">
        <?php if ($featured['image']) : ?>
            <a href="<?php echo esc_url($featured['permalink']); ?>">
                <img src="<?php echo esc_url($featured['image']); ?>" alt="<?php echo esc_attr($featured['title']); ?>">
            </a>
        <?php endif; ?>
    </div>
    <div class="feature-blog-content">
        <p><?php echo esc_html($featured['category']); ?></p>
        <h4><a href="<?php echo esc_url($featured['permalink']); ?>"><?php echo esc_html($featured['title']); ?></a></h4>
        <p><?php echo esc_html($featured['excerpt']); ?></p>
        <a href="<?php echo esc_url($featured['permalink']); ?>" class="read-more-button">Read More</a>
    </div>
</div>
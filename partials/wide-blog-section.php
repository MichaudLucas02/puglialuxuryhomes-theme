<div class="wide-blog-section" onclick="window.location='<?php echo esc_url($args['link']); ?>';" style="cursor: pointer;">
    <img src="<?php echo esc_url($args['image_url']); ?>" alt="<?php echo esc_attr($args['image_alt']); ?>">
    <div class="wide-blog-content">
        <p><?php echo esc_html($args['category']); ?></p>
        <h4 class="wide-blog-title"><?php echo esc_html($args['title']); ?></h4>
        <p class="wide-blog-excerpt"><?php echo esc_html($args['excerpt']); ?></p>
        <a href="<?php echo esc_url($args['link']); ?>" class="wide-blog-read-more"><?php echo esc_html($args['read_more_text']); ?></a>
    </div>
</div>
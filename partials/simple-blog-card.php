<div class="simple-blog-card">
    <div class="simple-blog-card__thumb">
        <img src="<?php echo esc_url( $args['image_url'] ); ?>" alt="<?php echo esc_attr( $args['image_alt'] ); ?>">
    </div>
    <div class="simple-blog-card__content">
        <p><?php echo esc_html( $args['category'] ); ?></p>
        <h4 class="simple-blog-card__title"><?php echo esc_html( $args['title'] ); ?></h4>
        <p class="simple-blog-card__excerpt"><?php echo esc_html( $args['excerpt'] ); ?></p>
        <a href="<?php echo esc_url( $args['link'] ); ?>" class="simple-blog-card__read-more"><?php echo esc_html( $args['read_more_text'] ); ?></a>
    </div>
</div>
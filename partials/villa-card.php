<?php

$args = wp_parse_args( $args ?? [], [
  'title'       => function_exists('get_field') ? ( get_field('villa_title') ?: get_the_title() ) : get_the_title(),
  'collection'  => function_exists('get_field') ? get_field('villa_collection_1') : null,
  'location'    => function_exists('get_field') ? get_field('villa_location_1') : '',
  'price_range' => function_exists('get_field') ? get_field('price_range_1') : '',
  'beds'        => function_exists('get_field') ? get_field('beds_1') : '',
  'baths'       => function_exists('get_field') ? get_field('baths_1') : '',
  'guests'      => function_exists('get_field') ? get_field('guests_1') : '',
  'link'        => get_permalink(),
] );

// Collect card images from ACF fields (card_image_11 through card_image_55)
$card_images = [];
if ( function_exists('get_field') ) {
  foreach ( [ 'card_image_11', 'card_image_22', 'card_image_33', 'card_image_44', 'card_image_55' ] as $field ) {
    $img_id = get_field( $field );
    if ( $img_id ) {
      $card_images[] = $img_id;
    }
  }
}

// Fallback to featured image
if ( empty( $card_images ) ) {
  $thumb = get_post_thumbnail_id();
  if ( $thumb ) {
    $card_images[] = $thumb;
  }
}

$has_carousel = count( $card_images ) > 1;
?>

<a class="villa-card" href="<?php echo esc_url( $args['link'] ); ?>">
    <div class="villa-card__media">
        <?php if ( $has_carousel ) : ?>
            <div class="swiper villa-card-carousel">
                <div class="swiper-wrapper">
                    <?php foreach ( $card_images as $img_id ) : ?>
                        <div class="swiper-slide">
                            <?php echo wp_get_attachment_image( $img_id, 'villa_card', false, ['class' => 'villa-card__img'] ); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="villa-card-carousel__pagination"></div>
                <div class="swiper-button-prev villa-card-carousel__prev"></div>
                <div class="swiper-button-next villa-card-carousel__next"></div>
            </div>
        <?php elseif ( ! empty( $card_images ) ) : ?>
            <?php echo wp_get_attachment_image( $card_images[0], 'villa_card', false, ['class' => 'villa-card__img'] ); ?>
        <?php else : ?>
            <div class="villa-card__img villa-card__img--placeholder"></div>
        <?php endif; ?>
        <div class="villa-card__collection"><?php echo esc_html($args['collection']); ?></div>
    </div>
    <div class="villa-card__body">
    <h3 class="villa-card__title"><?php echo esc_html( $args['title'] ); ?></h3>

    <div class="villa-card__meta">
      <p class="villa-card__location"><?php echo esc_html( $args['location'] ); ?></p>
      <?php
        $bits = [];
        if ( $args['beds'] )   { $bits[] = esc_html( $args['beds'] ) . ' ' . esc_html( function_exists('pll__') ? pll__('bedrooms') : 'bedrooms' ); }
        if ( $args['baths'] )  { $bits[] = esc_html( $args['baths'] ) . ' ' . esc_html( function_exists('pll__') ? pll__('bathrooms') : 'bathrooms' ); }
        if ( $args['guests'] ) { $bits[] = esc_html( $args['guests'] ) . ' ' . esc_html( function_exists('pll__') ? pll__('guests') : 'guests' ); }
        if ( $bits ) { echo ' • ' . implode( ' • ', $bits ); }
      ?>
      <?php if ( $args['price_range'] ) : ?>
        <div class="villa-card__price">
          <?php echo esc_html( $args['price_range'] ); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</a>

<?php

$args = wp_parse_args( $args ?? [], [
  'title'      => function_exists('get_field') ? ( get_field('villa_title') ?: get_the_title() ) : get_the_title(),
  'collection' => function_exists('get_field') ? get_field('villa_collection_1') : null,
  'location'   => function_exists('get_field') ? get_field('villa_location_1') : '',
  'price_from' => function_exists('get_field') ? get_field('price_from_1') : '',
  'price_to'   => function_exists('get_field') ? get_field('price_to_1') : '',
  'beds'       => function_exists('get_field') ? get_field('beds_1') : '',
  'baths'      => function_exists('get_field') ? get_field('baths_1') : '',
  'guests'     => function_exists('get_field') ? get_field('guests_1') : '',
  'image_id'   => function_exists('get_field') ? ( get_field('card_image_1') ?: get_post_thumbnail_id() ) : get_post_thumbnail_id(),
  'link'       => get_permalink(),
] ); // <-- needed semicolon

$image_html = $args['image_id']
  ? wp_get_attachment_image( $args['image_id'], 'villa_card', false, ['class' => 'villa-card__img'] )
  : '<div class="villa-card__img villa-card__img--placeholder"></div>';
?>

<a class="villa-card" href="<?php echo esc_url( $args['link'] ); ?>">
    <div class="villa-card__media">
        <?php echo $image_html; ?>
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
      <?php if ( $args['price_from'] ) : ?>
        <div class="villa-card__price">
          <?php echo esc_html( function_exists('pll__') ? pll__('From') : 'From' ); ?> €<?php echo esc_html( number_format_i18n( (float) $args['price_from'] ) ); ?>
          <?php if ( $args['price_to'] ) : ?>
            <?php echo esc_html( function_exists('pll__') ? pll__('To') : 'To' ); ?> €<?php echo esc_html( number_format_i18n( (float) $args['price_to'] ) ); ?>
          <?php endif; ?>
          <?php echo esc_html( function_exists('pll__') ? pll__('per weeks') : 'per weeks' ); ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</a>


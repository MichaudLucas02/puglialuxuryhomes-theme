<?php
/**
 * Homepage "Where in Puglia" section.
 * Same layout as the real estate block: text on the left, interactive map on the right.
 * The map shows every published villa (current language) that has coordinates,
 * styled like the map on the villas listing page.
 */

// Villas north of this latitude are in the Itria Valley, south of it in Salento.
$plh_itria_min_lat = 40.55;

$villa_query = new WP_Query([
  'post_type'      => 'villa',
  'post_status'    => 'publish',
  'posts_per_page' => -1,
  'orderby'        => 'title',
  'order'          => 'ASC',
  'no_found_rows'  => true,
]);

// One entry per villa, same data as the map on the villas listing page.
$villas = [];
$beds_label   = mb_strtolower( plh_t('Bedrooms') );
$guests_label = plh_t('guests');

foreach ( $villa_query->posts as $villa ) {
  $lat = (float) trim( (string) get_field( 'villa_lat', $villa->ID ) );
  $lng = (float) trim( (string) get_field( 'villa_lng', $villa->ID ) );
  if ( ! $lat || ! $lng ) continue;

  $region = $lat >= $plh_itria_min_lat ? 'itria' : 'salento';

  $img_id = get_field( 'card_image_11', $villa->ID ) ?: get_post_thumbnail_id( $villa->ID );
  $beds   = (string) get_field( 'beds_1', $villa->ID );
  $guests = (string) get_field( 'guests_1', $villa->ID );

  $villas[] = [
    'lat'    => $lat,
    'lng'    => $lng,
    'region' => $region,
    'title'  => html_entity_decode( get_field( 'villa_title', $villa->ID ) ?: get_the_title( $villa ), ENT_QUOTES, 'UTF-8' ),
    'url'    => get_permalink( $villa ),
    'image'  => $img_id ? wp_get_attachment_image_url( $img_id, 'villa_card' ) : '',
    'meta'   => implode( ' · ', array_filter( [
      $beds   !== '' ? $beds . ' ' . $beds_label : '',
      $guests !== '' ? $guests . ' ' . $guests_label : '',
    ] ) ),
    'price'  => (string) get_field( 'price_range_1', $villa->ID ),
  ];
}
wp_reset_postdata();

$regions = [
  'salento' => [
    'title'  => plh_t('Salento'),
    'cities' => plh_t('Lecce · Gagliano del Capo · Santa Maria di Leuca'),
    'text'   => plh_t('The tip of the heel, where the Adriatic meets the Ionian. Cliffs and sea caves on one coast, white beaches on the other. Inland, the baroque towns of Lecce, Maglie and Specchia, dry-stone walls and pajare among the olive trees. This is where we live.'),
  ],
  'itria' => [
    'title'  => plh_t('Itria Valley (region title)'),
    'cities' => plh_t('Ostuni · Noci'),
    'text'   => plh_t('Trulli, whitewashed facades, centuries-old olive trees. Ostuni, Cisternino, Locorotondo, and masserias at the end of dirt tracks. The most photographed countryside in Puglia, an hour from Bari and Brindisi airports.'),
  ],
];

$map_data = [
  'villas' => $villas,
  'labels' => [ 'cta' => plh_t('Discover the villa') ],
];

// Same map library and tiles as the villas listing page (all-villas.php)
wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], null );
wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], null, true );
wp_enqueue_script(
  'where-map',
  get_stylesheet_directory_uri() . '/assets/js/where-map.js',
  ['leaflet'],
  '2.0',
  true
);
?>

<section class="re-homepage-section where-puglia">

  <div class="re-homepage-text">
    <p class="re-homepage-eyebrow"><?php echo esc_html( plh_t('Our locations') ); ?></p>
    <span class="re-homepage-rule"></span>
    <h2 class="re-homepage-title"><?php echo esc_html( plh_t('Our villas in Salento and the Itria Valley') ); ?></h2>
    <p class="re-homepage-desc"><?php echo esc_html( plh_t('Two territories, two ways of living Puglia. We don\'t cover the whole region, only the part we know by heart.') ); ?></p>

    <div class="where-regions">
      <?php foreach ( $regions as $key => $region ) : ?>
        <div class="where-region" data-region="<?php echo esc_attr( $key ); ?>">
          <h3><button type="button" class="where-region-btn" data-region="<?php echo esc_attr( $key ); ?>" aria-controls="where-map"><?php echo esc_html( $region['title'] ); ?></button></h3>
          <p class="where-region-cities"><?php echo esc_html( $region['cities'] ); ?></p>
          <p class="where-region-text"><?php echo esc_html( $region['text'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <a href="<?php echo esc_url( plh_page_url('the-villas') ); ?>" class="re-homepage-cta">
      <?php echo esc_html( plh_t('Browse Our Villas') ); ?>
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </a>
  </div>

  <div class="where-map-col">
    <div id="where-map" class="where-map" data-map="<?php echo esc_attr( wp_json_encode( $map_data ) ); ?>"></div>
  </div>

</section>

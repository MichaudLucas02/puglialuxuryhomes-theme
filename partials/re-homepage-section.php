<?php
$re_eyebrow  = get_field('home_re_eyebrow')     ?: plh_t('Real Estate · Puglia');
$re_title    = get_field('home_re_title')        ?: plh_t('Find your place in Puglia');
$re_desc     = get_field('home_re_description')  ?: plh_t('Whether you are looking to buy, sell or build, we know the territory and guide you every step of the way.');
$re_cta_text = get_field('home_re_cta_text')     ?: plh_t('Discover more');
$re_cta_url  = get_field('home_re_cta_url')      ?: '';
$re_image    = get_field('home_re_image')        ?: '';

if ( empty($re_cta_url) ) {
  $re_page = get_page_by_path('real-estate');
  $re_cta_url = $re_page ? get_permalink($re_page) : '#';
}
?>

<section class="re-homepage-section">

  <div class="re-homepage-text">
    <?php if ( $re_eyebrow ) : ?>
      <p class="re-homepage-eyebrow"><?php echo esc_html( $re_eyebrow ); ?></p>
      <span class="re-homepage-rule"></span>
    <?php endif; ?>
    <h2 class="re-homepage-title"><?php echo esc_html( $re_title ); ?></h2>
    <?php if ( $re_desc ) : ?>
      <p class="re-homepage-desc"><?php echo esc_html( $re_desc ); ?></p>
    <?php endif; ?>
    <a href="<?php echo esc_url( $re_cta_url ); ?>" class="re-homepage-cta">
      <?php echo esc_html( $re_cta_text ); ?>
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
        <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </a>
  </div>

  <?php if ( $re_image ) : ?>
  <div class="re-homepage-image">
    <img src="<?php echo esc_url( $re_image ); ?>" alt="<?php echo esc_attr( $re_title ); ?>">
  </div>
  <?php endif; ?>

</section>

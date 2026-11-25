<?php
/**
 * Template Name: Weddings
 *
 * Simple layout: title, a few paragraphs, a button, then a large photo gallery.
 * Texts and photos are set in inc/weddings.php and can be replaced per page
 * in the admin ("Weddings page" box: Texts and Gallery tabs).
 */
get_header();

$wed_photos = plh_wedding_gallery();
$wed_alt    = plh_wed( 'title' );
?>

<div class="wedding-page wed-simple">

  <section class="wed-simple__intro">
    <h1 class="wed-simple__title wed-reveal"><?php echo esc_html( plh_wed( 'title' ) ); ?></h1>
    <div class="wed-simple__text wed-reveal">
      <?php foreach ( [ 'text1', 'text2', 'text3' ] as $key ) :
        $text = trim( plh_wed( $key ) );
        if ( $text === '' ) continue; ?>
        <p class="wed-body"><?php echo nl2br( esc_html( $text ) ); ?></p>
      <?php endforeach; ?>
    </div>
    <?php if ( trim( plh_wed( 'cta' ) ) !== '' ) : ?>
      <a class="wed-btn wed-btn--dark wed-reveal" href="<?php echo esc_url( plh_page_url( 'contact' ) ); ?>"><?php echo esc_html( plh_wed( 'cta' ) ); ?></a>
    <?php endif; ?>
  </section>

  <?php if ( $wed_photos ) : ?>
  <section class="wed-simple__gallery" aria-label="<?php echo esc_attr( $wed_alt ); ?>">
    <?php foreach ( $wed_photos as $i => $photo ) : ?>
      <figure class="wed-simple__photo">
        <?php if ( ! empty( $photo['id'] ) ) :
          echo wp_get_attachment_image( $photo['id'], 'large', false, [
            'loading' => $i < 3 ? 'eager' : 'lazy',
            'sizes'   => '(max-width: 775px) 100vw, 34vw',
            'alt'     => get_post_meta( $photo['id'], '_wp_attachment_image_alt', true ) ?: $wed_alt,
          ] );
        else : ?>
          <img src="<?php echo esc_url( $photo['src'] ); ?>" width="<?php echo (int) $photo['w']; ?>" height="<?php echo (int) $photo['h']; ?>" alt="<?php echo esc_attr( $wed_alt ); ?>" loading="<?php echo $i < 3 ? 'eager' : 'lazy'; ?>" decoding="async">
        <?php endif; ?>
      </figure>
    <?php endforeach; ?>
  </section>
  <?php endif; ?>

</div>

<script>
// Fade the text in on load (skipped when the visitor prefers less motion)
(function () {
  var items = document.querySelectorAll('.wedding-page .wed-reveal');
  if (!items.length || !('IntersectionObserver' in window)) return;
  if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  document.documentElement.classList.add('wed-anim');
  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (e) {
      if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
    });
  }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });
  items.forEach(function (el) { io.observe(el); });
})();
</script>

<?php get_footer(); ?>

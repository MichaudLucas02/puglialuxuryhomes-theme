<?php
/**
 * Template Name: Weddings
 *
 * Simple layout: title, a few paragraphs, a button, then three weddings.
 * Each wedding has the same photo layout but its own style (colours, type).
 * Texts and photos are set in inc/weddings.php and in the page admin
 * ("Weddings page: texts" and "Weddings (3 galleries)" boxes).
 */
get_header();

$wed_stories = plh_wedding_stories();
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

  <?php foreach ( $wed_stories as $s => $story ) : ?>
  <section class="wed-story wed-story--<?php echo esc_attr( $story['theme'] ); ?>" aria-label="<?php echo esc_attr( $story['name'] ); ?>">
    <header class="wed-story__head wed-reveal">
      <span class="wed-story__num"><?php echo esc_html( sprintf( '%02d', $s + 1 ) ); ?></span>
      <h2 class="wed-story__name"><?php echo esc_html( $story['name'] ); ?></h2>
      <?php if ( $story['place'] !== '' ) : ?>
        <p class="wed-story__place"><?php echo esc_html( $story['place'] ); ?></p>
      <?php endif; ?>
      <?php if ( $story['text'] !== '' ) : ?>
        <p class="wed-story__text"><?php echo nl2br( esc_html( $story['text'] ) ); ?></p>
      <?php endif; ?>
    </header>
    <div class="wed-simple__gallery">
      <?php foreach ( $story['photos'] as $i => $photo ) :
        $eager = $s === 0 && $i < 3; ?>
        <figure class="wed-simple__photo">
          <?php if ( ! empty( $photo['id'] ) ) :
            echo wp_get_attachment_image( $photo['id'], 'large', false, [
              'loading' => $eager ? 'eager' : 'lazy',
              'sizes'   => '(max-width: 775px) 100vw, 34vw',
              'alt'     => get_post_meta( $photo['id'], '_wp_attachment_image_alt', true ) ?: $story['name'],
            ] );
          else : ?>
            <img src="<?php echo esc_url( $photo['src'] ); ?>" width="<?php echo (int) $photo['w']; ?>" height="<?php echo (int) $photo['h']; ?>" alt="<?php echo esc_attr( $story['name'] ); ?>" loading="<?php echo $eager ? 'eager' : 'lazy'; ?>" decoding="async">
          <?php endif; ?>
        </figure>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endforeach; ?>

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

<?php
/**
 * Template Name: Weddings
 *
 * Texts and images are set in inc/weddings.php and can be replaced per page
 * in the admin ("Weddings page" box).
 */
get_header();

$wed_lang = plh_wedding_lang();
$wed_old  = [];
if ( isset( $_SESSION['wedding_form_data'] ) ) {
  $wed_old = $_SESSION['wedding_form_data'];
  unset( $_SESSION['wedding_form_data'] );
}
$wed_status = isset( $_GET['wedding_enquiry'] ) ? sanitize_key( $_GET['wedding_enquiry'] ) : '';
$wed_error  = isset( $_GET['wedding_error'] ) ? sanitize_key( $_GET['wedding_error'] ) : '';
?>

<div class="wedding-page">

  <!-- Hero -->
  <section class="wed-hero">
    <img class="wed-hero__img" src="<?php echo esc_url( plh_wed_img_url( 'hero', 'full' ) ); ?>" alt="" fetchpriority="high">
    <div class="wed-hero__content">
      <p class="wed-eyebrow wed-eyebrow--light"><?php echo esc_html( plh_wed( 'hero_eyebrow' ) ); ?></p>
      <h1 class="wed-hero__title"><?php echo esc_html( plh_wed( 'hero_title' ) ); ?></h1>
      <p class="wed-hero__text"><?php echo esc_html( plh_wed( 'hero_text' ) ); ?></p>
      <div class="wed-hero__actions">
        <a class="wed-btn wed-btn--light" href="#wedding-enquiry"><?php echo esc_html( plh_wed( 'hero_cta' ) ); ?></a>
        <a class="wed-btn wed-btn--ghost" href="#wed-settings"><?php echo esc_html( plh_wed( 'hero_cta2' ) ); ?></a>
      </div>
    </div>
    <span class="wed-hero__scroll" aria-hidden="true"></span>
  </section>

  <!-- Intro -->
  <section class="wed-intro">
    <div class="wed-intro__text wed-reveal">
      <p class="wed-eyebrow"><?php echo esc_html( plh_wed( 'intro_eyebrow' ) ); ?></p>
      <h2 class="wed-title"><?php echo esc_html( plh_wed( 'intro_title' ) ); ?></h2>
      <span class="wed-rule" aria-hidden="true"></span>
      <p class="wed-body"><?php echo nl2br( esc_html( plh_wed( 'intro_text' ) ) ); ?></p>
    </div>
    <div class="wed-intro__media wed-reveal">
      <img class="wed-intro__img-main" src="<?php echo esc_url( plh_wed_img_url( 'intro' ) ); ?>" alt="" loading="lazy">
      <img class="wed-intro__img-small" src="<?php echo esc_url( plh_wed_img_url( 'intro2', 'medium_large' ) ); ?>" alt="" loading="lazy">
    </div>
  </section>

  <div class="wed-moments wed-reveal">
    <p><?php echo esc_html( plh_wed( 'moments' ) ); ?></p>
  </div>

  <!-- Settings -->
  <section class="wed-settings" id="wed-settings">
    <header class="wed-head wed-reveal">
      <p class="wed-eyebrow"><?php echo esc_html( plh_wed( 'settings_eyebrow' ) ); ?></p>
      <h2 class="wed-title"><?php echo esc_html( plh_wed( 'settings_title' ) ); ?></h2>
    </header>
    <div class="wed-settings__grid">
      <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
        <article class="wed-setting wed-reveal" style="--wed-delay: <?php echo ( $i - 1 ) * 120; ?>ms">
          <div class="wed-setting__media">
            <img src="<?php echo esc_url( plh_wed_img_url( 'setting' . $i ) ); ?>" alt="" loading="lazy">
          </div>
          <span class="wed-setting__num"><?php echo esc_html( sprintf( '0%d', $i ) ); ?></span>
          <h3 class="wed-setting__title"><?php echo esc_html( plh_wed( 'setting' . $i . '_title' ) ); ?></h3>
          <p class="wed-body"><?php echo esc_html( plh_wed( 'setting' . $i . '_text' ) ); ?></p>
        </article>
      <?php endfor; ?>
    </div>
  </section>

  <!-- Quote -->
  <section class="wed-quote" style="--wed-band: url('<?php echo esc_url( plh_wed_img_url( 'band', 'full' ) ); ?>')">
    <div class="wed-quote__inner wed-reveal">
      <span class="wed-quote__mark" aria-hidden="true">“</span>
      <p class="wed-quote__text"><?php echo esc_html( plh_wed( 'quote' ) ); ?></p>
    </div>
  </section>

  <!-- Services -->
  <section class="wed-services">
    <div class="wed-services__inner">
      <header class="wed-services__head wed-reveal">
        <p class="wed-eyebrow"><?php echo esc_html( plh_wed( 'services_eyebrow' ) ); ?></p>
        <h2 class="wed-title"><?php echo esc_html( plh_wed( 'services_title' ) ); ?></h2>
        <span class="wed-rule" aria-hidden="true"></span>
        <p class="wed-body"><?php echo esc_html( plh_wed( 'services_text' ) ); ?></p>
      </header>
      <div class="wed-services__list">
        <?php for ( $i = 1; $i <= 8; $i++ ) : ?>
          <div class="wed-service wed-reveal" style="--wed-delay: <?php echo ( ( $i - 1 ) % 2 ) * 100; ?>ms">
            <span class="wed-service__num"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span>
            <div>
              <h3 class="wed-service__title"><?php echo esc_html( plh_wed( 'svc' . $i . '_title' ) ); ?></h3>
              <p class="wed-body"><?php echo esc_html( plh_wed( 'svc' . $i . '_text' ) ); ?></p>
            </div>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <!-- Process -->
  <section class="wed-process">
    <header class="wed-head wed-reveal">
      <p class="wed-eyebrow"><?php echo esc_html( plh_wed( 'process_eyebrow' ) ); ?></p>
      <h2 class="wed-title"><?php echo esc_html( plh_wed( 'process_title' ) ); ?></h2>
    </header>
    <ol class="wed-steps">
      <?php foreach ( [ 'I', 'II', 'III', 'IV' ] as $n => $roman ) : $s = $n + 1; ?>
        <li class="wed-step wed-reveal" style="--wed-delay: <?php echo $n * 120; ?>ms">
          <span class="wed-step__num"><?php echo esc_html( $roman ); ?></span>
          <h3 class="wed-step__title"><?php echo esc_html( plh_wed( 'step' . $s . '_title' ) ); ?></h3>
          <p class="wed-body"><?php echo esc_html( plh_wed( 'step' . $s . '_text' ) ); ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </section>

  <!-- Gallery -->
  <section class="wed-gallery">
    <header class="wed-head wed-reveal">
      <p class="wed-eyebrow"><?php echo esc_html( plh_wed( 'gallery_eyebrow' ) ); ?></p>
      <h2 class="wed-title"><?php echo esc_html( plh_wed( 'gallery_title' ) ); ?></h2>
    </header>
    <div class="wed-gallery__grid">
      <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
        <figure class="wed-gallery__item wed-gallery__item--<?php echo $i; ?> wed-reveal">
          <img src="<?php echo esc_url( plh_wed_img_url( 'gallery' . $i ) ); ?>" alt="" loading="lazy">
        </figure>
      <?php endfor; ?>
    </div>
  </section>

  <!-- Enquiry -->
  <section class="wed-enquiry" id="wedding-enquiry">
    <div class="wed-enquiry__inner">
      <div class="wed-enquiry__intro wed-reveal">
        <p class="wed-eyebrow"><?php echo esc_html( plh_wed( 'form_eyebrow' ) ); ?></p>
        <h2 class="wed-title"><?php echo esc_html( plh_wed( 'form_title' ) ); ?></h2>
        <span class="wed-rule" aria-hidden="true"></span>
        <p class="wed-body"><?php echo esc_html( plh_wed( 'form_text' ) ); ?></p>

        <div class="wed-enquiry__talk">
          <p class="wed-enquiry__talk-label"><?php echo esc_html( plh_wed( 'form_talk' ) ); ?></p>
          <a href="https://wa.me/393279379067" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i> +39 327 93 79 067</a>
          <a href="mailto:reservation@puglialuxuryhomes.com"><i class="fa-regular fa-envelope" aria-hidden="true"></i> reservation@puglialuxuryhomes.com</a>
        </div>
      </div>

      <div class="wed-enquiry__form wed-reveal">
        <?php if ( $wed_status === 'success' ) : ?>
          <div class="form-message success"><?php echo esc_html( plh_wed( 'f_success' ) ); ?></div>
        <?php elseif ( $wed_status === 'error' ) :
          $err_key = in_array( $wed_error, [ 'required', 'email', 'send', 'security' ], true ) ? 'err_' . $wed_error : 'err_send'; ?>
          <div class="form-message error"><?php echo esc_html( plh_wed( $err_key ) ); ?></div>
        <?php endif; ?>

        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="wed-form">
          <input type="hidden" name="action" value="plh_wedding_enquiry">
          <input type="hidden" name="form_language" value="<?php echo esc_attr( $wed_lang ); ?>">
          <?php wp_nonce_field( 'plh_wedding_enquiry', 'plh_wedding_nonce' ); ?>

          <div class="wed-field wed-field--full">
            <label for="wed_names"><?php echo esc_html( plh_wed( 'f_names' ) ); ?> *</label>
            <input type="text" id="wed_names" name="wed_names" autocomplete="name" required value="<?php echo esc_attr( $wed_old['wed_names'] ?? '' ); ?>">
          </div>

          <div class="wed-field">
            <label for="wed_email"><?php echo esc_html( plh_wed( 'f_email' ) ); ?> *</label>
            <input type="email" id="wed_email" name="wed_email" autocomplete="email" required value="<?php echo esc_attr( $wed_old['wed_email'] ?? '' ); ?>">
          </div>
          <div class="wed-field">
            <label for="wed_phone"><?php echo esc_html( plh_wed( 'f_phone' ) ); ?> *</label>
            <input type="tel" id="wed_phone" name="wed_phone" autocomplete="tel" required value="<?php echo esc_attr( $wed_old['wed_phone'] ?? '' ); ?>">
          </div>

          <div class="wed-field">
            <label for="wed_date"><?php echo esc_html( plh_wed( 'f_date' ) ); ?></label>
            <input type="text" id="wed_date" name="wed_date" placeholder="<?php echo esc_attr( plh_wed( 'f_date_ph' ) ); ?>" value="<?php echo esc_attr( $wed_old['wed_date'] ?? '' ); ?>">
          </div>
          <div class="wed-field">
            <label for="wed_guests"><?php echo esc_html( plh_wed( 'f_guests' ) ); ?></label>
            <select id="wed_guests" name="wed_guests">
              <option value=""><?php echo esc_html( plh_wed( 'f_select' ) ); ?></option>
              <?php foreach ( [ 'f_g1', 'f_g2', 'f_g3', 'f_g4' ] as $g ) : ?>
                <option value="<?php echo esc_attr( $g ); ?>"<?php selected( $wed_old['wed_guests'] ?? '', $g ); ?>><?php echo esc_html( plh_wed( $g ) ); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <fieldset class="wed-field wed-field--full wed-choices">
            <legend><?php echo esc_html( plh_wed( 'f_setting' ) ); ?></legend>
            <?php foreach ( [ 'setting1_title', 'setting2_title', 'setting3_title', 'f_unsure' ] as $opt ) : ?>
              <label class="wed-choice">
                <input type="radio" name="wed_setting" value="<?php echo esc_attr( $opt ); ?>"<?php checked( $wed_old['wed_setting'] ?? '', $opt ); ?>>
                <span><?php echo esc_html( plh_wed( $opt ) ); ?></span>
              </label>
            <?php endforeach; ?>
          </fieldset>

          <div class="wed-field wed-field--full">
            <label for="wed_message"><?php echo esc_html( plh_wed( 'f_message' ) ); ?></label>
            <textarea id="wed_message" name="wed_message" rows="4"><?php echo esc_textarea( $wed_old['wed_message'] ?? '' ); ?></textarea>
          </div>

          <div class="wed-field wed-field--full wed-consent">
            <input type="checkbox" id="wed_consent" name="wed_consent" value="1" required>
            <label for="wed_consent"><?php echo esc_html( plh_wed( 'f_consent' ) ); ?> *</label>
          </div>

          <input type="text" name="wed_hp_field" class="wed-hp" tabindex="-1" autocomplete="off" aria-hidden="true">

          <button type="submit" class="wed-btn wed-btn--dark wed-form__submit"><?php echo esc_html( plh_wed( 'f_submit' ) ); ?></button>
        </form>
      </div>
    </div>
  </section>

</div>

<script>
// Fade sections in as they scroll into view (skipped when the visitor prefers less motion)
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

<?php
/**
 * Template Name: Retreats
 *
 * Texts and images are set in inc/retreats.php and can be replaced per page
 * in the admin ("Retreats page" box). Shares the Weddings page look (fonts,
 * colours, buttons, form) but has its own layout (ret-* styles).
 */
get_header();

$ret_lang = plh_wedding_lang();
$ret_old  = [];
if ( isset( $_SESSION['retreat_form_data'] ) ) {
  $ret_old = $_SESSION['retreat_form_data'];
  unset( $_SESSION['retreat_form_data'] );
}
$ret_status = isset( $_GET['retreat_enquiry'] ) ? sanitize_key( $_GET['retreat_enquiry'] ) : '';
$ret_error  = isset( $_GET['retreat_error'] ) ? sanitize_key( $_GET['retreat_error'] ) : '';

// Thin line icons for the services grid (same order as svc1 … svc8)
$ret_icons = [
  // Private chef: chef hat
  '<path d="M15 30h18v7H15z"/><path d="M15 30c-4 0-7-3-7-7s3-7 7-7c1-4 5-7 9-7s8 3 9 7c4 0 7 3 7 7s-3 7-7 7"/>',
  // Teachers: person with open arms
  '<circle cx="24" cy="10" r="4"/><path d="M10 20l14 3 14-3"/><path d="M24 23v8l-6 9M24 31l6 9"/>',
  // Spaces for practice: mat with sun
  '<rect x="8" y="30" width="32" height="7" rx="2"/><circle cx="24" cy="15" r="5"/><path d="M24 5v2M24 23v2M14 15h2M32 15h2M17 8l1.5 1.5M29.5 20.5L31 22M31 8l-1.5 1.5M18.5 20.5L17 22"/>',
  // Massages: hands and drop
  '<path d="M24 8c4 6 7 9 7 13a7 7 0 0 1-14 0c0-4 3-7 7-13z"/><path d="M8 40c4-6 9-8 16-8s12 2 16 8"/>',
  // Activities: boat
  '<path d="M8 32h32l-5 7H13z"/><path d="M24 32V8l11 18H24"/><path d="M6 43c3 0 3-2 6-2s3 2 6 2 3-2 6-2 3 2 6 2 3-2 6-2 3 2 6 2"/>',
  // Rooms: bed
  '<path d="M6 36V14M6 28h36v8M42 36v-6c0-3-2-5-5-5H22v3"/><circle cx="14" cy="23" r="3.5"/>',
  // Transfers: car
  '<path d="M8 31l3-9c1-2 2-3 4-3h18c2 0 3 1 4 3l3 9"/><rect x="6" y="31" width="36" height="7" rx="2"/><circle cx="14" cy="38" r="3"/><circle cx="34" cy="38" r="3"/>',
  // Working sessions: board
  '<rect x="8" y="9" width="32" height="20" rx="1"/><path d="M24 29v6M16 41l8-6 8 6M14 16h12M14 21h18"/>',
];
?>

<div class="wedding-page retreat-page">

  <!-- Hero: wide photo, sand panel with the title overlapping its lower corner -->
  <section class="ret-hero">
    <div class="ret-hero__media">
      <img src="<?php echo esc_url( plh_ret_img_url( 'hero', 'full' ) ); ?>" alt="" fetchpriority="high">
    </div>
    <div class="ret-hero__text">
      <p class="wed-eyebrow"><?php echo esc_html( plh_ret( 'hero_eyebrow' ) ); ?></p>
      <h1 class="ret-hero__title"><?php echo esc_html( plh_ret( 'hero_title' ) ); ?></h1>
      <span class="wed-rule" aria-hidden="true"></span>
      <p class="ret-hero__lead"><?php echo esc_html( plh_ret( 'hero_text' ) ); ?></p>
      <div class="ret-hero__actions">
        <a class="wed-btn wed-btn--dark" href="#retreat-enquiry"><?php echo esc_html( plh_ret( 'hero_cta' ) ); ?></a>
        <a class="ret-link" href="#ret-types"><?php echo esc_html( plh_ret( 'hero_cta2' ) ); ?> <span aria-hidden="true">↓</span></a>
      </div>
    </div>
  </section>

  <!-- Intro: centered statement, three staggered photos -->
  <section class="ret-intro">
    <div class="ret-intro__text wed-reveal">
      <p class="wed-eyebrow"><?php echo esc_html( plh_ret( 'intro_eyebrow' ) ); ?></p>
      <h2 class="wed-title"><?php echo esc_html( plh_ret( 'intro_title' ) ); ?></h2>
      <p class="ret-intro__body"><?php echo nl2br( esc_html( plh_ret( 'intro_text' ) ) ); ?></p>
    </div>
    <div class="ret-intro__photos">
      <?php foreach ( [ 'intro', 'intro2', 'intro3' ] as $n => $img ) : ?>
        <figure class="ret-intro__photo ret-intro__photo--<?php echo $n + 1; ?> wed-reveal" style="--wed-delay: <?php echo $n * 150; ?>ms">
          <img src="<?php echo esc_url( plh_ret_img_url( $img ) ); ?>" alt="" loading="lazy">
        </figure>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Types of retreat: alternating rows -->
  <section class="ret-types" id="ret-types">
    <header class="wed-head wed-reveal">
      <p class="wed-eyebrow"><?php echo esc_html( plh_ret( 'types_eyebrow' ) ); ?></p>
      <h2 class="wed-title"><?php echo esc_html( plh_ret( 'types_title' ) ); ?></h2>
    </header>
    <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
      <article class="ret-type<?php echo $i % 2 === 0 ? ' ret-type--flip' : ''; ?>">
        <div class="ret-type__media wed-reveal">
          <img src="<?php echo esc_url( plh_ret_img_url( 'type' . $i ) ); ?>" alt="" loading="lazy">
        </div>
        <div class="ret-type__text wed-reveal" style="--wed-delay: 150ms">
          <span class="ret-type__num"><?php echo esc_html( sprintf( '0%d', $i ) ); ?></span>
          <h3 class="ret-type__title"><?php echo esc_html( plh_ret( 'type' . $i . '_title' ) ); ?></h3>
          <p class="wed-body"><?php echo esc_html( plh_ret( 'type' . $i . '_text' ) ); ?></p>
        </div>
      </article>
    <?php endfor; ?>
  </section>

  <!-- A day on retreat: photo that stays in place + timeline -->
  <section class="ret-day">
    <div class="ret-day__inner">
      <div class="ret-day__media">
        <img src="<?php echo esc_url( plh_ret_img_url( 'day' ) ); ?>" alt="" loading="lazy">
      </div>
      <div class="ret-day__content">
        <header class="wed-reveal">
          <p class="wed-eyebrow"><?php echo esc_html( plh_ret( 'day_eyebrow' ) ); ?></p>
          <h2 class="wed-title"><?php echo esc_html( plh_ret( 'day_title' ) ); ?></h2>
        </header>
        <ol class="ret-timeline">
          <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
            <li class="ret-timeline__item wed-reveal">
              <span class="ret-timeline__time"><?php echo esc_html( plh_ret( 'day' . $i . '_time' ) ); ?></span>
              <div>
                <h3 class="ret-timeline__title"><?php echo esc_html( plh_ret( 'day' . $i . '_title' ) ); ?></h3>
                <p class="wed-body"><?php echo esc_html( plh_ret( 'day' . $i . '_text' ) ); ?></p>
              </div>
            </li>
          <?php endfor; ?>
        </ol>
        <p class="ret-day__note"><?php echo esc_html( plh_ret( 'day_note' ) ); ?></p>
      </div>
    </div>
  </section>

  <!-- Quote: plain text between two rules -->
  <section class="ret-quote">
    <p class="ret-quote__text wed-reveal"><?php echo esc_html( plh_ret( 'quote' ) ); ?></p>
  </section>

  <!-- Two ways to work with us -->
  <section class="ret-ways">
    <header class="wed-head wed-reveal">
      <p class="wed-eyebrow"><?php echo esc_html( plh_ret( 'ways_eyebrow' ) ); ?></p>
      <h2 class="wed-title"><?php echo esc_html( plh_ret( 'ways_title' ) ); ?></h2>
    </header>
    <div class="ret-ways__grid">
      <?php for ( $i = 1; $i <= 2; $i++ ) : ?>
        <div class="ret-way wed-reveal" style="--wed-delay: <?php echo ( $i - 1 ) * 150; ?>ms">
          <span class="ret-way__num"><?php echo $i === 1 ? 'I' : 'II'; ?></span>
          <p class="wed-eyebrow"><?php echo esc_html( plh_ret( 'way' . $i . '_label' ) ); ?></p>
          <h3 class="ret-way__title"><?php echo esc_html( plh_ret( 'way' . $i . '_title' ) ); ?></h3>
          <p class="wed-body"><?php echo esc_html( plh_ret( 'way' . $i . '_text' ) ); ?></p>
        </div>
      <?php endfor; ?>
    </div>
  </section>

  <!-- Services: icon grid -->
  <section class="ret-services">
    <header class="wed-head wed-reveal">
      <p class="wed-eyebrow"><?php echo esc_html( plh_ret( 'services_eyebrow' ) ); ?></p>
      <h2 class="wed-title"><?php echo esc_html( plh_ret( 'services_title' ) ); ?></h2>
      <p class="wed-body ret-services__intro"><?php echo esc_html( plh_ret( 'services_text' ) ); ?></p>
    </header>
    <div class="ret-services__grid">
      <?php for ( $i = 1; $i <= 8; $i++ ) : ?>
        <div class="ret-service wed-reveal" style="--wed-delay: <?php echo ( ( $i - 1 ) % 4 ) * 90; ?>ms">
          <svg class="ret-service__icon" width="44" height="44" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><?php echo $ret_icons[ $i - 1 ]; ?></svg>
          <h3 class="ret-service__title"><?php echo esc_html( plh_ret( 'svc' . $i . '_title' ) ); ?></h3>
          <p class="wed-body"><?php echo esc_html( plh_ret( 'svc' . $i . '_text' ) ); ?></p>
        </div>
      <?php endfor; ?>
    </div>
  </section>

  <!-- Gallery: horizontal strip -->
  <section class="ret-gallery">
    <header class="ret-gallery__head wed-reveal">
      <div>
        <p class="wed-eyebrow"><?php echo esc_html( plh_ret( 'gallery_eyebrow' ) ); ?></p>
        <h2 class="wed-title"><?php echo esc_html( plh_ret( 'gallery_title' ) ); ?></h2>
      </div>
      <div class="ret-gallery__nav">
        <button type="button" class="ret-gallery__btn" data-dir="-1" aria-label="Previous">←</button>
        <button type="button" class="ret-gallery__btn" data-dir="1" aria-label="Next">→</button>
      </div>
    </header>
    <div class="ret-gallery__strip" tabindex="0">
      <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
        <figure class="ret-gallery__item ret-gallery__item--<?php echo $i; ?>">
          <img src="<?php echo esc_url( plh_ret_img_url( 'gallery' . $i ) ); ?>" alt="" loading="lazy">
        </figure>
      <?php endfor; ?>
    </div>
  </section>

  <!-- Enquiry: centered card over a photo -->
  <section class="ret-enquiry" id="retreat-enquiry" style="--ret-bg: url('<?php echo esc_url( plh_ret_img_url( 'form_bg', 'full' ) ); ?>')">
    <div class="ret-enquiry__card wed-reveal">
      <header class="ret-enquiry__head">
        <p class="wed-eyebrow"><?php echo esc_html( plh_ret( 'form_eyebrow' ) ); ?></p>
        <h2 class="wed-title"><?php echo esc_html( plh_ret( 'form_title' ) ); ?></h2>
        <p class="wed-body"><?php echo esc_html( plh_ret( 'form_text' ) ); ?></p>
      </header>

      <?php if ( $ret_status === 'success' ) : ?>
        <div class="form-message success"><?php echo esc_html( plh_ret( 'f_success' ) ); ?></div>
      <?php elseif ( $ret_status === 'error' ) :
        $err_key = in_array( $ret_error, [ 'required', 'email', 'send', 'security' ], true ) ? 'err_' . $ret_error : 'err_send'; ?>
        <div class="form-message error"><?php echo esc_html( plh_ret( $err_key ) ); ?></div>
      <?php endif; ?>

      <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="wed-form">
        <input type="hidden" name="action" value="plh_retreat_enquiry">
        <input type="hidden" name="form_language" value="<?php echo esc_attr( $ret_lang ); ?>">
        <?php wp_nonce_field( 'plh_retreat_enquiry', 'plh_retreat_nonce' ); ?>

        <div class="wed-field wed-field--full">
          <label for="ret_name"><?php echo esc_html( plh_ret( 'f_name' ) ); ?> *</label>
          <input type="text" id="ret_name" name="ret_name" autocomplete="name" required value="<?php echo esc_attr( $ret_old['ret_name'] ?? '' ); ?>">
        </div>

        <div class="wed-field">
          <label for="ret_email"><?php echo esc_html( plh_ret( 'f_email' ) ); ?> *</label>
          <input type="email" id="ret_email" name="ret_email" autocomplete="email" required value="<?php echo esc_attr( $ret_old['ret_email'] ?? '' ); ?>">
        </div>
        <div class="wed-field">
          <label for="ret_phone"><?php echo esc_html( plh_ret( 'f_phone' ) ); ?> *</label>
          <input type="tel" id="ret_phone" name="ret_phone" autocomplete="tel" required value="<?php echo esc_attr( $ret_old['ret_phone'] ?? '' ); ?>">
        </div>

        <fieldset class="wed-field wed-field--full wed-choices">
          <legend><?php echo esc_html( plh_ret( 'f_who' ) ); ?></legend>
          <?php foreach ( [ 'f_who1', 'f_who2', 'f_who3' ] as $opt ) : ?>
            <label class="wed-choice">
              <input type="radio" name="ret_who" value="<?php echo esc_attr( $opt ); ?>"<?php checked( $ret_old['ret_who'] ?? '', $opt ); ?>>
              <span><?php echo esc_html( plh_ret( $opt ) ); ?></span>
            </label>
          <?php endforeach; ?>
        </fieldset>

        <fieldset class="wed-field wed-field--full wed-choices">
          <legend><?php echo esc_html( plh_ret( 'f_type' ) ); ?></legend>
          <?php foreach ( [ 'type1_title', 'type2_title', 'type3_title', 'type4_title', 'f_other' ] as $opt ) : ?>
            <label class="wed-choice">
              <input type="radio" name="ret_type" value="<?php echo esc_attr( $opt ); ?>"<?php checked( $ret_old['ret_type'] ?? '', $opt ); ?>>
              <span><?php echo esc_html( plh_ret( $opt ) ); ?></span>
            </label>
          <?php endforeach; ?>
        </fieldset>

        <div class="wed-field">
          <label for="ret_date"><?php echo esc_html( plh_ret( 'f_date' ) ); ?></label>
          <input type="text" id="ret_date" name="ret_date" placeholder="<?php echo esc_attr( plh_ret( 'f_date_ph' ) ); ?>" value="<?php echo esc_attr( $ret_old['ret_date'] ?? '' ); ?>">
        </div>
        <div class="wed-field">
          <label for="ret_size"><?php echo esc_html( plh_ret( 'f_size' ) ); ?></label>
          <select id="ret_size" name="ret_size">
            <option value=""><?php echo esc_html( plh_ret( 'f_select' ) ); ?></option>
            <?php foreach ( [ 'f_s1', 'f_s2', 'f_s3', 'f_s4' ] as $s ) : ?>
              <option value="<?php echo esc_attr( $s ); ?>"<?php selected( $ret_old['ret_size'] ?? '', $s ); ?>><?php echo esc_html( plh_ret( $s ) ); ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="wed-field wed-field--full">
          <label for="ret_message"><?php echo esc_html( plh_ret( 'f_message' ) ); ?></label>
          <textarea id="ret_message" name="ret_message" rows="4"><?php echo esc_textarea( $ret_old['ret_message'] ?? '' ); ?></textarea>
        </div>

        <div class="wed-field wed-field--full wed-consent">
          <input type="checkbox" id="ret_consent" name="ret_consent" value="1" required>
          <label for="ret_consent"><?php echo esc_html( plh_ret( 'f_consent' ) ); ?> *</label>
        </div>

        <input type="text" name="ret_hp_field" class="wed-hp" tabindex="-1" autocomplete="off" aria-hidden="true">

        <button type="submit" class="wed-btn wed-btn--dark wed-form__submit"><?php echo esc_html( plh_ret( 'f_submit' ) ); ?></button>
      </form>

      <div class="ret-enquiry__talk">
        <span><?php echo esc_html( plh_ret( 'form_talk' ) ); ?></span>
        <a href="https://wa.me/393279379067" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i> +39 327 93 79 067</a>
        <a href="mailto:reservation@puglialuxuryhomes.com"><i class="fa-regular fa-envelope" aria-hidden="true"></i> reservation@puglialuxuryhomes.com</a>
      </div>
    </div>
  </section>

</div>

<script>
(function () {
  // Fade sections in as they scroll into view (skipped when the visitor prefers less motion)
  var items = document.querySelectorAll('.retreat-page .wed-reveal');
  var calm = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (items.length && 'IntersectionObserver' in window && !calm) {
    document.documentElement.classList.add('wed-anim');
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });
    items.forEach(function (el) { io.observe(el); });
  }

  // Gallery arrows scroll the strip by one photo
  var strip = document.querySelector('.ret-gallery__strip');
  document.querySelectorAll('.ret-gallery__btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      if (!strip) return;
      var item = strip.querySelector('.ret-gallery__item');
      var step = item ? item.getBoundingClientRect().width + 16 : 400;
      strip.scrollBy({ left: step * parseInt(btn.dataset.dir, 10), behavior: calm ? 'auto' : 'smooth' });
    });
  });
})();
</script>

<?php get_footer(); ?>

<?php
/*
 * Template Name: Real Estate Puglia
 */
get_header();
get_template_part('partials/small-hero');
?>

<div class="homepage">

  <?php
  $re_subtitle = get_field('re_subtitle');
  $re_intro    = get_field('re_intro_text');
  if ( $re_subtitle || $re_intro ) : ?>
  <section class="re-intro-section">
    <div class="re-intro-container">
      <?php if ( $re_subtitle ) : ?>
        <p class="re-intro-subtitle"><?php echo esc_html( $re_subtitle ); ?></p>
      <?php endif; ?>
      <?php if ( $re_intro ) : ?>
        <div class="re-intro-body"><?php echo wp_kses_post( wpautop( $re_intro ) ); ?></div>
      <?php endif; ?>
    </div>
  </section>
  <?php endif; ?>

  <?php get_template_part('partials/process'); ?>

  <section class="villa-submission-section re-inquiry-section">
    <div class="container">

      <div class="submission-intro">
        <h2><?php echo esc_html( plh_t('Start your property journey in Puglia') ); ?></h2>
        <p><?php echo esc_html( plh_t('Whether you are looking to find your place in Puglia or considering selling your property, we guide you every step of the way.') ); ?></p>
      </div>

      <?php if ( isset($_GET['re_inquiry']) ) :
        if ( $_GET['re_inquiry'] === 'success' ) : ?>
          <div class="form-message success"><?php echo esc_html( plh_t('Thank you! Your enquiry has been received. We will be in touch shortly.') ); ?></div>
        <?php else :
          $err = isset($_GET['re_error']) ? urldecode($_GET['re_error']) : plh_t('An error occurred. Please try again.');
        ?>
          <div class="form-message error"><?php echo esc_html( $err ); ?></div>
        <?php endif;
      endif; ?>

      <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" class="villa-submission-form re-inquiry-form">
        <input type="hidden" name="action" value="plh_real_estate_inquiry">
        <input type="hidden" name="form_language" value="<?php echo esc_attr( function_exists('pll_current_language') ? pll_current_language() : 'en' ); ?>">
        <?php wp_nonce_field('plh_re_inquiry_nonce', 'plh_re_inquiry_nonce'); ?>

        <div class="form-row">
          <div class="form-col">
            <label for="re_full_name"><?php echo esc_html( plh_t('Full Name') ); ?> *</label>
            <input type="text" id="re_full_name" name="re_full_name" required>
          </div>
          <div class="form-col">
            <label for="re_email"><?php echo esc_html( plh_t('Email address') ); ?> *</label>
            <input type="email" id="re_email" name="re_email" required>
          </div>
        </div>

        <div class="form-row">
          <div class="form-col">
            <label for="re_phone"><?php echo esc_html( plh_t('Phone') ); ?> *</label>
            <input type="tel" id="re_phone" name="re_phone" placeholder="+39 123 456 7890" required>
          </div>
          <div class="form-col">
            <label for="re_country"><?php echo esc_html( plh_t('Country of residence') ); ?></label>
            <input type="text" id="re_country" name="re_country">
          </div>
        </div>

        <div class="form-row full-width">
          <label for="re_intent"><?php echo esc_html( plh_t('I am looking to:') ); ?> *</label>
          <select id="re_intent" name="re_intent" required>
            <option value=""><?php echo esc_html( plh_t('Select an option') ); ?></option>
            <option value="Buy a property"><?php echo esc_html( plh_t('Buy a property') ); ?></option>
            <option value="Sell a property"><?php echo esc_html( plh_t('Sell a property') ); ?></option>
            <option value="Both"><?php echo esc_html( plh_t('Both') ); ?></option>
            <option value="Other"><?php echo esc_html( plh_t('Other') ); ?></option>
          </select>
        </div>

        <div class="form-row full-width">
          <label><?php echo esc_html( plh_t('Preferred location') ); ?> *</label>
          <div class="re-location-grid">
            <?php
            $locations = ['Basso Salento', 'Lecce & surroundings', "Valle d'Itria", 'Alta Murgia & Gravine', 'Ionian Arc', 'Gargano & Foggia', 'Other'];
            foreach ( $locations as $loc ) : ?>
              <label class="re-checkbox-label">
                <input type="checkbox" name="re_locations[]" value="<?php echo esc_attr($loc); ?>">
                <span><?php echo esc_html( plh_t($loc) ); ?></span>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="form-row">
          <div class="form-col">
            <label for="re_budget"><?php echo esc_html( plh_t('Budget') ); ?> *</label>
            <select id="re_budget" name="re_budget" required>
              <option value=""><?php echo esc_html( plh_t('Select a range') ); ?></option>
              <option value="Under €500,000"><?php echo esc_html( plh_t('Under €500,000') ); ?></option>
              <option value="€500,000 – €1,000,000"><?php echo esc_html( plh_t('€500,000 – €1,000,000') ); ?></option>
              <option value="€1,000,000 – €2,000,000"><?php echo esc_html( plh_t('€1,000,000 – €2,000,000') ); ?></option>
              <option value="€2,000,000 – €5,000,000"><?php echo esc_html( plh_t('€2,000,000 – €5,000,000') ); ?></option>
              <option value="€5,000,000+"><?php echo esc_html( plh_t('€5,000,000+') ); ?></option>
            </select>
          </div>
          <div class="form-col">
            <label for="re_property_type"><?php echo esc_html( plh_t('Property type') ); ?></label>
            <select id="re_property_type" name="re_property_type">
              <option value=""><?php echo esc_html( plh_t('Select property type') ); ?></option>
              <option value="Villa">Villa</option>
              <option value="Masseria">Masseria</option>
              <option value="Palazzo">Palazzo</option>
              <option value="Apartment"><?php echo esc_html( plh_t('Apartment') ); ?></option>
              <option value="Trullo">Trullo</option>
              <option value="Other"><?php echo esc_html( plh_t('Other') ); ?></option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-col">
            <label for="re_timeline"><?php echo esc_html( plh_t('Timeline') ); ?></label>
            <select id="re_timeline" name="re_timeline">
              <option value=""><?php echo esc_html( plh_t('Select a timeline') ); ?></option>
              <option value="Within 3 months"><?php echo esc_html( plh_t('Within 3 months') ); ?></option>
              <option value="3–6 months"><?php echo esc_html( plh_t('3–6 months') ); ?></option>
              <option value="6–12 months"><?php echo esc_html( plh_t('6–12 months') ); ?></option>
              <option value="No fixed timeline"><?php echo esc_html( plh_t('No fixed timeline') ); ?></option>
            </select>
          </div>
          <div class="form-col">
            <label for="re_prior_purchase"><?php echo esc_html( plh_t('Have you purchased property abroad before?') ); ?></label>
            <select id="re_prior_purchase" name="re_prior_purchase">
              <option value=""><?php echo esc_html( plh_t('Select an option') ); ?></option>
              <option value="Yes"><?php echo esc_html( plh_t('Yes') ); ?></option>
              <option value="No"><?php echo esc_html( plh_t('No') ); ?></option>
            </select>
          </div>
        </div>

        <div class="form-row full-width">
          <label for="re_message"><?php echo esc_html( plh_t('Tell us more about your project') ); ?></label>
          <textarea id="re_message" name="re_message" rows="5"></textarea>
        </div>

        <div class="form-row full-width">
          <div class="consent-checkbox">
            <input type="checkbox" id="re_consent" name="re_consent" required>
            <label for="re_consent"><?php echo esc_html( plh_t('I agree to be contacted by Puglia Luxury Homes regarding this enquiry.') ); ?> *</label>
          </div>
        </div>

        <input type="text" name="re_hp_field" style="display:none;" tabindex="-1" autocomplete="off">

        <div class="form-row">
          <button type="submit" class="submit-btn"><?php echo esc_html( plh_t('Send my enquiry') ); ?></button>
        </div>

      </form>
    </div>
  </section>

</div>

<?php get_footer(); ?>

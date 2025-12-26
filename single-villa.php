<?php
/** single-villa.php */
get_header();

if (have_posts()) : while (have_posts()) : the_post();

$bedrooms       = get_field('beds_1');
$bathrooms      = get_field('baths_1');
$guests         = get_field('guests_1');
$sqm            = get_field('sqm_1');
$rameaux        = get_field('rameaux_1');
$intro_paragrph = get_field('intro_paragraph');
$read_more      = get_field('read_more_paragraph');
?>

<div class="homepage">

    <article <?php post_class('single-villa'); ?>>

        <?php get_template_part('partials/large-hero'); ?>


        <div class="villa-page-menu">
            <div class="villa-page-menu-container">
                <button class="villa-menu-scroll-arrow villa-menu-scroll-left" aria-label="Scroll left">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <div class="villa-page-menu-container-1">
                    <ul>
                        <li><a href="#must-have"><?php echo esc_html( plh_t('Must Have') ); ?></a></li>
                        <li><a href="#description"><?php echo esc_html( plh_t('Description') ); ?></a></li>
                        <li><a href="#experiences"><?php echo esc_html( plh_t('Experiences') ); ?></a></li>
                        <li><a href="#avis"><?php echo esc_html( plh_t('Reviews') ); ?></a></li>
                        <li><a href="<?php echo esc_url( plh_villa_gallery_link(get_the_ID()) ); ?>"><?php echo esc_html( plh_t('Photos') ); ?></a></li>
                    </ul>
                </div>
                <button class="villa-menu-scroll-arrow villa-menu-scroll-right" aria-label="Scroll right">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <div class="villa-page-menu-container-2"></div>
            </div>
        </div>
        <section class="villa-content">
            <div class="villa-content-left">
                <div class="villa-kpis">
                    <div class="single-kpi">
                        <img src="/wp-content/uploads/2025/09/Bedrooms.png">
                        <p><?php echo esc_html($bedrooms); ?> <?php echo esc_html( plh_t('Bedrooms') ); ?></p>
                    </div>
                    <div class="single-kpi">
                        <img src="/wp-content/uploads/2025/09/SDB.png">
                        <p><?php echo esc_html($bathrooms); ?> <?php echo esc_html( plh_t('bathrooms') ); ?></p>
                    </div>
                    <div class="single-kpi">
                        <img src="/wp-content/uploads/2025/09/bagage.png">
                        <p><?php echo esc_html($guests); ?> <?php echo esc_html( plh_t('guests') ); ?></p>
                    </div>
                    <div class="single-kpi">
                        <img src="/wp-content/uploads/2025/09/m2.png">
                        <p><?php echo esc_html($sqm); ?> <?php echo esc_html( plh_t('sqm') ); ?></p>
                    </div>
                    <div class="single-kpi rameaux">
                        <img src="/wp-content/uploads/2025/09/Rameaux.png">
                        <p>
                            <?php echo esc_html($rameaux); ?>
                            <span class="info-icon" data-modal-image="<?php echo esc_attr( get_field('rameaux_image') ?: '/wp-content/uploads/2025/09/Rameaux.png' ); ?>">
                                <i class="fa-solid fa-circle-info"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="villa-divider"></div>
                <p><?php echo wp_kses_post($intro_paragrph); ?></p>
                <div class="text-container">
                    <div class="text-body"><?php echo wp_kses_post($read_more); ?></div>
                    <button id="readMoreBtn"><?php echo esc_html( plh_t('Read more') ); ?> <span>&#9660;</span></button>
                </div>
                <div class="villa-divider margined"></div>
                
                <h2 class="must-have-title"><?php echo esc_html( plh_t('Must Have') ); ?></h2>
                <div class="must-have-wrapper">
                    <div id="must-have" class="must-have">
                        <div class="must-have-list">
                            <?php 
                            $must_have_1 = get_field('must_have_1');
                            if ($must_have_1 !== ''): ?>
                            <div class="must-have-row">
                                <i class="fa-solid fa-circle-check" style="color: #90b0b7;"></i>
                                <p><?php echo esc_html($must_have_1); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php 
                            $must_have_2 = get_field('must_have_2');
                            if ($must_have_2 !== ''): ?>
                            <div class="must-have-row">
                                <i class="fa-solid fa-circle-check" style="color: #90b0b7;"></i>
                                <p><?php echo esc_html($must_have_2); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="must-have-list">
                            <?php 
                            $must_have_3 = get_field('must_have_3');
                            if ($must_have_3 !== ''): ?>
                            <div class="must-have-row">
                                <i class="fa-solid fa-circle-check" style="color: #90b0b7;"></i>
                                <p><?php echo esc_html($must_have_3); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php 
                            $must_have_4 = get_field('must_have_4');
                            if ($must_have_4 !== ''): ?>
                            <div class="must-have-row">
                                <i class="fa-solid fa-circle-check" style="color: #90b0b7;"></i>
                                <p><?php echo esc_html($must_have_4); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <section id="description" class="acc" data-accordion data-single>
                        <div class="acc-item">
                            <button class="acc-trigger" aria-expanded="false" aria-controls="acc1" id="acc1-btn">
                            <?php echo esc_html( plh_t('Bedrooms') ); ?>
                            </button>
                            <div id="acc1" class="acc-panel" role="region" aria-labelledby="acc1-btn" hidden>
                            <div class="villa-features-category"><?php echo plh_render_bedroom_descriptions(get_the_ID(), 12); ?></div>
                            </div>
                        </div>

                        <div class="acc-item">
                            <button class="acc-trigger" aria-expanded="false" aria-controls="acc2" id="acc2-btn">
                            <?php echo esc_html( plh_t('Features and Amenities') ); ?>
                            </button>
                            <div id="acc2" class="acc-panel" role="region" aria-labelledby="acc2-btn" hidden>
                                <?php get_template_part('partials/features-amenities', null, [
                                    'post_id' => get_the_ID(),
                                ]); ?>
                            </div>

                        </div>
                        <div class="acc-item">
                            <button class="acc-trigger" aria-expanded="false" aria-controls="acc3" id="acc3-btn">
                            <?php echo esc_html( plh_t("What's Included") ); ?>
                            </button>
                            <div id="acc3" class="acc-panel" role="region" aria-labelledby="acc3-btn" hidden>
                                <?php plh_render_included_excluded_rows2(get_the_ID(), 12); ?>
                            </div>

                        </div>
                        <div class="acc-item">
                            <button class="acc-trigger" aria-expanded="false" aria-controls="acc4" id="acc4-btn">
                            <?php echo esc_html( plh_t('Additional Informations') ); ?>
                            </button>
                            <div id="acc4" class="acc-panel" role="region" aria-labelledby="acc4-btn" hidden>
                                <div class="villa-features">
                                    <div class="villa-features left">
                                        <div class="check-in-out">
                                            <div class="check-in">
                                                <img src="/wp-content/uploads/2025/11/Check-inout.png">
                                                <div class="check-in-des">
                                                    <h4><?php echo esc_html( plh_t('Check in') ); ?></h4>
                                                    <p><?php echo esc_html( plh_booking_text('check_in_time', '4pm - 10pm') ); ?></p>

                                                </div>
                                            </div>
                                            <div class="check-out">
                                                <img src="/wp-content/uploads/2025/11/Check-inout.png">
                                                <div class="check-in-des">
                                                    <h4><?php echo esc_html( plh_t('Check out') ); ?></h4>
                                                    <p><?php echo esc_html( plh_booking_text('check_out_time', '10am') ); ?></p>

                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="minimum-stay"><?php echo esc_html( plh_t('Minimum stay') ); ?></h3>
                                        <div class="check-in">
                                            <img src="/wp-content/uploads/2025/11/Basse-saison.png">
                                            <div class="check-in-des">
                                                <h4><?php echo esc_html( plh_t('Low season:') ); ?> <?php echo esc_html( plh_booking_text('low_season_nights', '4 nights') ); ?></h4>
                                                <p><?php echo esc_html( plh_booking_text('low_season_months', 'April, May, September, October') ); ?></p>

                                            </div>
                                        </div>
                                        <div class="check-in">
                                            <img src="/wp-content/uploads/2025/11/Haute-saison.png">
                                            <div class="check-in-des">
                                                <h4><?php echo esc_html( plh_t('High season:') ); ?> <?php echo esc_html( plh_booking_text('high_season_nights', '5 nights') ); ?></h4>
                                                <p><?php echo esc_html( plh_booking_text('high_season_months', 'June, July, August') ); ?></p>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="villa-features right">
                                        <h3><?php echo esc_html( plh_t('Booking Confirmation') ); ?></h3>
                                        <p><?php echo esc_html( plh_booking_text('booking_policy_1', 'A 50% deposit is required upon booking confirmation, along with the signed rental agrrement.') ); ?></p>
                                        <p><?php echo esc_html( plh_booking_text('booking_policy_2', 'The remaining 50% balance is due 30 days prior to arrival (a payment link will be sent 35 days before arrival).') ); ?></p>
                                        <p><?php echo esc_html( plh_booking_text('booking_policy_3', 'A bank imprint will be taken on your account as a security deposit on the day of check-in. It will be autimatically released within 15 days after your stay, provided no damages are found.') ); ?></p>
                                        <h3><?php echo esc_html( plh_t('Cancellation Policy') ); ?></h3>
                                        <p><?php echo esc_html( plh_booking_text('cancellation_policy', 'Deposits and payments are non-refundable') ); ?></p>
                                        <p class="cis_number"><?php echo esc_html( get_field('cis_number') ); ?></p>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>


                </div>
                <div class="booking-box mobile">
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo esc_html( plh_booking_text('booking_intro', 'Book now to secure your dates in this exceptional villa.') ); ?></p>
                        <div class="book-cta">
                            <a href="<?php echo esc_url( plh_booking_text('booking_button_url', 'https://www.google.com/search?q=puglia+luxury+homes') ); ?>" target="_blank" rel="noopener" class="book-box">
                                <?php echo esc_html( plh_booking_text('booking_button_text', 'Book your stay') ); ?>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                        <p><?php echo esc_html( plh_booking_text('booking_subtext', 'Submit your request and our team will get back to you shortly, no strings attached.') ); ?></p>
                        <?php
                        // Show booking status messages
                        if ( isset($_GET['booking_status']) && $_GET['booking_status'] === 'success' ) {
                            echo '<div class="booking-alert success">'.esc_html__('Your enquiry has been sent. We will contact you shortly.', 'thinktech').'</div>';
                        } elseif ( isset($_GET['booking_error']) ) {
                            echo '<div class="booking-alert error">'.esc_html($_GET['booking_error']).'</div>';
                        }
                        ?>
                        <form class="villa-booking-form" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                            <?php wp_nonce_field('plh_booking_request','plh_booking_nonce'); ?>
                            <input type="hidden" name="action" value="plh_booking_request">
                            <input type="hidden" name="villa_id" value="<?php echo esc_attr(get_the_ID()); ?>">
                            <div class="form-row">
                                <label for="plh_name"><?php echo esc_html( plh_booking_text('booking_label_name', 'Name') ); ?> *</label>
                                <input type="text" id="plh_name" name="plh_name" required>
                            </div>
                            <div class="form-row">
                                <label for="plh_email"><?php echo esc_html( plh_booking_text('booking_label_email', 'Email') ); ?> *</label>
                                <input type="email" id="plh_email" name="plh_email" required>
                            </div>
                            <div class="form-row two">
                                <div>
                                    <label for="plh_date_in"><?php echo esc_html( plh_booking_text('booking_label_arrival', 'Arrival') ); ?> *</label>
                                    <input type="date" id="plh_date_in" name="plh_date_in" required>
                                </div>
                                <div>
                                    <label for="plh_date_out"><?php echo esc_html( plh_booking_text('booking_label_departure', 'Departure') ); ?> *</label>
                                    <input type="date" id="plh_date_out" name="plh_date_out" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <label for="plh_message"><?php echo esc_html( plh_booking_text('booking_label_comment', 'Comment / Requirements') ); ?></label>
                                <textarea id="plh_message" name="plh_message" rows="4" placeholder="<?php echo esc_attr( plh_booking_text('booking_placeholder_comment', 'Tell us about your plans') ); ?>"></textarea>
                            </div>
                            <!-- Honeypot field -->
                            <div style="display:none;">
                                <label for="plh_website"><?php echo esc_html( plh_t('Website') ); ?></label>
                                <input type="text" id="plh_website" name="plh_website" autocomplete="off">
                            </div>
                            <button type="submit" class="booking-submit"><?php echo esc_html( plh_booking_text('booking_submit_text', 'Send Request') ); ?></button>
                            <p class="booking-disclaimer"><?php echo esc_html( plh_booking_text('booking_disclaimer', 'By submitting you agree to be contacted regarding this enquiry.') ); ?></p>
                        </form>

                    </div>
                <section class="villa-location">
                    <h2 class="must-have-title"><?php echo esc_html( plh_t('Location') ); ?></h2>
                    <?php
                        $pid     = get_the_ID();
                        $lat     = trim((string) get_field('villa_lat', $pid));
                        $lng     = trim((string) get_field('villa_lng', $pid));
                        $addr    = (string) get_field('villa_address', $pid);
                        $map_id  = 'villa-map-' . $pid;
                        ?>
                        <div class="villa-map-wrap">
                        <div id="<?php echo esc_attr($map_id); ?>"
                            class="villa-map"
                            data-lat="<?php echo esc_attr($lat); ?>"
                            data-lng="<?php echo esc_attr($lng); ?>"
                            data-popup="<?php echo esc_attr($addr ?: get_the_title()); ?>">
                        </div>
                        <noscript>
                            <p><a target="_blank" rel="noopener" href="<?php
                            echo esc_url('https://www.google.com/maps/search/?api=1&query=' . rawurlencode($addr ?: ($lat . ',' . $lng)));
                                ?>"><?php echo esc_html( plh_t('Open in Google Maps') ); ?></a></p>
                        </noscript>
                    </div>
                </section>
                
                    
                




            </div>
            <div class="villa-content-right">
                <div class="booking-box">
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo esc_html( plh_booking_text('booking_intro', 'Book now to secure your dates in this exceptional villa.') ); ?></p>
                    <div class="book-cta">
                        <a href="<?php echo esc_url( plh_booking_text('booking_button_url', 'https://www.google.com/search?q=puglia+luxury+homes') ); ?>" target="_blank" rel="noopener" class="book-box">
                            <?php echo esc_html( plh_booking_text('booking_button_text', 'Book your stay') ); ?>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                    <p><?php echo esc_html( plh_booking_text('booking_subtext', 'Submit your request and our team will get back to you shortly, no strings attached.') ); ?></p>
                    <?php
                    // Show booking status messages
                    if ( isset($_GET['booking_status']) && $_GET['booking_status'] === 'success' ) {
                        echo '<div class="booking-alert success">'.esc_html__('Your enquiry has been sent. We will contact you shortly.', 'thinktech').'</div>';
                    } elseif ( isset($_GET['booking_error']) ) {
                        echo '<div class="booking-alert error">'.esc_html($_GET['booking_error']).'</div>';
                    }
                    ?>
                    <form class="villa-booking-form" method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                        <?php wp_nonce_field('plh_booking_request','plh_booking_nonce'); ?>
                        <input type="hidden" name="action" value="plh_booking_request">
                        <input type="hidden" name="villa_id" value="<?php echo esc_attr(get_the_ID()); ?>">
                        <div class="form-row">
                            <label for="plh_name"><?php echo esc_html( plh_booking_text('booking_label_name', 'Name') ); ?> *</label>
                            <input type="text" id="plh_name" name="plh_name" required>
                        </div>
                        <div class="form-row">
                            <label for="plh_email"><?php echo esc_html( plh_booking_text('booking_label_email', 'Email') ); ?> *</label>
                            <input type="email" id="plh_email" name="plh_email" required>
                        </div>
                        <div class="form-row two">
                            <div>
                                <label for="plh_date_in"><?php echo esc_html( plh_booking_text('booking_label_arrival', 'Arrival') ); ?> *</label>
                                <input type="date" id="plh_date_in" name="plh_date_in" required>
                            </div>
                            <div>
                                <label for="plh_date_out"><?php echo esc_html( plh_booking_text('booking_label_departure', 'Departure') ); ?> *</label>
                                <input type="date" id="plh_date_out" name="plh_date_out" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <label for="plh_message"><?php echo esc_html( plh_booking_text('booking_label_comment', 'Comment / Requirements') ); ?></label>
                            <textarea id="plh_message" name="plh_message" rows="4" placeholder="<?php echo esc_attr( plh_booking_text('booking_placeholder_comment', 'Tell us about your plans') ); ?>"></textarea>
                        </div>
                        <!-- Honeypot field -->
                        <div style="display:none;">
                            <label for="plh_website"><?php echo esc_html( plh_t('Website') ); ?></label>
                            <input type="text" id="plh_website" name="plh_website" autocomplete="off">
                        </div>
                        <button type="submit" class="booking-submit"><?php echo esc_html( plh_booking_text('booking_submit_text', 'Send Request') ); ?></button>
                        <p class="booking-disclaimer"><?php echo esc_html( plh_booking_text('booking_disclaimer', 'By submitting you agree to be contacted regarding this enquiry.') ); ?></p>
                    </form>

                </div>
            </div>
        </section>
        <div id="experiences">
            <section class="central-title">
                <?php
                // Get current language for Polylang
                $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'en';
                $option_key = 'discover_settings_' . $current_lang;
                
                // Get region section content from settings
                $region_title = get_option($option_key . '_region_title', 'Take a glance <br>at the region');
                $region_description = get_option($option_key . '_region_description', 'As a short-term rental management specialists in Salento, we assist our property owners with the management of their assets. From creating listings to revenue management and concierge services, our team takes care of your rental from the outset to completion.');
                ?>
                <h2><?php echo wp_kses_post($region_title); ?></h2>
                <p><?php echo esc_html($region_description); ?></p>
            </section>
            <?php get_template_part('partials/discover-section'); ?>
            <?php get_template_part('partials/discover-slider'); ?>
        </div>
        <?php get_template_part('partials/google-reviews', null, ['post_id' => get_the_ID()]); ?>
    </article>
    <div class="send-enquiry">
    <p><?php echo esc_html( plh_booking_text('mobile_price_text', 'From EUR 12,200 per week') ); ?></p>
    <a href="<?php echo esc_url( plh_booking_text('mobile_banner_button_url', '#') ); ?>"><?php echo esc_html( plh_booking_text('mobile_banner_button_text', 'Send Enquiry') ); ?></a>

    </div>
</div>

<?php endwhile; endif; get_footer(); ?>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const readMoreBtn = document.getElementById("readMoreBtn");
        const textContainer = document.querySelector(".text-container");

        readMoreBtn.addEventListener("click", function() {
            const isExpanded = textContainer.classList.toggle("expanded");
            readMoreBtn.classList.toggle("active");
            
            readMoreBtn.innerHTML = isExpanded
                ? '<?php echo esc_html( plh_t("Read less") ); ?> <span>&#9650;</span>'
                : '<?php echo esc_html( plh_t("Read more") ); ?> <span>&#9660;</span>';
            
            // Scroll to a position slightly above the top of the text container when collapsing
            if (!isExpanded) {
                const containerPosition = textContainer.getBoundingClientRect().top + window.scrollY;
                const offset = 20; // Adjust this value to scroll a bit more above the container
                window.scrollTo({
                    top: containerPosition - offset,
                    behavior: 'smooth'
                });
            }
        });
    });

</script>

<script>
document.addEventListener('click', (e) => {
  const btn = e.target.closest('.acc [aria-controls]');
  if (!btn) return;

  const panel = document.getElementById(btn.getAttribute('aria-controls'));
  const expanded = btn.getAttribute('aria-expanded') === 'true';

  // if data-single on container, close others
  const container = btn.closest('[data-accordion]');
  const single = container?.hasAttribute('data-single');

  if (single) {
    container.querySelectorAll('.acc-trigger[aria-expanded="true"]').forEach(b => {
      if (b !== btn) {
        b.setAttribute('aria-expanded', 'false');
        const p = document.getElementById(b.getAttribute('aria-controls'));
        if (p) p.hidden = true;
      }
    });
  }

  btn.setAttribute('aria-expanded', String(!expanded));
  panel.hidden = expanded;

  if (!expanded) {
    btn.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
});
</script>

<script>
        window.addEventListener('scroll', function() {
            const enquiryBar = document.querySelector('.send-enquiry');
            if (window.scrollY > 300) { // Appears after 300px scroll
                enquiryBar.classList.add('show');
            } else {
                enquiryBar.classList.remove('show');
            }
        });
</script>


<script>
// Scrollspy underline for villa-page-menu
document.addEventListener('DOMContentLoaded', function() {
    const menu = document.querySelector('.villa-page-menu');
    if (!menu) return;

    const links = Array.from(menu.querySelectorAll('a[href^="#"]'));
    if (!links.length) return;

    const pairs = links.map(link => {
        const id = decodeURIComponent(link.getAttribute('href') || '').slice(1);
        const section = id ? document.getElementById(id) : null;
        return section ? { link, section } : null;
    }).filter(Boolean);

    // Smooth scroll with offset for in-page links
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href') || '';
            if (!href.startsWith('#')) return; // skip external links
            const id = href.slice(1);
            const target = document.getElementById(id);
            if (!target) return;
            e.preventDefault();

            const rootStyles = getComputedStyle(document.documentElement);
            const headerH = parseInt(rootStyles.getPropertyValue('--header-height')) || 70;
            const menuH = menu.offsetHeight || 0;
            const offset = headerH + menuH + 8; // breathing space
            const y = target.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({ top: y, behavior: 'smooth' });
        });
    });

    if (!pairs.length) return;

    let currentActive = null;
    const rootStyles = getComputedStyle(document.documentElement);
    const headerH = parseInt(rootStyles.getPropertyValue('--header-height')) || 70;
    const menuH = (menu && menu.offsetHeight) || 0;
    const topOffset = headerH + menuH + 10;

    const observer = new IntersectionObserver((entries) => {
        // Sort by intersection ratio to favor the most visible
        const visible = entries
            .filter(en => en.isIntersecting)
            .sort((a,b) => b.intersectionRatio - a.intersectionRatio);

        if (!visible.length) return;

        const topMost = visible[0].target;
        const match = pairs.find(p => p.section === topMost);
        if (!match) return;

        if (currentActive && currentActive !== match.link) {
            currentActive.classList.remove('is-active');
        }
        match.link.classList.add('is-active');
        currentActive = match.link;
    }, {
        root: null,
        rootMargin: `-${topOffset}px 0px -60% 0px`,
        threshold: [0.1, 0.25, 0.5, 0.75, 1]
    });

    pairs.forEach(({ section }) => observer.observe(section));

    // Set initial state on load (in case the page loads mid-way)
    const setInitial = () => {
        let best = null;
        let bestDist = Infinity;
        pairs.forEach(({ section, link }) => {
            const rect = section.getBoundingClientRect();
            const dist = Math.abs(rect.top - topOffset);
            if (dist < bestDist) { bestDist = dist; best = link; }
        });
        if (best) {
            best.classList.add('is-active');
            currentActive = best;
        }
    };
    setInitial();
});

// Villa menu scroll arrows functionality
document.addEventListener('DOMContentLoaded', function() {
    const menuContainer = document.querySelector('.villa-page-menu-container-1');
    const leftArrow = document.querySelector('.villa-menu-scroll-left');
    const rightArrow = document.querySelector('.villa-menu-scroll-right');
    
    if (!menuContainer || !leftArrow || !rightArrow) return;
    
    function updateArrows() {
        const scrollLeft = menuContainer.scrollLeft;
        const maxScroll = menuContainer.scrollWidth - menuContainer.clientWidth;
        
        // Hide left arrow at start
        if (scrollLeft <= 10) {
            leftArrow.classList.add('hidden');
        } else {
            leftArrow.classList.remove('hidden');
        }
        
        // Hide right arrow at end
        if (scrollLeft >= maxScroll - 10) {
            rightArrow.classList.add('hidden');
        } else {
            rightArrow.classList.remove('hidden');
        }
    }
    
    // Scroll left
    leftArrow.addEventListener('click', function() {
        menuContainer.scrollBy({ left: -150, behavior: 'smooth' });
    });
    
    // Scroll right
    rightArrow.addEventListener('click', function() {
        menuContainer.scrollBy({ left: 150, behavior: 'smooth' });
    });
    
    // Update arrows on scroll
    menuContainer.addEventListener('scroll', updateArrows);
    
    // Initial update
    updateArrows();
});
</script>

<script>
// Hide villa-page-menu when reaching footer on mobile
document.addEventListener('DOMContentLoaded', function() {
    const villaMenu = document.querySelector('.villa-page-menu');
    const footer = document.querySelector('.site-footer');
    
    if (!villaMenu || !footer) return;
    
    function handleMenuVisibility() {
        const footerRect = footer.getBoundingClientRect();
        const menuRect = villaMenu.getBoundingClientRect();
        
        // Add 100px buffer to trigger fade before footer reaches menu
        const buffer = 200;
        
        if (footerRect.top <= menuRect.bottom + buffer) {
            villaMenu.style.opacity = '0';
            villaMenu.style.pointerEvents = 'none';
        } else {
            villaMenu.style.opacity = '1';
            villaMenu.style.pointerEvents = 'auto';
        }
    }
    
    window.addEventListener('scroll', handleMenuVisibility);
    handleMenuVisibility(); // Initial check
});
</script>

<!-- Info Icon Modal -->
<div id="infoModal" class="info-modal">
    <div class="info-modal-content">
        <button class="info-modal-close">&times;</button>
        <img id="infoModalImage" src="" alt="Information">
    </div>
</div>

<script>
// Info icon modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('infoModal');
    const modalImage = document.getElementById('infoModalImage');
    const closeBtn = document.querySelector('.info-modal-close');
    const infoIcons = document.querySelectorAll('.info-icon');

    if (!modal || !infoIcons.length) return;

    infoIcons.forEach(icon => {
        icon.addEventListener('click', function(e) {
            e.preventDefault();
            const imageUrl = this.getAttribute('data-modal-image');
            if (imageUrl) {
                modalImage.src = imageUrl;
                modal.classList.add('active');
            }
        });
    });

    closeBtn.addEventListener('click', function() {
        modal.classList.remove('active');
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modal.classList.remove('active');
        }
    });
});
</script>





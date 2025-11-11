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
                <div class="villa-page-menu-container-1">
                    <ul>
                        <li><a href="">Must have</a></li>
                        <li><a href="">Description</a></li>
                        <li><a href="">Experiences</a></li>
                        <li><a href="">Avis</a></li>
                        <li><a href="<?php echo esc_url( plh_villa_gallery_link(get_the_ID()) ); ?>">Photo</a></li>
                    </ul>
                </div>
                <div class="villa-page-menu-container-2"></div>
            </div>
        </div>
        <section class="villa-content">
            <div class="villa-content-left">
                <div class="villa-kpis">
                    <div class="single-kpi">
                        <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/Bedrooms.png">
                        <p><?php echo esc_html($bedrooms); ?> Bedrooms</p>
                    </div>
                    <div class="single-kpi">
                        <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/SDB.png">
                        <p><?php echo esc_html($bathrooms); ?> bathrooms</p>
                    </div>
                    <div class="single-kpi">
                        <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/bagage.png">
                        <p><?php echo esc_html($guests); ?> guests</p>
                    </div>
                    <div class="single-kpi">
                        <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/m2.png">
                        <p><?php echo esc_html($sqm); ?> sqm</p>
                    </div>
                    <div class="single-kpi rameaux">
                        <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/Rameaux.png">
                        <p><?php echo esc_html($rameaux); ?></p>
                    </div>
                </div>
                <div class="villa-divider"></div>
                <p><?php echo wp_kses_post($intro_paragrph); ?></p>
                <div class="text-container">
                    <p><?php echo wp_kses_post($read_more); ?></p>
                    <button id="readMoreBtn">Read more <span>&#9660;</span></button>
                </div>
                <div class="villa-divider margined"></div>
                
                <h2 class="must-have-title">Must Have</h2>
                <div class="must-have">
                    <div class="must-have-list">
                        <?php 
                        $must_have_1 = get_field('must_have_1');
                        if ($must_have_1 !== ''): ?>
                        <div class="must-have-row">
                            <i class="fa-regular fa-circle-check" style="color: #90b0b7;"></i>
                            <p><?php echo esc_html($must_have_1); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php 
                        $must_have_1 = get_field('must_have_1');
                        if ($must_have_1 !== ''): ?>
                        <div class="must-have-row">
                            <i class="fa-regular fa-circle-check" style="color: #90b0b7;"></i>
                            <p><?php echo esc_html($must_have_1); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="must-have-list">
                        <?php 
                        $must_have_1 = get_field('must_have_1');
                        if ($must_have_1 !== ''): ?>
                        <div class="must-have-row">
                            <i class="fa-regular fa-circle-check" style="color: #90b0b7;"></i>
                            <p><?php echo esc_html($must_have_1); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php 
                        $must_have_1 = get_field('must_have_1');
                        if ($must_have_1 !== ''): ?>
                        <div class="must-have-row">
                            <i class="fa-regular fa-circle-check" style="color: #90b0b7;"></i>
                            <p><?php echo esc_html($must_have_1); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <section class="acc" data-accordion data-single>
                        <div class="acc-item">
                            <button class="acc-trigger" aria-expanded="false" aria-controls="acc1" id="acc1-btn">
                            Bedrooms
                            </button>
                            <div id="acc1" class="acc-panel" role="region" aria-labelledby="acc1-btn" hidden>
                            <p class="bedroom-text">Bedroom 1: Flexible bed (180/90 x 200cm), private bathroom. <br>
                            Bedroom 2: Flexible bed (180/90 x 200cm), private bathroom. <br>
                            Bedroom 3: Flexible bed (180/90 x 200cm), private bathroom. <br>
                            Bedroom 4: Flexible bed (180/90 x 200cm), private bathroom.</p>
                            </div>
                        </div>

                        <div class="acc-item">
                            <button class="acc-trigger" aria-expanded="false" aria-controls="acc2" id="acc2-btn">
                            Features and Amenities
                            </button>
                            <div id="acc2" class="acc-panel" role="region" aria-labelledby="acc2-btn" hidden>
                                <?php get_template_part('partials/features-amenities', null, [
                                    'post_id' => get_the_ID(),
                                ]); ?>
                            </div>

                        </div>
                        <div class="acc-item">
                            <button class="acc-trigger" aria-expanded="false" aria-controls="acc3" id="acc3-btn">
                            What's Included
                            </button>
                            <div id="acc3" class="acc-panel" role="region" aria-labelledby="acc3-btn" hidden>
                                <?php plh_render_included_excluded_rows2(get_the_ID(), 12); ?>
                            </div>

                        </div>
                        <div class="acc-item">
                            <button class="acc-trigger" aria-expanded="false" aria-controls="acc4" id="acc4-btn">
                            Additional Informations
                            </button>
                            <div id="acc4" class="acc-panel" role="region" aria-labelledby="acc4-btn" hidden>
                                <div class="villa-features">
                                    <div class="villa-features left">
                                        <div class="check-in-out">
                                            <div class="check-in">
                                                <i class="fa-regular fa-calendar"></i>
                                                <div class="check-in-des">
                                                    <h4>Check in</h4>
                                                    <p>4pm - 10pm</p>

                                                </div>
                                            </div>
                                            <div class="check-out">
                                                <i class="fa-regular fa-calendar"></i>
                                                <div class="check-in-des">
                                                    <h4>Check out</h4>
                                                    <p>10am</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="villa-features row2">
                                            <i class="fa-regular fa-circle-check" style="color: #90b0b7;"></i>
                                            <p>Child friendly</p>

                                        </div>
                                        <div class="villa-features row2">
                                            <i class="fa-regular fa-circle-xmark" style="color: #90b0b7;"></i>
                                            <p>Not suitable for people with reduced mobility</p>
                                            
                                        </div>
                                        <h4 class="minimum-stay">Minimum stay</h4>
                                        <div class="check-in">
                                            <i class="fa-solid fa-snowflake"></i>
                                            <div class="check-in-des">
                                                <h4>Low season: 4 nights</h4>
                                                <p>April, May, September, October</p>

                                            </div>
                                        </div>
                                        <div class="check-in">
                                            <i class="fa-solid fa-sun"></i>
                                            <div class="check-in-des">
                                                <h4>High season: 5 nights</h4>
                                                <p>June, July, August</p>

                                            </div>
                                        </div>

                                    </div>
                                    <div class="villa-features right">
                                        <h4>Booking Confirmation</h4>
                                        <p>A 50% deposit is required upon booking confirmation, along with the signed rental agrrement.<br>
                                        The remaining 50% balance is due 30 days prior to arrival (a payment link will be sent 35 days before arrival).<br>
                                        A bank imprint will be taken on your account as a security deposit on the day of check-in. It will be autimatically released within 15 days after your stay, provided no damages are found.
                                        </p>
                                        <h4>Cancellation Policy</h4>
                                        <p>Deposits and payments are non-refundable</p>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>


                </div>
                <section class="villa-location">
                    <h2 class="must-have-title">Location</h2>
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
                            ?>">Open in Google Maps</a></p>
                        </noscript>
                    </div>
                </section>




            </div>
            <div class="villa-content-right">
                <div class="booking-box">
                    <?php the_title(); ?>
                    <p>Some random content about the villa I dont know about</p>
                    <h2>Add dates to view exact prices</h2>
                    <p>Want to check if your dates are available?
        Send us a quick enquiry - no strings attached.</p>
                    <button>Send Enquiry</button>

                </div>
            </div>
        </section>
        <section class="central-title">
            <h2>Take a glance <br>at the region</h2>
            <p>As a short-term rental management specialists in Salento, we assist our property owners with the management
                of their assets. From creating listings to revenue management and concierge services, our team takes care of your rental
                from the outset to completion.</p>
        </section>
        <?php get_template_part('partials/discover-section'); ?>
        <?php get_template_part('partials/discover-slider'); ?>
    </article>
    <div class="send-enquiry">
        <p>From EUR 12,200 per week</p>
        <a href="">Send Enquiry</a>

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
                ? 'Read less <span>&#9650;</span>'
                : 'Read more <span>&#9660;</span>';
            
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



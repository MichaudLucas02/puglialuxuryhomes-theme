<?php
/*
 * Template Name: Press / TV
 */
get_header();

$lang        = function_exists('pll_current_language') ? pll_current_language() : 'en';
$lang_prefix = $lang !== 'en' ? '/' . $lang : '';
$villa_slug  = $lang === 'it' ? 'ville' : 'villas';
$villa_url   = home_url($lang_prefix . '/' . $villa_slug . '/villa-acquamarina/');
$story_slugs = [
    'en' => '/our-story/',
    'fr' => '/fr/notre-histoire/',
    'it' => '/it/la-nostra-storia/',
];
$story_url = home_url($story_slugs[$lang] ?? '/our-story/');

$press_kits = [
    'en' => site_url('/wp-content/uploads/2026/07/PRESS-KIT-PLH-EN.pdf'),
    'fr' => site_url('/wp-content/uploads/2026/07/PRESS-KIT-PLH-FR.pdf'),
    'it' => site_url('/wp-content/uploads/2026/07/PRESS-KIT-PLH-IT.pdf'),
];
?>

<section class="large-hero press-hero">
    <img
        src="https://www.puglialuxuryhomes.com/wp-content/uploads/2025/02/Jardin-3-scaled.webp"
        alt="Villa Acquamarina — Puglia Luxury Homes"
        loading="eager"
    >
    <div class="press-hero-content">
        <p class="press-hero-eyebrow">L'agence · Nouvelles destinations</p>
        <h1>Puglia Luxury Homes</h1>
        <p class="press-hero-sub"><?php echo esc_html(plh_t('Soon on television')); ?></p>
        <div class="press-hero-broadcast">
            <span>TMC</span>
            <span class="press-hero-dot">·</span>
            <span>22 July 2026</span>
            <span class="press-hero-dot">·</span>
            <span>9:00pm</span>
            <span class="press-hero-dot">·</span>
            <span>TF1+</span>
        </div>
        <a href="#press-contact" class="press-hero-cta"><?php echo esc_html(plh_t('Book your stay in Puglia')); ?></a>
    </div>
</section>

<div class="homepage press-page">

    <section class="our-story-content">
        <div class="our-story-col press-slider-col">
            <!-- Replace src values with actual Villa Acquamarina photos when available -->
            <div class="swiper press-villa-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="https://www.puglialuxuryhomes.com/wp-content/uploads/2025/02/Jardin-3-scaled.webp" alt="Villa Acquamarina" loading="eager">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://www.puglialuxuryhomes.com/wp-content/uploads/2023/12/les-3-fondateurs-scaled.webp" alt="Villa Acquamarina" loading="lazy">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://www.puglialuxuryhomes.com/wp-content/uploads/2025/02/Jardin-3-scaled.webp" alt="Villa Acquamarina" loading="lazy">
                    </div>
                    <div class="swiper-slide">
                        <img src="https://www.puglialuxuryhomes.com/wp-content/uploads/2023/12/les-3-fondateurs-scaled.webp" alt="Villa Acquamarina" loading="lazy">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
        <div class="our-story-col">
            <h4><?php echo esc_html(plh_t('Featured in the episode')); ?></h4>
            <h2>Villa Acquamarina</h2>
            <p class="press-body"><?php echo esc_html(plh_t('The very first villa to join our portfolio, Villa Acquamarina sits perched above the turquoise waters of Salento — the place that sparked the entire Puglia Luxury Homes adventure.')); ?></p>
            <p class="press-body"><?php echo esc_html(plh_t('In this episode, our team organises an exclusive private boat excursion departing from the villa, exploring the hidden sea caves and crystal-clear bays of the Salento coast.')); ?></p>
            <a href="<?php echo esc_url($villa_url); ?>" class="discover-services-btn">
                <?php echo esc_html(plh_t('Discover the villa')); ?>
            </a>
        </div>
    </section>

    <section class="our-story-content grey">
        <div class="our-story-col">
            <h4><?php echo esc_html(plh_t('Our story')); ?></h4>
            <h2><?php echo esc_html(plh_t('Born in Puglia, for the love of Puglia')); ?></h2>
            <p class="press-body"><?php echo esc_html(plh_t('Puglia Luxury Homes curates an exceptional collection of private villas in Puglia, each paired with a bespoke programme of concierge services — private chefs, boat excursions, wine tastings and more.')); ?></p>
            <p class="press-body"><?php echo esc_html(plh_t('Founded by Sébastien and Augustine, the company was born from a deep love for this corner of southern Italy and a desire to share it with travellers who seek something truly extraordinary.')); ?></p>
            <a href="<?php echo esc_url($story_url); ?>" class="discover-services-btn">
                <?php echo esc_html(plh_t('Our story')); ?>
            </a>
        </div>
        <div class="our-story-col">
            <img
                src="https://www.puglialuxuryhomes.com/wp-content/uploads/2023/12/les-3-fondateurs-scaled.webp"
                alt="<?php echo esc_attr(plh_t('Puglia Luxury Homes founders')); ?>"
                loading="lazy"
            >
        </div>
    </section>

    <section class="press-media-section">
        <div class="press-media-inner">

            <div class="press-media-header">
                <p class="press-eyebrow"><?php echo esc_html(plh_t('Press')); ?></p>
                <h2><?php echo esc_html(plh_t('Press enquiries')); ?></h2>
                <p class="press-media-intro"><?php echo esc_html(plh_t('For interview requests, press assets or media coverage of Puglia Luxury Homes, get in touch with our press contact directly.')); ?></p>
            </div>

            <div class="press-media-body">

                <div class="press-media-contact">
                    <div class="press-person-card">
                        <h3 class="press-person-name">Augustine Jaquet</h3>
                        <p class="press-person-role"><?php echo esc_html(plh_t('Co-founder')); ?></p>
                        <div class="press-person-details">
                            <div class="contact-detail">
                                <span class="label"><?php echo esc_html(plh_t('Call (WhatsApp)')); ?></span>
                                <a href="tel:+393279379067">+39 327 93 79 067</a>
                            </div>
                            <div class="contact-detail">
                                <span class="label">Email</span>
                                <a href="mailto:ajaquet@puglialuxuryhomes.com">ajaquet@puglialuxuryhomes.com</a>
                            </div>
                        </div>
                    </div>

                    <div class="press-kit-block">
                        <p class="press-kit-label"><?php echo esc_html(plh_t('Press kit')); ?></p>
                        <div class="press-kit-links">
                            <a href="<?php echo esc_url($press_kits['en']); ?>" class="press-kit-btn" download>
                                <svg class="press-kit-arrow" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 2v9M4 8l4 4 4-4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 13h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                                <span>English</span>
                            </a>
                            <a href="<?php echo esc_url($press_kits['fr']); ?>" class="press-kit-btn" download>
                                <svg class="press-kit-arrow" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 2v9M4 8l4 4 4-4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 13h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                                <span>Français</span>
                            </a>
                            <a href="<?php echo esc_url($press_kits['it']); ?>" class="press-kit-btn" download>
                                <svg class="press-kit-arrow" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 2v9M4 8l4 4 4-4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 13h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                                <span>Italiano</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="contact-form-card press-enquiry-card">
                    <h4><?php echo esc_html(plh_t('Send a press enquiry')); ?></h4>
                    <?php
                    $pe_status = isset($_GET['press_status']) ? sanitize_text_field($_GET['press_status']) : '';
                    if ($pe_status === 'success') {
                        echo '<div class="form-message success">' . esc_html(plh_t('Thank you — your enquiry has been sent.')) . '</div>';
                    } elseif ($pe_status === 'error') {
                        echo '<div class="form-message error">' . esc_html(plh_t('Something went wrong. Please try again.')) . '</div>';
                    }
                    ?>
                    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="contact-form">
                        <input type="hidden" name="action" value="plh_press_enquiry">
                        <?php wp_nonce_field('plh_press_enquiry', 'plh_press_nonce'); ?>
                        <input type="text" name="press_hp_field" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;opacity:0;height:0;width:0;" aria-hidden="true">

                        <div class="contact-form-grid">
                            <div class="field">
                                <label for="pe_name"><?php echo esc_html(plh_t('Your full name')); ?> *</label>
                                <input type="text" id="pe_name" name="press_name" required>
                            </div>
                            <div class="field">
                                <label for="pe_media"><?php echo esc_html(plh_t('Publication / Media outlet')); ?></label>
                                <input type="text" id="pe_media" name="press_media">
                            </div>
                            <div class="field">
                                <label for="pe_email"><?php echo esc_html(plh_t('Your email')); ?> *</label>
                                <input type="email" id="pe_email" name="press_email" required>
                            </div>
                            <div class="field">
                                <label for="pe_phone"><?php echo esc_html(plh_t('Phone')); ?></label>
                                <input type="tel" id="pe_phone" name="press_phone">
                            </div>
                        </div>

                        <div class="field">
                            <label for="pe_message"><?php echo esc_html(plh_t('Your enquiry')); ?> *</label>
                            <textarea id="pe_message" name="press_message" rows="4" required></textarea>
                        </div>

                        <label class="consent">
                            <input type="checkbox" name="press_consent" value="1" required>
                            <span><?php echo esc_html(plh_t('I agree to be contacted regarding this enquiry.')); ?></span>
                        </label>

                        <button type="submit" class="contact-submit"><?php echo esc_html(plh_t('Submit enquiry')); ?></button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <section id="press-contact" class="press-contact-section">
        <div class="press-contact-inner">
            <div class="press-contact-info">
                <p class="press-eyebrow"><?php echo esc_html(plh_t('Enquire now')); ?></p>
                <h2><?php echo esc_html(plh_t('Book your stay in Puglia')); ?></h2>
                <p class="press-body"><?php echo esc_html(plh_t('Inspired by what you saw? Our team is on hand to help you plan the perfect Puglia escape — whether you are looking to stay at Villa Acquamarina or explore our wider collection.')); ?></p>

                <div class="contact-detail">
                    <span class="label"><?php echo esc_html(plh_t('Call (WhatsApp)')); ?></span>
                    <a href="tel:+393279379067">+39 327 93 79 067</a>
                </div>
                <div class="contact-detail">
                    <span class="label">Email</span>
                    <a href="mailto:reservation@puglialuxuryhomes.com">reservation@puglialuxuryhomes.com</a>
                </div>
            </div>

            <div class="contact-form-card press-enquiry-card">
                <h4><?php echo esc_html(plh_t('Send a message')); ?></h4>
                <?php
                $status = isset($_GET['contact_status']) ? sanitize_text_field($_GET['contact_status']) : '';
                $error  = isset($_GET['contact_error']) ? sanitize_text_field($_GET['contact_error']) : '';
                if ($status === 'success') {
                    echo '<div class="form-message success">' . esc_html(plh_t('Thank you — your message has been sent.')) . '</div>';
                } elseif ($status === 'error') {
                    $msg = $error ? $error : plh_t('Something went wrong. Please try again.');
                    echo '<div class="form-message error">' . esc_html($msg) . '</div>';
                }
                ?>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="contact-form">
                    <input type="hidden" name="action" value="plh_contact_form">
                    <?php wp_nonce_field('plh_contact', 'plh_contact_nonce'); ?>
                    <input type="text" name="contact_hp_field" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;opacity:0;height:0;width:0;" aria-hidden="true">

                    <div class="contact-form-grid">
                        <div class="field">
                            <label for="pc_name"><?php echo esc_html(plh_t('Your full name')); ?> *</label>
                            <input type="text" id="pc_name" name="contact_name" required>
                        </div>
                        <div class="field">
                            <label for="pc_email"><?php echo esc_html(plh_t('Your email')); ?> *</label>
                            <input type="email" id="pc_email" name="contact_email" required>
                        </div>
                        <div class="field">
                            <label for="pc_phone"><?php echo esc_html(plh_t('Phone')); ?></label>
                            <input type="tel" id="pc_phone" name="contact_phone">
                        </div>
                        <div class="field">
                            <label for="pc_subject"><?php echo esc_html(plh_t('Subject')); ?> *</label>
                            <select id="pc_subject" name="contact_subject" required>
                                <option value=""><?php echo esc_html(plh_t('Select a subject')); ?></option>
                                <option value="Booking request"><?php echo esc_html(plh_t('Booking request')); ?></option>
                                <option value="Concierge service"><?php echo esc_html(plh_t('Concierge service')); ?></option>
                                <option value="Other"><?php echo esc_html(plh_t('Other')); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <label for="pc_message"><?php echo esc_html(plh_t('How can we assist you?')); ?> *</label>
                        <textarea id="pc_message" name="contact_message" rows="5" required></textarea>
                    </div>

                    <label class="consent">
                        <input type="checkbox" name="contact_consent" value="1" required>
                        <span><?php echo esc_html(plh_t('I agree to be contacted regarding this enquiry.')); ?></span>
                    </label>

                    <button type="submit" class="contact-submit"><?php echo esc_html(plh_t('Submit enquiry')); ?></button>
                </form>
            </div>
        </div>
    </section>

</div>

<?php
add_action('wp_footer', function () { ?>
<script>
(function () {
    var el = document.querySelector('.press-villa-swiper');
    if (!el || typeof Swiper === 'undefined') return;
    new Swiper(el, {
        cssMode: true,
        loop: true,
        slidesPerView: 1,
        spaceBetween: 0,
        pagination: { el: el.querySelector('.swiper-pagination'), clickable: true },
        navigation: {
            nextEl: el.querySelector('.swiper-button-next'),
            prevEl: el.querySelector('.swiper-button-prev'),
        },
    });
})();
</script>
<?php }, 30);

get_footer(); ?>

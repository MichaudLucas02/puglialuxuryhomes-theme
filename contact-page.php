<?php
/*
 * Template Name: Contact
 */
get_header();
get_template_part('partials/small-hero');
?>

<section class="contact-section">
    <div class="contact-wrapper">
        <div class="contact-info">
            <div class="contact-card">
                <p class="eyebrow">Contact</p>
                <h4>We would love to hear from you</h4>
                <p class="lede">Share your travel plans, ask about our villas, or request concierge services. Our team will respond as quickly as possible, usually within one business day.</p>
                
                <div class="contact-detail">
                    <span class="label">Call (Whatsapp)</span>
                    <a href="tel:+393279379067">+39 327 93 79 067</a>
                </div>
                
                <div class="contact-detail">
                    <span class="label">Email</span>
                    <a href="mailto:reservation@puglialuxuryhomes.com">reservation@puglialuxuryhomes.com</a>
                </div>
            </div>
            
            <div class="contact-card">
                <h4>Visit us</h4>
                <p class="lede">We welcome you by appointment at our offices in Gagliano del Capo, in the heart of Puglia.</p>
                <div class="contact-detail">
                    <span class="label">Hours</span>
                    <p class="detail-text">Mon-Fri 9am - 6pm CET</p>
                </div>
            </div>
            
            <div class="contact-card">
                <h4>For partnerships</h4>
                <p class="lede">For press enquiries, brand partnerships</p>
                <a class="inline-link" href="mailto:reservation@puglialuxuryhomes.com">Email our team</a>
            </div>
            
            <div class="contact-card">
                <h4>For property owners</h4>
                <p class="lede">To submit your property for consideration, please fill out the dedicated form.</p>
                <a class="inline-link" href="<?php echo esc_url(home_url('/property-management')); ?>">Submit your property</a>
            </div>
        </div>

        <div class="contact-form-card">
            <h4>Send a message</h4>
            <?php
            $status = isset($_GET['contact_status']) ? sanitize_text_field($_GET['contact_status']) : '';
            $error  = isset($_GET['contact_error']) ? sanitize_text_field($_GET['contact_error']) : '';
            if ($status === 'success') {
                echo '<div class="form-message success">Thank you — your message has been sent.</div>';
            } elseif ($status === 'error') {
                $msg = $error ? $error : 'Something went wrong. Please try again.';
                echo '<div class="form-message error">' . esc_html($msg) . '</div>';
            }
            ?>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="contact-form">
                <input type="hidden" name="action" value="plh_contact_form">
                <?php wp_nonce_field('plh_contact','plh_contact_nonce'); ?>
                <input type="text" name="contact_hp_field" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;opacity:0;height:0;width:0;" aria-hidden="true">

                <div class="contact-form-grid">
                    <div class="field">
                        <label for="contact_name">Your full name *</label>
                        <input type="text" id="contact_name" name="contact_name" required>
                    </div>
                    <div class="field">
                        <label for="contact_email">Your Email *</label>
                        <input type="email" id="contact_email" name="contact_email" required>
                    </div>
                    <div class="field">
                        <label for="contact_phone">Phone</label>
                        <input type="tel" id="contact_phone" name="contact_phone">
                    </div>
                    <div class="field">
                        <label for="contact_subject">Subject *</label>
                        <select id="contact_subject" name="contact_subject" required>
                            <option value="">Select a subject</option>
                            <option value="Booking request">Booking request</option>
                            <option value="Concierge service">Concierge service</option>
                            <option value="Partnership">Partnership</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="contact_message">How can we assist you? *</label>
                    <textarea id="contact_message" name="contact_message" rows="5" required></textarea>
                </div>

                <label class="consent">
                    <input type="checkbox" name="contact_consent" value="1" required>
                    <span>I agree to be contacted regarding this enquiry *</span>
                </label>

                <button type="submit" class="contact-submit">Submit enquiry</button>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>

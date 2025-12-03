<?php
/*
* Template Name: Property Management 
*/
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<div class="homepage">
    <?php get_template_part('partials/process'); ?>
    
    <!-- Villa Submission Form Section -->
    <section class="villa-submission-section">
        <div class="container">
            <div class="submission-intro">
                <h2>List Your Villa With Us</h2>
                <p>Interested in listing your luxury villa on our platform? Fill out the form below and our team will get back to you shortly.</p>
            </div>
            
            <?php
            // Display success/error messages
            if (isset($_GET['villa_submission'])) {
                if ($_GET['villa_submission'] === 'success') {
                    echo '<div class="form-message success">Thank you! Your villa submission has been received. We will contact you soon.</div>';
                } elseif ($_GET['villa_submission'] === 'error') {
                    $error = isset($_GET['villa_error']) ? urldecode($_GET['villa_error']) : 'An error occurred. Please try again.';
                    echo '<div class="form-message error">' . esc_html($error) . '</div>';
                }
            }
            ?>
            
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="villa-submission-form">
                <input type="hidden" name="action" value="plh_villa_submission">
                <?php wp_nonce_field('plh_villa_submission_nonce', 'plh_villa_submission_nonce'); ?>
                
                <!-- Contact Information Section -->
                <h3 class="form-section-title">Contact Information</h3>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="owner_full_name">Full Name *</label>
                        <input type="text" id="owner_full_name" name="owner_full_name" required>
                    </div>
                    <div class="form-col">
                        <label for="owner_email">Email Address *</label>
                        <input type="email" id="owner_email" name="owner_email" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="owner_phone">Phone Number</label>
                        <input type="tel" id="owner_phone" name="owner_phone">
                    </div>
                    <div class="form-col">
                        <label for="owner_country">Country of Residence</label>
                        <input type="text" id="owner_country" name="owner_country">
                    </div>
                </div>
                
                <!-- Property Details Section -->
                <h3 class="form-section-title">Property Details</h3>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="property_name">Property Name</label>
                        <input type="text" id="property_name" name="property_name">
                    </div>
                    <div class="form-col">
                        <label for="property_location">Property Address / Location *</label>
                        <input type="text" id="property_location" name="property_location" placeholder="Town, area, or coordinates" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="property_type">Type of Property *</label>
                        <select id="property_type" name="property_type" required>
                            <option value="">Select property type</option>
                            <option value="Villa">Villa</option>
                            <option value="Masseria">Masseria</option>
                            <option value="Palazzo">Palazzo</option>
                            <option value="Apartment">Apartment</option>
                            <option value="Trullo">Trullo</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label for="property_bedrooms">Number of Bedrooms *</label>
                        <select id="property_bedrooms" name="property_bedrooms" required>
                            <option value="">Select bedrooms</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="10+">10+</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="property_bathrooms">Number of Bathrooms *</label>
                        <select id="property_bathrooms" name="property_bathrooms" required>
                            <option value="">Select bathrooms</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="10+">10+</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label for="property_size">Approximate Size (m²)</label>
                        <input type="number" id="property_size" name="property_size" min="1">
                    </div>
                </div>
                
                <div class="form-row full-width">
                    <label for="property_features">Main Features / Highlights</label>
                    <textarea id="property_features" name="property_features" rows="3" placeholder="e.g., pool, sea view, garden, etc."></textarea>
                </div>
                
                <div class="form-row full-width">
                    <label for="property_link">Link to your website or Instagram page</label>
                    <input type="url" id="property_link" name="property_link" placeholder="https://">
                </div>
                
                <!-- Management & Collaboration Section -->
                <h3 class="form-section-title">Management & Collaboration</h3>
                
                <div class="form-row full-width">
                    <label for="collaboration_type">What type of collaboration are you interested in? *</label>
                    <select id="collaboration_type" name="collaboration_type" required>
                        <option value="">Select collaboration type</option>
                        <option value="Full management">Full management</option>
                        <option value="Marketing/distribution only">Marketing/distribution only</option>
                    </select>
                </div>
                
                <div class="form-row full-width">
                    <label for="other_agency">Are you currently working with another agency or platform? *</label>
                    <select id="other_agency" name="other_agency" required>
                        <option value="">Select an option</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Unsure">Unsure</option>
                    </select>
                </div>
                
                <div class="form-row full-width">
                    <label for="rental_experience">Have you ever rented out your property? *</label>
                    <select id="rental_experience" name="rental_experience" required>
                        <option value="">Select an option</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Unsure">Unsure</option>
                    </select>
                </div>
                
                <!-- Message Section -->
                <h3 class="form-section-title">Message</h3>
                
                <div class="form-row full-width">
                    <label for="property_message">Tell us more about your property and expectations</label>
                    <textarea id="property_message" name="property_message" rows="5" placeholder="Share any additional details about your property and what you're looking for in a property management partnership"></textarea>
                </div>
                
                <!-- Consent Section -->
                <div class="form-row full-width">
                    <div class="consent-checkbox">
                        <input type="checkbox" id="consent_checkbox" name="consent_checkbox" required>
                        <label for="consent_checkbox">I agree to be contacted by Puglia Luxury Homes regarding property management opportunities. *</label>
                    </div>
                </div>
                
                <!-- Honeypot field -->
                <input type="text" name="villa_hp_field" style="display:none;" tabindex="-1" autocomplete="off">
                
                <div class="form-row">
                    <button type="submit" class="submit-btn">Submit Property</button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php get_footer(); ?>
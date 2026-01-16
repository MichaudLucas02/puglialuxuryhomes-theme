<?php
/*
* Template Name: Property Management FR
*/
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<div class="homepage">
    <?php get_template_part('partials/process'); ?>
    
    <!-- Villa Submission Form Section -->
    <section class="villa-submission-section">
        <div class="container">
            <div class="submission-intro">
                <h2>Listez votre villa avec nous</h2>
                <p>Vous souhaitez inscrire votre villa de luxe sur notre plateforme ? Remplissez le formulaire ci-dessous et notre équipe vous recontactera rapidement.</p>
            </div>
            
            <?php
            // Display success/error messages
            if (isset($_GET['villa_submission'])) {
                if ($_GET['villa_submission'] === 'success') {
                    echo '<div class="form-message success">Merci ! Votre demande a été reçue. Nous vous contacterons prochainement.</div>';
                } elseif ($_GET['villa_submission'] === 'error') {
                    $error = isset($_GET['villa_error']) ? urldecode($_GET['villa_error']) : 'Une erreur s\'est produite. Veuillez réessayer.';
                    echo '<div class="form-message error">' . esc_html($error) . '</div>';
                }
            }
            ?>
            
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="villa-submission-form">
                <input type="hidden" name="action" value="plh_villa_submission">
                <input type="hidden" name="form_language" value="fr">
                <?php wp_nonce_field('plh_villa_submission_nonce', 'plh_villa_submission_nonce'); ?>
                
                <!-- Contact Information Section -->
                <h3 class="form-section-title">Informations de contact</h3>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="owner_full_name">Nom complet *</label>
                        <input type="text" id="owner_full_name" name="owner_full_name" required>
                    </div>
                    <div class="form-col">
                        <label for="owner_email">Adresse e-mail *</label>
                        <input type="email" id="owner_email" name="owner_email" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="owner_phone">Numéro de téléphone</label>
                        <input type="tel" id="owner_phone" name="owner_phone">
                        <small class="field-hint">(optionnel mais recommandé)</small>
                    </div>
                    <div class="form-col">
                        <label for="owner_country">Pays de résidence</label>
                        <input type="text" id="owner_country" name="owner_country">
                    </div>
                </div>
                
                <!-- Property Details Section -->
                <h3 class="form-section-title">Détails de la propriété</h3>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="property_name">Nom de la propriété</label>
                        <input type="text" id="property_name" name="property_name">
                        <small class="field-hint">(le cas échéant)</small>
                    </div>
                    <div class="form-col">
                        <label for="property_location">Adresse / Localisation de la propriété *</label>
                        <input type="text" id="property_location" name="property_location" placeholder="Ville, zone ou coordonnées" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="property_type">Type de propriété *</label>
                        <select id="property_type" name="property_type" required>
                            <option value="">Sélectionnez le type de propriété</option>
                            <option value="Villa">Villa</option>
                            <option value="Masseria">Masseria</option>
                            <option value="Palazzo">Palazzo</option>
                            <option value="Appartement">Appartement</option>
                            <option value="Trullo">Trullo</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label for="property_bedrooms">Nombre de chambres *</label>
                        <select id="property_bedrooms" name="property_bedrooms" required>
                            <option value="">Sélectionnez le nombre de chambres</option>
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
                        <label for="property_bathrooms">Nombre de salles de bain *</label>
                        <select id="property_bathrooms" name="property_bathrooms" required>
                            <option value="">Sélectionnez le nombre de salles de bain</option>
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
                        <label for="property_size">Surface approximative (m²)</label>
                        <input type="number" id="property_size" name="property_size" min="1">
                        <small class="field-hint">(optionnel)</small>
                    </div>
                </div>
                
                <div class="form-row full-width">
                    <label for="property_features">Caractéristiques principales / Points forts</label>
                    <textarea id="property_features" name="property_features" rows="3" placeholder="Piscine, vue mer, jardin, etc."></textarea>
                </div>
                
                <div class="form-row full-width">
                    <label for="property_link">Lien vers votre site web ou page Instagram</label>
                    <input type="url" id="property_link" name="property_link" placeholder="https://">
                    <small class="field-hint">(optionnel mais recommandé)</small>
                </div>
                
                <!-- Management & Collaboration Section -->
                <h3 class="form-section-title">Gestion & Collaboration</h3>
                
                <div class="form-row full-width">
                    <label for="collaboration_type">Quel type de collaboration vous intéresse ? *</label>
                    <select id="collaboration_type" name="collaboration_type" required>
                        <option value="">Sélectionnez le type de collaboration</option>
                        <option value="Gestion complète">Gestion complète</option>
                        <option value="Marketing / distribution uniquement">Marketing / distribution uniquement</option>
                    </select>
                </div>
                
                <div class="form-row full-width">
                    <label for="other_agency">Travaillez-vous actuellement avec une autre agence ou plateforme ? *</label>
                    <select id="other_agency" name="other_agency" required>
                        <option value="">Sélectionnez une option</option>
                        <option value="Oui">Oui</option>
                        <option value="Non">Non</option>
                        <option value="Incertain">Incertain</option>
                    </select>
                </div>
                
                <div class="form-row full-width">
                    <label for="rental_experience">Avez-vous déjà loué votre propriété ? *</label>
                    <select id="rental_experience" name="rental_experience" required>
                        <option value="">Sélectionnez une option</option>
                        <option value="Oui">Oui</option>
                        <option value="Non">Non</option>
                        <option value="Incertain">Incertain</option>
                    </select>
                </div>
                
                <!-- Message Section -->
                <h3 class="form-section-title">Message</h3>
                
                <div class="form-row full-width">
                    <label for="property_message">Parlez-nous davantage de votre propriété et de vos attentes</label>
                    <textarea id="property_message" name="property_message" rows="5" placeholder="Partagez des détails supplémentaires sur votre propriété et ce que vous recherchez dans un partenariat de gestion immobilière"></textarea>
                </div>
                
                <!-- Consent Section -->
                <div class="form-row full-width">
                    <div class="consent-checkbox">
                        <input type="checkbox" id="consent_checkbox" name="consent_checkbox" required>
                        <label for="consent_checkbox">J'accepte d'être contacté(e) par Puglia Luxury Homes concernant des opportunités de gestion de propriété. *</label>
                    </div>
                </div>
                
                <!-- Honeypot field -->
                <input type="text" name="villa_hp_field" style="display:none;" tabindex="-1" autocomplete="off">
                
                <div class="form-row">
                    <button type="submit" class="submit-btn">Soumettre la propriété</button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php get_footer(); ?>

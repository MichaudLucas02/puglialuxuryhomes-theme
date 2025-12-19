<?php
/*
* Template Name: Property Management IT
*/
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<div class="homepage">
    <?php get_template_part('partials/process'); ?>
    
    <!-- Villa Submission Form Section -->
    <section class="villa-submission-section">
        <div class="container">
            <div class="submission-intro">
                <h2>Elenca la tua villa con noi</h2>
                <p>Sei interessato a inserire la tua villa di lusso sulla nostra piattaforma? Compila il modulo qui sotto e il nostro team ti ricontatterà a breve.</p>
            </div>
            
            <?php
            // Display success/error messages
            if (isset($_GET['villa_submission'])) {
                if ($_GET['villa_submission'] === 'success') {
                    echo '<div class="form-message success">Grazie! La tua richiesta è stata ricevuta. Ti contatteremo presto.</div>';
                } elseif ($_GET['villa_submission'] === 'error') {
                    $error = isset($_GET['villa_error']) ? urldecode($_GET['villa_error']) : 'Si è verificato un errore. Riprova.';
                    echo '<div class="form-message error">' . esc_html($error) . '</div>';
                }
            }
            ?>
            
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="villa-submission-form">
                <input type="hidden" name="action" value="plh_villa_submission">
                <input type="hidden" name="form_language" value="it">
                <?php wp_nonce_field('plh_villa_submission_nonce', 'plh_villa_submission_nonce'); ?>
                
                <!-- Contact Information Section -->
                <h3 class="form-section-title">Informazioni di contatto</h3>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="owner_full_name">Nome e cognome *</label>
                        <input type="text" id="owner_full_name" name="owner_full_name" required>
                    </div>
                    <div class="form-col">
                        <label for="owner_email">Indirizzo e-mail *</label>
                        <input type="email" id="owner_email" name="owner_email" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="owner_phone">Numero di telefono</label>
                        <input type="tel" id="owner_phone" name="owner_phone">
                        <small class="field-hint">(facoltativo ma consigliato)</small>
                    </div>
                    <div class="form-col">
                        <label for="owner_country">Paese di residenza</label>
                        <input type="text" id="owner_country" name="owner_country">
                    </div>
                </div>
                
                <!-- Property Details Section -->
                <h3 class="form-section-title">Dettagli della proprietà</h3>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="property_name">Nome della proprietà</label>
                        <input type="text" id="property_name" name="property_name">
                        <small class="field-hint">(se presente)</small>
                    </div>
                    <div class="form-col">
                        <label for="property_location">Indirizzo / Localizzazione della proprietà *</label>
                        <input type="text" id="property_location" name="property_location" placeholder="Città, zona o coordinate" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="property_type">Tipologia di proprietà *</label>
                        <select id="property_type" name="property_type" required>
                            <option value="">Seleziona la tipologia di proprietà</option>
                            <option value="Villa">Villa</option>
                            <option value="Masseria">Masseria</option>
                            <option value="Palazzo">Palazzo</option>
                            <option value="Appartamento">Appartamento</option>
                            <option value="Trullo">Trullo</option>
                            <option value="Altro">Altro</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label for="property_bedrooms">Numero di camere da letto *</label>
                        <select id="property_bedrooms" name="property_bedrooms" required>
                            <option value="">Seleziona il numero di camere</option>
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
                        <label for="property_bathrooms">Numero di bagni *</label>
                        <select id="property_bathrooms" name="property_bathrooms" required>
                            <option value="">Seleziona il numero di bagni</option>
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
                        <label for="property_size">Superficie approssimativa (m²)</label>
                        <input type="number" id="property_size" name="property_size" min="1">
                        <small class="field-hint">(facoltativa)</small>
                    </div>
                </div>
                
                <div class="form-row full-width">
                    <label for="property_features">Caratteristiche principali / Punti di forza</label>
                    <textarea id="property_features" name="property_features" rows="3" placeholder="Piscina, vista mare, giardino, ecc."></textarea>
                </div>
                
                <div class="form-row full-width">
                    <label for="property_link">Link al vostro sito web o pagina Instagram</label>
                    <input type="url" id="property_link" name="property_link" placeholder="https://">
                    <small class="field-hint">(facoltativo ma consigliato)</small>
                </div>
                
                <!-- Management & Collaboration Section -->
                <h3 class="form-section-title">Gestione & Collaborazione</h3>
                
                <div class="form-row full-width">
                    <label for="collaboration_type">Che tipo di collaborazione vi interessa? *</label>
                    <select id="collaboration_type" name="collaboration_type" required>
                        <option value="">Seleziona il tipo di collaborazione</option>
                        <option value="Gestione completa">Gestione completa</option>
                        <option value="Solo marketing / distribuzione">Solo marketing / distribuzione</option>
                    </select>
                </div>
                
                <div class="form-row full-width">
                    <label for="other_agency">State attualmente collaborando con un'altra agenzia o piattaforma? *</label>
                    <select id="other_agency" name="other_agency" required>
                        <option value="">Seleziona un'opzione</option>
                        <option value="Sì">Sì</option>
                        <option value="No">No</option>
                        <option value="Non so">Non so</option>
                    </select>
                </div>
                
                <div class="form-row full-width">
                    <label for="rental_experience">Avete mai affittato la vostra proprietà? *</label>
                    <select id="rental_experience" name="rental_experience" required>
                        <option value="">Seleziona un'opzione</option>
                        <option value="Sì">Sì</option>
                        <option value="No">No</option>
                        <option value="Non so">Non so</option>
                    </select>
                </div>
                
                <!-- Message Section -->
                <h3 class="form-section-title">Messaggio</h3>
                
                <div class="form-row full-width">
                    <label for="property_message">Raccontateci di più sulla vostra proprietà e sulle vostre aspettative</label>
                    <textarea id="property_message" name="property_message" rows="5" placeholder="Condividete maggiori dettagli sulla vostra proprietà e su cosa cercate in una partnership di gestione immobiliare"></textarea>
                </div>
                
                <!-- Consent Section -->
                <div class="form-row full-width">
                    <div class="consent-checkbox">
                        <input type="checkbox" id="consent_checkbox" name="consent_checkbox" required>
                        <label for="consent_checkbox">Acconsento a essere contattato/a da Puglia Luxury Homes in merito a opportunità di gestione immobiliare. *</label>
                    </div>
                </div>
                
                <!-- Honeypot field -->
                <input type="text" name="villa_hp_field" style="display:none;" tabindex="-1" autocomplete="off">
                
                <div class="form-row">
                    <button type="submit" class="submit-btn">Invia la proprietà</button>
                </div>
            </form>
        </div>
    </section>
</div>

<?php get_footer(); ?>

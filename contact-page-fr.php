<?php
/*
 * Template Name: Contact FR
 */
get_header();
get_template_part('partials/small-hero');
?>

<section class="contact-section">
    <div class="contact-wrapper">
        <div class="contact-info">
            <div class="contact-card">
                <p class="eyebrow">Contact</p>
                <h4>Nous serions ravis d'avoir de vos nouvelles.</h4>
                <p class="lede">Partagez vos projets de voyage, posez vos questions sur nos villas ou demandez des services de conciergerie. Notre équipe vous répondra dans les plus brefs délais, généralement sous un jour ouvré.</p>
                
                <div class="contact-detail">
                    <span class="label">Appeler (Whatsapp)</span>
                    <a href="tel:+393279379067">+39 327 93 79 067</a>
                </div>
                
                <div class="contact-detail">
                    <span class="label">Email</span>
                    <a href="mailto:reservation@puglialuxuryhomes.com">reservation@puglialuxuryhomes.com</a>
                </div>
            </div>
            
            <div class="contact-card">
                <h4>Nous rendre visite</h4>
                <p class="lede">Nous vous recevons sur rendez-vous dans nos bureaux à Gagliano del Capo, au cœur des Pouilles.</p>
                <div class="contact-detail">
                    <span class="label">Horaires</span>
                    <p class="detail-text">Du lundi au vendredi, de 9h à 18h (CET)</p>
                </div>
            </div>
            
            <div class="contact-card">
                <h4>Pour les partenariats</h4>
                <p class="lede">Pour les demandes presse et partenariats de marque</p>
                <a class="inline-link" href="mailto:reservation@puglialuxuryhomes.com">Contactez notre équipe par email</a>
            </div>
            
            <div class="contact-card">
                <h4>Pour les propriétaires</h4>
                <p class="lede">Pour soumettre votre propriété à étude, veuillez remplir le formulaire dédié.</p>
                <a class="inline-link" href="<?php echo esc_url(home_url('/fr/gestion-de-bien/')); ?>">Accès au formulaire</a>
            </div>
        </div>

        <div class="contact-form-card">
            <h4>Envoyer un message</h4>
            <?php
            $status = isset($_GET['contact_status']) ? sanitize_text_field($_GET['contact_status']) : '';
            $error  = isset($_GET['contact_error']) ? sanitize_text_field($_GET['contact_error']) : '';
            if ($status === 'success') {
                echo '<div class="form-message success">Merci — votre message a été envoyé.</div>';
            } elseif ($status === 'error') {
                $msg = $error ? $error : 'Une erreur s\'est produite. Veuillez réessayer.';
                echo '<div class="form-message error">' . esc_html($msg) . '</div>';
            }
            ?>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="contact-form">
                <input type="hidden" name="action" value="plh_contact_form">
                <?php wp_nonce_field('plh_contact','plh_contact_nonce'); ?>
                <input type="text" name="contact_hp_field" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;opacity:0;height:0;width:0;" aria-hidden="true">

                <div class="contact-form-grid">
                    <div class="field">
                        <label for="contact_name">Votre nom complet *</label>
                        <input type="text" id="contact_name" name="contact_name" required>
                    </div>
                    <div class="field">
                        <label for="contact_email">Votre email *</label>
                        <input type="email" id="contact_email" name="contact_email" required>
                    </div>
                    <div class="field">
                        <label for="contact_phone">Téléphone</label>
                        <input type="tel" id="contact_phone" name="contact_phone">
                    </div>
                    <div class="field">
                        <label for="contact_subject">Sujet *</label>
                        <select id="contact_subject" name="contact_subject" required>
                            <option value="">Sélectionnez un sujet</option>
                            <option value="Demande de réservation">Demande de réservation</option>
                            <option value="Service de conciergerie">Service de conciergerie</option>
                            <option value="Partenariat">Partenariat</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="contact_message">Comment pouvons-nous vous aider ? *</label>
                    <textarea id="contact_message" name="contact_message" rows="5" required></textarea>
                </div>

                <label class="consent">
                    <input type="checkbox" name="contact_consent" value="1" required>
                    <span>J'accepte d'être contacté(e) concernant cette demande *</span>
                </label>

                <button type="submit" class="contact-submit">Envoyer la demande</button>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>

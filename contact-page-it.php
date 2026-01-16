<?php
/*
 * Template Name: Contact IT
 */
get_header();
get_template_part('partials/small-hero');
?>

<section class="contact-section">
    <div class="contact-wrapper">
        <div class="contact-info">
            <div class="contact-card">
                <p class="eyebrow">Contatti</p>
                <h4>Saremo lieti di ricevere un Suo messaggio.</h4>
                <p class="lede">Condivida i Suoi progetti di viaggio, chieda informazioni sulle nostre ville o sui servizi di concierge. Il nostro team Le risponderà nel più breve tempo possibile, generalmente entro un giorno lavorativo.</p>
                
                <div class="contact-detail">
                    <span class="label">Telefono (Whatsapp)</span>
                    <a href="tel:+393279379067">+39 327 93 79 067</a>
                </div>
                
                <div class="contact-detail">
                    <span class="label">Email</span>
                    <a href="mailto:reservation@puglialuxuryhomes.com">reservation@puglialuxuryhomes.com</a>
                </div>
            </div>
            
            <div class="contact-card">
                <h4>Venga a trovarci</h4>
                <p class="lede">La riceviamo su appuntamento presso i nostri uffici a Gagliano del Capo, nel cuore della Puglia.</p>
                <div class="contact-detail">
                    <span class="label">Orari</span>
                    <p class="detail-text">Dal lunedì al venerdì, dalle 9:00 alle 18:00 (CET)</p>
                </div>
            </div>
            
            <div class="contact-card">
                <h4>Per le partnership</h4>
                <p class="lede">Per richieste stampa e collaborazioni con brand</p>
                <a class="inline-link" href="mailto:reservation@puglialuxuryhomes.com">Contatti il nostro team via email</a>
            </div>
            
            <div class="contact-card">
                <h4>Per i proprietari</h4>
                <p class="lede">Per proporre la Sua proprietà alla nostra valutazione, compili il modulo dedicato.</p>
                <a class="inline-link" href="<?php echo esc_url(home_url('/it/gestionne-immobiliare/')); ?>">Accedi al modulo</a>
            </div>
        </div>

        <div class="contact-form-card">
            <h4>Invia un messaggio</h4>
            <?php
            $status = isset($_GET['contact_status']) ? sanitize_text_field($_GET['contact_status']) : '';
            $error  = isset($_GET['contact_error']) ? sanitize_text_field($_GET['contact_error']) : '';
            if ($status === 'success') {
                echo '<div class="form-message success">Grazie — il Suo messaggio è stato inviato.</div>';
            } elseif ($status === 'error') {
                $msg = $error ? $error : 'Si è verificato un errore. Provi di nuovo.';
                echo '<div class="form-message error">' . esc_html($msg) . '</div>';
            }
            ?>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="contact-form">
                <input type="hidden" name="action" value="plh_contact_form">
                <?php wp_nonce_field('plh_contact','plh_contact_nonce'); ?>
                <input type="text" name="contact_hp_field" autocomplete="off" tabindex="-1" style="position:absolute;left:-9999px;opacity:0;height:0;width:0;" aria-hidden="true">

                <div class="contact-form-grid">
                    <div class="field">
                        <label for="contact_name">Nome e cognome *</label>
                        <input type="text" id="contact_name" name="contact_name" required>
                    </div>
                    <div class="field">
                        <label for="contact_email">Email *</label>
                        <input type="email" id="contact_email" name="contact_email" required>
                    </div>
                    <div class="field">
                        <label for="contact_phone">Telefono</label>
                        <input type="tel" id="contact_phone" name="contact_phone">
                    </div>
                    <div class="field">
                        <label for="contact_subject">Oggetto *</label>
                        <select id="contact_subject" name="contact_subject" required>
                            <option value="">Seleziona un argomento</option>
                            <option value="Richiesta di prenotazione">Richiesta di prenotazione</option>
                            <option value="Servizio concierge">Servizio concierge</option>
                            <option value="Partnership">Partnership</option>
                            <option value="Altro">Altro</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label for="contact_message">Come possiamo aiutarLa ? *</label>
                    <textarea id="contact_message" name="contact_message" rows="5" required></textarea>
                </div>

                <label class="consent">
                    <input type="checkbox" name="contact_consent" value="1" required>
                    <span>Acconsento a essere contattato/a per questa richiesta *</span>
                </label>

                <button type="submit" class="contact-submit">Invia la richiesta</button>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>

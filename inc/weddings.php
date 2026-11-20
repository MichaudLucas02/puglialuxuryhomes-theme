<?php
/**
 * Weddings page (template: weddings.php)
 *
 * - Copy in EN / FR / IT, each text can be overridden per page in the admin
 * - Admin fields for every image (villa photos are used until real ones are added)
 * - Wedding enquiry form handler
 * - One-time creation of the three pages (as drafts, linked in Polylang)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
   Copy. 'admin' => false keeps form labels and messages out of the admin.
   -------------------------------------------------------------------------- */
function plh_wedding_copy() {
  return [
    // Hero
    'hero_eyebrow' => [
      'en' => 'Weddings & celebrations in Puglia',
      'fr' => 'Mariages et célébrations dans les Pouilles',
      'it' => 'Matrimoni e celebrazioni in Puglia',
    ],
    'hero_title' => [
      'en' => 'Say yes in Puglia',
      'fr' => 'Dites oui dans les Pouilles',
      'it' => 'Dite sì in Puglia',
    ],
    'hero_text' => [
      'en' => 'Private villas, masserias and palazzi for the days you will remember all your life.',
      'fr' => 'Villas privées, masserias et palazzi pour les jours dont vous vous souviendrez toute votre vie.',
      'it' => 'Ville private, masserie e palazzi per i giorni che ricorderete per tutta la vita.',
    ],
    'hero_cta' => [
      'en' => 'Plan your wedding',
      'fr' => 'Organiser votre mariage',
      'it' => 'Organizzate il vostro matrimonio',
    ],
    'hero_cta2' => [
      'en' => 'Discover the settings',
      'fr' => 'Découvrir les lieux',
      'it' => 'Scoprite i luoghi',
    ],

    // Intro
    'intro_eyebrow' => [
      'en' => 'A wedding at home',
      'fr' => 'Un mariage comme à la maison',
      'it' => 'Un matrimonio come a casa',
    ],
    'intro_title' => [
      'en' => 'Your wedding, in a house that is yours for the week.',
      'fr' => 'Votre mariage, dans une maison qui est la vôtre le temps d’une semaine.',
      'it' => 'Il vostro matrimonio, in una casa che è vostra per una settimana.',
    ],
    'intro_text' => [
      'type' => 'textarea',
      'en' => 'No banquet hall, no other couple next door, no closing time. Just a private villa, your guests around you and Puglia as the backdrop. We open our most beautiful homes for ceremonies, long dinners under the stars and parties that go on until sunrise, and we organise every detail with the same care as a stay.',
      'fr' => 'Pas de salle de réception, pas d’autre couple à côté, pas d’heure de fermeture. Une villa privée, vos invités autour de vous et les Pouilles en décor. Nous ouvrons nos plus belles maisons pour des cérémonies, de longs dîners sous les étoiles et des fêtes qui durent jusqu’au lever du soleil, et nous organisons chaque détail avec le même soin qu’un séjour.',
      'it' => 'Nessuna sala ricevimenti, nessun’altra coppia accanto, nessun orario di chiusura. Una villa privata, i vostri ospiti intorno a voi e la Puglia come scenario. Apriamo le nostre case più belle per cerimonie, lunghe cene sotto le stelle e feste che durano fino all’alba, e curiamo ogni dettaglio con la stessa attenzione di un soggiorno.',
    ],
    'moments' => [
      'en' => 'Welcome dinner · Ceremony · Wedding dinner · Party · Farewell brunch',
      'fr' => 'Dîner de bienvenue · Cérémonie · Dîner de mariage · Soirée · Brunch du lendemain',
      'it' => 'Cena di benvenuto · Cerimonia · Cena di nozze · Festa · Brunch d’addio',
    ],

    // Settings
    'settings_eyebrow' => [
      'en' => 'Three settings',
      'fr' => 'Trois décors',
      'it' => 'Tre scenari',
    ],
    'settings_title' => [
      'en' => 'Choose your Puglia',
      'fr' => 'Choisissez vos Pouilles',
      'it' => 'Scegliete la vostra Puglia',
    ],
    'setting1_title' => [
      'en' => 'By the sea',
      'fr' => 'Au bord de la mer',
      'it' => 'In riva al mare',
    ],
    'setting1_text' => [
      'type' => 'textarea',
      'en' => 'Terraces above the Adriatic and the Ionian, a ceremony facing the horizon, dinner as the sun sets over the water.',
      'fr' => 'Des terrasses au-dessus de l’Adriatique et de la mer Ionienne, une cérémonie face à l’horizon, un dîner au coucher du soleil sur l’eau.',
      'it' => 'Terrazze sopra l’Adriatico e lo Ionio, una cerimonia di fronte all’orizzonte, la cena mentre il sole tramonta sull’acqua.',
    ],
    'setting2_title' => [
      'en' => 'In the countryside',
      'fr' => 'À la campagne',
      'it' => 'In campagna',
    ],
    'setting2_text' => [
      'type' => 'textarea',
      'en' => 'Masserias and trulli among centuries-old olive trees, long tables in the gardens, and silence all around.',
      'fr' => 'Des masserias et des trulli au milieu des oliviers centenaires, de longues tables dans les jardins, et le silence tout autour.',
      'it' => 'Masserie e trulli tra ulivi secolari, lunghe tavolate nei giardini e il silenzio tutto intorno.',
    ],
    'setting3_title' => [
      'en' => 'In the historic centre',
      'fr' => 'Au cœur des villes historiques',
      'it' => 'Nel centro storico',
    ],
    'setting3_text' => [
      'type' => 'textarea',
      'en' => 'Baroque palazzi and hidden courtyards in the heart of the old towns, for an intimate, elegant celebration.',
      'fr' => 'Des palazzi baroques et des cours cachées au cœur des vieilles villes, pour une célébration intime et élégante.',
      'it' => 'Palazzi barocchi e corti nascoste nel cuore dei centri antichi, per una celebrazione intima ed elegante.',
    ],

    // Quote band
    'quote' => [
      'type' => 'textarea',
      'en' => 'A long table under the olive trees, the sea turning gold, and nothing to think about but each other.',
      'fr' => 'Une longue table sous les oliviers, la mer qui se dore, et rien d’autre à penser que l’un à l’autre.',
      'it' => 'Una lunga tavola sotto gli ulivi, il mare che si fa d’oro, e nient’altro a cui pensare che l’uno all’altra.',
    ],

    // Services
    'services_eyebrow' => [
      'en' => 'Every detail',
      'fr' => 'Chaque détail',
      'it' => 'Ogni dettaglio',
    ],
    'services_title' => [
      'en' => 'Everything is taken care of',
      'fr' => 'Nous nous occupons de tout',
      'it' => 'Pensiamo a tutto noi',
    ],
    'services_text' => [
      'type' => 'textarea',
      'en' => 'One contact on the ground, from the first visit to the last guest’s departure. We work with the best local partners, people we know and trust.',
      'fr' => 'Un seul interlocuteur sur place, de la première visite au départ du dernier invité. Nous travaillons avec les meilleurs partenaires locaux, des gens que nous connaissons et en qui nous avons confiance.',
      'it' => 'Un unico referente sul posto, dal primo sopralluogo alla partenza dell’ultimo ospite. Lavoriamo con i migliori partner locali, persone che conosciamo e di cui ci fidiamo.',
    ],
    'svc1_title' => ['en' => 'Ceremony', 'fr' => 'Cérémonie', 'it' => 'Cerimonia'],
    'svc1_text'  => [
      'en' => 'A symbolic ceremony at the villa, or a civil or religious one nearby.',
      'fr' => 'Une cérémonie laïque à la villa, ou civile et religieuse à proximité.',
      'it' => 'Una cerimonia simbolica in villa, oppure civile o religiosa nei dintorni.',
    ],
    'svc2_title' => ['en' => 'Chef & catering', 'fr' => 'Chef et traiteur', 'it' => 'Chef e catering'],
    'svc2_text'  => [
      'en' => 'Private chefs and caterers for Puglian dinners, from the aperitivo to the wedding cake.',
      'fr' => 'Chefs privés et traiteurs pour des dîners des Pouilles, de l’aperitivo à la pièce montée.',
      'it' => 'Chef privati e catering per cene pugliesi, dall’aperitivo alla torta nuziale.',
    ],
    'svc3_title' => ['en' => 'Flowers & styling', 'fr' => 'Fleurs et décoration', 'it' => 'Fiori e allestimento'],
    'svc3_text'  => [
      'en' => 'Florists and stylists who work with what grows here: olive branches, bougainvillea, wild herbs.',
      'fr' => 'Des fleuristes et décorateurs qui travaillent avec ce qui pousse ici : branches d’olivier, bougainvilliers, herbes sauvages.',
      'it' => 'Fioristi e stylist che lavorano con ciò che cresce qui: rami d’ulivo, bouganville, erbe selvatiche.',
    ],
    'svc4_title' => ['en' => 'Music', 'fr' => 'Musique', 'it' => 'Musica'],
    'svc4_text'  => [
      'en' => 'A string quartet for the ceremony, a band or a DJ for the night.',
      'fr' => 'Un quatuor à cordes pour la cérémonie, un groupe ou un DJ pour la soirée.',
      'it' => 'Un quartetto d’archi per la cerimonia, una band o un DJ per la sera.',
    ],
    'svc5_title' => ['en' => 'Guest accommodation', 'fr' => 'Hébergement des invités', 'it' => 'Alloggio degli ospiti'],
    'svc5_text'  => [
      'en' => 'Your guests stay in our villas nearby, all arranged in one place.',
      'fr' => 'Vos invités séjournent dans nos villas voisines, tout est organisé au même endroit.',
      'it' => 'I vostri ospiti soggiornano nelle nostre ville vicine, tutto organizzato in un unico posto.',
    ],
    'svc6_title' => ['en' => 'Transfers', 'fr' => 'Transferts', 'it' => 'Transfer'],
    'svc6_text'  => [
      'en' => 'Airport pickups, shuttles for guests and a vintage car for the two of you.',
      'fr' => 'Accueil à l’aéroport, navettes pour les invités et une voiture vintage pour vous deux.',
      'it' => 'Accoglienza in aeroporto, navette per gli ospiti e un’auto d’epoca per voi due.',
    ],
    'svc7_title' => ['en' => 'Photo & video', 'fr' => 'Photo et vidéo', 'it' => 'Foto e video'],
    'svc7_text'  => [
      'en' => 'Photographers and filmmakers who know the light of Puglia.',
      'fr' => 'Des photographes et vidéastes qui connaissent la lumière des Pouilles.',
      'it' => 'Fotografi e videomaker che conoscono la luce della Puglia.',
    ],
    'svc8_title' => ['en' => 'Before and after', 'fr' => 'Avant et après', 'it' => 'Prima e dopo'],
    'svc8_text'  => [
      'en' => 'Welcome dinner, a day at sea, farewell brunch: the whole weekend, not just the day.',
      'fr' => 'Dîner de bienvenue, journée en mer, brunch du lendemain : tout le week-end, pas seulement le jour J.',
      'it' => 'Cena di benvenuto, giornata in mare, brunch d’addio: tutto il weekend, non solo il grande giorno.',
    ],

    // Process
    'process_eyebrow' => [
      'en' => 'How it works',
      'fr' => 'Comment ça se passe',
      'it' => 'Come funziona',
    ],
    'process_title' => [
      'en' => 'From the first call to the last dance',
      'fr' => 'Du premier appel à la dernière danse',
      'it' => 'Dalla prima chiamata all’ultimo ballo',
    ],
    'step1_title' => ['en' => 'We listen', 'fr' => 'Nous vous écoutons', 'it' => 'Vi ascoltiamo'],
    'step1_text'  => [
      'en' => 'Your date, your guests, the atmosphere you imagine. We suggest the homes that fit.',
      'fr' => 'Votre date, vos invités, l’ambiance que vous imaginez. Nous vous proposons les maisons qui correspondent.',
      'it' => 'La vostra data, i vostri ospiti, l’atmosfera che immaginate. Vi proponiamo le case giuste.',
    ],
    'step2_title' => ['en' => 'The visit', 'fr' => 'La visite', 'it' => 'Il sopralluogo'],
    'step2_text'  => [
      'en' => 'Come and see the villas in person, or let us show you around on a video call.',
      'fr' => 'Venez découvrir les villas sur place, ou laissez-nous vous les montrer en visioconférence.',
      'it' => 'Venite a vedere le ville di persona, oppure ve le mostriamo in videochiamata.',
    ],
    'step3_title' => ['en' => 'The planning', 'fr' => 'L’organisation', 'it' => 'L’organizzazione'],
    'step3_text'  => [
      'en' => 'Partners, menus, timings: we build the programme with you and handle every booking.',
      'fr' => 'Partenaires, menus, horaires : nous construisons le programme avec vous et gérons toutes les réservations.',
      'it' => 'Partner, menu, orari: costruiamo il programma con voi e gestiamo ogni prenotazione.',
    ],
    'step4_title' => ['en' => 'The day', 'fr' => 'Le jour J', 'it' => 'Il grande giorno'],
    'step4_text'  => [
      'en' => 'We are on site from morning until the last guest leaves. All you have to do is be there.',
      'fr' => 'Nous sommes sur place du matin jusqu’au départ du dernier invité. Vous n’avez qu’à être là.',
      'it' => 'Siamo sul posto dal mattino fino alla partenza dell’ultimo ospite. Dovete solo esserci.',
    ],

    // Gallery
    'gallery_eyebrow' => ['en' => 'Moments', 'fr' => 'Instants', 'it' => 'Momenti'],
    'gallery_title'   => ['en' => 'Imagine it here', 'fr' => 'Imaginez-le ici', 'it' => 'Immaginatelo qui'],

    // Enquiry
    'form_eyebrow' => [
      'en' => 'Wedding enquiry',
      'fr' => 'Demande de mariage',
      'it' => 'Richiesta per matrimonio',
    ],
    'form_title' => [
      'en' => 'Tell us about your wedding',
      'fr' => 'Parlez-nous de votre mariage',
      'it' => 'Raccontateci il vostro matrimonio',
    ],
    'form_text' => [
      'type' => 'textarea',
      'en' => 'Share a few details and we will come back to you within 48 hours with first ideas and a selection of homes.',
      'fr' => 'Donnez-nous quelques détails et nous revenons vers vous sous 48 heures avec de premières idées et une sélection de maisons.',
      'it' => 'Lasciateci qualche dettaglio: vi ricontattiamo entro 48 ore con le prime idee e una selezione di case.',
    ],
    'form_talk' => [
      'en' => 'Prefer to talk?',
      'fr' => 'Vous préférez en parler ?',
      'it' => 'Preferite parlarne?',
    ],

    // Form labels and messages (not editable in the admin)
    'f_names'    => ['admin' => false, 'en' => 'Your names', 'fr' => 'Vos noms', 'it' => 'I vostri nomi'],
    'f_email'    => ['admin' => false, 'en' => 'Email', 'fr' => 'E-mail', 'it' => 'E-mail'],
    'f_phone'    => ['admin' => false, 'en' => 'Phone', 'fr' => 'Téléphone', 'it' => 'Telefono'],
    'f_date'     => ['admin' => false, 'en' => 'Wedding date or period', 'fr' => 'Date ou période du mariage', 'it' => 'Data o periodo del matrimonio'],
    'f_date_ph'  => ['admin' => false, 'en' => 'e.g. June 2027', 'fr' => 'ex. juin 2027', 'it' => 'es. giugno 2027'],
    'f_guests'   => ['admin' => false, 'en' => 'Number of guests', 'fr' => 'Nombre d’invités', 'it' => 'Numero di ospiti'],
    'f_select'   => ['admin' => false, 'en' => 'Select', 'fr' => 'Sélectionner', 'it' => 'Selezionate'],
    'f_g1'       => ['admin' => false, 'en' => 'Up to 30 guests', 'fr' => 'Jusqu’à 30 invités', 'it' => 'Fino a 30 ospiti'],
    'f_g2'       => ['admin' => false, 'en' => '30 to 60 guests', 'fr' => 'De 30 à 60 invités', 'it' => 'Da 30 a 60 ospiti'],
    'f_g3'       => ['admin' => false, 'en' => '60 to 100 guests', 'fr' => 'De 60 à 100 invités', 'it' => 'Da 60 a 100 ospiti'],
    'f_g4'       => ['admin' => false, 'en' => 'More than 100 guests', 'fr' => 'Plus de 100 invités', 'it' => 'Più di 100 ospiti'],
    'f_setting'  => ['admin' => false, 'en' => 'Preferred setting', 'fr' => 'Décor souhaité', 'it' => 'Scenario preferito'],
    'f_unsure'   => ['admin' => false, 'en' => 'Not sure yet', 'fr' => 'Je ne sais pas encore', 'it' => 'Non lo sappiamo ancora'],
    'f_message'  => ['admin' => false, 'en' => 'Your wedding in a few words', 'fr' => 'Votre mariage en quelques mots', 'it' => 'Il vostro matrimonio in poche parole'],
    'f_consent'  => ['admin' => false, 'en' => 'I agree to be contacted by Puglia Luxury Homes regarding this enquiry.', 'fr' => 'J’accepte d’être contacté(e) par Puglia Luxury Homes au sujet de cette demande.', 'it' => 'Accetto di essere contattato/a da Puglia Luxury Homes in merito a questa richiesta.'],
    'f_submit'   => ['admin' => false, 'en' => 'Send my enquiry', 'fr' => 'Envoyer ma demande', 'it' => 'Invia la mia richiesta'],
    'f_success'  => ['admin' => false, 'en' => 'Thank you! Your enquiry has been received. We will be in touch within 48 hours.', 'fr' => 'Merci ! Votre demande a bien été reçue. Nous revenons vers vous sous 48 heures.', 'it' => 'Grazie! La vostra richiesta è stata ricevuta. Vi ricontatteremo entro 48 ore.'],
    'err_required' => ['admin' => false, 'en' => 'Please fill in all required fields.', 'fr' => 'Merci de remplir tous les champs obligatoires.', 'it' => 'Compilate tutti i campi obbligatori.'],
    'err_email'    => ['admin' => false, 'en' => 'Please provide a valid email address.', 'fr' => 'Merci d’indiquer une adresse e-mail valide.', 'it' => 'Inserite un indirizzo e-mail valido.'],
    'err_send'     => ['admin' => false, 'en' => 'Your enquiry could not be sent. Please try again or contact us directly.', 'fr' => 'Votre demande n’a pas pu être envoyée. Merci de réessayer ou de nous contacter directement.', 'it' => 'Non è stato possibile inviare la richiesta. Riprovate o contattateci direttamente.'],
    'err_security' => ['admin' => false, 'en' => 'Security check failed. Please reload the page and try again.', 'fr' => 'La vérification de sécurité a échoué. Merci de recharger la page et de réessayer.', 'it' => 'Verifica di sicurezza non riuscita. Ricaricate la pagina e riprovate.'],
  ];
}

function plh_wedding_lang() {
  $lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'en';
  return in_array( $lang, [ 'en', 'fr', 'it' ], true ) ? $lang : 'en';
}

/** Text for the current language: the admin override if filled in, else the default copy. */
function plh_wed( $key ) {
  $copy = plh_wedding_copy();
  if ( ! isset( $copy[ $key ] ) ) return '';
  if ( ( $copy[ $key ]['admin'] ?? true ) && function_exists( 'get_field' ) ) {
    $custom = get_field( 'wed_' . $key );
    if ( is_string( $custom ) && trim( $custom ) !== '' ) return $custom;
  }
  $lang = plh_wedding_lang();
  return $copy[ $key ][ $lang ] ?? $copy[ $key ]['en'];
}

/* --------------------------------------------------------------------------
   Images: admin field if set, otherwise a villa photo from the media library.
   -------------------------------------------------------------------------- */
function plh_wedding_images() {
  return [
    'hero'     => [ 'label' => 'Hero',                   'file' => '2024/11/Vue-generale-6-scaled.webp' ],
    'intro'    => [ 'label' => 'Intro — large',          'file' => '2024/11/4.1-Diner-5-scaled.webp' ],
    'intro2'   => [ 'label' => 'Intro — small',          'file' => '2025/05/Pergola-Pr-4.webp' ],
    'setting1' => [ 'label' => 'Setting 1 (sea)',        'file' => '2025/05/Ext.-Grande-14.webp' ],
    'setting2' => [ 'label' => 'Setting 2 (countryside)','file' => '2024/11/3-patio-1.webp' ],
    'setting3' => [ 'label' => 'Setting 3 (historic)',   'file' => '2025/03/View-Ext-1.webp' ],
    'band'     => [ 'label' => 'Quote background',       'file' => '2024/11/9-Vue-mer-6-scaled.webp' ],
    'gallery1' => [ 'label' => 'Gallery 1 (large)',      'file' => '2024/11/4.1-Diner-6-scaled.webp' ],
    'gallery2' => [ 'label' => 'Gallery 2',              'file' => '2025/03/Villa-Lucia-Terrasse-ext-1.webp' ],
    'gallery3' => [ 'label' => 'Gallery 3',              'file' => '2025/02/Jardin-3-scaled.webp' ],
    'gallery4' => [ 'label' => 'Gallery 4 (tall)',       'file' => '2024/11/2-SAM-EXT-7-scaled.webp' ],
    'gallery5' => [ 'label' => 'Gallery 5',              'file' => '2025/03/Villa-Lucia-Garden-1.webp' ],
    'gallery6' => [ 'label' => 'Gallery 6',              'file' => '2025/05/vue-Mer-28.webp' ],
  ];
}

function plh_wed_img_url( $key, $size = 'large' ) {
  $images = plh_wedding_images();
  if ( function_exists( 'get_field' ) ) {
    $id = get_field( 'wed_img_' . $key );
    if ( is_array( $id ) ) $id = $id['ID'] ?? 0;
    if ( $id ) {
      $url = wp_get_attachment_image_url( (int) $id, $size );
      if ( $url ) return $url;
    }
  }
  return isset( $images[ $key ] ) ? content_url( 'uploads/' . $images[ $key ]['file'] ) : '';
}

/* --------------------------------------------------------------------------
   Admin fields (shown on pages using the Weddings template)
   -------------------------------------------------------------------------- */
add_action( 'acf/init', function () {
  if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

  $fields   = [];
  $fields[] = [ 'key' => 'field_wed_tab_images', 'label' => 'Images', 'type' => 'tab', 'placement' => 'top' ];
  foreach ( plh_wedding_images() as $key => $img ) {
    $fields[] = [
      'key'           => 'field_wed_img_' . $key,
      'label'         => $img['label'],
      'name'          => 'wed_img_' . $key,
      'type'          => 'image',
      'return_format' => 'id',
      'preview_size'  => 'medium',
      'instructions'  => 'Leave empty to use the default villa photo.',
      'wrapper'       => [ 'width' => 33 ],
    ];
  }

  $fields[] = [ 'key' => 'field_wed_tab_texts', 'label' => 'Texts', 'type' => 'tab', 'placement' => 'top' ];
  $fields[] = [
    'key'     => 'field_wed_texts_note',
    'label'   => '',
    'name'    => '',
    'type'    => 'message',
    'message' => 'Every text already has a default in this page’s language (shown in grey). Fill a field only to replace that text.',
  ];
  foreach ( plh_wedding_copy() as $key => $c ) {
    if ( isset( $c['admin'] ) && ! $c['admin'] ) continue;
    $fields[] = [
      'key'         => 'field_wed_' . $key,
      'label'       => ucfirst( str_replace( '_', ' ', $key ) ),
      'name'        => 'wed_' . $key,
      'type'        => ( $c['type'] ?? 'text' ) === 'textarea' ? 'textarea' : 'text',
      'rows'        => 3,
      'placeholder' => $c['en'],
    ];
  }

  acf_add_local_field_group( [
    'key'             => 'group_weddings_page',
    'title'           => 'Weddings page',
    'fields'          => $fields,
    'location'        => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'weddings.php' ] ] ],
    'position'        => 'normal',
    'label_placement' => 'top',
    'hide_on_screen'  => [ 'the_content' ],
  ] );
} );

/* Show the page-language default as the placeholder of each text field */
add_filter( 'acf/prepare_field', function ( $field ) {
  if ( empty( $field['name'] ) || strpos( $field['name'], 'wed_' ) !== 0 || strpos( $field['name'], 'wed_img_' ) === 0 ) return $field;
  $key  = substr( $field['name'], 4 );
  $copy = plh_wedding_copy();
  if ( ! isset( $copy[ $key ] ) ) return $field;
  $lang = 'en';
  if ( function_exists( 'pll_get_post_language' ) && isset( $_GET['post'] ) ) {
    $lang = pll_get_post_language( (int) $_GET['post'] ) ?: 'en';
  }
  $field['placeholder'] = $copy[ $key ][ $lang ] ?? $copy[ $key ]['en'];
  return $field;
} );

/* --------------------------------------------------------------------------
   Enquiry form
   -------------------------------------------------------------------------- */
function plh_handle_wedding_enquiry() {
  $back = wp_get_referer() ?: home_url( '/' );
  $back = remove_query_arg( [ 'wedding_enquiry', 'wedding_error' ], $back );
  $fail = function ( $code, $data = null ) use ( $back ) {
    if ( $data !== null ) $_SESSION['wedding_form_data'] = $data;
    wp_safe_redirect( add_query_arg( [ 'wedding_enquiry' => 'error', 'wedding_error' => $code ], $back ) . '#wedding-enquiry' );
    exit;
  };

  if ( ! isset( $_POST['plh_wedding_nonce'] ) || ! wp_verify_nonce( $_POST['plh_wedding_nonce'], 'plh_wedding_enquiry' ) ) {
    $fail( 'security' );
  }
  // Honeypot: bots fill it, people never see it
  if ( ! empty( $_POST['wed_hp_field'] ) ) {
    wp_safe_redirect( add_query_arg( 'wedding_enquiry', 'success', $back ) . '#wedding-enquiry' );
    exit;
  }

  $data = [
    'wed_names'   => sanitize_text_field( wp_unslash( $_POST['wed_names'] ?? '' ) ),
    'wed_email'   => sanitize_email( wp_unslash( $_POST['wed_email'] ?? '' ) ),
    'wed_phone'   => sanitize_text_field( wp_unslash( $_POST['wed_phone'] ?? '' ) ),
    'wed_date'    => sanitize_text_field( wp_unslash( $_POST['wed_date'] ?? '' ) ),
    'wed_guests'  => sanitize_text_field( wp_unslash( $_POST['wed_guests'] ?? '' ) ),
    'wed_setting' => sanitize_text_field( wp_unslash( $_POST['wed_setting'] ?? '' ) ),
    'wed_message' => sanitize_textarea_field( wp_unslash( $_POST['wed_message'] ?? '' ) ),
  ];

  // sanitize_email() empties an invalid address, so check what was typed for "required"
  $typed_email = trim( sanitize_text_field( wp_unslash( $_POST['wed_email'] ?? '' ) ) );

  if ( $data['wed_names'] === '' || $typed_email === '' || $data['wed_phone'] === '' || empty( $_POST['wed_consent'] ) ) {
    $data['wed_email'] = $data['wed_email'] ?: $typed_email;
    $fail( 'required', $data );
  }
  if ( ! is_email( $data['wed_email'] ) ) {
    $data['wed_email'] = $typed_email;
    $fail( 'email', $data );
  }

  // The email to the team is in English, whatever the page language
  $copy  = plh_wedding_copy();
  $lang  = sanitize_key( $_POST['form_language'] ?? 'en' );
  $label = function ( $key, $value ) use ( $copy ) {
    // Guests and setting are sent as keys; show their English label
    return isset( $copy[ $value ] ) ? $copy[ $value ]['en'] : $value;
  };
  $rows = [
    'Names'             => $data['wed_names'],
    'Email'             => $data['wed_email'],
    'Phone'             => $data['wed_phone'],
    'Date or period'    => $data['wed_date'],
    'Guests'            => $label( 'f_guests', $data['wed_guests'] ),
    'Preferred setting' => $label( 'f_setting', $data['wed_setting'] ),
    'Page language'     => strtoupper( $lang ),
  ];

  $body  = '<html><body style="font-family:Arial,sans-serif;line-height:1.6;color:#222;">';
  $body .= '<h2 style="color:#6c9ba3;">New wedding enquiry</h2>';
  foreach ( $rows as $name => $value ) {
    $body .= '<p><strong>' . esc_html( $name ) . ':</strong> ' . esc_html( $value !== '' ? $value : 'Not provided' ) . '</p>';
  }
  if ( $data['wed_message'] !== '' ) {
    $body .= '<h3 style="color:#6c9ba3;border-bottom:2px solid #f0f0f0;padding-bottom:8px;">Message</h3>';
    $body .= '<p>' . nl2br( esc_html( $data['wed_message'] ) ) . '</p>';
  }
  $body .= '<hr style="margin:30px 0;border:none;border-top:1px solid #ddd;">';
  $body .= '<p style="color:#888;font-size:12px;"><em>Sent from the weddings page on ' . esc_html( wp_date( 'F j, Y \a\t g:i a' ) ) . '</em></p>';
  $body .= '</body></html>';

  $headers = [
    'Content-Type: text/html; charset=UTF-8',
    'Reply-To: ' . $data['wed_email'],
  ];
  $sent = wp_mail( 'reservation@puglialuxuryhomes.com', 'New wedding enquiry: ' . $data['wed_names'], $body, $headers );

  if ( ! $sent ) $fail( 'send', $data );

  wp_safe_redirect( add_query_arg( 'wedding_enquiry', 'success', $back ) . '#wedding-enquiry' );
  exit;
}
add_action( 'admin_post_plh_wedding_enquiry', 'plh_handle_wedding_enquiry' );
add_action( 'admin_post_nopriv_plh_wedding_enquiry', 'plh_handle_wedding_enquiry' );

/* --------------------------------------------------------------------------
   ONE-TIME: create the three Weddings pages as drafts, linked in Polylang.
   Runs the first time an admin opens the dashboard after the deploy, and only
   if no page uses the template yet. Publish them when the client has approved.
   -------------------------------------------------------------------------- */
add_action( 'admin_init', function () {
  $version = '2026-11-weddings-pages';
  if ( get_option( 'plh_content_update_weddings' ) === $version ) return;
  if ( ! current_user_can( 'manage_options' ) ) return;

  $existing = get_posts( [
    'post_type'   => 'page',
    'post_status' => 'any',
    'meta_key'    => '_wp_page_template',
    'meta_value'  => 'weddings.php',
    'numberposts' => 1,
    'fields'      => 'ids',
    'lang'        => '',
  ] );

  if ( ! $existing ) {
    $pages = [
      'en' => [ 'title' => 'Weddings in Puglia',          'slug' => 'weddings-in-puglia' ],
      'fr' => [ 'title' => 'Mariages dans les Pouilles',  'slug' => 'mariages-dans-les-pouilles' ],
      'it' => [ 'title' => 'Matrimoni in Puglia',         'slug' => 'matrimoni-in-puglia' ],
    ];
    $ids = [];
    foreach ( $pages as $lang => $p ) {
      $id = wp_insert_post( [
        'post_type'   => 'page',
        'post_status' => 'draft',
        'post_title'  => $p['title'],
        'post_name'   => $p['slug'],
        'post_content'=> '',
      ] );
      if ( ! $id || is_wp_error( $id ) ) continue;
      update_post_meta( $id, '_wp_page_template', 'weddings.php' );
      if ( function_exists( 'pll_set_post_language' ) ) pll_set_post_language( $id, $lang );
      $ids[ $lang ] = $id;
    }
    if ( count( $ids ) > 1 && function_exists( 'pll_save_post_translations' ) ) {
      pll_save_post_translations( $ids );
    }
  }

  update_option( 'plh_content_update_weddings', $version, false );
} );

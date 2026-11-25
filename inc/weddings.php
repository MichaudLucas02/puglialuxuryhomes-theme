<?php
/**
 * Weddings page (template: weddings.php)
 *
 * Simple layout requested by the client: a title, a few paragraphs of text,
 * then a large photo gallery.
 * - Copy in EN / FR / IT, each text can be overridden per page in the admin
 * - Gallery field in the admin (villa photos are shown until it is filled)
 * - Also holds form labels shared with the Retreats page
 * - One-time creation of the three pages (as drafts, linked in Polylang)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
   Copy. 'admin' => false keeps a text out of the admin.
   -------------------------------------------------------------------------- */
function plh_wedding_copy() {
  return [
    'title' => [
      'en' => 'Weddings & events in Puglia',
      'fr' => 'Mariages et événements dans les Pouilles',
      'it' => 'Matrimoni ed eventi in Puglia',
    ],
    'text1' => [
      'type' => 'textarea',
      'en' => 'Picture your wedding in a private villa in Puglia: a ceremony among the olive trees or facing the sea, a long dinner under the stars, and a house that belongs only to you and your guests for a few days. From the Salento coast to the countryside and the baroque old towns, our homes offer settings that feel both intimate and unforgettable.',
      'fr' => 'Imaginez votre mariage dans une villa privée des Pouilles : une cérémonie parmi les oliviers ou face à la mer, un long dîner sous les étoiles, et une maison rien que pour vous et vos invités le temps de quelques jours. De la côte du Salento à la campagne et aux vieilles villes baroques, nos maisons offrent des décors à la fois intimes et inoubliables.',
      'it' => 'Immaginate il vostro matrimonio in una villa privata in Puglia: una cerimonia tra gli ulivi o di fronte al mare, una lunga cena sotto le stelle e una casa tutta per voi e i vostri ospiti per qualche giorno. Dalla costa del Salento alla campagna e ai centri storici barocchi, le nostre case offrono scenari intimi e indimenticabili.',
    ],
    'text2' => [
      'type' => 'textarea',
      'en' => 'Whether you are planning an intimate ceremony with your closest friends or a celebration over a whole weekend, we organise every detail with you: the right house, the chef and the menus, flowers, music, transfers and accommodation for your guests. One contact on the ground, from the first visit to the farewell brunch.',
      'fr' => 'Que vous prépariez une cérémonie intime avec vos proches ou une fête sur tout un week-end, nous organisons chaque détail avec vous : la bonne maison, le chef et les menus, les fleurs, la musique, les transferts et l’hébergement de vos invités. Un seul interlocuteur sur place, de la première visite au brunch du lendemain.',
      'it' => 'Che stiate organizzando una cerimonia intima con gli amici più cari o una festa lunga un intero weekend, curiamo ogni dettaglio insieme a voi: la casa giusta, lo chef e i menù, i fiori, la musica, i transfer e l’alloggio degli ospiti. Un solo referente sul posto, dal primo sopralluogo al brunch d’addio.',
    ],
    'text3' => [
      'type' => 'textarea',
      'en' => 'We also host private events: birthdays, anniversaries, family gatherings and company celebrations. Tell us what you have in mind and we will suggest the homes that fit.',
      'fr' => 'Nous accueillons aussi des événements privés : anniversaires, anniversaires de mariage, réunions de famille et fêtes d’entreprise. Dites-nous ce que vous imaginez et nous vous proposerons les maisons qui s’y prêtent.',
      'it' => 'Ospitiamo anche eventi privati: compleanni, anniversari, riunioni di famiglia e feste aziendali. Raccontateci cosa avete in mente e vi proporremo le case più adatte.',
    ],
    'cta' => [
      'en' => 'Plan your wedding with us',
      'fr' => 'Organiser votre mariage avec nous',
      'it' => 'Organizzate il vostro matrimonio con noi',
    ],

    'form_talk' => [
      'admin' => false,
      'en' => 'Prefer to talk?',
      'fr' => 'Vous préférez en parler ?',
      'it' => 'Preferite parlarne?',
    ],

    // Form labels and messages used by the Retreats page (not editable here)
    'f_email'    => ['admin' => false, 'en' => 'Email', 'fr' => 'E-mail', 'it' => 'E-mail'],
    'f_phone'    => ['admin' => false, 'en' => 'Phone', 'fr' => 'Téléphone', 'it' => 'Telefono'],
    'f_select'   => ['admin' => false, 'en' => 'Select', 'fr' => 'Sélectionner', 'it' => 'Selezionate'],
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
   Gallery: the photos chosen in the admin, otherwise villa photos.
   Returns a list of [ 'id' => attachment id ] or [ 'src', 'w', 'h' ].
   -------------------------------------------------------------------------- */
function plh_wedding_gallery() {
  if ( function_exists( 'get_field' ) ) {
    $ids = get_field( 'wed_gallery' );
    if ( is_array( $ids ) && $ids ) {
      $out = [];
      foreach ( $ids as $id ) {
        $id = is_array( $id ) ? ( $id['ID'] ?? 0 ) : (int) $id;
        if ( $id ) $out[] = [ 'id' => $id ];
      }
      if ( $out ) return $out;
    }
  }

  // Default photos [ file, width, height ] until the real wedding photos are added
  $defaults = [
    [ '2024/11/4.1-Diner-5-scaled.webp',          1700, 2560 ],
    [ '2025/05/Pergola-Pr-4.webp',                2560, 1707 ],
    [ '2024/11/2-SAM-EXT-7-scaled.webp',          1707, 2560 ],
    [ '2024/11/Vue-generale-6-scaled.webp',       2560, 1920 ],
    [ '2024/11/9-Vue-mer-6-scaled.webp',          1708, 2560 ],
    [ '2025/02/Sam-EXT-3-scaled.webp',            2560, 1707 ],
    [ '2025/03/Villa-Lucia-Terrasse-ext-1.webp',  1080,  720 ],
    [ '2024/11/4.1-Diner-6-scaled.webp',          1700, 2560 ],
    [ '2025/02/Jardin-3-scaled.webp',             2560, 1707 ],
    [ '2025/05/Ext.-Grande-14.webp',              2560, 1707 ],
    [ '2024/11/5-Terrasse-RDJ-3-scaled.webp',     1707, 2560 ],
    [ '2025/02/Piscine-10-scaled.webp',            1707, 2560 ],
    [ '2025/03/View-Ext-1.webp',                  1440, 1059 ],
    [ '2025/02/Jardin-7-scaled.webp',             1707, 2560 ],
    [ '2024/11/4.2-Terrasse-PR-7.webp',           1920, 1280 ],
    [ '2025/03/Villa-Lucia-Garden-1.webp',        1080,  720 ],
    [ '2024/11/1-Grande-Ext.-3-scaled.webp',      1707, 2560 ],
    [ '2025/05/vue-Mer-28.webp',                  2560, 1440 ],
  ];
  $out = [];
  foreach ( $defaults as $d ) {
    $out[] = [ 'src' => content_url( 'uploads/' . $d[0] ), 'w' => $d[1], 'h' => $d[2] ];
  }
  return $out;
}

/* --------------------------------------------------------------------------
   Admin fields (shown on pages using the Weddings template)
   -------------------------------------------------------------------------- */
add_action( 'acf/init', function () {
  if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

  $fields   = [];
  $fields[] = [ 'key' => 'field_wed_tab_texts', 'label' => 'Texts', 'type' => 'tab', 'placement' => 'top' ];
  $fields[] = [
    'key'     => 'field_wed_texts_note',
    'label'   => '',
    'name'    => '',
    'type'    => 'message',
    'message' => 'Every text already has a default in this page’s language (shown in grey). Fill a field only to replace that text.',
  ];
  $labels = [ 'title' => 'Title', 'text1' => 'Paragraph 1', 'text2' => 'Paragraph 2', 'text3' => 'Paragraph 3', 'cta' => 'Button' ];
  foreach ( plh_wedding_copy() as $key => $c ) {
    if ( isset( $c['admin'] ) && ! $c['admin'] ) continue;
    $fields[] = [
      'key'         => 'field_wed_' . $key,
      'label'       => $labels[ $key ] ?? ucfirst( str_replace( '_', ' ', $key ) ),
      'name'        => 'wed_' . $key,
      'type'        => ( $c['type'] ?? 'text' ) === 'textarea' ? 'textarea' : 'text',
      'rows'        => 4,
      'placeholder' => $c['en'],
    ];
  }

  $fields[] = [ 'key' => 'field_wed_tab_gallery', 'label' => 'Gallery', 'type' => 'tab', 'placement' => 'top' ];
  $fields[] = [
    'key'           => 'field_wed_gallery',
    'label'         => 'Photos',
    'name'          => 'wed_gallery',
    'type'          => 'gallery',
    'return_format' => 'id',
    'preview_size'  => 'medium',
    'insert'        => 'append',
    'library'       => 'all',
    'instructions'  => 'Add the wedding photos in the order you want them (drag to reorder). Portrait and landscape photos can be mixed. While this is empty, villa photos are shown.',
  ];

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
  if ( empty( $field['name'] ) || strpos( $field['name'], 'wed_' ) !== 0 || $field['name'] === 'wed_gallery' ) return $field;
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

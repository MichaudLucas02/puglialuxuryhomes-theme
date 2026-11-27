<?php
/**
 * Weddings page (template: weddings.php)
 *
 * Simple layout requested by the client: a title, a few paragraphs of text,
 * then the photos of three weddings, each styled differently.
 * - Copy in EN / FR / IT, each text can be overridden per page in the admin
 * - Three weddings, each with its own photos and style ("Weddings" box in the admin)
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
   The three weddings: each has a name, a place/date line, a short text,
   a style (colours) and its own photos. Set in the "Weddings" box of the page.
   -------------------------------------------------------------------------- */
function plh_wedding_themes() {
  return [
    'ivory' => 'Ivory (light, warm white)',
    'olive' => 'Olive grove (soft green)',
    'night' => 'Evening (dark, gold accents)',
  ];
}

/** Default names, used while a wedding has no name in the admin. */
function plh_wedding_default_names() {
  return [
    1 => [ 'en' => 'A wedding by the sea',           'fr' => 'Un mariage face à la mer',       'it' => 'Un matrimonio sul mare' ],
    2 => [ 'en' => 'A wedding among the olive trees', 'fr' => 'Un mariage parmi les oliviers', 'it' => 'Un matrimonio tra gli ulivi' ],
    3 => [ 'en' => 'An evening celebration',          'fr' => 'Une fête à la tombée du jour',  'it' => 'Una festa al tramonto' ],
  ];
}

/** Saved settings of the three weddings (always 3 entries, keys 1 to 3). */
function plh_wedding_settings( $post_id ) {
  $saved  = get_post_meta( $post_id, '_plh_weddings', true );
  $saved  = is_array( $saved ) ? $saved : [];
  $themes = array_keys( plh_wedding_themes() );
  $out    = [];
  for ( $n = 1; $n <= 3; $n++ ) {
    $w   = isset( $saved[ $n ] ) && is_array( $saved[ $n ] ) ? $saved[ $n ] : [];
    $ids = isset( $w['ids'] ) && is_array( $w['ids'] ) ? $w['ids'] : [];
    // Photos saved before the page had three weddings go to the first one
    if ( $n === 1 && ! $saved ) {
      $old = get_post_meta( $post_id, '_plh_wed_gallery', true );
      if ( is_array( $old ) ) $ids = $old;
    }
    $ids = array_values( array_filter( array_map( 'absint', $ids ), function ( $id ) {
      return $id && wp_attachment_is_image( $id );
    } ) );
    $theme = $w['theme'] ?? '';
    $out[ $n ] = [
      'name'  => (string) ( $w['name'] ?? '' ),
      'place' => (string) ( $w['place'] ?? '' ),
      'text'  => (string) ( $w['text'] ?? '' ),
      'theme' => in_array( $theme, $themes, true ) ? $theme : $themes[ $n - 1 ],
      'ids'   => $ids,
    ];
  }
  return $out;
}

/**
 * Weddings to show on the page, in order. Only weddings with photos are shown.
 * Until no photos are added at all, villa photos are shown split in three.
 * Each photo is [ 'id' => attachment id ] or [ 'src', 'w', 'h' ].
 */
function plh_wedding_stories() {
  $post_id  = get_queried_object_id() ?: get_the_ID();
  $settings = $post_id ? plh_wedding_settings( $post_id ) : plh_wedding_settings( 0 );
  $lang     = plh_wedding_lang();
  $names    = plh_wedding_default_names();

  $has_photos = false;
  foreach ( $settings as $w ) { if ( $w['ids'] ) { $has_photos = true; break; } }
  $fallback = $has_photos ? [] : array_chunk( plh_wedding_default_photos(), 6 );

  $out = [];
  foreach ( $settings as $n => $w ) {
    if ( $has_photos ) {
      if ( ! $w['ids'] ) continue;
      $photos = array_map( function ( $id ) { return [ 'id' => $id ]; }, $w['ids'] );
    } else {
      $photos = $fallback[ $n - 1 ] ?? [];
    }
    $name  = trim( $w['name'] ) !== '' ? $w['name'] : ( $names[ $n ][ $lang ] ?? $names[ $n ]['en'] );
    $out[] = [
      'name'   => $name,
      'place'  => trim( $w['place'] ),
      'text'   => trim( $w['text'] ),
      'theme'  => $w['theme'],
      'photos' => $photos,
    ];
  }
  return $out;
}

/** Villa photos shown until the real wedding photos are added. */
function plh_wedding_default_photos() {
  $defaults = [
    // Wedding 1
    [ '2024/11/9-Vue-mer-6-scaled.webp',          1708, 2560 ],
    [ '2025/05/vue-Mer-28.webp',                  2560, 1440 ],
    [ '2024/11/4.1-Diner-5-scaled.webp',          1700, 2560 ],
    [ '2025/05/Pergola-Pr-4.webp',                2560, 1707 ],
    [ '2025/02/Piscine-10-scaled.webp',           1707, 2560 ],
    [ '2024/11/Vue-generale-6-scaled.webp',       2560, 1920 ],
    // Wedding 2
    [ '2025/02/Jardin-7-scaled.webp',             1707, 2560 ],
    [ '2025/02/Jardin-3-scaled.webp',             2560, 1707 ],
    [ '2025/03/Villa-Lucia-Garden-1.webp',        1080,  720 ],
    [ '2024/11/2-SAM-EXT-7-scaled.webp',          1707, 2560 ],
    [ '2025/03/Villa-Lucia-Terrasse-ext-1.webp',  1080,  720 ],
    [ '2025/02/Sam-EXT-3-scaled.webp',            2560, 1707 ],
    // Wedding 3
    [ '2024/11/4.1-Diner-6-scaled.webp',          1700, 2560 ],
    [ '2024/11/4.2-Terrasse-PR-7.webp',           1920, 1280 ],
    [ '2025/03/View-Ext-1.webp',                  1440, 1059 ],
    [ '2024/11/5-Terrasse-RDJ-3-scaled.webp',     1707, 2560 ],
    [ '2025/05/Ext.-Grande-14.webp',              2560, 1707 ],
    [ '2024/11/1-Grande-Ext.-3-scaled.webp',      1707, 2560 ],
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

  acf_add_local_field_group( [
    'key'             => 'group_weddings_page',
    'title'           => 'Weddings page: texts',
    'fields'          => $fields,
    'location'        => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'weddings.php' ] ] ],
    'position'        => 'normal',
    'label_placement' => 'top',
    'hide_on_screen'  => [ 'the_content' ],
  ] );
} );

/* Show the page-language default as the placeholder of each text field */
add_filter( 'acf/prepare_field', function ( $field ) {
  if ( empty( $field['name'] ) || strpos( $field['name'], 'wed_' ) !== 0 ) return $field;
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
   "Weddings" box: three weddings, each with its texts, style and photos.
   Built with WordPress itself (media library, drag to reorder), so it works
   without ACF Pro. Stored in the page meta _plh_weddings.
   -------------------------------------------------------------------------- */
function plh_is_wedding_page_screen( $post ) {
  return $post && $post->post_type === 'page' && get_page_template_slug( $post ) === 'weddings.php';
}

add_action( 'add_meta_boxes_page', function ( $post ) {
  if ( ! plh_is_wedding_page_screen( $post ) ) return;
  add_meta_box( 'plh_wed_gallery_box', 'Weddings (3 galleries)', 'plh_render_wedding_gallery_box', 'page', 'normal', 'high' );
} );

function plh_render_wedding_gallery_box( $post ) {
  $settings = plh_wedding_settings( $post->ID );
  $themes   = plh_wedding_themes();
  $lang     = function_exists( 'pll_get_post_language' ) ? ( pll_get_post_language( $post->ID ) ?: 'en' ) : 'en';
  $names    = plh_wedding_default_names();
  wp_nonce_field( 'plh_wed_gallery_save', 'plh_wed_gallery_nonce' );
  ?>
  <p style="margin-top:0">Each wedding has its own photos and its own style. Click <strong>Add photos</strong> to upload or choose photos (several at once), drag the thumbnails to change the order, click × to remove one. Then click <strong>Update</strong>.<br>A wedding without photos is not shown. While no wedding has photos, villa photos are shown on the page.</p>
  <?php foreach ( $settings as $n => $w ) :
    $f = 'plh_weddings[' . $n . ']'; ?>
    <div class="plh-wed-panel" data-wedding="<?php echo (int) $n; ?>">
      <h3>Wedding <?php echo (int) $n; ?></h3>
      <div class="plh-wed-panel__fields">
        <label>Name<br>
          <input type="text" class="widefat" name="<?php echo esc_attr( $f ); ?>[name]" value="<?php echo esc_attr( $w['name'] ); ?>" placeholder="<?php echo esc_attr( $names[ $n ][ $lang ] ?? $names[ $n ]['en'] ); ?>">
        </label>
        <label>Place and date (optional)<br>
          <input type="text" class="widefat" name="<?php echo esc_attr( $f ); ?>[place]" value="<?php echo esc_attr( $w['place'] ); ?>" placeholder="Villa Lucia · June 2025">
        </label>
        <label>Style<br>
          <select name="<?php echo esc_attr( $f ); ?>[theme]">
            <?php foreach ( $themes as $key => $label ) : ?>
              <option value="<?php echo esc_attr( $key ); ?>"<?php selected( $w['theme'], $key ); ?>><?php echo esc_html( $label ); ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label class="plh-wed-panel__wide">Short text (optional)<br>
          <textarea class="widefat" rows="3" name="<?php echo esc_attr( $f ); ?>[text]"><?php echo esc_textarea( $w['text'] ); ?></textarea>
        </label>
      </div>
      <input type="hidden" class="plh-wed-ids" name="<?php echo esc_attr( $f ); ?>[ids]" value="<?php echo esc_attr( implode( ',', $w['ids'] ) ); ?>">
      <ul class="plh-wed-gallery">
        <?php foreach ( $w['ids'] as $id ) : ?>
          <li data-id="<?php echo (int) $id; ?>">
            <?php echo wp_get_attachment_image( $id, 'thumbnail' ); ?>
            <button type="button" class="plh-wed-gallery__remove" aria-label="Remove">×</button>
          </li>
        <?php endforeach; ?>
      </ul>
      <p>
        <button type="button" class="button button-primary plh-wed-add">Add photos</button>
        <button type="button" class="button plh-wed-clear"<?php echo $w['ids'] ? '' : ' style="display:none"'; ?>>Remove all</button>
        <span class="plh-wed-count"></span>
      </p>
    </div>
  <?php endforeach; ?>
  <style>
    .plh-wed-panel { border: 1px solid #dcdcde; background: #fcfcfc; padding: 4px 16px 6px; margin: 0 0 16px; }
    .plh-wed-panel h3 { margin: 12px 0 10px; font-size: 14px; }
    .plh-wed-panel__fields { display: grid; grid-template-columns: 1fr 1fr 220px; gap: 10px 14px; }
    .plh-wed-panel__fields label { font-weight: 600; }
    .plh-wed-panel__fields input, .plh-wed-panel__fields select, .plh-wed-panel__fields textarea { font-weight: 400; margin-top: 4px; }
    .plh-wed-panel__wide { grid-column: 1 / -1; }
    .plh-wed-count { color: #646970; margin-left: 6px; }
    .plh-wed-gallery { display: flex; flex-wrap: wrap; gap: 10px; margin: 12px 0; min-height: 10px; }
    .plh-wed-gallery li { position: relative; width: 100px; height: 100px; margin: 0; cursor: move; background: #f0f0f1; }
    .plh-wed-gallery li img { width: 100px; height: 100px; object-fit: cover; display: block; }
    .plh-wed-gallery__remove { position: absolute; top: 4px; right: 4px; width: 24px; height: 24px; border: 0; border-radius: 50%; background: rgba(0,0,0,.7); color: #fff; font-size: 16px; line-height: 22px; cursor: pointer; padding: 0; }
    .plh-wed-gallery .ui-sortable-placeholder { visibility: visible !important; border: 2px dashed #c3c4c7; background: transparent; }
    @media (max-width: 900px) { .plh-wed-panel__fields { grid-template-columns: 1fr; } }
  </style>
  <script>
  jQuery(function ($) {
    $('.plh-wed-panel').each(function () {
      var $panel = $(this), n = $panel.data('wedding'), frame,
          $list = $panel.find('.plh-wed-gallery'), $input = $panel.find('.plh-wed-ids'),
          $clear = $panel.find('.plh-wed-clear'), $count = $panel.find('.plh-wed-count');
      function sync() {
        var ids = $list.children('li').map(function () { return $(this).data('id'); }).get();
        $input.val(ids.join(','));
        $clear.toggle(ids.length > 0);
        $count.text(ids.length ? ids.length + (ids.length > 1 ? ' photos' : ' photo') : '');
      }
      sync();
      $list.sortable({ items: 'li', tolerance: 'pointer', placeholder: 'ui-sortable-placeholder', update: sync });
      $list.on('click', '.plh-wed-gallery__remove', function () { $(this).closest('li').remove(); sync(); });
      $clear.on('click', function () { $list.empty(); sync(); });
      $panel.find('.plh-wed-add').on('click', function (e) {
        e.preventDefault();
        if (!frame) {
          frame = wp.media({ title: 'Wedding ' + n + ': photos', button: { text: 'Add to wedding ' + n }, library: { type: 'image' }, multiple: 'add' });
          frame.on('select', function () {
            var have = $input.val() ? $input.val().split(',') : [];
            frame.state().get('selection').each(function (att) {
              var a = att.toJSON();
              if (have.indexOf(String(a.id)) !== -1) return;
              var src = (a.sizes && (a.sizes.thumbnail || a.sizes.medium) || a).url;
              $('<li>').attr('data-id', a.id).data('id', a.id)
                .append($('<img>').attr({ src: src, alt: '' }))
                .append('<button type="button" class="plh-wed-gallery__remove" aria-label="Remove">×</button>')
                .appendTo($list);
              have.push(String(a.id));
            });
            sync();
          });
        }
        frame.open();
      });
    });
  });
  </script>
  <?php
}

add_action( 'admin_enqueue_scripts', function ( $hook ) {
  if ( $hook !== 'post.php' && $hook !== 'post-new.php' ) return;
  if ( ! plh_is_wedding_page_screen( get_post() ) ) return;
  wp_enqueue_media();
  wp_enqueue_script( 'jquery-ui-sortable' );
} );

add_action( 'save_post_page', function ( $post_id ) {
  if ( ! isset( $_POST['plh_wed_gallery_nonce'] ) || ! wp_verify_nonce( $_POST['plh_wed_gallery_nonce'], 'plh_wed_gallery_save' ) ) return;
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
  if ( wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_page', $post_id ) ) return;

  $raw    = isset( $_POST['plh_weddings'] ) && is_array( $_POST['plh_weddings'] ) ? wp_unslash( $_POST['plh_weddings'] ) : [];
  $themes = plh_wedding_themes();
  $data   = [];
  for ( $n = 1; $n <= 3; $n++ ) {
    $w   = isset( $raw[ $n ] ) && is_array( $raw[ $n ] ) ? $raw[ $n ] : [];
    $ids = array_values( array_unique( array_filter( array_map( 'absint', explode( ',', sanitize_text_field( $w['ids'] ?? '' ) ) ) ) ) );
    $theme = sanitize_key( $w['theme'] ?? '' );
    $data[ $n ] = [
      'name'  => sanitize_text_field( $w['name'] ?? '' ),
      'place' => sanitize_text_field( $w['place'] ?? '' ),
      'text'  => sanitize_textarea_field( $w['text'] ?? '' ),
      'theme' => isset( $themes[ $theme ] ) ? $theme : '',
      'ids'   => $ids,
    ];
  }
  update_post_meta( $post_id, '_plh_weddings', $data );
  delete_post_meta( $post_id, '_plh_wed_gallery' ); // replaced by _plh_weddings
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

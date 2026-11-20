<?php
/**
 * Retreats page (template: retreats.php)
 *
 * Same building blocks as the Weddings page (inc/weddings.php), different layout:
 * - Copy in EN / FR / IT, each text can be overridden per page in the admin
 * - Admin fields for every image (villa photos are used until real ones are added)
 * - Retreat enquiry form handler
 * - One-time creation of the three pages (as drafts, linked in Polylang)
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
   Copy. 'admin' => false keeps form labels and messages out of the admin.
   -------------------------------------------------------------------------- */
function plh_retreat_copy() {
  $copy = [
    // Hero
    'hero_eyebrow' => [
      'en' => 'Yoga, wellness & group retreats',
      'fr' => 'Yoga, bien-être et retraites de groupe',
      'it' => 'Yoga, benessere e ritiri di gruppo',
    ],
    'hero_title' => [
      'en' => 'Retreats in Puglia',
      'fr' => 'Retraites dans les Pouilles',
      'it' => 'Ritiri in Puglia',
    ],
    'hero_text' => [
      'en' => 'Private villas for yoga, wellness and team retreats, with everything organised around your group.',
      'fr' => 'Des villas privées pour des retraites de yoga, de bien-être ou d’équipe, avec tout organisé autour de votre groupe.',
      'it' => 'Ville private per ritiri di yoga, benessere o di team, con tutto organizzato intorno al vostro gruppo.',
    ],
    'hero_cta' => [
      'en' => 'Plan your retreat',
      'fr' => 'Organiser votre retraite',
      'it' => 'Organizzate il vostro ritiro',
    ],
    'hero_cta2' => [
      'en' => 'Discover the retreats',
      'fr' => 'Découvrir les retraites',
      'it' => 'Scoprite i ritiri',
    ],

    // Intro
    'intro_eyebrow' => [
      'en' => 'Space to breathe',
      'fr' => 'De l’espace pour respirer',
      'it' => 'Spazio per respirare',
    ],
    'intro_title' => [
      'en' => 'A whole house, for your group only.',
      'fr' => 'Une maison entière, rien que pour votre groupe.',
      'it' => 'Una casa intera, solo per il vostro gruppo.',
    ],
    'intro_text' => [
      'type' => 'textarea',
      'en' => 'No hotel lobby, no other guests, no timetable but your own. A private villa with terraces facing the sea, gardens among the olive trees and room for everyone. Whether you bring your own group or want us to build the whole programme, we take care of the house, the meals and everything around it, so the days can be about the practice.',
      'fr' => 'Pas de hall d’hôtel, pas d’autres clients, pas d’autre horaire que le vôtre. Une villa privée avec des terrasses face à la mer, des jardins au milieu des oliviers et de la place pour chacun. Que vous veniez avec votre groupe ou que vous souhaitiez que nous construisions tout le programme, nous nous occupons de la maison, des repas et de tout le reste, pour que les journées soient consacrées à la pratique.',
      'it' => 'Nessuna hall d’albergo, nessun altro ospite, nessun orario se non il vostro. Una villa privata con terrazze sul mare, giardini tra gli ulivi e spazio per tutti. Che arriviate con il vostro gruppo o desideriate che costruiamo noi l’intero programma, ci occupiamo della casa, dei pasti e di tutto il resto, perché le giornate siano dedicate alla pratica.',
    ],


    // A day on retreat (example timeline)
    'day_eyebrow' => [
      'en' => 'A day on retreat',
      'fr' => 'Une journée de retraite',
      'it' => 'Una giornata di ritiro',
    ],
    'day_title' => [
      'en' => 'Days with their own rhythm',
      'fr' => 'Des journées à leur rythme',
      'it' => 'Giornate al loro ritmo',
    ],
    'day_note' => [
      'en' => 'An example: every programme is built around your group.',
      'fr' => 'Un exemple : chaque programme est construit autour de votre groupe.',
      'it' => 'Un esempio: ogni programma è costruito intorno al vostro gruppo.',
    ],
    'day1_time'  => ['en' => '7:30', 'fr' => '7h30', 'it' => '7:30'],
    'day1_title' => ['en' => 'Sunrise practice', 'fr' => 'Pratique au lever du soleil', 'it' => 'Pratica all’alba'],
    'day1_text'  => [
      'en' => 'Yoga or meditation on the terrace, while the light comes up over the sea.',
      'fr' => 'Yoga ou méditation sur la terrasse, pendant que la lumière se lève sur la mer.',
      'it' => 'Yoga o meditazione in terrazza, mentre la luce sorge sul mare.',
    ],
    'day2_time'  => ['en' => '9:00', 'fr' => '9h00', 'it' => '9:00'],
    'day2_title' => ['en' => 'Slow breakfast', 'fr' => 'Petit-déjeuner sans hâte', 'it' => 'Colazione senza fretta'],
    'day2_text'  => [
      'en' => 'Seasonal fruit, local bread and ricotta, coffee in the shade.',
      'fr' => 'Fruits de saison, pain et ricotta d’ici, café à l’ombre.',
      'it' => 'Frutta di stagione, pane e ricotta locali, caffè all’ombra.',
    ],
    'day3_time'  => ['en' => '11:00', 'fr' => '11h00', 'it' => '11:00'],
    'day3_title' => ['en' => 'Workshop or free time', 'fr' => 'Atelier ou temps libre', 'it' => 'Workshop o tempo libero'],
    'day3_text'  => [
      'en' => 'A session with your teacher, or nothing at all: a book by the pool.',
      'fr' => 'Une séance avec votre professeur, ou rien du tout : un livre au bord de la piscine.',
      'it' => 'Una sessione con il vostro insegnante, o niente del tutto: un libro a bordo piscina.',
    ],
    'day4_time'  => ['en' => '13:30', 'fr' => '13h30', 'it' => '13:30'],
    'day4_title' => ['en' => 'Long lunch', 'fr' => 'Long déjeuner', 'it' => 'Lungo pranzo'],
    'day4_text'  => [
      'en' => 'Prepared by the chef with what the market had that morning.',
      'fr' => 'Préparé par le chef avec ce que le marché offrait le matin.',
      'it' => 'Preparato dallo chef con quello che offriva il mercato al mattino.',
    ],
    'day5_time'  => ['en' => '17:00', 'fr' => '17h00', 'it' => '17:00'],
    'day5_title' => ['en' => 'Massage or the sea', 'fr' => 'Massage ou mer', 'it' => 'Massaggio o mare'],
    'day5_text'  => [
      'en' => 'A treatment at the villa, a swim in a cove, a walk among the olive trees.',
      'fr' => 'Un soin à la villa, une baignade dans une crique, une balade entre les oliviers.',
      'it' => 'Un trattamento in villa, un bagno in una caletta, una passeggiata tra gli ulivi.',
    ],
    'day6_time'  => ['en' => '20:00', 'fr' => '20h00', 'it' => '20:00'],
    'day6_title' => ['en' => 'Dinner under the stars', 'fr' => 'Dîner sous les étoiles', 'it' => 'Cena sotto le stelle'],
    'day6_text'  => [
      'en' => 'Everyone around one table, as the day winds down.',
      'fr' => 'Tout le monde autour d’une même table, quand la journée s’achève.',
      'it' => 'Tutti intorno a una sola tavola, mentre la giornata si chiude.',
    ],

    // Types of retreat
    'types_eyebrow' => [
      'en' => 'Four kinds of retreat',
      'fr' => 'Quatre types de retraite',
      'it' => 'Quattro tipi di ritiro',
    ],
    'types_title' => [
      'en' => 'Retreats we host',
      'fr' => 'Les retraites que nous accueillons',
      'it' => 'I ritiri che ospitiamo',
    ],
    'type1_title' => ['en' => 'Yoga & meditation', 'fr' => 'Yoga et méditation', 'it' => 'Yoga e meditazione'],
    'type1_text'  => [
      'type' => 'textarea',
      'en' => 'Practice on a terrace facing the sea or in the shade of the olive trees, morning and evening, in complete quiet.',
      'fr' => 'La pratique sur une terrasse face à la mer ou à l’ombre des oliviers, matin et soir, dans un calme absolu.',
      'it' => 'La pratica su una terrazza sul mare o all’ombra degli ulivi, mattina e sera, nella quiete più assoluta.',
    ],
    'type2_title' => ['en' => 'Wellness & detox', 'fr' => 'Bien-être et détox', 'it' => 'Benessere e detox'],
    'type2_text'  => [
      'type' => 'textarea',
      'en' => 'Massages, light Puglian cooking, walks and swims: a few days to rest body and mind.',
      'fr' => 'Massages, cuisine des Pouilles légère, marches et baignades : quelques jours pour reposer le corps et l’esprit.',
      'it' => 'Massaggi, cucina pugliese leggera, passeggiate e bagni: qualche giorno per far riposare corpo e mente.',
    ],
    'type3_title' => ['en' => 'Company off-sites', 'fr' => 'Séminaires d’entreprise', 'it' => 'Ritiri aziendali'],
    'type3_text'  => [
      'type' => 'textarea',
      'en' => 'Work sessions in the morning, the region in the afternoon. A setting that brings a team together.',
      'fr' => 'Des sessions de travail le matin, la région l’après-midi. Un cadre qui rassemble une équipe.',
      'it' => 'Sessioni di lavoro al mattino, il territorio al pomeriggio. Una cornice che unisce una squadra.',
    ],
    'type4_title' => ['en' => 'Creative & cooking', 'fr' => 'Créativité et cuisine', 'it' => 'Creatività e cucina'],
    'type4_text'  => [
      'type' => 'textarea',
      'en' => 'Writing, painting, photography or cooking with local chefs, in places that inspire.',
      'fr' => 'Écriture, peinture, photographie ou cuisine avec des chefs locaux, dans des lieux qui inspirent.',
      'it' => 'Scrittura, pittura, fotografia o cucina con chef locali, in luoghi che ispirano.',
    ],

    // Quote band
    'quote' => [
      'type' => 'textarea',
      'en' => 'Wake up to the sea, practise in the shade of the olive trees, and let the days find their own rhythm.',
      'fr' => 'Se réveiller face à la mer, pratiquer à l’ombre des oliviers, et laisser les journées trouver leur propre rythme.',
      'it' => 'Svegliarsi davanti al mare, praticare all’ombra degli ulivi e lasciare che le giornate trovino il loro ritmo.',
    ],

    // Two ways to work with us
    'ways_eyebrow' => [
      'en' => 'Two ways to work with us',
      'fr' => 'Deux façons de travailler avec nous',
      'it' => 'Due modi di lavorare con noi',
    ],
    'ways_title' => [
      'en' => 'Your retreat, your way',
      'fr' => 'Votre retraite, à votre façon',
      'it' => 'Il vostro ritiro, a modo vostro',
    ],
    'way1_label' => [
      'en' => 'For teachers & organisers',
      'fr' => 'Pour les professeurs et organisateurs',
      'it' => 'Per insegnanti e organizzatori',
    ],
    'way1_title' => [
      'en' => 'You bring your group',
      'fr' => 'Vous venez avec votre groupe',
      'it' => 'Venite con il vostro gruppo',
    ],
    'way1_text' => [
      'type' => 'textarea',
      'en' => 'You have your students, your programme and your way of teaching. We provide the villa, the meals and the logistics, and handle everything around it, so you can focus on your group.',
      'fr' => 'Vous avez vos élèves, votre programme et votre façon d’enseigner. Nous fournissons la villa, les repas et la logistique, et gérons tout le reste, pour que vous puissiez vous consacrer à votre groupe.',
      'it' => 'Avete i vostri allievi, il vostro programma e il vostro modo di insegnare. Noi mettiamo a disposizione la villa, i pasti e la logistica, e ci occupiamo di tutto il resto, così potete dedicarvi al vostro gruppo.',
    ],
    'way2_label' => [
      'en' => 'For friends, families & companies',
      'fr' => 'Pour les amis, familles et entreprises',
      'it' => 'Per amici, famiglie e aziende',
    ],
    'way2_title' => [
      'en' => 'We organise it for you',
      'fr' => 'Nous l’organisons pour vous',
      'it' => 'Lo organizziamo per voi',
    ],
    'way2_text' => [
      'type' => 'textarea',
      'en' => 'You are a group of friends, a family or a team. We find the right teacher or facilitator, build the programme with you and take care of every detail.',
      'fr' => 'Vous êtes un groupe d’amis, une famille ou une équipe. Nous trouvons le bon professeur ou intervenant, construisons le programme avec vous et nous occupons de chaque détail.',
      'it' => 'Siete un gruppo di amici, una famiglia o una squadra. Troviamo l’insegnante o il facilitatore giusto, costruiamo il programma con voi e curiamo ogni dettaglio.',
    ],

    // Services
    'services_eyebrow' => [
      'en' => 'Around the practice',
      'fr' => 'Autour de la pratique',
      'it' => 'Intorno alla pratica',
    ],
    'services_title' => [
      'en' => 'Everything is taken care of',
      'fr' => 'Nous nous occupons de tout',
      'it' => 'Pensiamo a tutto noi',
    ],
    'services_text' => [
      'type' => 'textarea',
      'en' => 'One contact on the ground, before and during your stay. We work with local partners we know and trust.',
      'fr' => 'Un seul interlocuteur sur place, avant et pendant votre séjour. Nous travaillons avec des partenaires locaux que nous connaissons et en qui nous avons confiance.',
      'it' => 'Un unico referente sul posto, prima e durante il soggiorno. Lavoriamo con partner locali che conosciamo e di cui ci fidiamo.',
    ],
    'svc1_title' => ['en' => 'Private chef', 'fr' => 'Chef privé', 'it' => 'Chef privato'],
    'svc1_text'  => [
      'en' => 'Seasonal, local and healthy cooking, adapted to your group’s diets.',
      'fr' => 'Une cuisine de saison, locale et saine, adaptée aux régimes de votre groupe.',
      'it' => 'Una cucina di stagione, locale e sana, adattata alle esigenze alimentari del gruppo.',
    ],
    'svc2_title' => ['en' => 'Teachers & facilitators', 'fr' => 'Professeurs et intervenants', 'it' => 'Insegnanti e facilitatori'],
    'svc2_text'  => [
      'en' => 'Yoga teachers, coaches or artists we work with, if you do not bring your own.',
      'fr' => 'Des professeurs de yoga, coachs ou artistes avec qui nous travaillons, si vous ne venez pas avec les vôtres.',
      'it' => 'Insegnanti di yoga, coach o artisti con cui collaboriamo, se non portate i vostri.',
    ],
    'svc3_title' => ['en' => 'Spaces for practice', 'fr' => 'Des espaces pour pratiquer', 'it' => 'Spazi per la pratica'],
    'svc3_text'  => [
      'en' => 'Terraces, gardens and shaded corners chosen for practice and for working together.',
      'fr' => 'Des terrasses, des jardins et des coins d’ombre choisis pour pratiquer et travailler ensemble.',
      'it' => 'Terrazze, giardini e angoli d’ombra scelti per la pratica e per lavorare insieme.',
    ],
    'svc4_title' => ['en' => 'Massages & treatments', 'fr' => 'Massages et soins', 'it' => 'Massaggi e trattamenti'],
    'svc4_text'  => [
      'en' => 'Therapists who come to the villa, between two sessions or at the end of the day.',
      'fr' => 'Des thérapeutes qui viennent à la villa, entre deux séances ou en fin de journée.',
      'it' => 'Terapisti che vengono in villa, tra una sessione e l’altra o a fine giornata.',
    ],
    'svc5_title' => ['en' => 'Activities', 'fr' => 'Activités', 'it' => 'Attività'],
    'svc5_text'  => [
      'en' => 'Boat trips, walks in the countryside, wine tastings and cooking classes.',
      'fr' => 'Sorties en bateau, balades dans la campagne, dégustations de vin et cours de cuisine.',
      'it' => 'Uscite in barca, passeggiate in campagna, degustazioni di vino e corsi di cucina.',
    ],
    'svc6_title' => ['en' => 'Rooms for everyone', 'fr' => 'Des chambres pour chacun', 'it' => 'Camere per tutti'],
    'svc6_text'  => [
      'en' => 'One villa for your whole group, or several houses close together for larger retreats.',
      'fr' => 'Une villa pour tout votre groupe, ou plusieurs maisons proches pour les retraites plus importantes.',
      'it' => 'Una villa per tutto il gruppo, o più case vicine per i ritiri più numerosi.',
    ],
    'svc7_title' => ['en' => 'Transfers', 'fr' => 'Transferts', 'it' => 'Transfer'],
    'svc7_text'  => [
      'en' => 'Airport pickups and transport for the group throughout the stay.',
      'fr' => 'Accueil à l’aéroport et transport du groupe pendant tout le séjour.',
      'it' => 'Accoglienza in aeroporto e trasporto del gruppo per tutto il soggiorno.',
    ],
    'svc8_title' => ['en' => 'Working sessions', 'fr' => 'Sessions de travail', 'it' => 'Sessioni di lavoro'],
    'svc8_text'  => [
      'en' => 'For company off-sites: a space set up for meetings, with breaks planned around them.',
      'fr' => 'Pour les séminaires d’entreprise : un espace aménagé pour les réunions, et des pauses organisées autour.',
      'it' => 'Per i ritiri aziendali: uno spazio allestito per le riunioni e pause organizzate intorno.',
    ],

    // Gallery
    'gallery_eyebrow' => ['en' => 'Moments', 'fr' => 'Instants', 'it' => 'Momenti'],
    'gallery_title'   => [
      'en' => 'Picture your days here',
      'fr' => 'Imaginez vos journées ici',
      'it' => 'Immaginate qui le vostre giornate',
    ],

    // Enquiry
    'form_eyebrow' => [
      'en' => 'Retreat enquiry',
      'fr' => 'Demande de retraite',
      'it' => 'Richiesta per un ritiro',
    ],
    'form_title' => [
      'en' => 'Tell us about your retreat',
      'fr' => 'Parlez-nous de votre retraite',
      'it' => 'Raccontateci il vostro ritiro',
    ],
    'form_text' => [
      'type' => 'textarea',
      'en' => 'Share a few details and we will come back to you within 48 hours with first ideas and a selection of homes.',
      'fr' => 'Donnez-nous quelques détails et nous revenons vers vous sous 48 heures avec de premières idées et une sélection de maisons.',
      'it' => 'Lasciateci qualche dettaglio: vi ricontattiamo entro 48 ore con le prime idee e una selezione di case.',
    ],

    // Form labels (not editable in the admin)
    'f_name'    => ['admin' => false, 'en' => 'Your name', 'fr' => 'Votre nom', 'it' => 'Il vostro nome'],
    'f_who'     => ['admin' => false, 'en' => 'You are', 'fr' => 'Vous êtes', 'it' => 'Siete'],
    'f_who1'    => ['admin' => false, 'en' => 'A teacher or organiser', 'fr' => 'Un professeur ou organisateur', 'it' => 'Un insegnante o organizzatore'],
    'f_who2'    => ['admin' => false, 'en' => 'A private group', 'fr' => 'Un groupe privé', 'it' => 'Un gruppo privato'],
    'f_who3'    => ['admin' => false, 'en' => 'A company', 'fr' => 'Une entreprise', 'it' => 'Un’azienda'],
    'f_type'    => ['admin' => false, 'en' => 'Type of retreat', 'fr' => 'Type de retraite', 'it' => 'Tipo di ritiro'],
    'f_other'   => ['admin' => false, 'en' => 'Other', 'fr' => 'Autre', 'it' => 'Altro'],
    'f_date'    => ['admin' => false, 'en' => 'Dates or period', 'fr' => 'Dates ou période', 'it' => 'Date o periodo'],
    'f_date_ph' => ['admin' => false, 'en' => 'e.g. May 2027', 'fr' => 'ex. mai 2027', 'it' => 'es. maggio 2027'],
    'f_size'    => ['admin' => false, 'en' => 'Group size', 'fr' => 'Taille du groupe', 'it' => 'Dimensione del gruppo'],
    'f_s1'      => ['admin' => false, 'en' => 'Up to 10 people', 'fr' => 'Jusqu’à 10 personnes', 'it' => 'Fino a 10 persone'],
    'f_s2'      => ['admin' => false, 'en' => '10 to 20 people', 'fr' => 'De 10 à 20 personnes', 'it' => 'Da 10 a 20 persone'],
    'f_s3'      => ['admin' => false, 'en' => '20 to 30 people', 'fr' => 'De 20 à 30 personnes', 'it' => 'Da 20 a 30 persone'],
    'f_s4'      => ['admin' => false, 'en' => 'More than 30 people', 'fr' => 'Plus de 30 personnes', 'it' => 'Più di 30 persone'],
    'f_message' => ['admin' => false, 'en' => 'Your retreat in a few words', 'fr' => 'Votre retraite en quelques mots', 'it' => 'Il vostro ritiro in poche parole'],
  ];

  // Shared with the Weddings page: contact line, common form labels and messages
  $wedding = plh_wedding_copy();
  foreach ( [ 'form_talk', 'f_email', 'f_phone', 'f_select', 'f_consent', 'f_submit', 'f_success', 'err_required', 'err_email', 'err_send', 'err_security' ] as $k ) {
    $copy[ $k ] = $wedding[ $k ];
  }
  return $copy;
}

/** Text for the current language: the admin override if filled in, else the default copy. */
function plh_ret( $key ) {
  $copy = plh_retreat_copy();
  if ( ! isset( $copy[ $key ] ) ) return '';
  if ( ( $copy[ $key ]['admin'] ?? true ) && function_exists( 'get_field' ) ) {
    $custom = get_field( 'ret_' . $key );
    if ( is_string( $custom ) && trim( $custom ) !== '' ) return $custom;
  }
  $lang = plh_wedding_lang();
  return $copy[ $key ][ $lang ] ?? $copy[ $key ]['en'];
}

/* --------------------------------------------------------------------------
   Images: admin field if set, otherwise a villa photo from the media library.
   -------------------------------------------------------------------------- */
function plh_retreat_images() {
  return [
    'hero'     => [ 'label' => 'Hero',                       'file' => '2025/02/Jardin-1-scaled.webp' ],
    'intro'    => [ 'label' => 'Intro — photo 1',              'file' => '2025/03/Villa-Lucia-Garden-3.webp' ],
    'intro2'   => [ 'label' => 'Intro — photo 2',            'file' => '2024/11/1-Terrasse-ENT-3-scaled.webp' ],
    'intro3'   => [ 'label' => 'Intro — photo 3',            'file' => '2024/11/Jardin-2-scaled.webp' ],
    'type1'    => [ 'label' => 'Type 1 (yoga)',              'file' => '2024/11/4.2-Terrasse-PR-7.webp' ],
    'type2'    => [ 'label' => 'Type 2 (wellness)',          'file' => '2025/03/Villa-Lucia-Swimming-pool-1.webp' ],
    'type3'    => [ 'label' => 'Type 3 (company)',           'file' => '2025/02/Sam-EXT-3-scaled.webp' ],
    'type4'    => [ 'label' => 'Type 4 (creative & cooking)','file' => '2024/11/1-Grande-Ext.-3-scaled.webp' ],
    'day'      => [ 'label' => 'A day on retreat',           'file' => '2025/05/Terrasse-BA-6.webp' ],
    'gallery1' => [ 'label' => 'Gallery 1',          'file' => '2025/02/Piscine-10-scaled.webp' ],
    'gallery2' => [ 'label' => 'Gallery 2',                  'file' => '2025/05/Piscine-2.3.webp' ],
    'gallery3' => [ 'label' => 'Gallery 3',                  'file' => '2025/02/Jardin-7-scaled.webp' ],
    'gallery4' => [ 'label' => 'Gallery 4',           'file' => '2024/11/5-Terrasse-RDJ-3-scaled.webp' ],
    'gallery5' => [ 'label' => 'Gallery 5',                  'file' => '2025/05/Vue-generale-9-Mise-en-avant.webp' ],
    'gallery6' => [ 'label' => 'Gallery 6',                  'file' => '2025/05/Vue-generale-11.webp' ],
    'form_bg'  => [ 'label' => 'Enquiry background',         'file' => '2025/02/Jardin-6-scaled.webp' ],
  ];
}

function plh_ret_img_url( $key, $size = 'large' ) {
  $images = plh_retreat_images();
  if ( function_exists( 'get_field' ) ) {
    $id = get_field( 'ret_img_' . $key );
    if ( is_array( $id ) ) $id = $id['ID'] ?? 0;
    if ( $id ) {
      $url = wp_get_attachment_image_url( (int) $id, $size );
      if ( $url ) return $url;
    }
  }
  return isset( $images[ $key ] ) ? content_url( 'uploads/' . $images[ $key ]['file'] ) : '';
}

/* --------------------------------------------------------------------------
   Admin fields (shown on pages using the Retreats template)
   -------------------------------------------------------------------------- */
add_action( 'acf/init', function () {
  if ( ! function_exists( 'acf_add_local_field_group' ) ) return;

  $fields   = [];
  $fields[] = [ 'key' => 'field_ret_tab_images', 'label' => 'Images', 'type' => 'tab', 'placement' => 'top' ];
  foreach ( plh_retreat_images() as $key => $img ) {
    $fields[] = [
      'key'           => 'field_ret_img_' . $key,
      'label'         => $img['label'],
      'name'          => 'ret_img_' . $key,
      'type'          => 'image',
      'return_format' => 'id',
      'preview_size'  => 'medium',
      'instructions'  => 'Leave empty to use the default villa photo.',
      'wrapper'       => [ 'width' => 33 ],
    ];
  }

  $fields[] = [ 'key' => 'field_ret_tab_texts', 'label' => 'Texts', 'type' => 'tab', 'placement' => 'top' ];
  $fields[] = [
    'key'     => 'field_ret_texts_note',
    'label'   => '',
    'name'    => '',
    'type'    => 'message',
    'message' => 'Every text already has a default in this page’s language (shown in grey). Fill a field only to replace that text.',
  ];
  foreach ( plh_retreat_copy() as $key => $c ) {
    if ( isset( $c['admin'] ) && ! $c['admin'] ) continue;
    $fields[] = [
      'key'         => 'field_ret_' . $key,
      'label'       => ucfirst( str_replace( '_', ' ', $key ) ),
      'name'        => 'ret_' . $key,
      'type'        => ( $c['type'] ?? 'text' ) === 'textarea' ? 'textarea' : 'text',
      'rows'        => 3,
      'placeholder' => $c['en'],
    ];
  }

  acf_add_local_field_group( [
    'key'             => 'group_retreats_page',
    'title'           => 'Retreats page',
    'fields'          => $fields,
    'location'        => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'retreats.php' ] ] ],
    'position'        => 'normal',
    'label_placement' => 'top',
    'hide_on_screen'  => [ 'the_content' ],
  ] );
} );

/* Show the page-language default as the placeholder of each text field */
add_filter( 'acf/prepare_field', function ( $field ) {
  if ( empty( $field['name'] ) || strpos( $field['name'], 'ret_' ) !== 0 || strpos( $field['name'], 'ret_img_' ) === 0 ) return $field;
  $key  = substr( $field['name'], 4 );
  $copy = plh_retreat_copy();
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
function plh_handle_retreat_enquiry() {
  $back = wp_get_referer() ?: home_url( '/' );
  $back = remove_query_arg( [ 'retreat_enquiry', 'retreat_error' ], $back );
  $fail = function ( $code, $data = null ) use ( $back ) {
    if ( $data !== null ) $_SESSION['retreat_form_data'] = $data;
    wp_safe_redirect( add_query_arg( [ 'retreat_enquiry' => 'error', 'retreat_error' => $code ], $back ) . '#retreat-enquiry' );
    exit;
  };

  if ( ! isset( $_POST['plh_retreat_nonce'] ) || ! wp_verify_nonce( $_POST['plh_retreat_nonce'], 'plh_retreat_enquiry' ) ) {
    $fail( 'security' );
  }
  // Honeypot: bots fill it, people never see it
  if ( ! empty( $_POST['ret_hp_field'] ) ) {
    wp_safe_redirect( add_query_arg( 'retreat_enquiry', 'success', $back ) . '#retreat-enquiry' );
    exit;
  }

  $data = [
    'ret_name'    => sanitize_text_field( wp_unslash( $_POST['ret_name'] ?? '' ) ),
    'ret_email'   => sanitize_email( wp_unslash( $_POST['ret_email'] ?? '' ) ),
    'ret_phone'   => sanitize_text_field( wp_unslash( $_POST['ret_phone'] ?? '' ) ),
    'ret_who'     => sanitize_key( $_POST['ret_who'] ?? '' ),
    'ret_type'    => sanitize_key( $_POST['ret_type'] ?? '' ),
    'ret_date'    => sanitize_text_field( wp_unslash( $_POST['ret_date'] ?? '' ) ),
    'ret_size'    => sanitize_key( $_POST['ret_size'] ?? '' ),
    'ret_message' => sanitize_textarea_field( wp_unslash( $_POST['ret_message'] ?? '' ) ),
  ];

  // sanitize_email() empties an invalid address, so check what was typed for "required"
  $typed_email = trim( sanitize_text_field( wp_unslash( $_POST['ret_email'] ?? '' ) ) );

  if ( $data['ret_name'] === '' || $typed_email === '' || $data['ret_phone'] === '' || empty( $_POST['ret_consent'] ) ) {
    $data['ret_email'] = $data['ret_email'] ?: $typed_email;
    $fail( 'required', $data );
  }
  if ( ! is_email( $data['ret_email'] ) ) {
    $data['ret_email'] = $typed_email;
    $fail( 'email', $data );
  }

  // The email to the team is in English, whatever the page language.
  // Choices are sent as copy keys; show their English label.
  $copy  = plh_retreat_copy();
  $label = function ( $value ) use ( $copy ) {
    return isset( $copy[ $value ] ) ? $copy[ $value ]['en'] : $value;
  };
  $rows = [
    'Name'          => $data['ret_name'],
    'Email'         => $data['ret_email'],
    'Phone'         => $data['ret_phone'],
    'They are'      => $label( $data['ret_who'] ),
    'Retreat type'  => $label( $data['ret_type'] ),
    'Dates'         => $data['ret_date'],
    'Group size'    => $label( $data['ret_size'] ),
    'Page language' => strtoupper( sanitize_key( $_POST['form_language'] ?? 'en' ) ),
  ];

  $body  = '<html><body style="font-family:Arial,sans-serif;line-height:1.6;color:#222;">';
  $body .= '<h2 style="color:#6c9ba3;">New retreat enquiry</h2>';
  foreach ( $rows as $name => $value ) {
    $body .= '<p><strong>' . esc_html( $name ) . ':</strong> ' . esc_html( $value !== '' ? $value : 'Not provided' ) . '</p>';
  }
  if ( $data['ret_message'] !== '' ) {
    $body .= '<h3 style="color:#6c9ba3;border-bottom:2px solid #f0f0f0;padding-bottom:8px;">Message</h3>';
    $body .= '<p>' . nl2br( esc_html( $data['ret_message'] ) ) . '</p>';
  }
  $body .= '<hr style="margin:30px 0;border:none;border-top:1px solid #ddd;">';
  $body .= '<p style="color:#888;font-size:12px;"><em>Sent from the retreats page on ' . esc_html( wp_date( 'F j, Y \a\t g:i a' ) ) . '</em></p>';
  $body .= '</body></html>';

  $headers = [
    'Content-Type: text/html; charset=UTF-8',
    'Reply-To: ' . $data['ret_email'],
  ];
  $sent = wp_mail( 'reservation@puglialuxuryhomes.com', 'New retreat enquiry: ' . $data['ret_name'], $body, $headers );

  if ( ! $sent ) $fail( 'send', $data );

  wp_safe_redirect( add_query_arg( 'retreat_enquiry', 'success', $back ) . '#retreat-enquiry' );
  exit;
}
add_action( 'admin_post_plh_retreat_enquiry', 'plh_handle_retreat_enquiry' );
add_action( 'admin_post_nopriv_plh_retreat_enquiry', 'plh_handle_retreat_enquiry' );

/* --------------------------------------------------------------------------
   ONE-TIME: create the three Retreats pages as drafts, linked in Polylang.
   Runs the first time an admin opens the dashboard after the deploy, and only
   if no page uses the template yet. Publish them when the client has approved.
   -------------------------------------------------------------------------- */
add_action( 'admin_init', function () {
  $version = '2026-11-retreats-pages';
  if ( get_option( 'plh_content_update_retreats' ) === $version ) return;
  if ( ! current_user_can( 'manage_options' ) ) return;

  $existing = get_posts( [
    'post_type'   => 'page',
    'post_status' => 'any',
    'meta_key'    => '_wp_page_template',
    'meta_value'  => 'retreats.php',
    'numberposts' => 1,
    'fields'      => 'ids',
    'lang'        => '',
  ] );

  if ( ! $existing ) {
    $pages = [
      'en' => [ 'title' => 'Retreats in Puglia',          'slug' => 'retreats-in-puglia' ],
      'fr' => [ 'title' => 'Retraites dans les Pouilles', 'slug' => 'retraites-dans-les-pouilles' ],
      'it' => [ 'title' => 'Ritiri in Puglia',            'slug' => 'ritiri-in-puglia' ],
    ];
    $ids = [];
    foreach ( $pages as $lang => $p ) {
      $id = wp_insert_post( [
        'post_type'    => 'page',
        'post_status'  => 'draft',
        'post_title'   => $p['title'],
        'post_name'    => $p['slug'],
        'post_content' => '',
      ] );
      if ( ! $id || is_wp_error( $id ) ) continue;
      update_post_meta( $id, '_wp_page_template', 'retreats.php' );
      if ( function_exists( 'pll_set_post_language' ) ) pll_set_post_language( $id, $lang );
      $ids[ $lang ] = $id;
    }
    if ( count( $ids ) > 1 && function_exists( 'pll_save_post_translations' ) ) {
      pll_save_post_translations( $ids );
    }
  }

  update_option( 'plh_content_update_retreats', $version, false );
} );

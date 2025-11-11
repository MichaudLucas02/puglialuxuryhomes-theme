<?php
// Theme supports
add_action('after_setup_theme', function () {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']);
  add_theme_support('editor-styles');
  add_editor_style('editor.css'); // create later if you want
  register_nav_menus([
    'primary' => __('Primary Menu', 'thinktech'),
    'footer'  => __('Footer Menu', 'thinktech'),
    'mobile'  => __('Mobile Menu', 'thinktech'),
    'primary_fr' => __('Primary Menu FR', 'thinktech'),
  ]);
});

// Assets

add_action('wp_enqueue_scripts', function () {
  $dir = get_stylesheet_directory();
  $uri = get_stylesheet_directory_uri();

  // --- CSS (versioned by file mtime) ---
  $css = $dir . '/style.css';
  wp_enqueue_style(
    'plh-style',
    get_stylesheet_uri(),
    [],
    file_exists($css) ? filemtime($css) : '1.0.0'
  );

  // --- Header behavior (always load if present) ---
  $header_js = $dir . '/assets/js/header.js';
  if ( file_exists($header_js) ) {
    wp_enqueue_script(
      'plh-header',
      $uri . '/assets/js/header.js',
      [],
      filemtime($header_js),
      true
    );
  }

  // --- Villa card slider (load only where needed) ---
  $slider_js = $dir . '/assets/js/villa-card-slider.js';
  if ( file_exists($slider_js) ) {
    // Home page (front-page.php) and/or villas archive/single
    if ( is_front_page() || is_post_type_archive('villa') || is_singular('villa') ) {
      wp_enqueue_script(
        'plh-villa-slider',
        $uri . '/assets/js/villa-card-slider.js',
        [],
        filemtime($slider_js),
        true
      );
    }
  }
  $js = $dir . '/assets/js/discover-mobile.js';
  if ( file_exists($js) ) {
    wp_enqueue_script(
      'plh-discover-mobile',
      $uri . '/assets/js/discover-mobile.js',
      [],
      filemtime($js),
      true
    );
  }
  
});

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style(
    'swiper',
    'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
    [],
    '11'
  );

  wp_enqueue_script(
    'swiper',
    'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
    [],
    '11',
    true // load in footer
  );

  // Your script depends on swiper so it loads after it
  wp_enqueue_script(
    'theme-scripts',
    get_template_directory_uri() . '/assets/js/script.js',
    ['swiper'],
    filemtime(get_template_directory() . '/assets/js/script.js'),
    true
  );
});




// --- Theme supports you likely already have ---
add_action('after_setup_theme', function () {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails'); // needed for featured images
  add_image_size('villa_card', 960, 720, true); // 4:3 crop for cards
});

// --- Register the "villa" CPT (+ optional "Collections" taxonomy) ---
function plh_register_cpts() {
  register_post_type('villa', [
    'label'         => 'Villas',
    'labels'        => ['singular_name' => 'Villa'],
    'public'        => true,
    'has_archive'   => true,
    'rewrite'       => ['slug' => 'villas'],
    'menu_icon'     => 'dashicons-admin-home',
    'menu_position' => 20,
    'supports'      => ['title','editor','thumbnail','excerpt','page-attributes'],
    'show_in_rest'  => true,
  ]);

  // Optional taxonomy to group by Sea/City/Land etc.
  register_taxonomy('villa_collection', ['villa'], [
    'label'        => 'Collections',
    'hierarchical' => true,
    'rewrite'      => ['slug' => 'collection'],
    'show_in_rest' => true,
  ]);
}
add_action('init', 'plh_register_cpts');

// --- Flush permalinks once on theme switch so /villas works ---
add_action('after_switch_theme', function () {
  plh_register_cpts();
  flush_rewrite_rules();
});

function custom_breadcrumbs() {
  echo '<nav class="breadcrumbs">';
  if (!is_front_page()) {
    echo '<a href="' . home_url() . '">Home</a> » ';
      if (is_category() || is_single()) {
        the_category(' » ');
        if (is_single()) {
                echo " » ";
                the_title();
        }
       } elseif (is_page()) {
            echo the_title();
      }

  }
  echo '</nav>';
}


add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'    => 'group_villa_details_1',
    'title'  => 'All Villa Details ',
    'fields' => [
      [
        'key'   => 'field_villa_location_1',
        'label' => 'Location',
        'name'  => 'villa_location_1',
        'type'  => 'text',
      ],
      [
        'key'   => 'field_price_from_1',
        'label' => 'Price From (per week)',
        'name'  => 'price_from_1',
        'type'  => 'number',
        'prepend' => '€',
        'min'   => 0,
      ],
      [
        'key'   => 'field_price_to_1',
        'label' => 'Price to (per week)',
        'name'  => 'price_to_1',
        'type'  => 'number',
        'prepend' => '€',
        'min'   => 0,
      ],
      [
        'key'   => 'field_beds_1',
        'label' => 'Beds',
        'name'  => 'beds_1',
        'type'  => 'number',
        'min'   => 0,
      ],
      [
        'key'   => 'field_baths_1',
        'label' => 'Baths',
        'name'  => 'baths_1',
        'type'  => 'number',
        'min'   => 0,
      ],
      [
        'key'   => 'field_guests_1',
        'label' => 'Guests',
        'name'  => 'guests_1',
        'type'  => 'number',
        'min'   => 0,
      ],
      [
        'key'   => 'field_sqm_1',
        'label' => 'SQM',
        'name'  => 'sqm_1',
        'type'  => 'number',
        'min'   => 0,
      ],
      [
        'key'   => 'field_rameaux_1',
        'label' => 'Rameaux',
        'name'  => 'rameaux_1',
        'type'  => 'text',
      ],

      [
        'key'   => 'field_villa_collection_1',
        'label' => 'Collection',
        'name'  => 'villa_collection_1',
        'type'  => 'text',
        'instructions' => 'e.g., New, Featured',
      ],
      [
        'key'           => 'field_card_image_1',
        'label'         => 'Card Image',
        'name'          => 'card_image_11',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium',
        'library'       => 'all',
        'instructions'  => 'If empty, the Featured Image will be used.',
      ],
      [
        'key'           => 'field_card_image_22',
        'label'         => 'Card Image 2',
        'name'          => 'card_image_22',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium',
        'library'       => 'all',
      ],
      [
        'key'           => 'field_card_image_33',
        'label'         => 'Card Image 3',
        'name'          => 'card_image_33',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium',
        'library'       => 'all',
      ],
    ],
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'villa',
    ]]],
  ]);
});

add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'    => 'group_villa_details_2',
    'title'  => 'Villa Descirption Text ',
    'fields' => [
      [
        'key'        => 'field_intro_paragraph',
        'label'      => 'Intro Paragraph',
        'name'       => 'intro_paragraph',
        'type'       => 'textarea',
        'rows'       => 4,
        'new_lines'  => 'wpautop',   // converts line breaks to <p>…</p>
        'placeholder'=> 'Write a short intro…',
      ],
      [
        'key'        => 'field_readmore_paragraph',
        'label'      => 'Read More Paragraph',
        'name'       => 'read_more_paragraph',
        'type'       => 'textarea',
        'rows'       => 4,
        'new_lines'  => 'wpautop',   // converts line breaks to <p>…</p>
        'placeholder'=> 'Write a short intro…',
      ],
    ],


      
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'villa',
    ]]],
  ]);
});

add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'   => 'group_villa_details_3',
    'title' => 'Must Have',
    'fields' => [
      [
        'key'     => 'field_must_have_1',
        'label'   => 'Must Have 1',
        'name'    => 'must_have_1',
        'type'    => 'text',
      ],
      [
        'key'     => 'field_must_have_2',
        'label'   => 'Must Have 2',
        'name'    => 'must_have_2',
        'type'    => 'text',
      ],
      [
        'key'     => 'field_must_have_3',
        'label'   => 'Must Have 3',
        'name'    => 'must_have_3',
        'type'    => 'text',
      ],
      [
        'key'     => 'field_must_have_4',
        'label'   => 'Must Have 4',
        'name'    => 'must_have_4',
        'type'    => 'text',
      ],
    ],

    'location' => [[[
      'param'     => 'post_type',
      'operator'  => '==',
      'value'     => 'villa',
    ]]],
  ]);
});

add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  $GROUP_COUNT = 8;   // how many feature groups
  $ROWS_PER    = 10;  // rows per group (Feature + KPI)

  $fields = [];

  for ($g = 1; $g <= $GROUP_COUNT; $g++) {

    // --- Visual tab for this group in the editor ---
    $fields[] = [
      'key'       => "field_features_tab_$g",
      'label'     => "Feature Group $g",
      'type'      => 'tab',
      'placement' => 'top',
    ];

    // --- HEADER ROW: Title (70) | KPI Type (15) | KPI Text (15) | KPI Icon (10) | Icon Color (5) ---
    $fields[] = [
      'key'    => "field_group_header_$g",
      'label'  => "Group $g Header",
      'name'   => "group_header_$g",
      'type'   => 'group',
      'layout' => 'row', // make sub_fields sit on one line
      'sub_fields' => [
        [
          'key'     => "field_features_title_$g",
          'label'   => "Group $g Title",
          'name'    => "features_title_$g",
          'type'    => 'text',
          'wrapper' => ['width' => 70],
        ],
        [
          'key'           => "field_features_title_kpi_type_$g",
          'label'         => "Group $g KPI Type",
          'name'          => "features_title_kpi_type_$g",
          'type'          => 'select',
          'choices'       => ['text' => 'Text', 'icon' => 'Icon'],
          'default_value' => 'text',
          'return_format' => 'value',
          'wrapper'       => ['width' => 15],
        ],
        [
          'key'     => "field_features_title_kpi_text_$g",
          'label'   => "Group $g KPI (Text)",
          'name'    => "features_title_kpi_text_$g",
          'type'    => 'text',
          'conditional_logic' => [[[
            'field'    => "field_features_title_kpi_type_$g",
            'operator' => '==',
            'value'    => 'text',
          ]]],
          'wrapper' => ['width' => 15],
        ],
        [
          'key'     => "field_features_title_kpi_icon_$g",
          'label'   => "Group $g KPI (Icon)",
          'name'    => "features_title_kpi_icon_$g",
          'type'    => 'select',
          'choices' => [
            'check' => 'Check',
            'x'     => 'X',
            'info'  => 'Info',
            'star'  => 'Star',
          ],
          'conditional_logic' => [[[
            'field'    => "field_features_title_kpi_type_$g",
            'operator' => '==',
            'value'    => 'icon',
          ]]],
          'wrapper' => ['width' => 10],
        ],
        [
          'key'     => "field_features_title_kpi_color_$g",
          'label'   => "Icon Color (hex)",
          'name'    => "features_title_kpi_color_$g",
          'type'    => 'text', // e.g. #90b0b7 (use color_picker if you have ACF Pro)
          'placeholder' => '#90b0b7',
          'conditional_logic' => [[[
            'field'    => "field_features_title_kpi_type_$g",
            'operator' => '==',
            'value'    => 'icon',
          ]]],
          'wrapper' => ['width' => 5],
        ],
      ],
    ];

    // --- FEATURE ROWS: Label (70) | KPI Type (15) | KPI Text (15) | KPI Icon (10) | Icon Color (5) ---
    for ($i = 1; $i <= $ROWS_PER; $i++) {
      $fields[] = [
        'key'    => "field_group_row_{$g}_{$i}",
        'label'  => "Feature $i",
        'name'   => "group_row_{$g}_{$i}",
        'type'   => 'group',
        'layout' => 'row',
        'sub_fields' => [
          [
            'key'     => "field_feature_label_{$g}_{$i}",
            'label'   => "Feature $i Label",
            'name'    => "feature_label_{$g}_{$i}",
            'type'    => 'text',
            'wrapper' => ['width' => 70],
          ],
          [
            'key'           => "field_feature_kpi_type_{$g}_{$i}",
            'label'         => "KPI $i Type",
            'name'          => "feature_kpi_type_{$g}_{$i}",
            'type'          => 'select',
            'choices'       => ['text' => 'Text', 'icon' => 'Icon'],
            'default_value' => 'text',
            'return_format' => 'value',
            'wrapper'       => ['width' => 15],
          ],
          [
            'key'     => "field_feature_kpi_text_{$g}_{$i}",
            'label'   => "KPI $i (Text)",
            'name'    => "feature_kpi_text_{$g}_{$i}",
            'type'    => 'text',
            'conditional_logic' => [[[
              'field'    => "field_feature_kpi_type_{$g}_{$i}",
              'operator' => '==',
              'value'    => 'text',
            ]]],
            'wrapper' => ['width' => 15],
          ],
          [
            'key'     => "field_feature_kpi_icon_{$g}_{$i}",
            'label'   => "KPI $i (Icon)",
            'name'    => "feature_kpi_icon_{$g}_{$i}",
            'type'    => 'select',
            'choices' => ['check'=>'Check','x'=>'X','info'=>'Info','optional'=>'Optional'],
            'conditional_logic' => [[[
              'field'    => "field_feature_kpi_type_{$g}_{$i}",
              'operator' => '==',
              'value'    => 'icon',
            ]]],
            'wrapper' => ['width' => 10],
          ],
          [
            'key'     => "field_feature_kpi_color_{$g}_{$i}",
            'label'   => "Icon Color (hex)",
            'name'    => "feature_kpi_color_{$g}_{$i}",
            'type'    => 'text',
            'placeholder' => '#90b0b7',
            'conditional_logic' => [[[
              'field'    => "field_feature_kpi_type_{$g}_{$i}",
              'operator' => '==',
              'value'    => 'icon',
            ]]],
            'wrapper' => ['width' => 5],
          ],
        ],
      ];
    }
  }

  acf_add_local_field_group([
    'key'      => 'group_features_parent',
    'title'    => 'Features',
    'fields'   => $fields,
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'villa',
    ]]],
    'position'        => 'acf_after_title',
    'label_placement' => 'top',
  ]);
});


function plh_render_features_4x4($post_id, $rows_per = 10) {
  $fa_map = [
    'check' => 'fa-solid fa-circle-check',
    'x'     => 'fa-regular fa-circle-xmark',
    'info'  => 'fa-regular fa-circle-question',
    'optional'  => 'fa-solid fa-circle-minus',
  ];
  $sanitize_hex = function ($c) {
    return preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $c) ? $c : '';
  };

  // helpers that read the NEW grouped values first, fallback to OLD flat fields
  $get_header = function ($g) use ($post_id) {
    $h = get_field("group_header_$g", $post_id); // array if using Group
    return is_array($h) ? $h : [
      // fallbacks to pre-group field names (old structure)
      "features_title_$g"        => get_field("features_title_$g", $post_id),
      "features_title_kpi_type_$g"  => get_field("features_title_kpi_type_$g", $post_id),
      "features_title_kpi_text_$g"  => get_field("features_title_kpi_text_$g", $post_id),
      "features_title_kpi_icon_$g"  => get_field("features_title_kpi_icon_$g", $post_id),
      "features_title_kpi_color_$g" => get_field("features_title_kpi_color_$g", $post_id),
    ];
  };

  $get_row = function ($g, $i) use ($post_id) {
    $r = get_field("group_row_{$g}_{$i}", $post_id); // array if using Group
    if (is_array($r)) return $r;
    // fallbacks to pre-group field names
    return [
      "feature_label_{$g}_{$i}"    => get_field("feature_label_{$g}_{$i}", $post_id),
      "feature_kpi_type_{$g}_{$i}" => get_field("feature_kpi_type_{$g}_{$i}", $post_id),
      "feature_kpi_text_{$g}_{$i}" => get_field("feature_kpi_text_{$g}_{$i}", $post_id),
      "feature_kpi_icon_{$g}_{$i}" => get_field("feature_kpi_icon_{$g}_{$i}", $post_id),
      "feature_kpi_color_{$g}_{$i}"=> get_field("feature_kpi_color_{$g}_{$i}", $post_id),
    ];
  };

  $render_kpi = function ($type, $txt, $icon_key, $color_hex) use ($fa_map, $sanitize_hex) {
    if ($type === 'icon' && isset($fa_map[$icon_key])) {
      $style = ($color_hex = $sanitize_hex($color_hex)) ? ' style="color:'.$color_hex.';"' : '';
      return '<i class="'.esc_attr($fa_map[$icon_key]).'"'.$style.'></i>';
    }
    if ($type === 'text' && $txt !== '') {
      return '<p>'.esc_html($txt).'</p>';
    }
    return '';
  };

  $render_group = function ($g) use ($post_id, $rows_per, $get_header, $get_row, $render_kpi) {
    $H = $get_header($g);
    $title = trim((string) ($H["features_title_$g"] ?? ''));
    $h_type = ($H["features_title_kpi_type_$g"] ?? 'text') ?: 'text';
    $h_txt  = trim((string) ($H["features_title_kpi_text_$g"] ?? ''));
    $h_icon = ($H["features_title_kpi_icon_$g"] ?? '');
    $h_col  = (string) ($H["features_title_kpi_color_$g"] ?? '');

    $rows_html = '';
    for ($i = 1; $i <= $rows_per; $i++) {
      $R = $get_row($g, $i);
      $label = trim((string) ($R["feature_label_{$g}_{$i}"] ?? ''));
      $r_type = ($R["feature_kpi_type_{$g}_{$i}"] ?? 'text') ?: 'text';
      $r_txt  = trim((string) ($R["feature_kpi_text_{$g}_{$i}"] ?? ''));
      $r_icon = ($R["feature_kpi_icon_{$g}_{$i}"] ?? '');
      $r_col  = (string) ($R["feature_kpi_color_{$g}_{$i}"] ?? '');

      $kpi_html = $render_kpi($r_type, $r_txt, $r_icon, $r_col);
      if ($label === '' && $kpi_html === '') continue;

      $rows_html .= '<div class="villa-features row">'
                  .   '<p>'.esc_html($label).'</p>'
                  .   ($kpi_html ?: '<p></p>')
                  . '</div>';
    }

    $header_html = $render_kpi($h_type, $h_txt, $h_icon, $h_col);
    if ($title === '' && $header_html === '' && $rows_html === '') return '';

    $header = ($title !== '' || $header_html)
      ? '<div class="villa-features row"><h3>'.esc_html($title).'</h3>'.($header_html ?: '<p></p>').'</div>'
      : '';

    return '<div class="villa-features-category">'.$header.$rows_html.'</div>';
  };

  $left = $right = '';
  for ($g = 1; $g <= 8; $g++) {
    $html = $render_group($g);
    if ($html === '') continue;
    if ($g <= 4) $left .= $html; else $right .= $html;
  }

  if ($left === '' && $right === '') return;
  echo '<div class="villa-features"><div class="villa-features left">'.$left.'</div><div class="villa-features right">'.$right.'</div></div>';
}




// functions.php
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  $ROWS_PER = 12; // how many items per side (change to suit)

  $fields = [];

  // -------- Included (LEFT) --------
  $fields[] = [
    'key'       => 'field_ie_tab_included',
    'label'     => 'Included',
    'type'      => 'tab',
    'placement' => 'top',
  ];

  // Header (Title + Note) inline
  $fields[] = [
    'key'    => 'field_ie_included_header',
    'label'  => 'Included Header',
    'name'   => 'ie_included_header',
    'type'   => 'group',
    'layout' => 'row',
    'sub_fields' => [
      [
        'key'     => 'field_ie_included_title',
        'label'   => 'Title',
        'name'    => 'ie_included_title',
        'type'    => 'text',
        'wrapper' => ['width' => 70],
        'placeholder' => 'Included',
      ],
      [
        'key'     => 'field_ie_included_note',
        'label'   => 'Small Note (optional)',
        'name'    => 'ie_included_note',
        'type'    => 'text',
        'wrapper' => ['width' => 30],
      ],
    ],
  ];

  // Included rows
  for ($i = 1; $i <= $ROWS_PER; $i++) {
    $fields[] = [
      'key'    => "field_ie_included_row_$i",
      'label'  => "Included $i",
      'name'   => "ie_included_row_$i",
      'type'   => 'group',
      'layout' => 'row',
      'sub_fields' => [
        [
          'key'     => "field_ie_included_label_$i",
          'label'   => 'Label',
          'name'    => 'label',
          'type'    => 'text',
          'wrapper' => ['width' => 70],
        ],
        [
          'key'     => "field_ie_included_icon_$i",
          'label'   => 'Icon',
          'name'    => 'icon',
          'type'    => 'select',
          'choices' => [
            'check' => 'Check',
            'minus' => 'Minus',
            'x'     => 'X',
          ],
          'return_format' => 'value',
          'wrapper' => ['width' => 30],
        ],
      ],
    ];
  }

  // -------- Excluded (RIGHT) --------
  $fields[] = [
    'key'       => 'field_ie_tab_excluded',
    'label'     => 'Excluded',
    'type'      => 'tab',
    'placement' => 'top',
  ];

  // Header (Title + Note) inline
  $fields[] = [
    'key'    => 'field_ie_excluded_header',
    'label'  => 'Excluded Header',
    'name'   => 'ie_excluded_header',
    'type'   => 'group',
    'layout' => 'row',
    'sub_fields' => [
      [
        'key'     => 'field_ie_excluded_title',
        'label'   => 'Title',
        'name'    => 'ie_excluded_title',
        'type'    => 'text',
        'wrapper' => ['width' => 70],
        'placeholder' => 'Excluded',
      ],
      [
        'key'     => 'field_ie_excluded_note',
        'label'   => 'Small Note (optional)',
        'name'    => 'ie_excluded_note',
        'type'    => 'text',
        'wrapper' => ['width' => 30],
      ],
    ],
  ];

  // Excluded rows
  for ($i = 1; $i <= $ROWS_PER; $i++) {
    $fields[] = [
      'key'    => "field_ie_excluded_row_$i",
      'label'  => "Excluded $i",
      'name'   => "ie_excluded_row_$i",
      'type'   => 'group',
      'layout' => 'row',
      'sub_fields' => [
        [
          'key'     => "field_ie_excluded_label_$i",
          'label'   => 'Label',
          'name'    => 'label',
          'type'    => 'text',
          'wrapper' => ['width' => 70],
        ],
        [
          'key'     => "field_ie_excluded_icon_$i",
          'label'   => 'Icon',
          'name'    => 'icon',
          'type'    => 'select',
          'choices' => [
            'check' => 'Check',
            'minus' => 'Minus',
            'x'     => 'X',
          ],
          'return_format' => 'value',
          'wrapper' => ['width' => 30],
        ],
      ],
    ];
  }

  acf_add_local_field_group([
    'key'      => 'group_included_excluded',
    'title'    => 'Included / Excluded',
    'fields'   => $fields,
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'villa',
    ]]],
    'position'        => 'acf_after_title',
    'label_placement' => 'top',
  ]);
});



function plh_render_included_excluded_rows2($post_id, $rows_per = 12) {
  $fa = [
    'check' => 'fa-regular fa-circle-check',
    'minus' => 'fa-regular fa-circle-minus',
    'x'     => 'fa-regular fa-circle-xmark',
  ];
  $icon_tag = function($key) use ($fa) {
    return isset($fa[$key]) ? '<i class="'.esc_attr($fa[$key]).'"></i>' : '';
  };

  // Headers
  $inc_head  = get_field('ie_included_header', $post_id) ?: [];
  $inc_title = trim((string)($inc_head['ie_included_title'] ?? 'Included'));

  $exc_head  = get_field('ie_excluded_header', $post_id) ?: [];
  $exc_title = trim((string)($exc_head['ie_excluded_title'] ?? 'Excluded'));

  // Included rows (skip if label empty)
  $included_rows = '';
  for ($i = 1; $i <= $rows_per; $i++) {
    $row   = get_field("ie_included_row_$i", $post_id);
    if (!is_array($row)) continue;
    $label = trim((string)($row['label'] ?? ''));
    if ($label === '') continue;                    // <- key line: no label, no row
    $icon  = (string)($row['icon'] ?? '');
    $included_rows .= '<div class="villa-features row2">'
                    .   $icon_tag($icon)
                    .   '<p>'.esc_html($label).'</p>'
                    . '</div>';
  }

  // Excluded rows (skip if label empty)
  $excluded_rows = '';
  for ($i = 1; $i <= $rows_per; $i++) {
    $row   = get_field("ie_excluded_row_$i", $post_id);
    if (!is_array($row)) continue;
    $label = trim((string)($row['label'] ?? ''));
    if ($label === '') continue;                    // <- key line
    $icon  = (string)($row['icon'] ?? '');
    $excluded_rows .= '<div class="villa-features row2">'
                    .   $icon_tag($icon)
                    .   '<p>'.esc_html($label).'</p>'
                    . '</div>';
  }

  if ($included_rows === '' && $excluded_rows === '') return;

  echo '<div class="villa-features">';
    echo '<div class="villa-features left"><div class="villa-features-category">';
      echo '<h3>'.esc_html($inc_title).'</h3>';
      echo $included_rows;
    echo '</div></div>';

    echo '<div class="villa-features right"><div class="villa-features-category">';
      echo '<h3>'.esc_html($exc_title).'</h3>';
      echo $excluded_rows;
    echo '</div></div>';
  echo '</div>';
}



add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'    => 'group_villa_location',
    'title'  => 'Villa Location',
    'fields' => [
      [
        'key'   => 'field_villa_address',
        'label' => 'Address (display only)',
        'name'  => 'villa_address',
        'type'  => 'text',
        'wrapper' => ['width'=>100],
      ],
      [
        'key'   => 'field_villa_lat',
        'label' => 'Latitude',
        'name'  => 'villa_lat',
        'type'  => 'text', // text to avoid locale decimal issues
        'wrapper' => ['width'=>50],
      ],
      [
        'key'   => 'field_villa_lng',
        'label' => 'Longitude',
        'name'  => 'villa_lng',
        'type'  => 'text',
        'wrapper' => ['width'=>50],
      ],
    ],
    'location' => [[[
      'param' => 'post_type', 'operator' => '==', 'value' => 'villa',
    ]]],
  ]);
});


add_action('wp_enqueue_scripts', function () {
  // Leaflet CSS & JS
  wp_enqueue_style(
    'leaflet',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
    [],
    '1.9.4'
  );
  wp_enqueue_script(
    'leaflet',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
    [],
    '1.9.4',
    true
  );

  // Our tiny init script
  wp_enqueue_script(
    'villa-map',
    get_stylesheet_directory_uri() . '/assets/js/villa-map.js',
    ['leaflet'],
    '1.0',
    true
  );
  wp_enqueue_style(
    'villa-map',
    get_stylesheet_directory_uri() . '/assets/css/villa-map.css',
    [],
    '1.0'
  );
});


// Add /gallery endpoint to single villa permalinks, e.g. /villas/my-villa/gallery/
add_action('init', function () {
  add_rewrite_endpoint('gallery', EP_PERMALINK);
});

// Load a special template when /gallery/ is present
add_filter('template_include', function ($template) {
  if (is_singular('villa') && get_query_var('gallery', false) !== false) {
    $t = locate_template('single-villa-gallery.php');
    if ($t) return $t;
  }
  return $template;
});

// Make 'gallery' a public query var
add_filter('query_vars', function ($vars) {
  $vars[] = 'gallery';
  return $vars;
});

// Helper to build the gallery URL
function plh_villa_gallery_link($post_id = null) {
  $post_id = $post_id ?: get_the_ID();
  return trailingslashit(get_permalink($post_id)) . 'gallery/';
}




add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  $SECTION_COUNT = 6; // change this to how many “blocks” you want

  $fields = [];
  for ($s = 1; $s <= $SECTION_COUNT; $s++) {
    // Visual tab
    $fields[] = [
      'key'       => "field_gallery_tab_$s",
      'label'     => "Gallery — Section $s",
      'type'      => 'tab',
      'placement' => 'top',
    ];

    // Optional enable toggle per section
    $fields[] = [
      'key'     => "field_gallery_section_enable_$s",
      'label'   => "Enable Section $s",
      'name'    => "gallery_section_enable_$s",
      'type'    => 'true_false',
      'ui'      => 1,
      'default_value' => 1,
    ];

    // Layout A (matches .gallery-container)
    $fields[] = [
      'key'    => "field_gallery_section_{$s}_layout_a",
      'label'  => "Layout A (four images)",
      'name'   => "gallery_section_{$s}_layout_a",
      'type'   => 'group',
      'layout' => 'block',
      'sub_fields' => [
        [
          'key'   => "field_gallery_s{$s}_a1",
          'label' => "A1 — Left Top (big)",
          'name'  => "a1",
          'type'  => 'image',
          'return_format' => 'id',
          'preview_size'  => 'medium_large',
        ],
        [
          'key'   => "field_gallery_s{$s}_a2",
          'label' => "A2 — Left Bottom Left",
          'name'  => "a2",
          'type'  => 'image',
          'return_format' => 'id',
          'preview_size'  => 'medium',
        ],
        [
          'key'   => "field_gallery_s{$s}_a3",
          'label' => "A3 — Left Bottom Right",
          'name'  => "a3",
          'type'  => 'image',
          'return_format' => 'id',
          'preview_size'  => 'medium',
        ],
        [
          'key'   => "field_gallery_s{$s}_a4",
          'label' => "A4 — Right (big)",
          'name'  => "a4",
          'type'  => 'image',
          'return_format' => 'id',
          'preview_size'  => 'large',
        ],
      ],
    ];

    // Layout B (matches .gallery-container-2)
    $fields[] = [
      'key'    => "field_gallery_section_{$s}_layout_b",
      'label'  => "Layout B (four images)",
      'name'   => "gallery_section_{$s}_layout_b",
      'type'   => 'group',
      'layout' => 'block',
      'sub_fields' => [
        [
          'key'   => "field_gallery_s{$s}_b1",
          'label' => "B1 — Top Wide",
          'name'  => "b1",
          'type'  => 'image',
          'return_format' => 'id',
          'preview_size'  => 'large',
        ],
        [
          'key'   => "field_gallery_s{$s}_b2",
          'label' => "B2 — Row2 Left (tall)",
          'name'  => "b2",
          'type'  => 'image',
          'return_format' => 'id',
          'preview_size'  => 'large',
        ],
        [
          'key'   => "field_gallery_s{$s}_b3",
          'label' => "B3 — Row2 Right Top",
          'name'  => "b3",
          'type'  => 'image',
          'return_format' => 'id',
          'preview_size'  => 'medium',
        ],
        [
          'key'   => "field_gallery_s{$s}_b4",
          'label' => "B4 — Row2 Right Bottom",
          'name'  => "b4",
          'type'  => 'image',
          'return_format' => 'id',
          'preview_size'  => 'medium',
        ],
      ],
    ];
  }

  acf_add_local_field_group([
    'key'      => 'group_villa_gallery_sections',
    'title'    => 'Villa Gallery (Sections)',
    'fields'   => $fields,
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'villa',
    ]]],
    'position'        => 'acf_after_title',
    'label_placement' => 'top',
  ]);
});

function plh_render_villa_gallery_sections($post_id, $sections = 6) {
  // helper to get <img> by ID with your classes
  $img = function($id, $classes = '', $alt = '') {
    if (!$id) return '';
    // Use WordPress to output responsive markup; add your classes + lazy
    return wp_get_attachment_image(
      (int)$id,
      'full',
      false,
      [
        'class'   => trim($classes . ' lightbox-trigger'),
        'loading' => 'lazy',
        'alt'     => $alt !== '' ? $alt : get_post_meta($id, '_wp_attachment_image_alt', true),
      ]
    );
  };

  echo '<div class="gallery">';

  for ($s = 1; $s <= $sections; $s++) {
    $enabled = (bool) get_field("gallery_section_enable_$s", $post_id);
    $A = get_field("gallery_section_{$s}_layout_a", $post_id) ?: [];
    $B = get_field("gallery_section_{$s}_layout_b", $post_id) ?: [];
    // If disabled AND empty, skip
    if (!$enabled && !array_filter($A) && !array_filter($B)) continue;

    // --- Layout A ---
    if (array_filter($A)) {
      echo '<div class="gallery-container">';
        echo '<div class="gallery-column-1">';
          echo '<div class="container-photo-11">';
            echo $img($A['a1'] ?? null);
            echo '<div class="gallery-overlay"></div>';
          echo '</div>';
          echo '<div class="container-photo-12">';
            echo '<div class="container-photo-121">'.$img($A['a2'] ?? null).'</div>';
            echo '<div class="container-photo-121">'.$img($A['a3'] ?? null).'</div>';
          echo '</div>';
        echo '</div>';

        echo '<div class="gallery-column-2">';
          echo $img($A['a4'] ?? null);
        echo '</div>';
      echo '</div>';
    }

    // --- Layout B ---
    if (array_filter($B)) {
      echo '<div class="gallery-container-2">';
        echo '<div class="gallery2-row1">'.$img($B['b1'] ?? null).'</div>';
        echo '<div class="gallery2-row2">';
          echo '<div class="row2-col1">'.$img($B['b2'] ?? null).'</div>';
          echo '<div class="row2-col2">';
            echo '<div class="row2-col2-row1">'.$img($B['b3'] ?? null).'</div>';
            echo '<div class="row2-col2-row2">'.$img($B['b4'] ?? null).'</div>';
          echo '</div>';
        echo '</div>';
      echo '</div>';
    }
  }

  // Lightbox shell (leave as-is if you already include elsewhere)
  echo '
    <div id="lightbox">
      <span class="close">&times;</span>
      <img id="lightbox-img" src="" alt="" />
      <div class="controls">
        <span class="prev">&#10094;</span>
        <span class="next">&#10095;</span>
      </div>
    </div>
  ';

  echo '</div>'; // .gallery
}



add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'    => 'group_process',
    'title'  => 'Process',
    'fields' => [
      [
        'key'   => 'field_step_title_1',
        'label' => 'Step 1 Title',
        'name'  => 'step_title_1',
        'type'  => 'text',
      ],
      [
        'key'   => 'field_step_text_1',
        'label' => 'Step 1 Text',
        'name'  => 'step_text_1',
        'type'  => 'text',
      ],
      [
        'key'   => 'field_step_title_2',
        'label' => 'Step 2 Title',
        'name'  => 'step_title_2',
        'type'  => 'text',
      ],
      [
        'key'   => 'field_step_text_2',
        'label' => 'Step 2 Text',
        'name'  => 'step_text_2',
        'type'  => 'text',
      ],
      [
        'key'   => 'field_step_title_3',
        'label' => 'Step 3 Title',
        'name'  => 'step_title_3',
        'type'  => 'text',
      ],
      [
        'key'   => 'field_step_text_3',
        'label' => 'Step 3 Text',
        'name'  => 'step_text_3',
        'type'  => 'text',
      ],
      [
        'key'   => 'field_step_title_4',
        'label' => 'Step 4 Title',
        'name'  => 'step_title_4',
        'type'  => 'text',
      ],
      [
        'key'   => 'field_step_text_4',
        'label' => 'Step 4 Text',
        'name'  => 'step_text_4',
        'type'  => 'text',
      ],
      [
        'key'   => 'field_step_title_5',
        'label' => 'Step 5 Title',
        'name'  => 'step_title_5',
        'type'  => 'text',
      ],
      [
        'key'  => 'field_step_text_5',
        'label' => 'Step 5 Text',
        'name'  => 'step_text_5',
        'type'  => 'text',
      ]
    ],
    'location' => [
      [
        [
          'param'    => 'page_template',
          'operator' => '==',
          'value'    => 'property-management.php',
        ],
      ],
      [
        [
          'param'   => 'page_template',
          'operator'  => '==',
          'value'   => 'concierge-services.php',
        ],
      ]
    ],
  ]);
});
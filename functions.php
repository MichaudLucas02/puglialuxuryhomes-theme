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

  // Register a custom block pattern category for PLH patterns
  if ( function_exists('register_block_pattern_category') ) {
    register_block_pattern_category('plh', [
      'label' => __('PLH', 'thinktech')
    ]);
    
  }
  load_theme_textdomain('thinktech', get_template_directory() . '/languages');
});

// Assets




// Register Custom Post Type: Blog
add_action('init', function() {
  $labels = [
    'name' => _x('Blog Posts', 'Post Type General Name', 'plh'),
    'singular_name' => _x('Blog Post', 'Post Type Singular Name', 'plh'),
    'menu_name' => __('Blog', 'plh'),
    'name_admin_bar' => __('Blog Post', 'plh'),
    'add_new' => __('Add New', 'plh'),
    'add_new_item' => __('Add New Blog Post', 'plh'),
    'edit_item' => __('Edit Blog Post', 'plh'),
    'new_item' => __('New Blog Post', 'plh'),
    'view_item' => __('View Blog Post', 'plh'),
    'search_items' => __('Search Blog Posts', 'plh'),
    'not_found' => __('No blog posts found', 'plh'),
    'not_found_in_trash' => __('No blog posts found in Trash', 'plh'),
  ];
  $args = [
    'label' => __('Blog', 'plh'),
    'labels' => $labels,
    'public' => true,
    'has_archive' => true,
    'rewrite' => ['slug' => 'blog', 'with_front' => false],
    'show_in_rest' => true,
    'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments'],
    'taxonomies' => ['category', 'post_tag'],
    'menu_icon' => 'dashicons-edit',
  ];
  register_post_type('blog', $args);
});

// Flush rewrite rules on theme switch so the /blog archive works immediately
add_action('after_switch_theme', function() {
  flush_rewrite_rules();
});

  // -----------------------
  // SEO Meta (Title + Description) for Blog CPT
  // -----------------------
  add_action('add_meta_boxes', function() {
    add_meta_box(
      'plh_blog_seo',
      __('SEO Settings', 'plh'),
      function($post){
        $custom_title = get_post_meta($post->ID, '_plh_seo_title', true);
        $meta_desc    = get_post_meta($post->ID, '_plh_meta_description', true);
        wp_nonce_field('plh_seo_meta_nonce', 'plh_seo_meta_nonce_field');
        echo '<p><label style="display:block;font-weight:600;margin-bottom:4px">'.__('Custom SEO Title (optional)', 'plh').'</label>';
        echo '<input type="text" name="plh_seo_title" value="'.esc_attr($custom_title).'" style="width:100%;max-width:760px" placeholder="'.esc_attr__('Villas de luxe à louer dans les Pouilles en 2026 | Puglia Luxury Homes','plh').'" />';
        echo '<small>'.__('Max ~70 characters. Leave empty to use post title.', 'plh').'</small></p>';
        echo '<p style="margin-top:16px"><label style="display:block;font-weight:600;margin-bottom:4px">'.__('Meta Description', 'plh').'</label>';
        echo '<textarea name="plh_meta_description" rows="3" style="width:100%;max-width:760px" placeholder="'.esc_attr__('Découvrez la sélection 2026 des plus belles villas à louer dans les Pouilles : charme, vue mer, conciergerie et expérience sur mesure.','plh').'">'.esc_textarea($meta_desc).'</textarea>';
        echo '<small>'.__('Max ~155 characters. Appears in search results.', 'plh').'</small></p>';
      },
      'blog',
      'normal',
      'default'
    );
  });

  add_action('save_post_blog', function($post_id){
    if( !isset($_POST['plh_seo_meta_nonce_field']) || !wp_verify_nonce($_POST['plh_seo_meta_nonce_field'], 'plh_seo_meta_nonce') ) return; 
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return; 
    if( !current_user_can('edit_post', $post_id) ) return;
    $title = isset($_POST['plh_seo_title']) ? sanitize_text_field($_POST['plh_seo_title']) : '';
    $desc  = isset($_POST['plh_meta_description']) ? sanitize_textarea_field($_POST['plh_meta_description']) : '';
    update_post_meta($post_id, '_plh_seo_title', $title);
    update_post_meta($post_id, '_plh_meta_description', $desc);
  });

  // Output SEO values in <head>
  add_action('wp_head', function(){
    if( is_singular('blog') ) {
      global $post; 
      $custom = get_post_meta($post->ID, '_plh_seo_title', true);
      $desc   = get_post_meta($post->ID, '_plh_meta_description', true);
      if($custom){
        echo '<title>'.esc_html($custom)."</title>\n"; // Overrides default title-tag for this CPT if provided
      }
      if($desc){
        echo '<meta name="description" content="'.esc_attr($desc).'" />\n';
      }
    }
  });

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
      [
        'key'           => 'field_card_image_44',
        'label'         => 'Card Image 4',
        'name'          => 'card_image_44',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium',
        'library'       => 'all',
      ],
      [
        'key'           => 'field_card_image_55',
        'label'         => 'Card Image 5',
        'name'          => 'card_image_55',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium',
        'library'       => 'all',
      ]
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
  $ROWS_PER    = 15;  // rows per group (Feature + KPI) increased from 10

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
    'title'    => 'Features/Amenities',
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


function plh_render_features_4x4($post_id, $rows_per = 15) {
  $fa_map = [
    'check' => 'fa-solid fa-circle-check',
    'x'     => 'fa-solid fa-circle-xmark',
    'info'  => 'fa-solid fa-circle-question',
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
  
  // Icon legend
  $legend = '<div class="villa-features-legend">'
    .   '<div class="legend-item"><i class="fa-solid fa-circle-check"></i><span>'.esc_html__( 'Included', 'thinktech' ).'</span></div>'
    .   '<div class="legend-item"><i class="fa-solid fa-circle-xmark"></i><span>'.esc_html__( 'Not included', 'thinktech' ).'</span></div>'
    .   '<div class="legend-item"><i class="fa-solid fa-circle-minus"></i><span>'.esc_html__( 'Optional (extra charge)', 'thinktech' ).'</span></div>'
    . '</div>';
  
  echo '<div class="villa-features"><div class="villa-features left">'.$left.'</div><div class="villa-features right">'.$right.$legend.'</div></div>';
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
    'check' => 'fa-solid fa-circle-check',
    'minus' => 'fa-solid fa-circle-minus',
    'x'     => 'fa-solid fa-circle-xmark',
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

  // Icon legend
  $legend = '<div class="villa-features-legend">'
    .   '<div class="legend-item"><i class="fa-solid fa-circle-check"></i><span>'.esc_html__( 'Included', 'thinktech' ).'</span></div>'
    .   '<div class="legend-item"><i class="fa-solid fa-circle-xmark"></i><span>'.esc_html__( 'Not included', 'thinktech' ).'</span></div>'
    .   '<div class="legend-item"><i class="fa-solid fa-circle-minus"></i><span>'.esc_html__( 'Optional (extra charge)', 'thinktech' ).'</span></div>'
    
    . '</div>';

  echo '<div class="villa-features">';
    echo '<div class="villa-features left"><div class="villa-features-category">';
      echo '<h3>'.esc_html($inc_title).'</h3>';
      echo $included_rows;
    echo '</div></div>';

    echo '<div class="villa-features right"><div class="villa-features-category">';
      echo '<h3>'.esc_html($exc_title).'</h3>';
      echo $excluded_rows;
      echo $legend;
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

  // Bedroom Descriptions ACF Group (Titles + Descriptions + Footer Text)
  $bedroom_fields = [];
  for ($i = 1; $i <= 8; $i++) {
    // Title field per bedroom
    $bedroom_fields[] = [
      'key'   => "field_bedroom_{$i}_title",
      'label' => "Bedroom {$i} Title",
      'name'  => "bedroom_{$i}_title",
      'type'  => 'text',
      'placeholder' => "e.g., Master Suite",
      'wrapper' => ['width' => 40],
    ];
    // Description field per bedroom
    $bedroom_fields[] = [
      'key'   => "field_bedroom_{$i}_description",
      'label' => "Bedroom {$i} Description",
      'name'  => "bedroom_{$i}_description",
      'type'  => 'textarea',
      'placeholder' => 'e.g., Flexible bed (180/90 x 200cm), private bathroom.',
      'rows'  => 2,
      'wrapper' => ['width' => 60],
    ];
  }
  // Footer / additional text after listing bedrooms
  $bedroom_fields[] = [
    'key'   => 'field_bedrooms_footer_text',
    'label' => 'Bedrooms Footer Text',
    'name'  => 'bedrooms_footer_text',
    'type'  => 'textarea',
    'placeholder' => 'Additional notes about bedroom configurations, baby cots, etc.',
    'rows'  => 3,
    'wrapper' => ['width' => 100],
  ];

  acf_add_local_field_group([
    'key'      => 'group_villa_bedrooms',
    'title'    => 'Villa Bedrooms',
    'fields'   => $bedroom_fields,
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'villa',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);

  // Booking Form Text ACF Group
  acf_add_local_field_group([
    'key'      => 'group_booking_form_text',
    'title'    => 'Booking Form Text',
    'fields'   => [
      [
        'key'   => 'field_booking_intro',
        'label' => 'Intro Text',
        'name'  => 'booking_intro',
        'type'  => 'text',
        'default_value' => 'Book now to secure your dates in this exceptional villa.',
        'wrapper' => ['width' => 100],
      ],
      [
        'key'   => 'field_booking_button_text',
        'label' => 'Button Text',
        'name'  => 'booking_button_text',
        'type'  => 'text',
        'default_value' => 'Book your stay',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_booking_button_url',
        'label' => 'Button URL',
        'name'  => 'booking_button_url',
        'type'  => 'url',
        'default_value' => 'https://www.google.com/search?q=puglia+luxury+homes',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_booking_subtext',
        'label' => 'Subtext',
        'name'  => 'booking_subtext',
        'type'  => 'text',
        'default_value' => 'Submit your request and our team will get back to you shortly, no strings attached.',
        'wrapper' => ['width' => 100],
      ],
      [
        'key'   => 'field_booking_label_name',
        'label' => 'Label: Name',
        'name'  => 'booking_label_name',
        'type'  => 'text',
        'default_value' => 'Name',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_booking_label_email',
        'label' => 'Label: Email',
        'name'  => 'booking_label_email',
        'type'  => 'text',
        'default_value' => 'Email',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_booking_label_arrival',
        'label' => 'Label: Arrival',
        'name'  => 'booking_label_arrival',
        'type'  => 'text',
        'default_value' => 'Arrival',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_booking_label_departure',
        'label' => 'Label: Departure',
        'name'  => 'booking_label_departure',
        'type'  => 'text',
        'default_value' => 'Departure',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_booking_label_comment',
        'label' => 'Label: Comment',
        'name'  => 'booking_label_comment',
        'type'  => 'text',
        'default_value' => 'Comment / Requirements',
        'wrapper' => ['width' => 100],
      ],
      [
        'key'   => 'field_booking_placeholder_comment',
        'label' => 'Placeholder: Comment',
        'name'  => 'booking_placeholder_comment',
        'type'  => 'text',
        'default_value' => 'Tell us about your plans',
        'wrapper' => ['width' => 100],
      ],
      [
        'key'   => 'field_booking_submit_text',
        'label' => 'Submit Button Text',
        'name'  => 'booking_submit_text',
        'type'  => 'text',
        'default_value' => 'Send Request',
        'wrapper' => ['width' => 100],
      ],
      [
        'key'   => 'field_booking_disclaimer',
        'label' => 'Disclaimer Text',
        'name'  => 'booking_disclaimer',
        'type'  => 'text',
        'default_value' => 'By submitting you agree to be contacted regarding this enquiry.',
        'wrapper' => ['width' => 100],
      ],
    ],
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'villa',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);

  // Mobile Booking Banner ACF Group
  acf_add_local_field_group([
    'key'      => 'group_mobile_banner',
    'title'    => 'Mobile Booking Banner',
    'fields'   => [
      [
        'key'   => 'field_mobile_price_text',
        'label' => 'Price Text',
        'name'  => 'mobile_price_text',
        'type'  => 'text',
        'default_value' => 'From EUR 12,200 per week',
        'wrapper' => ['width' => 100],
      ],
      [
        'key'   => 'field_mobile_banner_button_text',
        'label' => 'Button Text',
        'name'  => 'mobile_banner_button_text',
        'type'  => 'text',
        'default_value' => 'Send Enquiry',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_mobile_banner_button_url',
        'label' => 'Button URL',
        'name'  => 'mobile_banner_button_url',
        'type'  => 'url',
        'default_value' => '#',
        'wrapper' => ['width' => 50],
      ],
    ],
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'villa',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);

  // Additional Informations ACF Group
  acf_add_local_field_group([
    'key'      => 'group_additional_info',
    'title'    => 'Additional Informations',
    'fields'   => [
      [
        'key'   => 'field_check_in_time',
        'label' => 'Check-in Time',
        'name'  => 'check_in_time',
        'type'  => 'text',
        'default_value' => '4pm - 10pm',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_check_out_time',
        'label' => 'Check-out Time',
        'name'  => 'check_out_time',
        'type'  => 'text',
        'default_value' => '10am',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_low_season_nights',
        'label' => 'Low Season Minimum Nights',
        'name'  => 'low_season_nights',
        'type'  => 'text',
        'default_value' => '4 nights',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_low_season_months',
        'label' => 'Low Season Months',
        'name'  => 'low_season_months',
        'type'  => 'text',
        'default_value' => 'April, May, September, October',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_high_season_nights',
        'label' => 'High Season Minimum Nights',
        'name'  => 'high_season_nights',
        'type'  => 'text',
        'default_value' => '5 nights',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_high_season_months',
        'label' => 'High Season Months',
        'name'  => 'high_season_months',
        'type'  => 'text',
        'default_value' => 'June, July, August',
        'wrapper' => ['width' => 50],
      ],
      [
        'key'   => 'field_booking_policy_1',
        'label' => 'Booking Policy - Deposit',
        'name'  => 'booking_policy_1',
        'type'  => 'text',
        'default_value' => 'A 50% deposit is required upon booking confirmation, along with the signed rental agrrement.',
        'wrapper' => ['width' => 100],
      ],
      [
        'key'   => 'field_booking_policy_2',
        'label' => 'Booking Policy - Balance',
        'name'  => 'booking_policy_2',
        'type'  => 'text',
        'default_value' => 'The remaining 50% balance is due 30 days prior to arrival (a payment link will be sent 35 days before arrival).',
        'wrapper' => ['width' => 100],
      ],
      [
        'key'   => 'field_booking_policy_3',
        'label' => 'Booking Policy - Security Deposit',
        'name'  => 'booking_policy_3',
        'type'  => 'text',
        'default_value' => 'A bank imprint will be taken on your account as a security deposit on the day of check-in. It will be autimatically released within 15 days after your stay, provided no damages are found.',
        'wrapper' => ['width' => 100],
      ],
      [
        'key'   => 'field_cancellation_policy',
        'label' => 'Cancellation Policy',
        'name'  => 'cancellation_policy',
        'type'  => 'text',
        'default_value' => 'Deposits and payments are non-refundable',
        'wrapper' => ['width' => 100],
      ],
      [
        'key' => 'field_cis_number',
        'label' => 'CIS Number',
        'name'  => 'cis_number',
        'type'  => 'text',
        'wrapper' => ['width' => 100],
      ]
    ],
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'villa',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
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

  $SECTION_COUNT = 10; // change this to how many “blocks” you want

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

function plh_render_villa_gallery_sections($post_id, $sections = 10) {
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


// Google Reviews ACF Fields for Villas
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  $fields = [];

  // Create 6 review groups (adjust number as needed)
  for ($i = 1; $i <= 6; $i++) {
    $fields[] = [
      'key'       => "field_review_tab_$i",
      'label'     => "Review $i",
      'type'      => 'tab',
      'placement' => 'top',
    ];

    $fields[] = [
      'key'    => "field_google_review_$i",
      'label'  => "Review $i Details",
      'name'   => "google_review_$i",
      'type'   => 'group',
      'layout' => 'block',
      'sub_fields' => [
        [
          'key'     => "field_reviewer_name_$i",
          'label'   => 'Reviewer Name',
          'name'    => 'reviewer_name',
          'type'    => 'text',
          'wrapper' => ['width' => 50],
        ],
        [
          'key'           => "field_reviewer_photo_$i",
          'label'         => 'Reviewer Photo (optional)',
          'name'          => 'reviewer_photo',
          'type'          => 'image',
          'return_format' => 'id',
          'preview_size'  => 'thumbnail',
          'wrapper'       => ['width' => 50],
        ],
        [
          'key'     => "field_rating_$i",
          'label'   => 'Rating (1-5 stars)',
          'name'    => 'rating',
          'type'    => 'number',
          'min'     => 1,
          'max'     => 5,
          'default_value' => 5,
          'wrapper' => ['width' => 50],
        ],
        [
          'key'     => "field_review_date_$i",
          'label'   => 'Review Date',
          'name'    => 'review_date',
          'type'    => 'text',
          'placeholder' => 'e.g., November 2025',
          'wrapper' => ['width' => 50],
        ],
        [
          'key'     => "field_review_text_$i",
          'label'   => 'Review Text',
          'name'    => 'review_text',
          'type'    => 'textarea',
          'rows'    => 4,
          'new_lines' => 'wpautop',
        ],
      ],
    ];
  }

  acf_add_local_field_group([
    'key'      => 'group_google_reviews',
    'title'    => 'Google Reviews',
    'fields'   => $fields,
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'villa',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

/**
 * Handle booking request form submissions.
 */
function plh_handle_booking_request() {
  $redirect = wp_get_referer() ?: home_url();

  // Honeypot: if filled, pretend success but drop.
  if ( ! empty($_POST['plh_website']) ) {
    wp_safe_redirect( add_query_arg('booking_status','success',$redirect) );
    exit;
  }

  if ( ! isset($_POST['plh_booking_nonce']) || ! wp_verify_nonce($_POST['plh_booking_nonce'],'plh_booking_request') ) {
    wp_safe_redirect( add_query_arg('booking_error', urlencode('Security check failed.'), $redirect) );
    exit;
  }

  $villa_id   = isset($_POST['villa_id']) ? (int) $_POST['villa_id'] : 0;
  $name       = isset($_POST['plh_name']) ? sanitize_text_field($_POST['plh_name']) : '';
  $email      = isset($_POST['plh_email']) ? sanitize_email($_POST['plh_email']) : '';
  $date_in    = isset($_POST['plh_date_in']) ? sanitize_text_field($_POST['plh_date_in']) : '';
  $date_out   = isset($_POST['plh_date_out']) ? sanitize_text_field($_POST['plh_date_out']) : '';
  $message    = isset($_POST['plh_message']) ? wp_kses_post($_POST['plh_message']) : '';

  // Basic validation
  if ( $name === '' || $email === '' || ! is_email($email) || $date_in === '' || $date_out === '' ) {
    wp_safe_redirect( add_query_arg('booking_error', urlencode('Please fill all required fields.'), $redirect) );
    exit;
  }

  $villa_title = $villa_id ? get_the_title($villa_id) : 'Unknown Villa';

  $recipient = 'reservation@puglialuxuryhomes.com'; // change to desired email
  $subject   = sprintf('Booking enquiry: %s (%s → %s)', $villa_title, $date_in, $date_out);
  $headers   = [ 'Content-Type: text/html; charset=UTF-8', 'Reply-To: '. $name .' <'. $email .'>' ];

  $body  = '<h2>New Booking Enquiry</h2>';
  $body .= '<p><strong>Villa:</strong> '.esc_html($villa_title).' (ID '.$villa_id.')</p>';
  $body .= '<p><strong>Name:</strong> '.esc_html($name).'</p>';
  $body .= '<p><strong>Email:</strong> '.esc_html($email).'</p>';
  $body .= '<p><strong>Arrival:</strong> '.esc_html($date_in).'</p>';
  $body .= '<p><strong>Departure:</strong> '.esc_html($date_out).'</p>';
  if ($message) {
    $body .= '<p><strong>Message:</strong><br>'.wpautop($message).'</p>';
  }
  $body .= '<hr><p>Sent from '.esc_url( home_url() ).'</p>';

  $sent = wp_mail($recipient, $subject, $body, $headers);

  if ($sent) {
    wp_safe_redirect( add_query_arg('booking_status','success',$redirect) );
  } else {
    wp_safe_redirect( add_query_arg('booking_error', urlencode('Could not send email. Please try again.'), $redirect) );
  }
  exit;
}

add_action('admin_post_plh_booking_request','plh_handle_booking_request');
add_action('admin_post_nopriv_plh_booking_request','plh_handle_booking_request');

/**
 * Polylang string registration (Option 2 strategy)
 * Registers UI strings so they appear in Polylang's String Translation without relying solely on file scanning.
 */
function plh_register_ui_strings() {
  if ( ! function_exists('pll_register_string') ) return;
  $group = 'Villa UI';
  $strings = [
    'Must Have', 'Description', 'Experiences', 'Reviews', 'Photo', 'Location',
    'Bedrooms', 'bathrooms', 'guests', 'sqm',
    'Read more', 'Read less',
    'Book now to secure your dates in this exceptional villa.',
    'Book your stay',
    'Submit your request and our team will get back to you shortly, no strings attached.',
    'Your enquiry has been sent. We will contact you shortly.',
    'Name', 'Email', 'Arrival', 'Departure', 'Comment / Requirements', 'Tell us about your plans', 'Website', 'Send Request', 'By submitting you agree to be contacted regarding this enquiry.',
    'From EUR 12,200 per week', 'Send Enquiry',
    "What's Included", 'Features and Amenities', 'Additional Informations',
    'Check in', '4pm - 10pm', 'Check out', 'Minimum stay', 'Low season: 4 nights', 'April, May, September, October', 'High season: 5 nights', 'June, July, August', 'Booking Confirmation', 'A 50% deposit is required upon booking confirmation, along with the signed rental agrrement.', 'The remaining 50% balance is due 30 days prior to arrival (a payment link will be sent 35 days before arrival).', 'A bank imprint will be taken on your account as a security deposit on the day of check-in. It will be autimatically released within 15 days after your stay, provided no damages are found.', 'Cancellation Policy', 'Deposits and payments are non-refundable',
    'Open in Google Maps',
    'Take a glance', 'at the region',
    'Included', 'Not included', 'Optional (extra charge)'
  ];
  foreach ( $strings as $s ) {
    pll_register_string( 'plh_ui_' . sanitize_title( $s ), $s, $group );
  }
}
add_action('init', 'plh_register_ui_strings');

/**
 * Helper for translating UI strings via Polylang first, fallback to theme domain.
 */
function plh_t( $text, $context = '' ) {
  if ( function_exists('pll__') ) {
    $translated = pll__($text);
    if ( is_string($translated) && $translated !== '' ) return $translated;
  }
  return $context ? _x( $text, $context, 'thinktech' ) : __( $text, 'thinktech' );
}

/**
 * Render bedroom descriptions from ACF fields (supports up to 8 bedrooms).
 * Outputs formatted bedroom rows with bed type and bathroom info.
 */
function plh_render_bedroom_descriptions($post_id, $max_bedrooms = 8) {
  $parts = [];
  for ($i = 1; $i <= $max_bedrooms; $i++) {
    $title = get_field("bedroom_{$i}_title", $post_id);
    $desc  = get_field("bedroom_{$i}_description", $post_id);
    $title = is_string($title) ? trim($title) : '';
    $desc  = is_string($desc) ? trim($desc) : '';
    if ($title === '' && $desc === '') continue;
    // Build with title as inline h3 and description inline (nl2br converts line breaks to <br>)
    if ($title !== '' && $desc !== '') {
      $parts[] = '<div class="bedroom-row"><h3>' . esc_html($title) . '</h3><p>' . nl2br(esc_html($desc)) . '</p></div>';
    } elseif ($title !== '') {
      $parts[] = '<div class="bedroom-row"><h3>' . esc_html($title) . '</h3></div>';
    } else {
      $parts[] = '<div class="bedroom-row"><p>' . nl2br(esc_html($desc)) . '</p></div>';
    }
  }
  $footer = get_field('bedrooms_footer_text', $post_id);
  $footer = is_string($footer) ? trim($footer) : '';
  if ($footer !== '') {
    $parts[] = '<p class="bedrooms-footer">' . nl2br(esc_html($footer)) . '</p>';
  }
  return implode('', $parts);
}

/**
 * Get booking form text from ACF with fallback to default.
 */
function plh_booking_text($field_name, $default = '') {
  $value = get_field($field_name);
  $value = is_string($value) ? trim($value) : '';
  return $value !== '' ? $value : $default;
}
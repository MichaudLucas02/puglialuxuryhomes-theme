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
    'mobile_fr' => __('Mobile Menu FR', 'thinktech'),
    'primary_it' => __('Primary Menu IT', 'thinktech'),
    'mobile_it' => __('Mobile Menu IT', 'thinktech'),
    'footer_fr'  => __('Footer Menu FR', 'thinktech'),
    'footer_it'  => __('Footer Menu IT', 'thinktech'),
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
    'has_archive' => false,
    'rewrite' => ['slug' => 'magazine/%category%', 'with_front' => false],
    'show_in_rest' => true,
    'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'author', 'comments'],
    'taxonomies' => ['category', 'post_tag'],
    'menu_icon' => 'dashicons-edit',
  ];
  register_post_type('blog', $args);
});

// Replace %category% in blog post URLs with actual category slug
add_filter('post_type_link', function($post_link, $post) {
  if ($post->post_type !== 'blog') {
    return $post_link;
  }
  
  if (strpos($post_link, '%category%') === false) {
    return $post_link;
  }
  
  $categories = get_the_terms($post->ID, 'category');
  
  if ($categories && !is_wp_error($categories)) {
    // Use the first category
    $category = array_shift($categories);
    return str_replace('%category%', $category->slug, $post_link);
  } else {
    // Fallback to 'uncategorized' if no category is set
    return str_replace('%category%', 'uncategorized', $post_link);
  }
}, 10, 2);

// Flush rewrite rules on theme switch so the /blog archive works immediately
add_action('after_switch_theme', function() {
  flush_rewrite_rules();
});

// -----------------------
// ACF Fields: Small Hero (available on all pages)
// -----------------------
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'    => 'group_small_hero_section',
    'title'  => 'Small Hero Section',
    'fields' => [
      [
        'key'   => 'field_small_hero_enable',
        'label' => 'Enable Small Hero',
        'name'  => 'small_hero_enable',
        'type'  => 'true_false',
        'ui'    => 1,
        'default_value' => 1,
        'instructions' => 'Toggle to show/hide the small hero section on this page',
      ],
      [
        'key'           => 'field_small_hero_video',
        'label'         => 'Hero Video URL',
        'name'          => 'small_hero_video',
        'type'          => 'url',
        'default_value' => 'https://www.puglialuxuryhomes.com/wp-content/uploads/2025/05/PLH.mp4',
        'instructions'  => 'MP4 video URL for the hero background',
      ],
      [
        'key'           => 'field_small_hero_poster',
        'label'         => 'Hero Poster Image',
        'name'          => 'small_hero_poster',
        'type'          => 'url',
        'default_value' => 'https://www.puglialuxuryhomes.com/wp-content/uploads/2025/02/Jardin-3-scaled.webp',
        'instructions'  => 'Fallback image shown before video loads',
      ],
      [
        'key'   => 'field_small_hero_title',
        'label' => 'Hero Title',
        'name'  => 'small_hero_title',
        'type'  => 'text',
        'instructions'  => 'Leave blank to use page title automatically',
      ],
    ],
    'location' => [[[
      'param'    => 'post_type',
      'operator' => '==',
      'value'    => 'page',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
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
        echo '<title>'.esc_html($custom).'</title>';
      }
      if($desc){
        echo '<meta name="description" content="'.esc_attr($desc).'" />';
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

  // Auto-create default collection terms if they don't exist
  $default_collections = ['sea', 'land', 'city'];
  foreach ($default_collections as $slug) {
    if (!term_exists($slug, 'villa_collection')) {
      wp_insert_term(
        ucfirst($slug),
        'villa_collection',
        ['slug' => $slug]
      );
    }
  }
}
add_action('init', 'plh_register_cpts');

// --- Flush permalinks once on theme switch so /villas works ---
add_action('after_switch_theme', function () {
  plh_register_cpts();
  flush_rewrite_rules();
});

// --- Translate villa CPT slug per language (Polylang) ---
add_filter('pll_translated_post_type_rewrite_slugs', function($slugs, $post_type) {
  if ($post_type === 'villa') {
    $slugs = [
      'en' => ['has_archive' => 'villas', 'rewrite' => ['slug' => 'villas']],
      'fr' => ['has_archive' => 'villas', 'rewrite' => ['slug' => 'villas']],
      'it' => ['has_archive' => 'ville',  'rewrite' => ['slug' => 'ville']],
    ];
  }
  return $slugs;
}, 10, 2);

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
        'key'   => 'field_price_range_1',
        'label' => 'Price Range',
        'name'  => 'price_range_1',
        'type'  => 'text',
        'instructions' => 'e.g., From €1000 to €1500 per week or From €50 per day',
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
        'key'           => 'field_rameaux_image_1',
        'label'         => 'Rameaux Image',
        'name'          => 'rameaux_image',
        'type'          => 'image',
        'return_format' => 'url',
        'instructions'  => 'Image to display in the modal when clicking the info icon',
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
    'x'     => 'fa-regular fa-circle-xmark',
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
    .   '<div class="legend-item"><i class="fa-solid fa-circle-check"></i><span>'.(function_exists('pll__') ? pll__('Included') : esc_html__('Included', 'plh')).'</span></div>'
    .   '<div class="legend-item"><i class="fa-regular fa-circle-xmark"></i><span>'.(function_exists('pll__') ? pll__('Excluded') : esc_html__('Excluded', 'plh')).'</span></div>'
    .   '<div class="legend-item"><i class="fa-solid fa-circle-minus"></i><span>'.(function_exists('pll__') ? pll__('Optional (extra charge)') : esc_html__('Optional (extra charge)', 'plh')).'</span></div>'
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

  // Icon legend
  $legend = '<div class="villa-features-legend">'
    .   '<div class="legend-item"><i class="fa-solid fa-circle-check"></i><span>'.(function_exists('pll__') ? pll__('Included') : esc_html__('Included', 'plh')).'</span></div>'
    .   '<div class="legend-item"><i class="fa-regular fa-circle-xmark"></i><span>'.(function_exists('pll__') ? pll__('Excluded') : esc_html__('Excluded', 'plh')).'</span></div>'
    .   '<div class="legend-item"><i class="fa-solid fa-circle-minus"></i><span>'.(function_exists('pll__') ? pll__('Optional (extra charge)') : esc_html__('Optional (extra charge)', 'plh')).'</span></div>'
    
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
  for ($i = 1; $i <= 12; $i++) {
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
    // Second description field (optional extra paragraph)
    $bedroom_fields[] = [
      'key'   => "field_bedroom_{$i}_description_2",
      'label' => "Bedroom {$i} Description 2",
      'name'  => "bedroom_{$i}_description_2",
      'type'  => 'textarea',
      'placeholder' => 'e.g., Additional notes: terrace access, TV, safe, etc.',
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
        'type'  => 'text',
        'default_value' => '#',
        'wrapper' => ['width' => 50],
        'placeholder' => 'https://example.com or leave empty',
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
  // Google Maps API - Replace YOUR_API_KEY with your actual Google Maps API key
  wp_enqueue_script(
    'google-maps',
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyCG3b66d3LyMC9bKhMYAnlGtsmSOZcLcgw',
    [],
    null,
    true
  );

  // Our map init script
  wp_enqueue_script(
    'villa-map',
    get_stylesheet_directory_uri() . '/assets/js/villa-map.js',
    ['google-maps'],
    '1.1',
    true
  );
  wp_enqueue_style(
    'villa-map',
    get_stylesheet_directory_uri() . '/assets/css/villa-map.css',
    [],
    '1.0'
  );
});


// Map gallery endpoint slugs per language; fallback to 'gallery'
function plh_gallery_endpoint_map() {
  return [
    'en' => 'gallery',
    'fr' => 'galerie',
    'it' => 'galleria',
  ];
}

// Map villa post type slug per language
function plh_villa_slug_map() {
  return [
    'en' => 'villas',
    'fr' => 'villas',
    'it' => 'ville',
  ];
}

// Register gallery rewrite rules (more reliable than endpoints with Polylang)
add_action('init', function () {
  $gallery_map = plh_gallery_endpoint_map();
  $villa_map = plh_villa_slug_map();
  
  foreach ($gallery_map as $lang => $gallery_slug) {
    $villa_slug = $villa_map[$lang];
    
    if ($lang === 'en') {
      // English: /villas/{villa-slug}/gallery/
      add_rewrite_rule(
        '^' . $villa_slug . '/([^/]+)/' . $gallery_slug . '/?$',
        'index.php?villa=$matches[1]&gallery_page=1',
        'top'
      );
    } else {
      // Other languages: /{lang}/ville-or-villas/{villa-slug}/galerie-or-galleria/
      add_rewrite_rule(
        '^' . $lang . '/' . $villa_slug . '/([^/]+)/' . $gallery_slug . '/?$',
        'index.php?villa=$matches[1]&gallery_page=1&lang=' . $lang,
        'top'
      );
    }
  }
}, 10);

// Make gallery_page query var public
add_filter('query_vars', function ($vars) {
  $vars[] = 'gallery_page';
  return $vars;
});

// Load gallery template when gallery_page is set
add_filter('template_include', function ($template) {
  if (is_singular('villa') && get_query_var('gallery_page')) {
    $t = locate_template('single-villa-gallery.php');
    if ($t) return $t;
  }
  return $template;
});

// Helper to build the gallery URL with localized slug based on current language
function plh_villa_gallery_link($post_id = null) {
  $post_id = $post_id ?: get_the_ID();
  $lang = function_exists('pll_current_language') ? pll_current_language('slug') : '';
  $map  = plh_gallery_endpoint_map();
  $slug = $map[$lang] ?? 'gallery';
  return trailingslashit(get_permalink($post_id)) . $slug . '/';
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
        'key'   => 'field_process_title',
        'label' => 'Process Section Title',
        'name'  => 'process_title',
        'type'  => 'text',
        'default_value' => 'With you from start to finish',
        'instructions' => 'Heading displayed above the process steps (desktop and mobile).',
      ],
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
          'param'    => 'page_template',
          'operator' => '==',
          'value'    => 'property-management-fr.php',
        ],
      ],
      [
        [
          'param'    => 'page_template',
          'operator' => '==',
          'value'    => 'property-management-it.php',
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

// Register WordPress menu item for Discover Items
add_action('admin_menu', function () {
  add_menu_page(
    'Discover Settings',           // Page title
    'Discover Settings',           // Menu title
    'manage_options',              // Capability
    'theme_discover_settings',     // Menu slug
    'plh_render_discover_settings',// Callback
    'dashicons-images-alt',        // Icon
    6                              // Position (before Tools which is at 75)
  );
});

// Render the settings page
function plh_render_discover_settings() {
  // Check user capabilities
  if (!current_user_can('manage_options')) {
    return;
  }

  // Enqueue media uploader scripts and styles
  wp_enqueue_media();

  // Get current language from Polylang or use default
  $current_lang = 'en';
  $lang_display = 'English';
  
  // Check for lang parameter in URL first (for reliable detection during POST)
  if (isset($_GET['lang']) && !empty($_GET['lang'])) {
    $current_lang = sanitize_key($_GET['lang']);
  } elseif (function_exists('pll_current_language')) {
    $current_lang = pll_current_language() ?: 'en';
  }
  
  // Get language display name
  if (function_exists('pll_the_languages')) {
    $languages = pll_the_languages(['echo' => 0, 'raw' => 1]);
    if (isset($languages[$current_lang])) {
      $lang_display = $languages[$current_lang]['name'];
    }
  }

  // Create a language-specific option key
  $option_key = 'discover_settings_' . $current_lang;

  // Show the settings form with language-specific option key
  echo '<div class="wrap">';
  echo '<h1>Discover Settings</h1>';
  
  // Display current language indicator
  echo '<div style="margin-bottom: 20px; padding: 15px; background: #0073aa; color: white; border-radius: 4px; font-size: 16px; font-weight: bold;">';
  echo '📝 Currently Editing: ' . esc_html($lang_display) . ' (' . strtoupper($current_lang) . ')';
  echo '</div>';
  
  // Display language switcher if using Polylang
  if (function_exists('pll_the_languages')) {
    $languages = pll_the_languages(['echo' => 0, 'raw' => 1]);
    if (!empty($languages)) {
      echo '<div style="margin-bottom: 20px; padding: 10px; background: #f1f1f1; border-radius: 4px;">';
      echo '<strong>Switch Language:</strong> ';
      $lang_links = [];
      foreach ($languages as $lang_code => $lang_info) {
        $lang_url = add_query_arg('lang', $lang_code, admin_url('admin.php?page=theme_discover_settings'));
        $lang_links[] = '<a href="' . esc_url($lang_url) . '">' . esc_html($lang_info['name']) . '</a>';
      }
      echo implode(' | ', $lang_links);
      echo '</div>';
    }
  }

  // Save form data
  if (isset($_POST['submit'])) {
    if (!wp_verify_nonce($_POST['discover_nonce'], 'save_discover_settings')) {
      wp_die('Security check failed');
    }
    
    // Save region section
    $region_title = isset($_POST['region_title']) ? sanitize_text_field($_POST['region_title']) : '';
    $region_description = isset($_POST['region_description']) ? sanitize_textarea_field($_POST['region_description']) : '';
    update_option($option_key . '_region_title', $region_title);
    update_option($option_key . '_region_description', $region_description);
    
    $saved_count = 0;
    // Save all 4 items (save even if empty to allow clearing)
    for ($i = 1; $i <= 4; $i++) {
      $title = isset($_POST['discover_item_' . $i . '_title']) ? sanitize_text_field($_POST['discover_item_' . $i . '_title']) : '';
      $description = isset($_POST['discover_item_' . $i . '_description']) ? sanitize_text_field($_POST['discover_item_' . $i . '_description']) : '';
      $image = isset($_POST['discover_item_' . $i . '_image']) ? esc_url_raw($_POST['discover_item_' . $i . '_image']) : '';
      $url = isset($_POST['discover_item_' . $i . '_url']) ? esc_url_raw($_POST['discover_item_' . $i . '_url']) : '';
      
      update_option($option_key . '_discover_item_' . $i . '_title', $title);
      update_option($option_key . '_discover_item_' . $i . '_description', $description);
      update_option($option_key . '_discover_item_' . $i . '_image', $image);
      update_option($option_key . '_discover_item_' . $i . '_url', $url);
      
      if ($image) $saved_count++;
    }
    
    echo '<div class="notice notice-success"><p><strong>Settings saved successfully!</strong></p></div>';
  }

  // Display form fields manually
  echo '<form method="post" enctype="multipart/form-data">';
  wp_nonce_field('save_discover_settings', 'discover_nonce');
  
  // Hidden field to pass language through POST
  echo '<input type="hidden" name="lang" value="' . esc_attr($current_lang) . '">';
  
  echo '<table class="form-table">';
  
  // Region Section
  $region_title = get_option($option_key . '_region_title', '');
  $region_description = get_option($option_key . '_region_description', '');
  
  echo '<tr>';
  echo '<th colspan="2" style="background: #f9f9f9; padding: 15px;"><h2 style="margin: 0;">Take a Glance at the Region Section</h2></th>';
  echo '</tr>';
  
  // Region Title field
  echo '<tr>';
  echo '<th scope="row"><label for="region_title">Section Title</label></th>';
  echo '<td>';
  echo '<input type="text" id="region_title" name="region_title" value="' . esc_attr($region_title) . '" class="large-text" placeholder="Take a glance at the region" />';
  echo '<p class="description">The main heading for the region section. Use &lt;br&gt; tag for line breaks.</p>';
  echo '</td>';
  echo '</tr>';
  
  // Region Description field
  echo '<tr>';
  echo '<th scope="row"><label for="region_description">Section Description</label></th>';
  echo '<td>';
  echo '<textarea id="region_description" name="region_description" rows="4" class="large-text">' . esc_textarea($region_description) . '</textarea>';
  echo '<p class="description">The descriptive paragraph shown below the title.</p>';
  echo '</td>';
  echo '</tr>';
  
  echo '<tr>';
  echo '<th colspan="2" style="background: #f9f9f9; padding: 15px;"><h2 style="margin: 0;">Discover Items</h2></th>';
  echo '</tr>';
  
  for ($i = 1; $i <= 4; $i++) {
    $title = get_option($option_key . '_discover_item_' . $i . '_title', '');
    $description = get_option($option_key . '_discover_item_' . $i . '_description', '');
    $image = get_option($option_key . '_discover_item_' . $i . '_image', '');
    $url = get_option($option_key . '_discover_item_' . $i . '_url', '');
    
    echo '<tr>';
    echo '<th colspan="2"><h3>Discover Item ' . $i . '</h3></th>';
    echo '</tr>';
    
    // Title field
    echo '<tr>';
    echo '<th scope="row"><label for="discover_title_' . $i . '">Title</label></th>';
    echo '<td>';
    echo '<input type="text" id="discover_title_' . $i . '" name="discover_item_' . $i . '_title" value="' . esc_attr($title) . '" class="regular-text" />';
    echo '</td>';
    echo '</tr>';
    
    // Description field
    echo '<tr>';
    echo '<th scope="row"><label for="discover_desc_' . $i . '">Description</label></th>';
    echo '<td>';
    echo '<input type="text" id="discover_desc_' . $i . '" name="discover_item_' . $i . '_description" value="' . esc_attr($description) . '" class="regular-text" />';
    echo '</td>';
    echo '</tr>';
    
    // Image field
    echo '<tr>';
    echo '<th scope="row"><label for="discover_image_' . $i . '">Image URL</label></th>';
    echo '<td>';
    echo '<input type="text" id="discover_image_' . $i . '" name="discover_item_' . $i . '_image" value="' . esc_attr($image) . '" class="regular-text" />';
    echo '<button type="button" class="button" onclick="openMediaUploader(' . $i . ')">Upload Image</button>';
    echo '</td>';
    echo '</tr>';
    
    // URL field
    echo '<tr>';
    echo '<th scope="row"><label for="discover_url_' . $i . '">Link URL</label></th>';
    echo '<td>';
    echo '<input type="url" id="discover_url_' . $i . '" name="discover_item_' . $i . '_url" value="' . esc_attr($url) . '" class="regular-text" />';
    echo '</td>';
    echo '</tr>';
  }
  
  echo '</table>';
  submit_button('Save Settings');
  echo '</form>';
  
  // Add media uploader script
  echo '<script>
    function openMediaUploader(itemNum) {
      var frame = wp.media({
        title: "Select Image",
        button: {
          text: "Select"
        },
        multiple: false
      });
      
      frame.on("select", function() {
        var attachment = frame.state().get("selection").first().toJSON();
        document.getElementById("discover_image_" + itemNum).value = attachment.url;
      });
      
      frame.open();
    }
  </script>';
  
  echo '</div>';
}


/**
 * Handle contact page form submissions.
 */
function plh_handle_contact_form() {
  $redirect = wp_get_referer() ?: home_url('/contact/');

  // Honeypot: if filled, pretend success but drop.
  if (!empty($_POST['contact_hp_field'])) {
    wp_safe_redirect(add_query_arg('contact_status', 'success', $redirect));
    exit;
  }

  if (!isset($_POST['plh_contact_nonce']) || !wp_verify_nonce($_POST['plh_contact_nonce'], 'plh_contact')) {
    wp_safe_redirect(add_query_arg(['contact_status' => 'error', 'contact_error' => urlencode('Security check failed.')], $redirect));
    exit;
  }

  $name    = sanitize_text_field($_POST['contact_name'] ?? '');
  $email   = sanitize_email($_POST['contact_email'] ?? '');
  $phone   = sanitize_text_field($_POST['contact_phone'] ?? '');
  $subject = sanitize_text_field($_POST['contact_subject'] ?? '');
  $message = wp_kses_post($_POST['contact_message'] ?? '');
  $consent = isset($_POST['contact_consent']);

  if ($name === '' || $email === '' || !is_email($email) || $message === '' || !$consent) {
    wp_safe_redirect(add_query_arg(['contact_status' => 'error', 'contact_error' => urlencode('Please fill all required fields.')], $redirect));
    exit;
  }

  $recipient = 'reservation@puglialuxuryhomes.com';
  $subject_line = $subject ? 'Contact enquiry: ' . $subject : 'Contact enquiry from site';
  $headers = [
    'Content-Type: text/html; charset=UTF-8',
    'Reply-To: ' . $name . ' <' . $email . '>'
  ];

  $body  = '<h2>New Contact Enquiry</h2>';
  $body .= '<p><strong>Name:</strong> ' . esc_html($name) . '</p>';
  $body .= '<p><strong>Email:</strong> ' . esc_html($email) . '</p>';
  if ($phone) {
    $body .= '<p><strong>Phone:</strong> ' . esc_html($phone) . '</p>';
  }
  if ($subject) {
    $body .= '<p><strong>Subject:</strong> ' . esc_html($subject) . '</p>';
  }
  $body .= '<p><strong>Message:</strong><br>' . wpautop($message) . '</p>';
  $body .= '<hr><p>Sent from ' . esc_url(home_url()) . '</p>';

  $sent = wp_mail($recipient, $subject_line, $body, $headers);

  if ($sent) {
    wp_safe_redirect(add_query_arg('contact_status', 'success', $redirect));
  } else {
    wp_safe_redirect(add_query_arg(['contact_status' => 'error', 'contact_error' => urlencode('Could not send email. Please try again.')], $redirect));
  }
  exit;
}

add_action('admin_post_plh_contact_form', 'plh_handle_contact_form');
add_action('admin_post_nopriv_plh_contact_form', 'plh_handle_contact_form');

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
 * Handle villa submission form
 */
function plh_handle_villa_submission() {
  // Verify nonce
  if (!isset($_POST['plh_villa_submission_nonce']) || !wp_verify_nonce($_POST['plh_villa_submission_nonce'], 'plh_villa_submission_nonce')) {
    wp_redirect(add_query_arg(['villa_submission' => 'error', 'villa_error' => urlencode('Security check failed.')], wp_get_referer()));
    exit;
  }

  // Honeypot check
  if (!empty($_POST['villa_hp_field'])) {
    wp_redirect(add_query_arg('villa_submission', 'error', wp_get_referer()));
    exit;
  }

  // Sanitize all fields
  // Contact Information
  $owner_name = sanitize_text_field($_POST['owner_full_name'] ?? '');
  $owner_email = sanitize_email($_POST['owner_email'] ?? '');
  $owner_phone = sanitize_text_field($_POST['owner_phone'] ?? '');
  $owner_country = sanitize_text_field($_POST['owner_country'] ?? '');

  // Property Details
  $property_name = sanitize_text_field($_POST['property_name'] ?? '');
  $property_location = sanitize_text_field($_POST['property_location'] ?? '');
  $property_type = sanitize_text_field($_POST['property_type'] ?? '');
  $property_bedrooms = sanitize_text_field($_POST['property_bedrooms'] ?? '');
  $property_bathrooms = sanitize_text_field($_POST['property_bathrooms'] ?? '');
  $property_size = sanitize_text_field($_POST['property_size'] ?? '');
  $property_features = sanitize_textarea_field($_POST['property_features'] ?? '');
  $property_link = esc_url_raw($_POST['property_link'] ?? '');

  // Management & Collaboration
  $collaboration_type = sanitize_text_field($_POST['collaboration_type'] ?? '');
  $other_agency = sanitize_text_field($_POST['other_agency'] ?? '');
  $rental_experience = sanitize_text_field($_POST['rental_experience'] ?? '');

  // Message
  $property_message = sanitize_textarea_field($_POST['property_message'] ?? '');

  // Consent
  $consent = isset($_POST['consent_checkbox']) ? 'Yes' : 'No';

  // Language
  $form_language = sanitize_text_field($_POST['form_language'] ?? 'en');

  // Required field validation
  $required_fields = [
    'owner_name' => $owner_name,
    'owner_email' => $owner_email,
    'property_location' => $property_location,
    'property_type' => $property_type,
    'property_bedrooms' => $property_bedrooms,
    'property_bathrooms' => $property_bathrooms,
    'collaboration_type' => $collaboration_type,
    'other_agency' => $other_agency,
    'rental_experience' => $rental_experience,
  ];

  foreach ($required_fields as $field => $value) {
    if (empty($value)) {
      wp_redirect(add_query_arg(['villa_submission' => 'error', 'villa_error' => urlencode('Please fill in all required fields.')], wp_get_referer()));
      exit;
    }
  }

  // Email validation
  if (!is_email($owner_email)) {
    wp_redirect(add_query_arg(['villa_submission' => 'error', 'villa_error' => urlencode('Please provide a valid email address.')], wp_get_referer()));
    exit;
  }

  // Consent validation
  if ($consent !== 'Yes') {
    wp_redirect(add_query_arg(['villa_submission' => 'error', 'villa_error' => urlencode('You must agree to be contacted.')], wp_get_referer()));
    exit;
  }

  // Build email with language-specific content
  $to = 'reservation@puglialuxuryhomes.com'; // or use a specific email
  
  // Language-specific email content
  $translations = [
    'en' => [
      'subject_prefix' => 'New Property Management Inquiry',
      'heading' => 'New Property Management Submission',
      'contact_info' => 'Contact Information',
      'full_name' => 'Full Name',
      'email' => 'Email',
      'phone' => 'Phone',
      'country' => 'Country of Residence',
      'property_details' => 'Property Details',
      'property_name' => 'Property Name',
      'location' => 'Location',
      'type' => 'Type',
      'bedrooms' => 'Bedrooms',
      'bathrooms' => 'Bathrooms',
      'size' => 'Size',
      'features' => 'Main Features',
      'website' => 'Website/Instagram',
      'management' => 'Management & Collaboration',
      'collaboration' => 'Collaboration Type',
      'other_agency' => 'Working with other agency',
      'rental_exp' => 'Rental Experience',
      'message' => 'Additional Message',
      'not_provided' => 'Not provided',
      'submitted_on' => 'Submitted on',
    ],
    'fr' => [
      'subject_prefix' => 'Nouvelle demande de gestion immobilière',
      'heading' => 'Nouvelle soumission de gestion immobilière',
      'contact_info' => 'Informations de contact',
      'full_name' => 'Nom complet',
      'email' => 'E-mail',
      'phone' => 'Téléphone',
      'country' => 'Pays de résidence',
      'property_details' => 'Détails de la propriété',
      'property_name' => 'Nom de la propriété',
      'location' => 'Localisation',
      'type' => 'Type',
      'bedrooms' => 'Chambres',
      'bathrooms' => 'Salles de bain',
      'size' => 'Surface',
      'features' => 'Caractéristiques principales',
      'website' => 'Site web/Instagram',
      'management' => 'Gestion & Collaboration',
      'collaboration' => 'Type de collaboration',
      'other_agency' => 'Travaille avec une autre agence',
      'rental_exp' => 'Expérience de location',
      'message' => 'Message supplémentaire',
      'not_provided' => 'Non renseigné',
      'submitted_on' => 'Soumis le',
    ],
    'it' => [
      'subject_prefix' => 'Nuova richiesta di gestione immobiliare',
      'heading' => 'Nuova sottomissione gestione immobiliare',
      'contact_info' => 'Informazioni di contatto',
      'full_name' => 'Nome e cognome',
      'email' => 'E-mail',
      'phone' => 'Telefono',
      'country' => 'Paese di residenza',
      'property_details' => 'Dettagli della proprietà',
      'property_name' => 'Nome della proprietà',
      'location' => 'Localizzazione',
      'type' => 'Tipologia',
      'bedrooms' => 'Camere da letto',
      'bathrooms' => 'Bagni',
      'size' => 'Superficie',
      'features' => 'Caratteristiche principali',
      'website' => 'Sito web/Instagram',
      'management' => 'Gestione & Collaborazione',
      'collaboration' => 'Tipo di collaborazione',
      'other_agency' => 'Collabora con altra agenzia',
      'rental_exp' => 'Esperienza di affitto',
      'message' => 'Messaggio aggiuntivo',
      'not_provided' => 'Non fornito',
      'submitted_on' => 'Inviato il',
    ],
  ];
  
  $lang = $translations[$form_language] ?? $translations['en'];
  
  $subject = $lang['subject_prefix'] . ': ' . ($property_name ?: $property_location);
  $headers = ['Content-Type: text/html; charset=UTF-8'];
  
  $message = '<html><body style="font-family: Arial, sans-serif; line-height: 1.6;">';
  $message .= '<h2 style="color: #6c9ba3;">' . esc_html($lang['heading']) . '</h2>';
  
  $message .= '<h3 style="color: #6c9ba3; border-bottom: 2px solid #f0f0f0; padding-bottom: 8px;">' . esc_html($lang['contact_info']) . '</h3>';
  $message .= '<p><strong>' . esc_html($lang['full_name']) . ':</strong> ' . esc_html($owner_name) . '</p>';
  $message .= '<p><strong>' . esc_html($lang['email']) . ':</strong> ' . esc_html($owner_email) . '</p>';
  $message .= '<p><strong>' . esc_html($lang['phone']) . ':</strong> ' . esc_html($owner_phone ?: $lang['not_provided']) . '</p>';
  $message .= '<p><strong>' . esc_html($lang['country']) . ':</strong> ' . esc_html($owner_country ?: $lang['not_provided']) . '</p>';
  
  $message .= '<h3 style="color: #6c9ba3; border-bottom: 2px solid #f0f0f0; padding-bottom: 8px;">' . esc_html($lang['property_details']) . '</h3>';
  $message .= '<p><strong>' . esc_html($lang['property_name']) . ':</strong> ' . esc_html($property_name ?: $lang['not_provided']) . '</p>';
  $message .= '<p><strong>' . esc_html($lang['location']) . ':</strong> ' . esc_html($property_location) . '</p>';
  $message .= '<p><strong>' . esc_html($lang['type']) . ':</strong> ' . esc_html($property_type) . '</p>';
  $message .= '<p><strong>' . esc_html($lang['bedrooms']) . ':</strong> ' . esc_html($property_bedrooms) . '</p>';
  $message .= '<p><strong>' . esc_html($lang['bathrooms']) . ':</strong> ' . esc_html($property_bathrooms) . '</p>';
  $message .= '<p><strong>' . esc_html($lang['size']) . ':</strong> ' . esc_html($property_size ? $property_size . ' m²' : $lang['not_provided']) . '</p>';
  if (!empty($property_features)) {
    $message .= '<p><strong>' . esc_html($lang['features']) . ':</strong><br>' . nl2br(esc_html($property_features)) . '</p>';
  }
  if (!empty($property_link)) {
    $message .= '<p><strong>' . esc_html($lang['website']) . ':</strong> <a href="' . esc_url($property_link) . '">' . esc_html($property_link) . '</a></p>';
  }
  
  $message .= '<h3 style="color: #6c9ba3; border-bottom: 2px solid #f0f0f0; padding-bottom: 8px;">' . esc_html($lang['management']) . '</h3>';
  $message .= '<p><strong>' . esc_html($lang['collaboration']) . ':</strong> ' . esc_html($collaboration_type) . '</p>';
  $message .= '<p><strong>' . esc_html($lang['other_agency']) . ':</strong> ' . esc_html($other_agency) . '</p>';
  $message .= '<p><strong>' . esc_html($lang['rental_exp']) . ':</strong> ' . esc_html($rental_experience) . '</p>';
  
  if (!empty($property_message)) {
    $message .= '<h3 style="color: #6c9ba3; border-bottom: 2px solid #f0f0f0; padding-bottom: 8px;">' . esc_html($lang['message']) . '</h3>';
    $message .= '<p>' . nl2br(esc_html($property_message)) . '</p>';
  }
  
  $message .= '<hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">';
  $message .= '<p style="color: #888; font-size: 12px;"><em>' . esc_html($lang['submitted_on']) . ' ' . date('F j, Y \a\t g:i a') . '</em></p>';
  $message .= '</body></html>';

  // Send email
  $sent = wp_mail($to, $subject, $message, $headers);

  if ($sent) {
    wp_redirect(add_query_arg('villa_submission', 'success', wp_get_referer()));
  } else {
    wp_redirect(add_query_arg(['villa_submission' => 'error', 'villa_error' => urlencode('Failed to send submission. Please try again.')], wp_get_referer()));
  }
  exit;
}

add_action('admin_post_plh_villa_submission', 'plh_handle_villa_submission');
add_action('admin_post_nopriv_plh_villa_submission', 'plh_handle_villa_submission');

/**
 * Polylang string registration (Option 2 strategy)
 * Registers UI strings so they appear in Polylang's String Translation without relying solely on file scanning.
 */
function plh_register_ui_strings() {
  if ( ! function_exists('pll_register_string') ) return;
  $group = 'Villa UI';
  $strings = [
    'Must Have', 'Description', 'Experiences', 'Reviews', 'Photo', 'Location',
    'Bedrooms', 'bathrooms', 'guests', 'sqm', 'bedrooms', 'From', 'To', 'per weeks',
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
    'Included', 'Excluded', 'Not included', 'Optional (extra charge)',
    'The Collections',
    'Sea Collection',
    'Land Collection',
    'City Collection',
    'Discover our exclusive coastal villas',
    'Experience luxury in the countryside',
    'Urban elegance meets luxury living',
    'No villas found in this collection',
    'See all our luxury villas',
    'villas by the sea',
    'villas in the countryside',
    'villas in the city',
    // Filter UI
    'Filter', 'Capacity', '6+ guests', '8+ guests', '10+ guests', '12+ guests', '15+ guests', '16+ guests',
    'Collection', 'Seaside', 'Countryside', 'Historic center',
    'Price per night (from)', 'Up to €600', '€600 – €1,200', '€1,200 – €2,000', '€2,000 – €3,000', '€3,000 – €5,000', 'More than €5,000',
    'Reset Filters', 'villas found', 'Loading...', 'No villas match your filters. Please try adjusting your criteria.', 'Error loading villas. Please try again.',
    // Footer UI
    'Follow us on socials:',  'Contact us',
    // Gallery UI
    'Back to villa',
    // Blog page
    'Latest Blog Posts', 'All Categories', 'Read More', 'Read More', 'Read More', 'Previous', 'Next',

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
 * Render bedroom descriptions from ACF fields (supports up to 12 bedrooms).
 * Outputs formatted bedroom rows with bed type and bathroom info.
 */
function plh_render_bedroom_descriptions($post_id, $max_bedrooms = 12) {
  $parts = [];
  for ($i = 1; $i <= $max_bedrooms; $i++) {
    $title = get_field("bedroom_{$i}_title", $post_id);
    $desc  = get_field("bedroom_{$i}_description", $post_id);
    $desc2 = get_field("bedroom_{$i}_description_2", $post_id);
    $title = is_string($title) ? trim($title) : '';
    $desc  = is_string($desc) ? trim($desc) : '';
    $desc2 = is_string($desc2) ? trim($desc2) : '';
    if ($title === '' && $desc === '' && $desc2 === '') continue;
    $row = '<div class="bedroom-row">';
    if ($title !== '') {
      $row .= '<h3>' . esc_html($title) . '</h3>';
    }
    if ($desc !== '') {
      $row .= '<p>' . nl2br(esc_html($desc)) . '</p>';
    }
    if ($desc2 !== '') {
      $row .= '<p>' . nl2br(esc_html($desc2)) . '</p>';
    }
    $row .= '</div>';
    $parts[] = $row;
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

/**
 * Villa Card Shortcode
 * Usage: [villa_card id="123"] or [villa_card name="villa-slug"] or [villa_card title="Villa Name"]
 */
add_shortcode('villa_card', function($atts) {
  $atts = shortcode_atts([
    'id' => null,
    'post_id' => null,
    'name' => null,     // slug
    'title' => null,    // post title
  ], $atts, 'villa_card');
  
  $post_id = null;
  
  // Try to get post ID from 'id' or 'post_id' parameter
  if ($atts['id'] || $atts['post_id']) {
    $post_id = intval($atts['id'] ?: $atts['post_id']);
  }
  // Try to get by slug/name
  elseif ($atts['name']) {
    $post = get_page_by_path($atts['name'], OBJECT, 'villa');
    if ($post) {
      $post_id = $post->ID;
    }
  }
  // Try to get by title
  elseif ($atts['title']) {
    $posts = get_posts([
      'post_type' => 'villa',
      'title' => $atts['title'],
      'posts_per_page' => 1,
    ]);
    if (!empty($posts)) {
      $post_id = $posts[0]->ID;
    }
  }
  
  if (!$post_id) {
    return '<!-- Villa card shortcode: no valid villa found. Use id="123" or name="villa-slug" or title="Villa Name" -->';
  }
  
  // Verify the post exists and is a villa
  $post = get_post($post_id);
  if (!$post || $post->post_type !== 'villa') {
    return '<!-- Villa card shortcode: villa not found -->';
  }
  
  // Set up globals so get_template_part can access the post
  global $post;
  $post = get_post($post_id);
  setup_postdata($post);
  
  ob_start();
  get_template_part('partials/villa-card', null, [
    'post_id' => $post_id,
  ]);
  $output = ob_get_clean();
  
  wp_reset_postdata();
  
  return $output;
});

// -----------------------
// ACF Fields: Collections Page Content
// -----------------------
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  $collections = ['sea', 'land', 'city'];
  $collection_names = [
    'sea' => 'Sea Collection',
    'land' => 'Land Collection',
    'city' => 'City Collection',
  ];

  $fields = [];

  foreach ($collections as $collection) {
    $name = $collection_names[$collection] ?? ucfirst($collection);
    
    // Visual tab for this collection
    $fields[] = [
      'key'       => "field_collection_tab_$collection",
      'label'     => $name,
      'type'      => 'tab',
      'placement' => 'top',
    ];

    // Collection title
    $fields[] = [
      'key'   => "field_collection_{$collection}_title",
      'label' => 'Collection Title',
      'name'  => "collection_{$collection}_title",
      'type'  => 'text',
      'instructions' => 'Custom title for this collection (translatable via Polylang). Leave empty to use default.',
    ];

    // Collection image
    $fields[] = [
      'key'           => "field_collection_{$collection}_image",
      'label'         => 'Collection Image',
      'name'          => "collection_{$collection}_image",
      'type'          => 'image',
      'return_format' => 'id',
      'preview_size'  => 'medium_large',
      'instructions'  => 'Main image for the collection section (left side)',
    ];

    // Collection video (YouTube)
    $fields[] = [
      'key'           => "field_collection_{$collection}_video_url",
      'label'         => 'Collection Video (YouTube URL)',
      'name'          => "collection_{$collection}_video_url",
      'type'          => 'url',
      'instructions'  => 'Paste a YouTube link to autoplay in place of the image. Leave blank to show the image.',
      'default_value' => '',
    ];

    // Short description
    $fields[] = [
      'key'   => "field_collection_{$collection}_short_desc",
      'label' => 'Short Description',
      'name'  => "collection_{$collection}_short_desc",
      'type'  => 'text',
      'instructions' => 'One-line tagline for the collection',
    ];

    // Long description
    $fields[] = [
      'key'   => "field_collection_{$collection}_long_desc",
      'label' => 'Extended Description',
      'name'  => "collection_{$collection}_long_desc",
      'type'  => 'textarea',
      'rows'  => 4,
      'new_lines' => 'wpautop',
      'instructions' => 'Detailed narrative about the collection, location highlights, and selling points',
    ];

    // Read more link
    $fields[] = [
      'key'   => "field_collection_{$collection}_read_more_url",
      'label' => 'Read More URL (optional)',
      'name'  => "collection_{$collection}_read_more_url",
      'type'  => 'url',
      'instructions' => 'Link for the "Read More" button. Leave blank to hide button.',
    ];
  }

  acf_add_local_field_group([
    'key'    => 'group_collections_content',
    'title'  => 'Collections Page Content',
    'fields' => $fields,
    'location' => [[[
      'param'    => 'page_template',
      'operator' => '==',
      'value'    => 'collections.php',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

// -----------------------
// ACF Fields: All Villas Page Titles
// -----------------------
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'    => 'group_all_villas_titles',
    'title'  => 'All Villas Page Titles',
    'fields' => [
      [
        'key'   => 'field_all_villas_sea_title',
        'label' => 'Sea Collection Title',
        'name'  => 'all_villas_sea_title',
        'type'  => 'text',
        'default_value' => 'Sea Collection',
        'instructions' => 'H2 title for the Sea collection slider.',
      ],
      [
        'key'   => 'field_all_villas_land_title',
        'label' => 'Land Collection Title',
        'name'  => 'all_villas_land_title',
        'type'  => 'text',
        'default_value' => 'Land Collection',
        'instructions' => 'H2 title for the Land collection slider.',
      ],
      [
        'key'   => 'field_all_villas_city_title',
        'label' => 'City Collection Title',
        'name'  => 'all_villas_city_title',
        'type'  => 'text',
        'default_value' => 'City Collection',
        'instructions' => 'H2 title for the City collection slider.',
      ],
    ],
    'location' => [[[
      'param'    => 'page_template',
      'operator' => '==',
      'value'    => 'all-villas.php',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

// -----------------------
// ACF Fields: Concierge Services Page
// -----------------------
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'    => 'group_concierge_header',
    'title'  => 'Concierge Services - Header',
    'fields' => [
      [
        'key'   => 'field_concierge_title',
        'label' => 'Section Title',
        'name'  => 'concierge_title',
        'type'  => 'text',
        'default_value' => 'Get inspired',
        'instructions' => 'Main section title',
      ],
      [
        'key'   => 'field_concierge_subtitle',
        'label' => 'Section Subtitle',
        'name'  => 'concierge_subtitle',
        'type'  => 'text',
        'default_value' => 'Top experiences for your itinerary',
        'instructions' => 'Subtitle text',
      ],
      [
        'key'   => 'field_concierge_button_text',
        'label' => 'Button Text',
        'name'  => 'concierge_button_text',
        'type'  => 'text',
        'default_value' => 'Discover All Services',
        'instructions' => 'Text for "Discover All Services" button',
      ],
      [
        'key'   => 'field_concierge_button_url',
        'label' => 'Button Link',
        'name'  => 'concierge_button_url',
        'type'  => 'text',
        'default_value' => '#all-services',
        'instructions' => 'URL or anchor link for the button (e.g., #all-services or https://example.com)',
      ],
    ],
    'location' => [[[
      'param'    => 'page_template',
      'operator' => '==',
      'value'    => 'concierge-services.php',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);

  // Individual service fields (4 services for free ACF)
  acf_add_local_field_group([
    'key'    => 'group_concierge_services',
    'title'  => 'Concierge Services - Service Items',
    'fields' => [
      [
        'key'   => 'field_service_1_label',
        'label' => 'Service 1',
        'name'  => 'service_1_label',
        'type'  => 'message',
        'message' => 'Configure the first service below',
      ],
      [
        'key'           => 'field_service_1_image',
        'label'         => 'Service 1 - Image',
        'name'          => 'service_1_image',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_1_image_2',
        'label'         => 'Service 1 - Image 2 (Carousel)',
        'name'          => 'service_1_image_2',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_1_image_3',
        'label'         => 'Service 1 - Image 3 (Carousel)',
        'name'          => 'service_1_image_3',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_1_image_4',
        'label'         => 'Service 1 - Image 4 (Carousel)',
        'name'          => 'service_1_image_4',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'   => 'field_service_1_title',
        'label' => 'Service 1 - Title',
        'name'  => 'service_1_title',
        'type'  => 'text',
        'placeholder' => 'e.g., Supercar Grand Tour',
      ],
      [
        'key'   => 'field_service_1_description',
        'label' => 'Service 1 - Description',
        'name'  => 'service_1_description',
        'type'  => 'textarea',
        'rows'  => 6,
        'new_lines' => 'wpautop',
      ],
      [
        'key'   => 'field_service_2_label',
        'label' => 'Service 2',
        'name'  => 'service_2_label',
        'type'  => 'message',
        'message' => 'Configure the second service below',
      ],
      [
        'key'           => 'field_service_2_image',
        'label'         => 'Service 2 - Image',
        'name'          => 'service_2_image',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_2_image_2',
        'label'         => 'Service 2 - Image 2 (Carousel)',
        'name'          => 'service_2_image_2',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_2_image_3',
        'label'         => 'Service 2 - Image 3 (Carousel)',
        'name'          => 'service_2_image_3',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_2_image_4',
        'label'         => 'Service 2 - Image 4 (Carousel)',
        'name'          => 'service_2_image_4',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'   => 'field_service_2_title',
        'label' => 'Service 2 - Title',
        'name'  => 'service_2_title',
        'type'  => 'text',
        'placeholder' => 'e.g., Private Chef Experience',
      ],
      [
        'key'   => 'field_service_2_description',
        'label' => 'Service 2 - Description',
        'name'  => 'service_2_description',
        'type'  => 'textarea',
        'rows'  => 6,
        'new_lines' => 'wpautop',
      ],
      [
        'key'   => 'field_service_3_label',
        'label' => 'Service 3',
        'name'  => 'service_3_label',
        'type'  => 'message',
        'message' => 'Configure the third service below',
      ],
      [
        'key'           => 'field_service_3_image',
        'label'         => 'Service 3 - Image',
        'name'          => 'service_3_image',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_3_image_2',
        'label'         => 'Service 3 - Image 2 (Carousel)',
        'name'          => 'service_3_image_2',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_3_image_3',
        'label'         => 'Service 3 - Image 3 (Carousel)',
        'name'          => 'service_3_image_3',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_3_image_4',
        'label'         => 'Service 3 - Image 4 (Carousel)',
        'name'          => 'service_3_image_4',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'   => 'field_service_3_title',
        'label' => 'Service 3 - Title',
        'name'  => 'service_3_title',
        'type'  => 'text',
        'placeholder' => 'e.g., Yacht Adventure',
      ],
      [
        'key'   => 'field_service_3_description',
        'label' => 'Service 3 - Description',
        'name'  => 'service_3_description',
        'type'  => 'textarea',
        'rows'  => 6,
        'new_lines' => 'wpautop',
      ],
      [
        'key'   => 'field_service_4_label',
        'label' => 'Service 4',
        'name'  => 'service_4_label',
        'type'  => 'message',
        'message' => 'Configure the fourth service below',
      ],
      [
        'key'           => 'field_service_4_image',
        'label'         => 'Service 4 - Image',
        'name'          => 'service_4_image',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_4_image_2',
        'label'         => 'Service 4 - Image 2 (Carousel)',
        'name'          => 'service_4_image_2',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_4_image_3',
        'label'         => 'Service 4 - Image 3 (Carousel)',
        'name'          => 'service_4_image_3',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'           => 'field_service_4_image_4',
        'label'         => 'Service 4 - Image 4 (Carousel)',
        'name'          => 'service_4_image_4',
        'type'          => 'image',
        'return_format' => 'id',
        'preview_size'  => 'medium_large',
      ],
      [
        'key'   => 'field_service_4_title',
        'label' => 'Service 4 - Title',
        'name'  => 'service_4_title',
        'type'  => 'text',
        'placeholder' => 'e.g., Wine Tasting Tour',
      ],
      [
        'key'   => 'field_service_4_description',
        'label' => 'Service 4 - Description',
        'name'  => 'service_4_description',
        'type'  => 'textarea',
        'rows'  => 6,
        'new_lines' => 'wpautop',
      ],
    ],
    'location' => [[[
      'param'    => 'page_template',
      'operator' => '==',
      'value'    => 'concierge-services.php',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

// -----------------------
// ACF Fields: Homepage Collections
// -----------------------
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  $fields = [];
  
  // Sea Collection
  $fields[] = [
    'key'   => 'field_home_sea_image',
    'label' => 'Sea Collection - Image',
    'name'  => 'home_sea_image',
    'type'  => 'url',
    'instructions' => 'URL of the sea collection image',
  ];
  $fields[] = [
    'key'   => 'field_home_sea_title',
    'label' => 'Sea Collection - Title',
    'name'  => 'home_sea_title',
    'type'  => 'textarea',
    'rows'  => 2,
    'default_value' => 'Sea Collection',
  ];
  $fields[] = [
    'key'   => 'field_home_sea_description',
    'label' => 'Sea Collection - Description',
    'name'  => 'home_sea_description',
    'type'  => 'textarea',
    'rows'  => 4,
    'default_value' => 'Unveiling the Epitome of Luxury Living - Step into a world of unparalledled exclusivity with our carefully curated collection of the best luxury holiday villas in the world, each a masterpiece of award winning design and a heaven of privcy, staffed to cater to your every need.',
  ];
  $fields[] = [
    'key'   => 'field_home_sea_link',
    'label' => 'Sea Collection - Link',
    'name'  => 'home_sea_link',
    'type'  => 'url',
    'instructions' => 'URL for "Explore Collection" button',
  ];
  $fields[] = [
    'key'   => 'field_home_sea_button_text',
    'label' => 'Sea Collection - Button Text',
    'name'  => 'home_sea_button_text',
    'type'  => 'text',
    'default_value' => '',
  ];
  
  // City Collection
  $fields[] = [
    'key'   => 'field_home_city_image',
    'label' => 'City Collection - Image',
    'name'  => 'home_city_image',
    'type'  => 'url',
    'instructions' => 'URL of the city collection image',
  ];
  $fields[] = [
    'key'   => 'field_home_city_title',
    'label' => 'City Collection - Title',
    'name'  => 'home_city_title',
    'type'  => 'textarea',
    'rows'  => 2,
    'default_value' => 'City Collection',
  ];
  $fields[] = [
    'key'   => 'field_home_city_description',
    'label' => 'City Collection - Description',
    'name'  => 'home_city_description',
    'type'  => 'textarea',
    'rows'  => 4,
    'default_value' => 'Unveiling the Epitome of Luxury Living - Step into a world of unparalledled exclusivity with our carefully curated collection of the best luxury holiday villas in the world, each a masterpiece of award winning design and a heaven of privcy, staffed to cater to your every need.',
  ];
  $fields[] = [
    'key'   => 'field_home_city_link',
    'label' => 'City Collection - Link',
    'name'  => 'home_city_link',
    'type'  => 'url',
    'instructions' => 'URL for "Explore Collection" button',
  ];
  $fields[] = [
    'key'   => 'field_home_city_button_text',
    'label' => 'City Collection - Button Text',
    'name'  => 'home_city_button_text',
    'type'  => 'text',
    'default_value' => '',
  ];
  
  // Land Collection
  $fields[] = [
    'key'   => 'field_home_land_image',
    'label' => 'Land Collection - Image',
    'name'  => 'home_land_image',
    'type'  => 'url',
    'instructions' => 'URL of the land collection image',
  ];
  $fields[] = [
    'key'   => 'field_home_land_title',
    'label' => 'Land Collection - Title',
    'name'  => 'home_land_title',
    'type'  => 'textarea',
    'rows'  => 2,
    'default_value' => 'Land Collection',
  ];
  $fields[] = [
    'key'   => 'field_home_land_description',
    'label' => 'Land Collection - Description',
    'name'  => 'home_land_description',
    'type'  => 'textarea',
    'rows'  => 4,
    'default_value' => 'Unveiling the Epitome of Luxury Living - Step into a world of unparalledled exclusivity with our carefully curated collection of the best luxury holiday villas in the world, each a masterpiece of award winning design and a heaven of privcy, staffed to cater to your every need.',
  ];
  $fields[] = [
    'key'   => 'field_home_land_link',
    'label' => 'Land Collection - Link',
    'name'  => 'home_land_link',
    'type'  => 'url',
    'instructions' => 'URL for "Explore Collection" button',
  ];
  $fields[] = [
    'key'   => 'field_home_land_button_text',
    'label' => 'Land Collection - Button Text',
    'name'  => 'home_land_button_text',
    'type'  => 'text',
    'default_value' => '',
  ];

  acf_add_local_field_group([
    'key'    => 'group_homepage_collections',
    'title'  => 'Homepage Collections',
    'fields' => $fields,
    'location' => [[[
      'param'    => 'page_type',
      'operator' => '==',
      'value'    => 'front_page',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

// -----------------------
// ACF Fields: Homepage Hero Section
// -----------------------
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  $fields = [];
  
  $fields[] = [
    'key'   => 'field_home_hero_image',
    'label' => 'Background Image',
    'name'  => 'home_hero_image',
    'type'  => 'url',
    'instructions' => 'URL of the hero background image',
    'default_value' => 'http://puglialuxuryhomes.com/wp-content/uploads/2024/11/7-Vue-1-scaled.webp',
  ];
  $fields[] = [
    'key'   => 'field_home_hero_title',
    'label' => 'Title',
    'name'  => 'home_hero_title',
    'type'  => 'text',
    'default_value' => 'A WINDOW ON THE ADRIATIC',
  ];
  $fields[] = [
    'key'   => 'field_home_hero_description',
    'label' => 'Description',
    'name'  => 'home_hero_description',
    'type'  => 'textarea',
    'rows'  => 3,
    'default_value' => 'Here, the dry stone of Solento sinks into the intense blue of the Mediterranean. Bordered by cliffs, inlets and long white beaches, hemmed in by scrumbland and pine forests, this wild land is an obe to the art of living and the seaside indolence.',
  ];
  $fields[] = [
    'key'   => 'field_home_hero_video_url',
    'label' => 'Background Video (YouTube URL)',
    'name'  => 'home_hero_video_url',
    'type'  => 'url',
    'instructions' => 'Paste a YouTube link to autoplay as the hero background. Leave empty to use only the image.',
    'default_value' => '',
  ];

  acf_add_local_field_group([
    'key'    => 'group_homepage_hero',
    'title'  => 'Homepage Hero Section',
    'fields' => $fields,
    'location' => [[[
      'param'    => 'page_type',
      'operator' => '==',
      'value'    => 'front_page',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

// -----------------------
// ACF Fields: Homepage Property Management
// -----------------------
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  $fields = [];
  
  // Property Management Title & Description
  $fields[] = [
    'key'   => 'field_home_pm_title',
    'label' => 'Property Management - Title',
    'name'  => 'home_pm_title',
    'type'  => 'text',
    'default_value' => 'PROPERTY MANAGEMENT',
  ];
  $fields[] = [
    'key'   => 'field_home_pm_description',
    'label' => 'Property Management - Description',
    'name'  => 'home_pm_description',
    'type'  => 'textarea',
    'rows'  => 4,
    'default_value' => 'As a short-term rental management specialists in Salento, we assist our property owners with the management of their assets. From creating listings to revenue management and concierge services, our team takes care of your rental from the outset to completion.',
  ];
  
  // Management Card 1
  $fields[] = [
    'key'   => 'field_home_pm_card1_image',
    'label' => 'Management Card 1 - Image',
    'name'  => 'home_pm_card1_image',
    'type'  => 'url',
    'instructions' => 'URL of the card 1 image',
    'default_value' => 'http://puglialuxuryhomes.com/wp-content/uploads/2024/11/1-Vue-generale-1.webp',
  ];
  $fields[] = [
    'key'   => 'field_home_pm_card1_title',
    'label' => 'Management Card 1 - Title',
    'name'  => 'home_pm_card1_title',
    'type'  => 'text',
    'default_value' => 'Marketing of your property',
  ];
  
  // Management Card 2
  $fields[] = [
    'key'   => 'field_home_pm_card2_image',
    'label' => 'Management Card 2 - Image',
    'name'  => 'home_pm_card2_image',
    'type'  => 'url',
    'instructions' => 'URL of the card 2 image',
    'default_value' => 'http://puglialuxuryhomes.com/wp-content/uploads/2024/11/4.1-Diner-1.webp',
  ];
  $fields[] = [
    'key'   => 'field_home_pm_card2_title',
    'label' => 'Management Card 2 - Title',
    'name'  => 'home_pm_card2_title',
    'type'  => 'text',
    'default_value' => 'Annual management of your property',
  ];
  
  // Management Card 3
  $fields[] = [
    'key'   => 'field_home_pm_card3_image',
    'label' => 'Management Card 3 - Image',
    'name'  => 'home_pm_card3_image',
    'type'  => 'url',
    'instructions' => 'URL of the card 3 image',
    'default_value' => 'http://puglialuxuryhomes.com/wp-content/uploads/2024/11/2-CH-1.2-scaled.webp',
  ];
  $fields[] = [
    'key'   => 'field_home_pm_card3_title',
    'label' => 'Management Card 3 - Title',
    'name'  => 'home_pm_card3_title',
    'type'  => 'text',
    'default_value' => 'Rental Management',
  ];
  
  // Management Card 4
  $fields[] = [
    'key'   => 'field_home_pm_card4_image',
    'label' => 'Management Card 4 - Image',
    'name'  => 'home_pm_card4_image',
    'type'  => 'url',
    'instructions' => 'URL of the card 4 image',
    'default_value' => 'http://puglialuxuryhomes.com/wp-content/uploads/2024/11/Lifestyle-24-scaled.webp',
  ];
  $fields[] = [
    'key'   => 'field_home_pm_card4_title',
    'label' => 'Management Card 4 - Title',
    'name'  => 'home_pm_card4_title',
    'type'  => 'text',
    'default_value' => 'Dedicated conciergerie',
  ];

  acf_add_local_field_group([
    'key'    => 'group_homepage_property_management',
    'title'  => 'Homepage Property Management',
    'fields' => $fields,
    'location' => [[[
      'param'    => 'page_type',
      'operator' => '==',
      'value'    => 'front_page',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

// Homepage Section Titles ACF Fields
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  $fields = [];

  // Our Collections Section
  $fields[] = [
    'key'   => 'field_home_collections_title',
    'label' => 'Our Collections - Title',
    'name'  => 'home_collections_title',
    'type'  => 'text',
    'default_value' => 'Our Collections',
  ];
  $fields[] = [
    'key'   => 'field_home_collections_description',
    'label' => 'Our Collections - Description',
    'name'  => 'home_collections_description',
    'type'  => 'textarea',
    'rows'  => 3,
    'default_value' => 'Discover our collections of exclusive villas',
  ];

  // Villas Section
  $fields[] = [
    'key'   => 'field_home_villas_title',
    'label' => 'Villas - Title',
    'name'  => 'home_villas_title',
    'type'  => 'text',
    'default_value' => 'Villas',
  ];
  $fields[] = [
    'key'   => 'field_home_villas_description',
    'label' => 'Villas - Description',
    'name'  => 'home_villas_description',
    'type'  => 'textarea',
    'rows'  => 3,
    'default_value' => 'Elegance and tranquility in exceptional places',
  ];

  acf_add_local_field_group([
    'key'    => 'group_homepage_section_titles',
    'title'  => 'Homepage Section Titles',
    'fields' => $fields,
    'location' => [[[
      'param'    => 'page_type',
      'operator' => '==',
      'value'    => 'front_page',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

// Our Story Page ACF Fields
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'    => 'group_our_story',
    'title'  => 'Our Story Sections',
    'fields' => [
      // --- THE STORY SECTION ---
      [
        'key'       => 'field_story_tab',
        'label'     => 'The Story',
        'type'      => 'tab',
        'placement' => 'top',
      ],
      [
        'key'   => 'field_story_subtitle',
        'label' => 'Story Subtitle',
        'name'  => 'story_subtitle',
        'type'  => 'text',
        'default_value' => 'The Story',
      ],
      [
        'key'   => 'field_story_title',
        'label' => 'Story Title',
        'name'  => 'story_title',
        'type'  => 'text',
        'default_value' => 'Once Upon a Time...',
      ],
      [
        'key'   => 'field_story_image',
        'label' => 'Story Image',
        'name'  => 'story_image',
        'type'  => 'url',
        'default_value' => 'https://www.puglialuxuryhomes.com/wp-content/uploads/2023/12/les-3-fondateurs-scaled.webp',
      ],
      [
        'key'   => 'field_story_paragraph_1',
        'label' => 'Story Paragraph 1',
        'name'  => 'story_paragraph_1',
        'type'  => 'textarea',
        'rows'  => 4,
        'default_value' => 'It all started with Villa Acquamarina, a simple vacation home project initiated by our parents. This precious place in Salento sparkered in us a passion for this authentic region bathed in light. The italian language became a new melody to our ears, the Salentine cuisine a feast, and the Italians we met, like actors in a sunny play, each adding a note of joy and charm to our stays.',
      ],
      [
        'key'   => 'field_story_paragraph_2',
        'label' => 'Story Paragraph 2',
        'name'  => 'story_paragraph_2',
        'type'  => 'textarea',
        'rows'  => 4,
        'default_value' => 'But what captibated us most was the feeling of being immersed in a bygone era. Salento had he nostalgic charm of the 60s, a place seemingly frozen in time but full of life - an oasis of serenity, far from the frenzy of today\'s world.',
      ],
      [
        'key'   => 'field_story_button_text',
        'label' => 'Story Button Text',
        'name'  => 'story_button_text',
        'type'  => 'text',
        'default_value' => 'Contact Us',
      ],
      [
        'key'   => 'field_story_button_url',
        'label' => 'Story Button URL',
        'name'  => 'story_button_url',
        'type'  => 'url',
        'default_value' => '/contact',
      ],

      // --- THE ADVENTURE SECTION ---
      [
        'key'       => 'field_adventure_tab',
        'label'     => 'The Adventure',
        'type'      => 'tab',
        'placement' => 'top',
      ],
      [
        'key'   => 'field_adventure_subtitle',
        'label' => 'Adventure Subtitle',
        'name'  => 'adventure_subtitle',
        'type'  => 'text',
        'default_value' => 'The Adventure',
      ],
      [
        'key'   => 'field_adventure_title',
        'label' => 'Adventure Title',
        'name'  => 'adventure_title',
        'type'  => 'text',
        'default_value' => 'The desire to live there...',
      ],
      [
        'key'   => 'field_adventure_image',
        'label' => 'Adventure Image',
        'name'  => 'adventure_image',
        'type'  => 'url',
      ],
      [
        'key'   => 'field_adventure_paragraph_1',
        'label' => 'Adventure Paragraph 1',
        'name'  => 'adventure_paragraph_1',
        'type'  => 'textarea',
        'rows'  => 4,
        'default_value' => 'Seeing it as a unique opportunity, we decided to pursue our professional dream, shaped by our meeting in 2015 at the Ecole Hôtelière de Lausanne, where we honed our sense of excellence in hospitality and service.',
      ],
      [
        'key'   => 'field_adventure_paragraph_2',
        'label' => 'Adventure Paragraph 2',
        'name'  => 'adventure_paragraph_2',
        'type'  => 'textarea',
        'rows'  => 4,
        'default_value' => 'After Acquamarina, our passion for Salento naturally led us to expand our collection of properties. We handpicked unique villas, each with its own character, to offer our guests priviledged access to the beauty and seranity of this still-preserved region. Our shared expertise, nurtured by our hospitality training, enabled us to create a tailored concierge service, where every detail is thoughtfully considered to ensure that every stay becomes an exceptional moment.',
      ],

      // --- OUR MISSION SECTION ---
      [
        'key'       => 'field_mission_tab',
        'label'     => 'Our Mission',
        'type'      => 'tab',
        'placement' => 'top',
      ],
      [
        'key'   => 'field_mission_subtitle',
        'label' => 'Mission Subtitle',
        'name'  => 'mission_subtitle',
        'type'  => 'text',
        'default_value' => 'Our Mission',
      ],
      [
        'key'   => 'field_mission_title',
        'label' => 'Mission Title',
        'name'  => 'mission_title',
        'type'  => 'text',
        'default_value' => 'Share our paradise...',
      ],
      [
        'key'   => 'field_mission_video_id',
        'label' => 'Mission Video YouTube ID',
        'name'  => 'mission_video_id',
        'type'  => 'text',
        'default_value' => 'HsHxR7onVnE',
        'instructions' => 'YouTube Shorts video ID (e.g., HsHxR7onVnE from https://youtube.com/shorts/HsHxR7onVnE)',
      ],
      [
        'key'   => 'field_mission_paragraph_1',
        'label' => 'Mission Paragraph 1',
        'name'  => 'mission_paragraph_1',
        'type'  => 'textarea',
        'rows'  => 4,
        'default_value' => 'Today, our mission is to share this region, which has become our home, by offering our visitors more than just a vacation destination. We are committed to helping them experience Salento in all its authenticity, combining comfort, elegance, and attentive service. For us, every smile, every moment spent under the Salentine sun, is a way to transmit our passion and give travelers an experience that resonates long after their departure.',
      ],
      [
        'key'   => 'field_mission_paragraph_2',
        'label' => 'Mission Paragraph 2',
        'name'  => 'mission_paragraph_2',
        'type'  => 'textarea',
        'rows'  => 3,
        'default_value' => 'So, we hope you\'ll find a much delight here as we do, and we assure you of our wholehearted devotion and boundless joy.',
      ],
      [
        'key'   => 'field_mission_signature',
        'label' => 'Mission Signature',
        'name'  => 'mission_signature',
        'type'  => 'text',
        'default_value' => 'Sébastien & Augustine',
      ],

      // --- THE PORTRAIT SECTION ---
      [
        'key'       => 'field_portrait_tab',
        'label'     => 'The Portrait',
        'type'      => 'tab',
        'placement' => 'top',
      ],
      [
        'key'   => 'field_portrait_subtitle',
        'label' => 'Portrait Subtitle',
        'name'  => 'portrait_subtitle',
        'type'  => 'text',
        'default_value' => 'The portrait',
      ],
      [
        'key'   => 'field_portrait_title',
        'label' => 'Portrait Title',
        'name'  => 'portrait_title',
        'type'  => 'text',
        'default_value' => '"Born out of love...',
      ],
      [
        'key'   => 'field_portrait_video_id',
        'label' => 'Portrait Video YouTube ID',
        'name'  => 'portrait_video_id',
        'type'  => 'text',
        'default_value' => '0xpYqmAWEvs',
        'instructions' => 'YouTube video ID (standard 16:9 format)',
      ],
    ],
    'location' => [[[
      'param'    => 'page_template',
      'operator' => '==',
      'value'    => 'our-story.php',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

// Conditions Générales Page ACF Fields
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'    => 'group_conditions_generales',
    'title'  => 'Conditions Générales Content',
    'fields' => [
      [
        'key'   => 'field_cgl_content',
        'label' => 'General Conditions Content',
        'name'  => 'cgl_content',
        'type'  => 'wysiwyg',
        'tabs'  => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'delay' => 0,
        'instructions' => 'Add your general conditions / terms and conditions content here. Full HTML editor with formatting options.',
      ],
    ],
    'location' => [[[
      'param'    => 'page_template',
      'operator' => '==',
      'value'    => 'policies.php',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

// Confidentiality Policy Page ACF Fields
add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key'    => 'group_confidentiality_policy',
    'title'  => 'Confidentiality Policy Content',
    'fields' => [
      [
        'key'   => 'field_confidentiality_content',
        'label' => 'Confidentiality Policy Content',
        'name'  => 'confidentiality_content',
        'type'  => 'wysiwyg',
        'tabs'  => 'all',
        'toolbar' => 'full',
        'media_upload' => 1,
        'delay' => 0,
        'instructions' => 'Add your confidentiality/privacy policy content here. Full HTML editor with formatting options.',
      ],
    ],
    'location' => [[[
      'param'    => 'page_template',
      'operator' => '==',
      'value'    => 'policies.php',
    ]]],
    'position'        => 'normal',
    'label_placement' => 'top',
  ]);
});

// -----------------------
// AJAX Filter Villas
// -----------------------
add_action('wp_ajax_filter_villas', 'plh_filter_villas');
add_action('wp_ajax_nopriv_filter_villas', 'plh_filter_villas');

function plh_filter_villas() {
  // Verify nonce
  if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'filter_villas_nonce')) {
    wp_die('Security check failed');
  }
  
  // Get filter values
  $collection = isset($_POST['collection']) ? sanitize_text_field($_POST['collection']) : '';
  $guests = isset($_POST['guests']) ? intval($_POST['guests']) : 0;
  $price = isset($_POST['price']) ? sanitize_text_field($_POST['price']) : '';
  
  // Build query args
  $args = [
    'post_type' => 'villa',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
  ];
  
  // Collection taxonomy filter
  if (!empty($collection)) {
    $args['tax_query'] = [[
      'taxonomy' => 'villa_collection',
      'field' => 'slug',
      'terms' => $collection,
    ]];
  }
  
  // Meta query for guests and price
  $meta_query = ['relation' => 'AND'];
  
  if ($guests > 0) {
    // Guests filter now uses threshold buckets (e.g., 8+ means guests_1 >= 8)
    $meta_query[] = [
      'key' => 'guests_1',
      'value' => $guests,
      'compare' => '>=',
      'type' => 'NUMERIC',
    ];
  }
  
  // Price range filter (convert nightly to weekly)
  if (!empty($price)) {
    $price_parts = explode('-', $price);
    if (count($price_parts) === 2) {
      $price_min = intval($price_parts[0]) * 7;
      $price_max = intval($price_parts[1]) * 7;
      
      $meta_query[] = [
        'key' => 'price_from_1',
        'value' => [$price_min, $price_max],
        'compare' => 'BETWEEN',
        'type' => 'NUMERIC',
      ];
    }
  }
  
  if (count($meta_query) > 1) {
    $args['meta_query'] = $meta_query;
  }
  
  // Execute query
  $query = new WP_Query($args);
  
  // Output results
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      echo '<article class="villa-grid-item">';
      get_template_part('partials/villa-card', null, ['post_id' => get_the_ID()]);
      echo '</article>';
    }
    wp_reset_postdata();
  } else {
    echo '<p class="no-villas">' . esc_html__('No villas found matching your criteria', 'plh') . '</p>';
  }
  
  wp_die();
}

// AJAX handler for villa filters (with capacity, collection, price)
add_action('wp_ajax_filter_villas', 'plh_filter_villas_ajax');
add_action('wp_ajax_nopriv_filter_villas', 'plh_filter_villas_ajax');

function plh_filter_villas_ajax() {
  if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'villa_filter_nonce')) {
    wp_send_json_error(['message' => 'Invalid nonce']);
    return;
  }

  $capacity = isset($_POST['capacity']) ? json_decode(stripslashes($_POST['capacity']), true) : [];
  $collection = isset($_POST['collection']) ? json_decode(stripslashes($_POST['collection']), true) : [];
  $price = isset($_POST['price']) ? json_decode(stripslashes($_POST['price']), true) : [];

  $args = [
    'post_type' => 'villa',
    'posts_per_page' => -1,
    'post_status' => 'publish',
  ];

  $meta_query = ['relation' => 'AND'];
  
  if (!empty($capacity)) {
    $capacity_query = ['relation' => 'OR'];

    foreach ($capacity as $cap) {
      $cap_value = intval($cap);
      if ($cap_value > 0) {
        $capacity_query[] = [
          'key' => 'guests_1',
          'value' => $cap_value,
          'compare' => '>=',
          'type' => 'NUMERIC',
        ];
      }
    }

    if (count($capacity_query) > 1) {
      $meta_query[] = $capacity_query;
    }
  }

  if (!empty($price)) {
    $price_query = ['relation' => 'OR'];
    foreach ($price as $range) {
      $parts = explode('-', $range);
      if (count($parts) === 2) {
        $min = intval($parts[0]);
        $max = intval($parts[1]);
        $price_query[] = [
          'key' => 'price_from_1',
          'value' => [$min * 7, $max * 7],
          'compare' => 'BETWEEN',
          'type' => 'NUMERIC',
        ];
      }
    }
    if (count($price_query) > 1) {
      $meta_query[] = $price_query;
    }
  }

  if (count($meta_query) > 1) {
    $args['meta_query'] = $meta_query;
  }

  if (!empty($collection)) {
    $args['tax_query'] = [
      [
        'taxonomy' => 'villa_collection',
        'field' => 'slug',
        'terms' => $collection,
        'operator' => 'IN',
      ],
    ];
  }

  $query = new WP_Query($args);
  
  ob_start();
  
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      echo '<article class="villa-grid-item">';
      get_template_part('partials/villa-card');
      echo '</article>';
    }
    $html = ob_get_clean();
    wp_reset_postdata();
    
    wp_send_json_success([
      'html' => $html,
      'count' => $query->post_count,
    ]);
  } else {
    ob_end_clean();
    wp_send_json_error([
      'html' => '',
      'count' => 0,
    ]);
  }

  wp_die();
}

// Allow identical slugs for villa CPT across Polylang languages
add_filter('wp_unique_post_slug', function ($slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug) {
  if ($post_type !== 'villa') {
    return $slug;
  }
  return $original_slug;
}, 10, 6);

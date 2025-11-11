<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
  <link rel="preload"
      href="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/fonts/vogue/vogue-regular.woff2' ); ?>"
      as="font" type="font/woff2" crossorigin>

  <?php wp_head(); ?>
</head>
<body <?php body_class('headerless'); ?>>
<?php wp_body_open(); ?>
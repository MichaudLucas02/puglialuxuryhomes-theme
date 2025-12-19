<?php
/** 
 * Template Name: The villas
 */
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<?php
// Use the same approach as collections.php: loop collections and query by slug.
// Titles come from ACF (per-language via Polylang), with sensible fallbacks.
$collections = [
    'sea'  => get_field('all_villas_sea_title')  ?: plh_t('Sea Collection'),
    'land' => get_field('all_villas_land_title') ?: plh_t('Land Collection'),
    'city' => get_field('all_villas_city_title') ?: plh_t('City Collection'),
];

foreach ($collections as $slug => $label):
    $q = new WP_Query([
        'post_type'      => 'villa',
        'posts_per_page' => -1, // show all in slider
        'tax_query' => [
            [
                'taxonomy' => 'villa_collection',
                'field'    => 'slug',
                'terms'    => [$slug],
            ],
        ],
    ]);
?>

<section class="collection-villa">
    <h2><?php echo esc_html($label); ?></h2>
    <section class="main-content villa-slider">
        <div class="swiper <?php echo esc_attr($slug); ?>-collection-swiper">
            <div class="swiper-wrapper">
            <?php if ($q->have_posts()): while ($q->have_posts()): $q->the_post(); ?>
                <article class="swiper-slide">
                    <?php get_template_part('partials/villa-card', null, ['post_id' => get_the_ID()]); ?>
                </article>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <p class="no-villas"><?php echo esc_html__('No villas found in this collection', 'plh'); ?></p>
            <?php endif; ?>
            </div>
            
        </div>
        <button class="villa-arrow prev <?php echo esc_attr($slug); ?>-prev" type="button" aria-label="Previous slide">
            <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/right-arrow.png" alt="" />
            </button>
            <button class="villa-arrow next <?php echo esc_attr($slug); ?>-next" type="button" aria-label="Next slide">
            <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/right-arrow.png" alt="" />
        </button>
        <div class="swiper-pagination"></div>

        
        <!-- <div class="vs-dots" data-vs-dots></div> -->
    </section>
</section>

<?php endforeach; ?>

<?php get_footer(); ?>
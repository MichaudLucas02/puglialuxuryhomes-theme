<?php
/** 
 * Template Name: The villas
 */
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<?php
$all_villas = new WP_Query([
        'post_type'      => 'villa',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
]);
?>

<style>
.all-villas-grid {
    padding: 40px 5vw 60px;
}
.all-villas-grid .villas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 28px;
}
@media (min-width: 1024px) {
    .all-villas-grid .villas-grid { grid-template-columns: repeat(3, 1fr); }
}
.all-villas-grid .villa-grid-item { height: 100%; }
</style>

<div class="homepage">

    <section class="all-villas-grid">
        <div class="villas-grid">
            <?php if ($all_villas->have_posts()): while ($all_villas->have_posts()): $all_villas->the_post(); ?>
                <article class="villa-grid-item">
                    <?php get_template_part('partials/villa-card', null, ['post_id' => get_the_ID()]); ?>
                </article>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <p class="no-villas"><?php echo esc_html__('No villas found', 'plh'); ?></p>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php get_footer(); ?>
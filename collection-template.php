<?php
/**
 * Template Name: Single Collection
 */
get_header(); ?>

<?php 
$collection_group = get_field('single_collection');
$collection_description = $collection_group['collection_description'] ?? get_field('collection_description') ?? null;
$description_text = $collection_description['description_text'] ?? null;
$description_image = $collection_description['description_image'] ?? null;
?>

<?php get_template_part('partials/large-hero'); ?>
<section class="breadcrumbs">
    <?php custom_breadcrumbs(); ?>
</section>

<section class="collection-description">
    <div class="collection-description-wrapper">
        <div class="collection-description-column__left">
            <img src="<?php echo esc_url($description_image); ?>">
        </div>
        <div class="collection-description-column__right">
            <p><?php echo esc_html($description_text); ?></p>
            <a href="">Read more</a>
        </div>
    </div>

</section>
<section>
    <h2>The Villas</h2>
</section>
<section class="main-content villa-slider">
  <div class="swiper">
    <div class="swiper-wrapper">
      <?php
      // Example: query villas (replace with your own query)
      $q = new WP_Query([
        'post_type'      => 'villa',    // change if your CPT differs
        'posts_per_page' => 12,
      ]);
      if ($q->have_posts()):
        while ($q->have_posts()): $q->the_post(); ?>
          <article class="swiper-slide">
            <?php
              
              get_template_part('partials/villa-card', null, ['post_id' => get_the_ID()]);

              // Example B: inline minimal card (replace with your component)
            ?>
            
          </article>
        <?php endwhile; wp_reset_postdata();
      endif; ?>
    </div>
    
  </div>
  <button class="villa-arrow prev" type="button" aria-label="Previous slide">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M12.5 15L7.5 10l5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </button>
  <button class="villa-arrow next" type="button" aria-label="Next slide">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M7.5 15l5-5-5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
  </button>
  <div class="swiper-pagination"></div>

  
  <!-- <div class="vs-dots" data-vs-dots></div> -->
</section>





<?php get_footer(); ?>


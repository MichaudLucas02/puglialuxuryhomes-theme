<?php
/** 
 * Template Name: The villas
 */
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<section class="collection-villa">
    <h2>Sea Collection</h2>
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
            <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/right-arrow.png" alt="" />
            </button>
            <button class="villa-arrow next" type="button" aria-label="Next slide">
            <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/right-arrow.png" alt="" />
        </button>
        <div class="swiper-pagination"></div>

        
        <!-- <div class="vs-dots" data-vs-dots></div> -->
    </section>
</section>
<section class="collection-villa">
    <h2>Land Collection</h2>
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
            <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/right-arrow.png" alt="" />
            </button>
            <button class="villa-arrow next" type="button" aria-label="Next slide">
            <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/right-arrow.png" alt="" />
        </button>
        <div class="swiper-pagination"></div>

        
        <!-- <div class="vs-dots" data-vs-dots></div> -->
    </section>

</section>
<section class="collection-villa">
    <h2>City Collection</h2>
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
            <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/right-arrow.png" alt="" />
            </button>
            <button class="villa-arrow next" type="button" aria-label="Next slide">
            <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/right-arrow.png" alt="" />
        </button>
        <div class="swiper-pagination"></div>

        
        <!-- <div class="vs-dots" data-vs-dots></div> -->
    </section>
</section>

<?php get_footer(); ?>
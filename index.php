<?php get_header(); ?>

<div class='homepage'>
    
    <section class='hero-section'>
        <img 
            src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/7-Vue-1-scaled.webp"
            class='hero-background'
        ></img>


        <div class='hero-content'>
            <h1>A WINDOW ON THE ADRIATIC</h1>
            <p>Here, the dry stone of Solento sinks into the intense blue of the Mediterranean. Bordered by cliffs,
                    inlets and long white beaches, hemmed in by scrumbland and pine forests, this wild land is an obe to
                    the art of living and the seaside indolence.</p>
            
        </div>

    </section>
    <section class='our-collection'>
        <h2>Our Collections</h2>
        <p class="p-title">Discover our collections of exclusive villas</p>
        
        <?php
        // Sea Collection
        $sea_image = get_field('home_sea_image') ?: 'http://puglialuxuryhomes.com/wp-content/uploads/2025/04/6-Salotto-2-scaled.jpg';
        $sea_title = get_field('home_sea_title') ?: 'Sea Collection';
        $sea_desc = get_field('home_sea_description') ?: 'Unveiling the Epitome of Luxury Living - Step into a world of unparalledled exclusivity with our carefully curated collection of the best luxury holiday villas in the world, each a masterpiece of award winning design and a heaven of privcy, staffed to cater to your every need.';
        $sea_link = get_field('home_sea_link') ?: '';
        ?>
        <div class="sea-collection">
            <img 
                src="<?php echo esc_url($sea_image); ?>"
                class='sea-collection-cover'
            ></img>
            <div class='sea-overlay'>
                <h1><?php echo esc_html($sea_title); ?></h1>
                <p><?php echo esc_html($sea_desc); ?></p>
                <a href="<?php echo esc_url($sea_link); ?>">EXPLORE COLLECTION</a>
            </div>
        </div>
    
        <div class="collection-wrapper">
            <?php
            // City Collection
            $city_image = get_field('home_city_image') ?: 'http://puglialuxuryhomes.com/wp-content/uploads/2024/08/luca-dimola-bIUIhzGo8_U-unsplash-scaled.jpg';
            $city_title = get_field('home_city_title') ?: 'City Collection';
            $city_desc = get_field('home_city_description') ?: 'Unveiling the Epitome of Luxury Living - Step into a world of unparalledled exclusivity with our carefully curated collection of the best luxury holiday villas in the world, each a masterpiece of award winning design and a heaven of privcy, staffed to cater to your every need.';
            $city_link = get_field('home_city_link') ?: '';
            ?>
            <div class='city-collection'>
                <img
                    src="<?php echo esc_url($city_image); ?>"
                    class='sea-collection-cover'
                ></img>
                <div class='city-overlay'>
                    <h1><?php echo esc_html($city_title); ?></h1>
                    <p><?php echo esc_html($city_desc); ?></p>
                    <a href="<?php echo esc_url($city_link); ?>">EXPLORE COLLECTION</a>
                </div>
            </div>
            
            <?php
            // Land Collection
            $land_image = get_field('home_land_image') ?: '/wp-content/uploads/2025/08/kalina-o-5BhEr7SKhvE-unsplash-scaled.jpg';
            $land_title = get_field('home_land_title') ?: 'Land Collection';
            $land_desc = get_field('home_land_description') ?: 'Unveiling the Epitome of Luxury Living - Step into a world of unparalledled exclusivity with our carefully curated collection of the best luxury holiday villas in the world, each a masterpiece of award winning design and a heaven of privcy, staffed to cater to your every need.';
            $land_link = get_field('home_land_link') ?: get_permalink(get_page_by_path('land-collection'));
            ?>
            <div class='land-collection'>
                <img 
                    src="<?php echo esc_url($land_image); ?>"
                    class='sea-collection-cover'
                ></img>
                <div class='land-overlay'>
                    <h1><?php echo esc_html($land_title); ?></h1>
                    <p><?php echo esc_html($land_desc); ?></p>
                    <a href="<?php echo esc_url($land_link); ?>">EXPLORE COLLECTION</a>
                </div>
            </div>

        </div>
    </section>
    <section class='villa-section'>
        <h2>Villas</h2>
        <p class="p-title">Elegance and tranquility in exceptional places</p>
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
            <img src="/wp-content/uploads/2025/09/right-arrow.png" alt="" />
            </button>
            <button class="villa-arrow next" type="button" aria-label="Next slide">
            <img src="/wp-content/uploads/2025/09/right-arrow.png" alt="" />
        </button>
        <div class="swiper-pagination"></div>

        
        <!-- <div class="vs-dots" data-vs-dots></div> -->
    </section>
    <section class="central-title-section grey">
        <div class="central-title grey">
            <h2>Take a glance <br>at the region</h2>
            <p class="p-title">As a short-term rental management specialists in Salento, we assist our property owners with the management
                of their assets. From creating listings to revenue management and concierge services, our team takes care of your rental
                from the outset to completion.</p>
        </div>
    </section>
    <?php get_template_part('partials/discover-section', null, ['bg_color' => '#F5F5F5']); ?>

    <?php get_template_part('partials/discover-slider'); ?>
    <!--
    
    <section class="why-us">
        <div class="why-us-container">
            <img src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/7-Vue-1-scaled.webp">
            <div class="why-us-absolute">
                
                <div class="why-us-text col1">
                    <h2>Why go with us ?</h2>
                    <p>We'll take care of everything, so you can relax and enjoy</p>
                    <a href="" class="border-button">
                        Find out More
            </a>
                </div>
                 <div class="why-us-text col1">
                    <h2>Superb service</h2>
                    <p>We'll take care of everything, so you can relax and enjoy</p>
                </div>
            </div>

        </div>
    </section>
    -->

    <section class="central-title">
        <h2>PROPERTY MANAGEMENT</h2>
        <p class="p-title">As a short-term rental management specialists in Salento, we assist our property owners with the management
            of their assets. From creating listings to revenue management and concierge services, our team takes care of your rental
            from the outset to completion.</p>
    </section>
    
    <section class="management">

        <div class="management-div">
            <img src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/1-Vue-generale-1.webp">
            <div class="management-title"><h3>Marketing of your property</h3></div>
        </div>
        
        <div class="management-div">
            <img src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/4.1-Diner-1.webp">
            <div class="management-title"><h3>Annual management of your property</h3></div>
        </div>
        <div class="management-div">
            <img src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/2-CH-1.2-scaled.webp">
            <div class="management-title"><h3>Rental Management</h3></div>
        </div>
        <div class="management-div">
            <img src="http://puglialuxuryhomes.com/wp-content/uploads/2024/11/Lifestyle-24-scaled.webp">
            <div class="management-title"><h3>Dedicated conciergerie</h3></div>
        </div>
    </section>


</div>

<?php get_footer(); ?>
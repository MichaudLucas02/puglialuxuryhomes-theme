<?php get_header(); ?>

<div class='homepage'>
    
    <?php
    // Hero Section
    $hero_image = get_field('home_hero_image') ?: 'http://puglialuxuryhomes.com/wp-content/uploads/2024/11/7-Vue-1-scaled.webp';
    $hero_title = get_field('home_hero_title') ?: 'A WINDOW ON THE ADRIATIC';
    $hero_description = get_field('home_hero_description') ?: 'Here, the dry stone of Solento sinks into the intense blue of the Mediterranean. Bordered by cliffs, inlets and long white beaches, hemmed in by scrumbland and pine forests, this wild land is an obe to the art of living and the seaside indolence.';
    $hero_video_url = get_field('home_hero_video_url');
    $hero_video_id = '';
    if (!empty($hero_video_url)) {
        // Extract YouTube video ID from common URL formats
        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:embed/|shorts/|v/|watch\?v=|watch\?.*?&v=))([\w-]{11})~', $hero_video_url, $m)) {
            $hero_video_id = $m[1];
        }
    }
    ?>
    
        <section class='hero-section'>
                <div class="hero-media<?php echo $hero_video_id ? '' : ' no-video'; ?>">
                        <?php if ($hero_video_id) : ?>
                                <div class="hero-video" data-video-id="<?php echo esc_attr($hero_video_id); ?>">
                                        <div id="hero-yt-player"></div>
                                </div>
                        <?php endif; ?>
                        <img 
                                src="<?php echo esc_url($hero_image); ?>"
                                class='hero-background hero-fallback'
                                alt="<?php echo esc_attr($hero_title); ?>"
                        />
                </div>


                <div class='hero-content'>
            <h1><?php echo esc_html($hero_title); ?></h1>
            <p><?php echo esc_html($hero_description); ?></p>
            
        </div>

    </section>
        <?php if ($hero_video_id) : ?>
        <script>
        (function(){
            const media = document.querySelector('.hero-media');
            const videoWrap = document.querySelector('.hero-video');
            if (!media || !videoWrap) return;
            const videoId = videoWrap.getAttribute('data-video-id');
            if (!videoId) return;

            // Respect reduced motion
            if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            let player;
            let playAttempted = false;
            
            function tryPlay() {
                if (!player || playAttempted) return;
                playAttempted = true;
                try {
                    player.mute();
                    player.playVideo();
                    media.classList.add('is-playing');
                } catch(e) {
                    console.log('Video play attempt:', e);
                }
            }

            function onPlayerReady() {
                tryPlay();
                
                // Mobile fallback: try to play on first user interaction
                const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
                if (isMobile) {
                    const playOnInteraction = function() {
                        tryPlay();
                        document.removeEventListener('touchstart', playOnInteraction);
                        document.removeEventListener('scroll', playOnInteraction);
                    };
                    document.addEventListener('touchstart', playOnInteraction, { once: true, passive: true });
                    document.addEventListener('scroll', playOnInteraction, { once: true, passive: true });
                }
            }

            function createPlayer(){
                player = new YT.Player('hero-yt-player', {
                    videoId: videoId,
                    playerVars: {
                        autoplay: 1,
                        mute: 1,
                        controls: 0,
                        rel: 0,
                        playsinline: 1,
                        modestbranding: 1,
                        loop: 1,
                        playlist: videoId,
                        fs: 0,
                        showinfo: 0,
                        iv_load_policy: 3,
                        disablekb: 1
                    },
                    events: { onReady: onPlayerReady }
                });
            }

            function ensureYT(){
                if (window.YT && YT.Player) { createPlayer(); return; }
                const tag = document.createElement('script');
                tag.src = 'https://www.youtube.com/iframe_api';
                document.head.appendChild(tag);
                window.onYouTubeIframeAPIReady = function(){ createPlayer(); };
            }

            ensureYT();
        })();
        </script>
        <?php endif; ?>
    <section class='our-collection'>
        <h2><?php echo esc_html( get_field('home_collections_title') ?: 'Our Collections' ); ?></h2>
        <p class="p-title"><?php echo esc_html( get_field('home_collections_description') ?: 'Discover our collections of exclusive villas' ); ?></p>
        
        <?php
        // Sea Collection
        $sea_image = get_field('home_sea_image') ?: 'http://puglialuxuryhomes.com/wp-content/uploads/2025/04/6-Salotto-2-scaled.jpg';
        $sea_title = get_field('home_sea_title') ?: 'Sea Collection';
        $sea_title_display = nl2br(esc_html($sea_title));
        $sea_desc = get_field('home_sea_description') ?: 'Unveiling the Epitome of Luxury Living - Step into a world of unparalledled exclusivity with our carefully curated collection of the best luxury holiday villas in the world, each a masterpiece of award winning design and a heaven of privcy, staffed to cater to your every need.';
        $sea_link = get_field('home_sea_link') ?: '';
        $sea_button_text = get_field('home_sea_button_text');
        ?>

        <?php if (!empty($sea_link)) : ?><a href="<?php echo esc_url($sea_link); ?>" class="collection-link"><?php endif; ?>
        <div class="sea-collection">
            <img
                src="<?php echo esc_url($sea_image); ?>"
                class='sea-collection-cover'
            ></img>
            <div class='sea-overlay'>
                <h1><?php echo $sea_title_display; ?></h1>
                <p><?php echo esc_html($sea_desc); ?></p>
                <?php if (!empty($sea_button_text)) : ?>
                    <span class="collection-btn"><?php echo esc_html($sea_button_text); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty($sea_link)) : ?></a><?php endif; ?>
    
        <div class="collection-wrapper">
            <?php
            // City Collection
            $city_image = get_field('home_city_image') ?: 'http://puglialuxuryhomes.com/wp-content/uploads/2024/08/luca-dimola-bIUIhzGo8_U-unsplash-scaled.jpg';
            $city_title = get_field('home_city_title') ?: 'City Collection';
            $city_title_display = nl2br(esc_html($city_title));
            $city_desc = get_field('home_city_description') ?: 'Unveiling the Epitome of Luxury Living - Step into a world of unparalledled exclusivity with our carefully curated collection of the best luxury holiday villas in the world, each a masterpiece of award winning design and a heaven of privcy, staffed to cater to your every need.';
            $city_link = get_field('home_city_link') ?: '';
            $city_button_text = get_field('home_city_button_text');
            ?>
            <?php if (!empty($city_link)) : ?><a href="<?php echo esc_url($city_link); ?>" class="collection-link"><?php endif; ?>
            <div class='city-collection'>
                <img
                    src="<?php echo esc_url($city_image); ?>"
                    class='sea-collection-cover'
                ></img>
                <div class='city-overlay'>
                    <h1><?php echo $city_title_display; ?></h1>
                    <p><?php echo esc_html($city_desc); ?></p>
                    <?php if (!empty($city_button_text)) : ?>
                        <span class="collection-btn"><?php echo esc_html($city_button_text); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($city_link)) : ?></a><?php endif; ?>
            
            <?php
            // Land Collection
            $land_image = get_field('home_land_image') ?: '/wp-content/uploads/2025/08/kalina-o-5BhEr7SKhvE-unsplash-scaled.jpg';
            $land_title = get_field('home_land_title') ?: 'Land Collection';
            $land_title_display = nl2br(esc_html($land_title));
            $land_desc = get_field('home_land_description') ?: 'Unveiling the Epitome of Luxury Living - Step into a world of unparalledled exclusivity with our carefully curated collection of the best luxury holiday villas in the world, each a masterpiece of award winning design and a heaven of privcy, staffed to cater to your every need.';
            $land_link = get_field('home_land_link') ?: get_permalink(get_page_by_path('land-collection'));
            $land_button_text = get_field('home_land_button_text');
            ?>
            <?php if (!empty($land_link)) : ?><a href="<?php echo esc_url($land_link); ?>" class="collection-link"><?php endif; ?>
            <div class='land-collection'>
                <img
                    src="<?php echo esc_url($land_image); ?>"
                    class='sea-collection-cover'
                ></img>
                <div class='land-overlay'>
                    <h1><?php echo $land_title_display; ?></h1>
                    <p><?php echo esc_html($land_desc); ?></p>
                    <?php if (!empty($land_button_text)) : ?>
                        <span class="collection-btn"><?php echo esc_html($land_button_text); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($land_link)) : ?></a><?php endif; ?>

        </div>
    </section>
    <section class='villa-section'>
        <h2><?php echo esc_html( get_field('home_villas_title') ?: 'Villas' ); ?></h2>
        <p class="p-title"><?php echo esc_html( get_field('home_villas_description') ?: 'Elegance and tranquility in exceptional places' ); ?></p>
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
            <?php
            // Get current language for Polylang
            $current_lang = function_exists('pll_current_language') ? pll_current_language() : 'en';
            $option_key = 'discover_settings_' . $current_lang;
            
            // Get region section content from settings
            $region_title = get_option($option_key . '_region_title', 'Take a glance <br>at the region');
            $region_description = get_option($option_key . '_region_description', 'As a short-term rental management specialists in Salento, we assist our property owners with the management of their assets. From creating listings to revenue management and concierge services, our team takes care of your rental from the outset to completion.');
            ?>
            <h2><?php echo wp_kses_post($region_title); ?></h2>
            <p class="p-title"><?php echo esc_html($region_description); ?></p>
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

    <?php
    // Property Management Section
    $pm_title = get_field('home_pm_title') ?: 'PROPERTY MANAGEMENT';
    $pm_description = get_field('home_pm_description') ?: 'As a short-term rental management specialists in Salento, we assist our property owners with the management of their assets. From creating listings to revenue management and concierge services, our team takes care of your rental from the outset to completion.';
    
    $pm_card1_image = get_field('home_pm_card1_image') ?: 'http://puglialuxuryhomes.com/wp-content/uploads/2024/11/1-Vue-generale-1.webp';
    $pm_card1_title = get_field('home_pm_card1_title') ?: 'Marketing of your property';
    
    $pm_card2_image = get_field('home_pm_card2_image') ?: 'http://puglialuxuryhomes.com/wp-content/uploads/2024/11/4.1-Diner-1.webp';
    $pm_card2_title = get_field('home_pm_card2_title') ?: 'Annual management of your property';
    
    $pm_card3_image = get_field('home_pm_card3_image') ?: 'http://puglialuxuryhomes.com/wp-content/uploads/2024/11/2-CH-1.2-scaled.webp';
    $pm_card3_title = get_field('home_pm_card3_title') ?: 'Rental Management';
    
    $pm_card4_image = get_field('home_pm_card4_image') ?: 'http://puglialuxuryhomes.com/wp-content/uploads/2024/11/Lifestyle-24-scaled.webp';
    $pm_card4_title = get_field('home_pm_card4_title') ?: 'Dedicated conciergerie';
    ?>
    
    <section class="central-title">
        <h2><?php echo esc_html($pm_title); ?></h2>
        <p class="p-title"><?php echo esc_html($pm_description); ?></p>
    </section>
    
    <section class="management">

        <div class="management-div">
            <img src="<?php echo esc_url($pm_card1_image); ?>" alt="<?php echo esc_attr($pm_card1_title); ?>">
            <div class="management-title"><h3><?php echo esc_html($pm_card1_title); ?></h3></div>
        </div>
        
        <div class="management-div">
            <img src="<?php echo esc_url($pm_card2_image); ?>" alt="<?php echo esc_attr($pm_card2_title); ?>">
            <div class="management-title"><h3><?php echo esc_html($pm_card2_title); ?></h3></div>
        </div>
        <div class="management-div">
            <img src="<?php echo esc_url($pm_card3_image); ?>" alt="<?php echo esc_attr($pm_card3_title); ?>">
            <div class="management-title"><h3><?php echo esc_html($pm_card3_title); ?></h3></div>
        </div>
        <div class="management-div">
            <img src="<?php echo esc_url($pm_card4_image); ?>" alt="<?php echo esc_attr($pm_card4_title); ?>">
            <div class="management-title"><h3><?php echo esc_html($pm_card4_title); ?></h3></div>
        </div>
    </section>


</div>

<?php get_footer(); ?>
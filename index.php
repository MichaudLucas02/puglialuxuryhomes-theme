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
            <h1 class="hero-seo-title"><?php echo esc_html(plh_t('Luxury Villa Rentals in Puglia, Italy')); ?></h1>
            <p class="hero-tagline"><?php echo esc_html($hero_title); ?></p>
            <p class="hero-description"><?php echo esc_html($hero_description); ?></p>
            <div class="hero-ctas">
                <a href="<?php echo esc_url(home_url('/the-villas/')); ?>" class="hero-cta hero-cta--primary"><?php echo esc_html(plh_t('Browse Our Villas')); ?></a>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="hero-cta hero-cta--secondary"><?php echo esc_html(plh_t('Plan Your Stay')); ?></a>
            </div>
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
            
            function onStateChange(event) {
                if (event.data === YT.PlayerState.PLAYING) {
                    media.classList.add('is-playing');
                }
            }

            function tryPlay() {
                if (!player || playAttempted) return;
                playAttempted = true;
                try {
                    player.mute();
                    player.playVideo();
                } catch(e) {}
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
                    events: { onReady: onPlayerReady, onStateChange: onStateChange }
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
    <section class="homepage-intro">
        <h2><?php echo esc_html(plh_t('A boutique villa agency in Puglia, Italy.')); ?></h2>
        <p><?php echo esc_html(plh_t('Exclusively managed properties across the Salento coast and the Valle d\'Itria, private pool villas, traditional trulli houses for rent, and historic palazzo residences, each managed directly by the founders and supported by a concierge service on request.')); ?></p>
    </section>

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
                <h3><?php echo $sea_title_display; ?></h3>
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
                    <h3><?php echo $city_title_display; ?></h3>
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
                    <h3><?php echo $land_title_display; ?></h3>
                    <p><?php echo esc_html($land_desc); ?></p>
                    <?php if (!empty($land_button_text)) : ?>
                        <span class="collection-btn"><?php echo esc_html($land_button_text); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($land_link)) : ?></a><?php endif; ?>

        </div>
    </section>
    <section class="where-in-puglia">
        <h2><?php echo esc_html(plh_t('Where in Puglia')); ?></h2>
        <div class="where-in-puglia-grid">
            <?php
            $regions = [
                [
                    'title'  => plh_t('Salento'),
                    'cities' => plh_t('Lecce · Gagliano del Capo · Santa Maria di Leuca'),
                    'count'  => get_field('home_region_salento_count') ?: '9',
                    'image'  => get_field('home_region_salento_image'),
                    'link'   => get_field('home_region_salento_link') ?: home_url('/the-villas/'),
                ],
                [
                    'title'  => plh_t("Valle d'Itria"),
                    'cities' => plh_t('Ostuni · Noci'),
                    'count'  => get_field('home_region_valleditria_count') ?: '4',
                    'image'  => get_field('home_region_valleditria_image'),
                    'link'   => get_field('home_region_valleditria_link') ?: home_url('/the-villas/'),
                ],
            ];
            foreach ($regions as $region) :
                $img_url = is_array($region['image']) ? $region['image']['url'] : $region['image'];
            ?>
            <a href="<?php echo esc_url($region['link']); ?>" class="where-region-card">
                <?php if ($img_url) : ?>
                <div class="where-region-image">
                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($region['title']); ?>">
                </div>
                <?php endif; ?>
                <div class="where-region-caption">
                    <h3><?php echo esc_html($region['title']); ?></h3>
                    <p class="where-region-cities"><?php echo esc_html($region['cities']); ?></p>
                    <p class="where-region-count"><?php echo esc_html($region['count'] . ' ' . plh_t('villas')); ?></p>
                </div>
            </a>
            <?php endforeach; ?>
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
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M12.5 15L7.5 10l5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <button class="villa-arrow next" type="button" aria-label="Next slide">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M7.5 15l5-5-5-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
        <div class="swiper-pagination"></div>

        
        <!-- <div class="vs-dots" data-vs-dots></div> -->
    </section>
    <?php get_template_part('partials/google-reviews', null, ['post_id' => get_the_ID()]); ?>

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
            <p class="hospitality-tags"><?php echo esc_html(plh_t('Private chef · In-villa massage · Boat rental · Wine tasting · Cooking class · Airport transfer · Pre-arrival stocking · Restaurant booking')); ?></p>
        </div>
    </section>
    <?php get_template_part('partials/discover-section', null, ['bg_color' => '#FFFFFF']); ?>

    <?php get_template_part('partials/discover-slider'); ?>

    <section class="why-plh">
        <div class="why-plh-inner">
            <h2><?php echo esc_html(plh_t('Why Puglia Luxury Homes')); ?></h2>
            <div class="why-plh-grid">
                <div class="why-plh-item">
                    <div class="why-plh-icon">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M19 4C14.029 4 10 8.029 10 13c0 8 9 21 9 21s9-13 9-21c0-4.971-4.029-9-9-9z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="19" cy="13" r="3.5" stroke="currentColor" stroke-width="1.4"/>
                        </svg>
                    </div>
                    <h3><?php echo esc_html(plh_t('Locally Based Founders')); ?></h3>
                    <p><?php echo esc_html(plh_t('Run directly by its two founders, graduates of the École Hôtelière de Lausanne who live in Sud Salento year-round. Every stay is held to the standards of five-star hospitality, looked after in person rather than from a distant office.')); ?></p>
                </div>
                <div class="why-plh-item">
                    <div class="why-plh-icon">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="7" y="8" width="24" height="22" rx="2" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M7 14h24" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M13 6v4M25 6v4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                            <path d="M12 21l4 4 10-8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3><?php echo esc_html(plh_t('Your Stay Arranged Before You Arrive')); ?></h3>
                    <p><?php echo esc_html(plh_t('Tell us what you need ahead of time and it is taken care of: the fridge stocked to your taste, the right tables booked, transfers arranged, and an itinerary shaped around the days you have in mind.')); ?></p>
                </div>
                <div class="why-plh-item">
                    <div class="why-plh-icon">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <circle cx="19" cy="19" r="14" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M19 9v2M19 27v2M9 19h2M27 19h2" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                            <path d="M24 14l-5 5.5-5 5.5 5-5.5L24 14z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3><?php echo esc_html(plh_t('Beyond the Villa')); ?></h3>
                    <p><?php echo esc_html(plh_t('Once you arrive, the region comes to you: a private chef cooking in your own kitchen, wellness treatments by the pool, and long days out along the coast by boat.')); ?></p>
                </div>
                <div class="why-plh-item">
                    <div class="why-plh-icon">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <circle cx="14" cy="13" r="5" stroke="currentColor" stroke-width="1.4"/>
                            <circle cx="24" cy="13" r="5" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M4 33c0-5.523 4.477-9 10-9h10c5.523 0 10 3.477 10 9" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3><?php echo esc_html(plh_t('Introductions, Not Just Reservations')); ?></h3>
                    <p><?php echo esc_html(plh_t('Years of living and working here mean we know the people worth knowing. The restaurateurs, the winemakers, the boat captains. Our guests are welcomed personally and seated at tables that are hard to reach from the outside.')); ?></p>
                </div>
                <div class="why-plh-item">
                    <div class="why-plh-icon">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M4 26l9-9 7 7 6-6 8 8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M4 33h30" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                            <circle cx="29" cy="11" r="4" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M29 7V5M29 17v2M25 11h-2M35 11h-2" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3><?php echo esc_html(plh_t('Seaside, Countryside, or Historic Centre')); ?></h3>
                    <p><?php echo esc_html(plh_t('A small, personally chosen collection, grouped by the setting you want to wake up in, whether by the sea, out in the countryside, or in the heart of a historic town. What you find is a handful of places we stand behind, not a catalogue of everything on the market.')); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section class="parisian-agency-section">
        <?php $pa_image = get_field('home_parisian_agency_image'); ?>
        <div class="parisian-agency-text">
            <p class="parisian-agency-eyebrow"><?php echo esc_html(plh_t('As Seen On')); ?></p>
            <h2><?php echo esc_html(plh_t('The Parisian Agency')); ?></h2>
            <p><?php echo esc_html(plh_t('The Kretz family\'s luxury real estate series, broadcast on TMC and streaming on Netflix.')); ?></p>
        </div>
        <?php if ($pa_image) : ?>
        <div class="parisian-agency-image">
            <img src="<?php echo esc_url(is_array($pa_image) ? $pa_image['url'] : $pa_image['url'] ?? $pa_image); ?>" alt="<?php echo esc_attr(plh_t('As Seen on The Parisian Agency')); ?>">
        </div>
        <?php endif; ?>
    </section>

    <?php get_template_part('partials/re-homepage-section'); ?>

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
    
    $pm_link = get_field('home_pm_link') ?: '';

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

        <?php if (!empty($pm_link)) : ?><a href="<?php echo esc_url($pm_link); ?>" class="management-link"><?php endif; ?>
        <div class="management-div">
            <img src="<?php echo esc_url($pm_card1_image); ?>" alt="<?php echo esc_attr($pm_card1_title); ?>">
            <div class="management-title"><h3><?php echo esc_html($pm_card1_title); ?></h3></div>
        </div>
        <?php if (!empty($pm_link)) : ?></a><?php endif; ?>

        <?php if (!empty($pm_link)) : ?><a href="<?php echo esc_url($pm_link); ?>" class="management-link"><?php endif; ?>
        <div class="management-div">
            <img src="<?php echo esc_url($pm_card2_image); ?>" alt="<?php echo esc_attr($pm_card2_title); ?>">
            <div class="management-title"><h3><?php echo esc_html($pm_card2_title); ?></h3></div>
        </div>
        <?php if (!empty($pm_link)) : ?></a><?php endif; ?>

        <?php if (!empty($pm_link)) : ?><a href="<?php echo esc_url($pm_link); ?>" class="management-link"><?php endif; ?>
        <div class="management-div">
            <img src="<?php echo esc_url($pm_card3_image); ?>" alt="<?php echo esc_attr($pm_card3_title); ?>">
            <div class="management-title"><h3><?php echo esc_html($pm_card3_title); ?></h3></div>
        </div>
        <?php if (!empty($pm_link)) : ?></a><?php endif; ?>

        <?php if (!empty($pm_link)) : ?><a href="<?php echo esc_url($pm_link); ?>" class="management-link"><?php endif; ?>
        <div class="management-div">
            <img src="<?php echo esc_url($pm_card4_image); ?>" alt="<?php echo esc_attr($pm_card4_title); ?>">
            <div class="management-title"><h3><?php echo esc_html($pm_card4_title); ?></h3></div>
        </div>
        <?php if (!empty($pm_link)) : ?></a><?php endif; ?>

    </section>


</div>

<?php get_footer(); ?>
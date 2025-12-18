<?php
/**
 * Template Name: The Collections
 */
get_header(); ?>

<?php get_template_part('partials/small-hero'); ?>

<div class="homepage">

    <?php
    $collections = [
        'sea' => [
            'title' => plh_t('Sea Collection'),
            'description' => plh_t('Discover our exclusive coastal villas'),
            'class' => 'sea-collection-swiper'
        ],
        'land' => [
            'title' => plh_t('Land Collection'),
            'description' => plh_t('Experience luxury in the countryside'),
            'class' => 'land-collection-swiper'
        ],
        'city' => [
            'title' => plh_t('City Collection'),
            'description' => plh_t('Urban elegance meets luxury living'),
            'class' => 'city-collection-swiper'
        ]
    ];

    foreach ($collections as $slug => $data):
        $video_url = get_field("collection_{$slug}_video_url");
        $video_id = '';
        if ($video_url && preg_match('~(?:youtu\.be/|youtube\.com/(?:embed/|shorts/|v/|watch\?v=|watch\?.*?&v=))([\w-]{11})~', $video_url, $m)) {
            $video_id = $m[1];
        }
        $player_id = "collection-{$slug}-player";
        $args = [
            'post_type' => 'villa',
            'posts_per_page' => 12,
            'tax_query' => [
                [
                    'taxonomy' => 'villa_collection',
                    'field' => 'slug',
                    'terms' => $slug,
                ],
            ],
        ];
        $query = new WP_Query($args);
    ?>
    <section class="collection-description">
        <div class="collection-description-wrapper">
            <div class="collection-description-column__left">
                <?php $image_id = get_field("collection_{$slug}_image"); ?>
                <div class="collection-media<?php echo $video_id ? ' has-video' : ' no-video'; ?>">
                    <?php if ($video_id): ?>
                        <div class="collection-video" data-video-id="<?php echo esc_attr($video_id); ?>" data-player-id="<?php echo esc_attr($player_id); ?>">
                            <div id="<?php echo esc_attr($player_id); ?>"></div>
                        </div>
                    <?php endif; ?>
                    <?php
                    if ($image_id) {
                        echo wp_get_attachment_image($image_id, 'medium_large', false, [
                            'alt' => esc_attr($data['title']),
                            'class' => 'collection-description-image collection-fallback',
                        ]);
                    } else {
                        echo '<img src="https://via.placeholder.com/400x300" alt="' . esc_attr($data['title']) . ' placeholder" class="collection-description-image collection-fallback">';
                    }
                    ?>
                </div>
            </div>
            <div class="collection-description-column__right">
                <h2 class="collection-description-title"><?php echo esc_html($data['title']); ?></h2>
                <p class="p-title collection-short-desc">
                    <?php 
                    $short_desc = get_field("collection_{$slug}_short_desc");
                    echo esc_html($short_desc ?: $data['description']);
                    ?>
                </p>
                <p class="collection-long-desc">
                    <?php 
                    $long_desc = get_field("collection_{$slug}_long_desc");
                    echo wp_kses_post($long_desc ?: 'Placeholder extended description. Replace this with richer narrative copy about ambiance, location highlights, and unique selling points of the collection.');
                    ?>
                </p>
                <?php 
                $read_more_url = get_field("collection_{$slug}_read_more_url");
                if ($read_more_url):
                ?>
                <a href="<?php echo esc_url($read_more_url); ?>" class="collection-description-read-more">Read more</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <?php
        $carousel_titles = [
            'sea'  => plh_t('villas by the sea'),
            'land' => plh_t('villas in the countryside'),
            'city' => plh_t('villas in the city'),
        ];
    ?>
    <section class="collection-carousel-title">
        <h3><?php echo esc_html( $carousel_titles[$slug] ?? '' ); ?></h3>
    </section>

    <section class="main-content villa-slider collection-slider <?php echo esc_attr($slug); ?>-slider">
        <?php if ($query->have_posts()): ?>
        <div class="swiper <?php echo esc_attr($data['class']); ?>">
            <div class="swiper-wrapper">
                <?php while ($query->have_posts()): $query->the_post(); ?>
                <article class="swiper-slide">
                    <?php get_template_part('partials/villa-card'); ?>
                </article>
                <?php endwhile; ?>
            </div>
        </div>
        <button class="villa-arrow prev <?php echo esc_attr($slug); ?>-prev" type="button" aria-label="Previous slide">
            <img src="/wp-content/uploads/2025/09/right-arrow.png" alt="" />
        </button>
        <button class="villa-arrow next <?php echo esc_attr($slug); ?>-next" type="button" aria-label="Next slide">
            <img src="/wp-content/uploads/2025/09/right-arrow.png" alt="" />
        </button>
        <div class="swiper-pagination"></div>
        <?php else: ?>
        <p class="no-villas"><?php echo plh_t('No villas found in this collection'); ?></p>
        <?php endif; ?>
    </section>
    <?php
        wp_reset_postdata();
    endforeach;
    ?>

        <script>
        (function(){
            const videos = document.querySelectorAll('.collection-video');
            if (!videos.length) return;
            if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            function initPlayer(el){
                const videoId = el.getAttribute('data-video-id');
                const playerId = el.getAttribute('data-player-id');
                if (!videoId || !playerId) return;
                new YT.Player(playerId, {
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
                    events: {
                        onReady: function(){
                            const media = el.closest('.collection-media');
                            if (media) media.classList.add('is-playing');
                        }
                    }
                });
            }

            function initAll(){ videos.forEach(initPlayer); }

            function loadAPI(){
                if (window.YT && YT.Player) { initAll(); return; }
                window._plhYTQueues = window._plhYTQueues || [];
                window._plhYTQueues.push(initAll);
                if (!window._plhYTLoading) {
                    window._plhYTLoading = true;
                    const tag = document.createElement('script');
                    tag.src = 'https://www.youtube.com/iframe_api';
                    document.head.appendChild(tag);
                    const prev = window.onYouTubeIframeAPIReady;
                    window.onYouTubeIframeAPIReady = function(){
                        if (typeof prev === 'function') { try { prev(); } catch(e){} }
                        (window._plhYTQueues || []).forEach(fn => { try { fn(); } catch(e){} });
                    };
                }
            }

            loadAPI();
        })();
        </script>

    <section class="collection-villa-button-section">
        <a href="<?php echo esc_url(get_post_type_archive_link('villa')); ?>" class="all-villa-button"><?php echo plh_t('See all our luxury villas'); ?></a>
    </section>
    
</div>

<?php get_footer();
<?php
/**
 * Template Name: The Collections
 */
get_header(); ?>

<?php get_template_part('partials/small-hero'); ?>

<!-- Villa Filters Section -->
<section class="villa-filters-section">
    <div class="villa-filters-container">
        <aside class="villa-filters">
            <h2><?php echo esc_html(plh_t('Filter')); ?></h2>
            
            <!-- Capacity Filter -->
            <div class="filter-group">
                <h3><?php echo esc_html(plh_t('Capacity')); ?></h3>
                <div class="filter-options">
                    <label><input type="checkbox" name="capacity[]" value="6"> <?php echo esc_html(plh_t('Up to 6 guests')); ?></label>
                    <label><input type="checkbox" name="capacity[]" value="8"> <?php echo esc_html(plh_t('Up to 8 guests')); ?></label>
                    <label><input type="checkbox" name="capacity[]" value="10"> <?php echo esc_html(plh_t('Up to 10 guests')); ?></label>
                    <label><input type="checkbox" name="capacity[]" value="12"> <?php echo esc_html(plh_t('Up to 12 guests')); ?></label>
                    <label><input type="checkbox" name="capacity[]" value="15"> <?php echo esc_html(plh_t('Up to 15 guests')); ?></label>
                    <label><input type="checkbox" name="capacity[]" value="16"> <?php echo esc_html(plh_t('16 + guests')); ?></label>
                </div>
            </div>

            <!-- Collection Filter -->
            <div class="filter-group">
                <h3><?php echo esc_html(plh_t('Collection')); ?></h3>
                <div class="filter-options">
                    <label><input type="checkbox" name="collection[]" value="sea"> <?php echo esc_html(plh_t('Seaside')); ?></label>
                    <label><input type="checkbox" name="collection[]" value="land"> <?php echo esc_html(plh_t('Countryside')); ?></label>
                    <label><input type="checkbox" name="collection[]" value="city"> <?php echo esc_html(plh_t('Historic center')); ?></label>
                </div>
            </div>

            <!-- Price Filter -->
            <div class="filter-group">
                <h3><?php echo esc_html(plh_t('Price per night (from)')); ?></h3>
                <div class="filter-options">
                    <label><input type="checkbox" name="price[]" value="0-600"> <?php echo esc_html(plh_t('Up to €600')); ?></label>
                    <label><input type="checkbox" name="price[]" value="600-1200"> <?php echo esc_html(plh_t('€600 – €1,200')); ?></label>
                    <label><input type="checkbox" name="price[]" value="1200-2000"> <?php echo esc_html(plh_t('€1,200 – €2,000')); ?></label>
                    <label><input type="checkbox" name="price[]" value="2000-3000"> <?php echo esc_html(plh_t('€2,000 – €3,000')); ?></label>
                    <label><input type="checkbox" name="price[]" value="3000-5000"> <?php echo esc_html(plh_t('€3,000 – €5,000')); ?></label>
                    <label><input type="checkbox" name="price[]" value="5000-999999"> <?php echo esc_html(plh_t('More than €5,000')); ?></label>
                </div>
            </div>

            <button type="button" class="reset-filters"><?php echo esc_html(plh_t('Reset Filters')); ?></button>
        </aside>

        <div class="filtered-villas-content">
            <div class="villas-results-header">
                <p class="results-count"><span class="count">0</span> <?php echo esc_html(plh_t('villas found')); ?></p>
            </div>
            <div class="villas-grid" id="filtered-villas-grid">
                <div class="loading-spinner"><?php echo esc_html(plh_t('Loading...')); ?></div>
            </div>
            <div class="no-results" style="display: none;">
                <p><?php echo esc_html(plh_t('No villas match your filters. Please try adjusting your criteria.')); ?></p>
            </div>
        </div>
    </div>
</section>

<script>
(function() {
    const filtersForm = document.querySelector('.villa-filters');
    const villasGrid = document.getElementById('filtered-villas-grid');
    const resultsCount = document.querySelector('.results-count .count');
    const noResults = document.querySelector('.no-results');
    const resetBtn = document.querySelector('.reset-filters');

    function getFilters() {
        const capacity = Array.from(document.querySelectorAll('input[name="capacity[]"]:checked')).map(el => el.value);
        const collection = Array.from(document.querySelectorAll('input[name="collection[]"]:checked')).map(el => el.value);
        const price = Array.from(document.querySelectorAll('input[name="price[]"]:checked')).map(el => el.value);
        return { capacity, collection, price };
    }

    function loadVillas() {
        const filters = getFilters();
        villasGrid.innerHTML = '<div class="loading-spinner"><?php echo esc_js(plh_t('Loading...')); ?></div>';
        noResults.style.display = 'none';

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'filter_villas',
                capacity: JSON.stringify(filters.capacity),
                collection: JSON.stringify(filters.collection),
                price: JSON.stringify(filters.price),
                nonce: '<?php echo wp_create_nonce('villa_filter_nonce'); ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.html) {
                villasGrid.innerHTML = data.data.html;
                resultsCount.textContent = data.data.count;
                noResults.style.display = 'none';
            } else {
                villasGrid.innerHTML = '';
                resultsCount.textContent = '0';
                noResults.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            villasGrid.innerHTML = '<p><?php echo esc_js(plh_t('Error loading villas. Please try again.')); ?></p>';
        });
    }

    if (filtersForm) {
        filtersForm.addEventListener('change', loadVillas);
    }
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            document.querySelectorAll('.villa-filters input[type="checkbox"]').forEach(cb => cb.checked = false);
            loadVillas();
        });
    }
    loadVillas();
})();
</script>

<div class="homepage">

    <?php
    $collections = [
        'sea' => [
            'title' => get_field('collection_sea_title') ?: plh_t('Sea Collection'),
            'description' => plh_t('Discover our exclusive coastal villas'),
            'class' => 'sea-collection-swiper'
        ],
        'land' => [
            'title' => get_field('collection_land_title') ?: plh_t('Land Collection'),
            'description' => plh_t('Experience luxury in the countryside'),
            'class' => 'land-collection-swiper'
        ],
        'city' => [
            'title' => get_field('collection_city_title') ?: plh_t('City Collection'),
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

            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            const players = [];
            let playAttempted = false;

            function tryPlay() {
                if (playAttempted) return;
                playAttempted = true;
                players.forEach(player => {
                    if (player && typeof player.playVideo === 'function') {
                        try { player.playVideo(); } catch(e) {}
                    }
                });
            }

            function initPlayer(el){
                const videoId = el.getAttribute('data-video-id');
                const playerId = el.getAttribute('data-player-id');
                if (!videoId || !playerId) return;
                const player = new YT.Player(playerId, {
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
                        onReady: function(event){
                            const media = el.closest('.collection-media');
                            if (media) media.classList.add('is-playing');
                                                    if (isMobile) {
                                                        players.push(event.target);
                                                    }
                        }
                    }
                });
            }

            function initAll(){ 
                videos.forEach(initPlayer);
                if (isMobile && videos.length > 0) {
                    document.addEventListener('touchstart', tryPlay, {once: true, passive: true});
                    document.addEventListener('scroll', tryPlay, {once: true, passive: true});
                }
            }

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

    <?php /*
    <section class="collection-villa-button-section">
        <a href="<?php echo esc_url(get_post_type_archive_link('villa')); ?>" class="all-villa-button"><?php echo plh_t('See all our luxury villas'); ?></a>
    </section>
    */ ?>
    
</div>

<?php get_footer();
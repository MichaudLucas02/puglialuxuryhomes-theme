<?php
/**
 * Template Name: The villas
 */
get_header();
get_template_part('partials/small-hero');

$all_villas = new WP_Query([
    'post_type'      => 'villa',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

// First pass: collect map data
$villa_map_data = [];
if ($all_villas->have_posts()) {
    while ($all_villas->have_posts()) {
        $all_villas->the_post();
        $lat = get_field('villa_lat');
        $lng = get_field('villa_lng');
        if ($lat && $lng) {
            $img_id = get_field('card_image_11') ?: get_post_thumbnail_id();
            $villa_map_data[] = [
                'id'          => get_the_ID(),
                'title'       => get_field('villa_title') ?: get_the_title(),
                'lat'         => (float) $lat,
                'lng'         => (float) $lng,
                'link'        => get_permalink(),
                'image'       => $img_id ? wp_get_attachment_image_url($img_id, 'villa_card') : '',
                'location'    => (string) (get_field('villa_location_1') ?: ''),
                'beds'        => (string) (get_field('beds_1') ?: ''),
                'guests'      => (string) (get_field('guests_1') ?: ''),
                'price_range' => (string) (get_field('price_range_1') ?: ''),
            ];
        }
    }
    $all_villas->rewind_posts();
}
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
/* ── Full-bleed reset for this page ──────────────────── */
body { margin: 0; }
.site-main { padding: 0 !important; margin: 0 !important; }
.homepage { overflow-x: hidden; }

/* ── Split layout ─────────────────────────────────────── */
.villas-split {
    display: flex;
    align-items: stretch;
    width: 100vw;
    margin-left: calc(-1 * (100vw - 100%) / 2);
    position: sticky;
    top: var(--header-height, 70px);
    height: calc(100vh - var(--header-height, 70px));
}
.villas-list-panel {
    width: 58%;
    flex-shrink: 0;
    border-right: 1px solid #eee;
    overflow-y: auto;
    height: 100%;
}
.villas-map-panel {
    width: 42%;
    position: relative;
    height: 100%;
}
#villas-map {
    width: 100%;
    height: 100%;
}

/* ── Filter trigger bar ───────────────────────────────── */
.filter-trigger-bar {
    padding: 16px 24px;
    border-bottom: 1px solid #eee;
    background: #fff;
    display: flex;
    align-items: center;
    gap: 16px;
    width: 100vw;
    margin-left: calc(-1 * (100vw - 100%) / 2);
    box-sizing: border-box;
}
.filter-trigger-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border: 1.5px solid #333;
    background: transparent;
    font-family: 'Raleway', sans-serif;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #333;
    cursor: pointer;
    transition: all 0.2s;
}
.filter-trigger-btn:hover,
.filter-trigger-btn.has-filters {
    background: #333;
    color: #fff;
}
.filter-trigger-btn svg { flex-shrink: 0; }
.filter-active-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    background: #b8996a;
    color: #fff;
    border-radius: 50%;
    font-size: 10px;
    font-weight: 600;
    display: none;
}
.filter-trigger-btn.has-filters .filter-active-count { display: inline-flex; }

/* ── Filter drawer backdrop ───────────────────────────── */
.filter-backdrop {
    position: fixed;
    top: var(--header-height, 70px);
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.35);
    z-index: 1020;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
}
.filter-backdrop.is-open {
    opacity: 1;
    pointer-events: auto;
}

/* ── Filter drawer ────────────────────────────────────── */
.filter-drawer {
    position: fixed;
    left: 0;
    top: var(--header-height, 70px);
    height: calc(100vh - var(--header-height, 70px));
    width: 360px;
    background: #fff;
    z-index: 1021;
    transform: translateX(-100%);
    transition: transform 0.35s ease;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.filter-drawer.is-open { transform: translateX(0); }

.filter-drawer__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 28px 28px 20px;
    border-bottom: 1px solid #eee;
    flex-shrink: 0;
}
.filter-drawer__header h3 {
    font-family: 'Raleway', sans-serif;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #111;
    margin: 0;
}
.filter-drawer__close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    color: #666;
    line-height: 1;
    font-size: 20px;
    transition: color 0.2s;
}
.filter-drawer__close:hover { color: #111; }

.filter-drawer__body {
    flex: 1;
    overflow-y: auto;
    padding: 28px;
}
.filter-section {
    margin-bottom: 36px;
}
.filter-section__title {
    font-family: 'Raleway', sans-serif;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #999;
    margin: 0 0 14px;
}
.filter-pills {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.filter-pill {
    padding: 9px 18px;
    border: 1px solid #ddd;
    background: #fff;
    font-family: 'Raleway', sans-serif;
    font-size: 13px;
    font-weight: 400;
    color: #333;
    cursor: pointer;
    transition: all 0.2s;
    line-height: 1;
}
.filter-pill:hover { border-color: #999; }
.filter-pill.active {
    background: #333;
    color: #fff;
    border-color: #333;
}

.filter-drawer__footer {
    padding: 20px 28px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 12px;
    flex-shrink: 0;
}
.filter-reset-btn {
    flex: 1;
    padding: 12px;
    border: 1.5px solid #ddd;
    background: transparent;
    font-family: 'Raleway', sans-serif;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #333;
    cursor: pointer;
    transition: all 0.2s;
}
.filter-reset-btn:hover { border-color: #333; }
.filter-close-btn {
    flex: 2;
    padding: 12px;
    border: none;
    background: #333;
    font-family: 'Raleway', sans-serif;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #fff;
    cursor: pointer;
    transition: background 0.2s;
}
.filter-close-btn:hover { background: #555; }

/* ── Cards grid ───────────────────────────────────────── */
.all-villas-grid {
    padding: 24px 20px 48px;
}
.villas-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    transition: opacity 0.3s ease;
}
.villas-grid.loading {
    opacity: 0.5;
    pointer-events: none;
}
@media (max-width: 1200px) {
    .villas-grid { grid-template-columns: 1fr; }
}
.villa-grid-item { height: 100%; }
.no-villas {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    font-family: 'Raleway';
    font-size: 16px;
    color: #666;
}

/* ── Card highlight on marker hover ──────────────────── */
.villa-grid-item--highlighted .villa-card {
    box-shadow: 0 0 0 2px #b8996a;
    transition: box-shadow 0.2s;
}

/* ── Map toggle (mobile only) ─────────────────────────── */
.map-toggle-bar {
    display: none;
    justify-content: center;
    padding: 14px;
    border-bottom: 1px solid #eee;
    background: #fff;
    gap: 8px;
}
.map-toggle-btn {
    padding: 8px 20px;
    font-family: 'Raleway';
    font-size: 13px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1.5px solid #ddd;
    background: #fff;
    cursor: pointer;
    color: #333;
    transition: all 0.2s;
}
.map-toggle-btn.active {
    background: #333;
    color: #fff;
    border-color: #333;
}

/* ── Leaflet custom markers ───────────────────────────── */
.plh-marker { background: none !important; border: none !important; }
.plh-marker__dot {
    width: 12px;
    height: 12px;
    background: #2c2c2c;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 1px 5px rgba(0,0,0,.4);
    transition: transform .2s ease, background .2s ease;
    cursor: pointer;
}
.plh-marker--active .plh-marker__dot {
    background: #b8996a;
    transform: scale(1.7);
}

/* ── Leaflet popup ────────────────────────────────────── */
.leaflet-popup-content-wrapper {
    border-radius: 0;
    padding: 0;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.15);
}
.leaflet-popup-content {
    margin: 0;
    width: 280px !important;
}
.plh-popup__img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    display: block;
}
.plh-popup__body { padding: 14px; }
.plh-popup__title {
    font-family: 'Didot', serif;
    font-size: 16px;
    font-weight: 400;
    margin: 0 0 6px;
    color: #111;
    line-height: 1.3;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.plh-popup__meta {
    font-family: 'Raleway';
    font-size: 12px;
    color: #888;
    margin: 0 0 4px;
}
.plh-popup__price {
    font-family: 'Raleway';
    font-size: 12px;
    color: #555;
    margin: 0 0 12px;
}
.plh-popup__btn {
    display: block;
    text-align: center;
    padding: 11px 14px;
    background: #2c2c2c;
    color: #fff !important;
    font-family: 'Raleway', sans-serif;
    font-size: 13px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    text-decoration: none !important;
    transition: background 0.2s;
}
.plh-popup__btn:hover { background: #444; color: #fff !important; }

/* ── Mobile ───────────────────────────────────────────── */
@media (max-width: 775px) {
    .map-toggle-bar { display: flex; }
    .villas-split {
        flex-direction: column;
        position: relative;
        top: 0;
        height: auto;
    }
    .villas-list-panel {
        width: 100%;
        height: auto;
        overflow-y: visible;
        border-right: none;
    }
    .villas-list-panel.is-hidden { display: none; }
    .villas-map-panel {
        width: 100%;
        height: 380px;
        display: none;
    }
    .villas-map-panel.is-visible { display: block; }
    #villas-map { height: 380px; }
    .filter-row { flex-direction: column; align-items: stretch; }
    .filter-select { width: 100%; min-width: auto; }
    .reset-filters { width: 100%; margin-left: 0; }
    .villas-grid { grid-template-columns: 1fr; }
}
</style>

<div class="homepage">

    <!-- Filter drawer backdrop -->
    <div class="filter-backdrop" id="filter-backdrop"></div>

    <!-- Filter drawer -->
    <aside class="filter-drawer" id="filter-drawer" aria-hidden="true">
        <div class="filter-drawer__header">
            <h3><?php echo esc_html(function_exists('pll__') ? pll__('Filters') : 'Filters'); ?></h3>
            <button class="filter-drawer__close" id="filter-drawer-close" aria-label="Close filters">&#215;</button>
        </div>
        <div class="filter-drawer__body">

            <div class="filter-section">
                <p class="filter-section__title"><?php echo esc_html(plh_t('Collection')); ?></p>
                <div class="filter-pills" data-filter="collection">
                    <button class="filter-pill active" data-value=""><?php echo esc_html(function_exists('pll__') ? pll__('All') : 'All'); ?></button>
                    <button class="filter-pill" data-value="sea"><?php echo esc_html(plh_t('Seaside')); ?></button>
                    <button class="filter-pill" data-value="land"><?php echo esc_html(plh_t('Countryside')); ?></button>
                    <button class="filter-pill" data-value="city"><?php echo esc_html(plh_t('Historic center')); ?></button>
                </div>
            </div>

            <div class="filter-section">
                <p class="filter-section__title"><?php echo esc_html(plh_t('Capacity')); ?></p>
                <div class="filter-pills" data-filter="guests">
                    <button class="filter-pill active" data-value=""><?php echo esc_html(function_exists('pll__') ? pll__('Any') : 'Any'); ?></button>
                    <button class="filter-pill" data-value="6">6+</button>
                    <button class="filter-pill" data-value="8">8+</button>
                    <button class="filter-pill" data-value="10">10+</button>
                    <button class="filter-pill" data-value="12">12+</button>
                    <button class="filter-pill" data-value="15">15+</button>
                    <button class="filter-pill" data-value="16">16+</button>
                </div>
            </div>

            <div class="filter-section">
                <p class="filter-section__title"><?php echo esc_html(plh_t('Price per night')); ?></p>
                <div class="filter-pills" data-filter="price">
                    <button class="filter-pill active" data-value=""><?php echo esc_html(function_exists('pll__') ? pll__('Any') : 'Any'); ?></button>
                    <button class="filter-pill" data-value="0-600"><?php echo esc_html(plh_t('Up to €600')); ?></button>
                    <button class="filter-pill" data-value="600-1200">€600 – €1,200</button>
                    <button class="filter-pill" data-value="1200-2000">€1,200 – €2,000</button>
                    <button class="filter-pill" data-value="2000-3000">€2,000 – €3,000</button>
                    <button class="filter-pill" data-value="3000-5000">€3,000 – €5,000</button>
                    <button class="filter-pill" data-value="5000-999999"><?php echo esc_html(plh_t('More than €5,000')); ?></button>
                </div>
            </div>

        </div>
        <div class="filter-drawer__footer">
            <button class="filter-reset-btn" id="filter-reset"><?php echo esc_html(function_exists('pll__') ? pll__('Reset') : 'Reset'); ?></button>
            <button class="filter-close-btn" id="filter-apply"><?php echo esc_html(function_exists('pll__') ? pll__('See results') : 'See results'); ?></button>
        </div>
    </aside>

    <div class="filter-trigger-bar">
        <button class="filter-trigger-btn" id="filter-trigger">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
            <?php echo esc_html(function_exists('pll__') ? pll__('Filters') : 'Filters'); ?>
            <span class="filter-active-count" id="filter-count">0</span>
        </button>
    </div>

    <!-- Mobile map/list toggle -->
    <div class="map-toggle-bar">
        <button class="map-toggle-btn active" data-panel="list">
            <?php echo esc_html(function_exists('pll__') ? pll__('List') : 'List'); ?>
        </button>
        <button class="map-toggle-btn" data-panel="map">
            <?php echo esc_html(function_exists('pll__') ? pll__('Map') : 'Map'); ?>
        </button>
    </div>

    <div class="villas-split">

        <!-- Left: scrollable cards -->
        <div class="villas-list-panel" id="villas-list-panel">
            <div class="all-villas-grid">
                <div class="villas-grid" id="villas-container">
                    <?php if ($all_villas->have_posts()): while ($all_villas->have_posts()): $all_villas->the_post(); ?>
                        <article class="villa-grid-item" data-post-id="<?php echo get_the_ID(); ?>">
                            <?php get_template_part('partials/villa-card', null, ['post_id' => get_the_ID()]); ?>
                        </article>
                    <?php endwhile; wp_reset_postdata(); else: ?>
                        <p class="no-villas"><?php echo esc_html__('No villas found', 'plh'); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right: sticky map -->
        <div class="villas-map-panel" id="villas-map-panel">
            <div id="villas-map"></div>
        </div>

    </div><!-- .villas-split -->

</div><!-- .homepage -->

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function () {
    // ── Villa data from PHP ──────────────────────────────
    const VILLA_DATA = <?php echo wp_json_encode($villa_map_data); ?>;

    // ── Map init ─────────────────────────────────────────
    const map = L.map('villas-map', { zoomControl: true }).setView([40.5, 17.2], 9);
    map.attributionControl.setPrefix(false);

    L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.png', {
        attribution: '',
        maxZoom: 20,
    }).addTo(map);

    // ── Custom icon factory ───────────────────────────────
    function makeIcon(active) {
        return L.divIcon({
            className: 'plh-marker' + (active ? ' plh-marker--active' : ''),
            html: '<div class="plh-marker__dot"></div>',
            iconSize: [12, 12],
            iconAnchor: [6, 6],
            popupAnchor: [0, -12],
        });
    }

    // ── Build popup HTML ──────────────────────────────────
    function popupHTML(v) {
        const meta = [
            v.beds   ? v.beds + ' beds'   : '',
            v.guests ? v.guests + ' guests' : '',
        ].filter(Boolean).join(' · ');

        return '<div class="plh-popup">' +
            (v.image ? '<img src="' + v.image + '" class="plh-popup__img" alt="' + v.title + '">' : '') +
            '<div class="plh-popup__body">' +
                '<h4 class="plh-popup__title">' + v.title + '</h4>' +
                (meta        ? '<p class="plh-popup__meta">'  + meta           + '</p>' : '') +
                (v.price_range ? '<p class="plh-popup__price">' + v.price_range + '</p>' : '') +
                '<a href="' + v.link + '" class="plh-popup__btn">View Villa</a>' +
            '</div>' +
        '</div>';
    }

    // ── Active marker state ───────────────────────────────
    const markers = {};
    let activeId = null;

    function activate(id) {
        if (activeId === id) return;
        if (activeId !== null) deactivate(activeId);
        activeId = id;
        if (markers[id]) markers[id].setIcon(makeIcon(true));
        highlightCard(id);
    }

    function deactivate(id) {
        if (activeId !== id) return;
        activeId = null;
        if (markers[id]) markers[id].setIcon(makeIcon(false));
        unhighlightCard(id);
    }

    function highlightCard(id) {
        const el = container.querySelector('.villa-grid-item[data-post-id="' + id + '"]');
        if (el) el.classList.add('villa-grid-item--highlighted');
    }
    function unhighlightCard(id) {
        const el = container.querySelector('.villa-grid-item[data-post-id="' + id + '"]');
        if (el) el.classList.remove('villa-grid-item--highlighted');
    }

    // ── Create markers ────────────────────────────────────
    VILLA_DATA.forEach(function (v) {
        const marker = L.marker([v.lat, v.lng], { icon: makeIcon(false) });
        marker.bindPopup(popupHTML(v), { maxWidth: 280 });

        marker.on('mouseover', function () { activate(v.id); });
        marker.on('mouseout',  function () { if (!marker.isPopupOpen()) deactivate(v.id); });
        marker.on('popupclose', function () { deactivate(v.id); });

        marker.addTo(map);
        markers[v.id] = marker;
    });

    // ── Card ↔ marker sync (event delegation) ─────────────
    const container = document.getElementById('villas-container');

    container.addEventListener('mouseenter', function (e) {
        const article = e.target.closest('.villa-grid-item[data-post-id]');
        if (!article) return;
        activate(parseInt(article.dataset.postId));
    }, true);

    container.addEventListener('mouseleave', function (e) {
        const article = e.target.closest('.villa-grid-item[data-post-id]');
        if (!article) return;
        const id = parseInt(article.dataset.postId);
        if (!markers[id] || !markers[id].isPopupOpen()) deactivate(id);
    }, true);

    // ── Mobile map/list toggle ─────────────────────────────
    const listPanel = document.getElementById('villas-list-panel');
    const mapPanel  = document.getElementById('villas-map-panel');

    document.querySelectorAll('.map-toggle-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.map-toggle-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            if (btn.dataset.panel === 'map') {
                listPanel.classList.add('is-hidden');
                mapPanel.classList.add('is-visible');
                map.invalidateSize(); // recalculate after display change
            } else {
                mapPanel.classList.remove('is-visible');
                listPanel.classList.remove('is-hidden');
            }
        });
    });

    // ── Filter drawer ─────────────────────────────────────
    const drawer   = document.getElementById('filter-drawer');
    const backdrop = document.getElementById('filter-backdrop');
    const triggerBtn  = document.getElementById('filter-trigger');
    const closeBtn    = document.getElementById('filter-drawer-close');
    const applyBtn    = document.getElementById('filter-apply');
    const resetBtn    = document.getElementById('filter-reset');
    const countBadge  = document.getElementById('filter-count');

    function openDrawer() {
        drawer.classList.add('is-open');
        backdrop.classList.add('is-open');
        drawer.setAttribute('aria-hidden', 'false');
    }
    function closeDrawer() {
        drawer.classList.remove('is-open');
        backdrop.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
    }

    triggerBtn.addEventListener('click', openDrawer);
    closeBtn.addEventListener('click', closeDrawer);
    applyBtn.addEventListener('click', function () { fetchVillas(); closeDrawer(); });
    backdrop.addEventListener('click', closeDrawer);

    // ── Pill selection (single-select per group) ──────────
    let currentFilters = { collection: '', guests: '', price: '' };

    document.querySelectorAll('.filter-pills').forEach(function (group) {
        group.addEventListener('click', function (e) {
            const pill = e.target.closest('.filter-pill');
            if (!pill) return;
            group.querySelectorAll('.filter-pill').forEach(function (p) { p.classList.remove('active'); });
            pill.classList.add('active');
            currentFilters[group.dataset.filter] = pill.dataset.value;
            updateTriggerState();
        });
    });

    function updateTriggerState() {
        const count = [currentFilters.collection, currentFilters.guests, currentFilters.price]
            .filter(function (v) { return v !== ''; }).length;
        countBadge.textContent = count;
        if (count > 0) {
            triggerBtn.classList.add('has-filters');
        } else {
            triggerBtn.classList.remove('has-filters');
        }
    }

    // ── Reset ─────────────────────────────────────────────
    resetBtn.addEventListener('click', function () {
        currentFilters = { collection: '', guests: '', price: '' };
        document.querySelectorAll('.filter-pills').forEach(function (group) {
            group.querySelectorAll('.filter-pill').forEach(function (p) { p.classList.remove('active'); });
            const first = group.querySelector('.filter-pill[data-value=""]');
            if (first) first.classList.add('active');
        });
        updateTriggerState();
        fetchVillas();
        closeDrawer();
    });

    // ── Sync map markers with visible cards ───────────────
    function syncMarkers() {
        const visibleIds = new Set(
            Array.from(container.querySelectorAll('.villa-grid-item[data-post-id]'))
                .map(function (el) { return parseInt(el.dataset.postId); })
        );
        Object.keys(markers).forEach(function (id) {
            const marker = markers[id];
            if (visibleIds.has(parseInt(id))) {
                if (!map.hasLayer(marker)) marker.addTo(map);
            } else {
                if (map.hasLayer(marker)) marker.remove();
            }
        });
    }

    // ── AJAX fetch ────────────────────────────────────────
    function fetchVillas() {
        container.classList.add('loading');
        const formData = new FormData();
        formData.append('action', 'filter_villas');
        formData.append('nonce', '<?php echo wp_create_nonce('filter_villas_nonce'); ?>');
        formData.append('collection', currentFilters.collection);
        formData.append('guests',     currentFilters.guests);
        formData.append('price',      currentFilters.price);

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', { method: 'POST', body: formData })
            .then(function (r) { return r.text(); })
            .then(function (html) {
                container.innerHTML = html;
                container.classList.remove('loading');
                syncMarkers();
            })
            .catch(function () { container.classList.remove('loading'); });
    }

    // ── Invalidate map size on initial desktop load ────────
    // Ensures tiles render correctly when the panel first becomes visible
    window.addEventListener('load', function () { map.invalidateSize(); });

})();
</script>

<?php get_footer(); ?>

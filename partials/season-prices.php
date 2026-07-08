<?php
/**
 * partials/season-prices.php
 * Weekly seasonal prices section — inserted between accordion and location.
 */

$pid    = get_the_ID();
$year   = get_field('season_price_year', $pid) ?: '2026';
$period = get_field('season_price_period', $pid) ?: 'week';
$per_period_label = $period === 'day' ? plh_t('per day') : plh_t('per week');
$rates_label      = $period === 'day' ? plh_t('Daily rates') : plh_t('Weekly rates');

$period27           = get_field('season27_price_period', $pid) ?: 'week';
$per_period_label27 = $period27 === 'day' ? plh_t('per day') : plh_t('per week');

$period28           = get_field('season28_price_period', $pid) ?: 'week';
$per_period_label28 = $period28 === 'day' ? plh_t('per day') : plh_t('per week');

$month_slugs = ['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'];
$month_nums  = [1,2,3,4,5,6,7,8,9,10,11,12];

$color_class = [
    'low'      => 'season-dot--low',
    'mid'      => 'season-dot--mid',
    'high'     => 'season-dot--high',
    'veryhigh' => 'season-dot--veryhigh',
];

// Build 2026 month data
$months = [];
foreach ($month_slugs as $i => $slug) {
    $num   = $month_nums[$i];
    $price = get_field("season_{$slug}_price", $pid);
    $months[] = [
        'slug'      => $slug,
        'num'       => $num,
        'name'      => ucfirst(date_i18n('F', mktime(0, 0, 0, $num, 1))),
        'price'     => ($price !== '' && $price !== null) ? (string) $price : null,
        'label'     => get_field("season_{$slug}_label", $pid),
        'color'     => get_field("season_{$slug}_color", $pid),
        'date_from' => get_field("season_{$slug}_date_from", $pid),
        'date_to'   => get_field("season_{$slug}_date_to", $pid),
        'min_stay'  => get_field("season_{$slug}_min_stay", $pid),
    ];
}

// Build 2027 month data — toggle only appears if at least one price is filled
$months27 = [];
$has_2027 = false;
foreach ($month_slugs as $i => $slug) {
    $num     = $month_nums[$i];
    $price27 = get_field("season27_{$slug}_price", $pid);
    $filled  = ($price27 !== '' && $price27 !== null);
    if ($filled) $has_2027 = true;
    $months27[] = [
        'slug'      => $slug,
        'num'       => $num,
        'name'      => ucfirst(date_i18n('F', mktime(0, 0, 0, $num, 1))),
        'price'     => $filled ? (string) $price27 : null,
        'label'     => get_field("season27_{$slug}_label", $pid),
        'color'     => get_field("season27_{$slug}_color", $pid),
        'date_from' => get_field("season27_{$slug}_date_from", $pid),
        'date_to'   => get_field("season27_{$slug}_date_to", $pid),
        'min_stay'  => get_field("season27_{$slug}_min_stay", $pid),
    ];
}

// Build 2028 month data
$months28 = [];
$has_2028 = false;
foreach ($month_slugs as $i => $slug) {
    $num     = $month_nums[$i];
    $price28 = get_field("season28_{$slug}_price", $pid);
    $filled  = ($price28 !== '' && $price28 !== null);
    if ($filled) $has_2028 = true;
    $months28[] = [
        'slug'      => $slug,
        'num'       => $num,
        'name'      => ucfirst(date_i18n('F', mktime(0, 0, 0, $num, 1))),
        'price'     => $filled ? (string) $price28 : null,
        'label'     => get_field("season28_{$slug}_label", $pid),
        'color'     => get_field("season28_{$slug}_color", $pid),
        'date_from' => get_field("season28_{$slug}_date_from", $pid),
        'date_to'   => get_field("season28_{$slug}_date_to", $pid),
        'min_stay'  => get_field("season28_{$slug}_min_stay", $pid),
    ];
}

$first_half    = array_slice($months, 0, 6);
$second_half   = array_slice($months, 6, 6);
$first_half27  = array_slice($months27, 0, 6);
$second_half27 = array_slice($months27, 6, 6);
$first_half28  = array_slice($months28, 0, 6);
$second_half28 = array_slice($months28, 6, 6);

$show_tabs = $has_2027 || $has_2028;

// Render a single month row
if (!function_exists('plh_render_season_row')) {
function plh_render_season_row($m, $color_class, $per_period_label = '', $suffix = '') {
    $slug      = $m['slug'];
    $raw_price = $m['price'];
    $has_price = ($raw_price !== null && $raw_price !== '');
    $has_extra = $has_price && ($m['date_from'] || $m['date_to'] || $m['min_stay']);
    $dot_class = isset($color_class[$m['color']]) ? $color_class[$m['color']] : '';
    $detail_id = 'season-detail-' . $slug . $suffix;
    ?>
    <div class="season-month<?php echo $has_price ? '' : ' season-month--empty'; ?>">
        <div class="season-month-row" <?php if ($has_extra): ?>data-expand="<?php echo esc_attr($detail_id); ?>"<?php endif; ?>>
            <span class="season-bar <?php echo esc_attr($dot_class); ?>"></span>
            <span class="season-month-name"><?php echo esc_html($m['name']); ?></span>
            <?php if ($m['label']): ?>
                <span class="season-month-label"><?php echo esc_html($m['label']); ?></span>
            <?php endif; ?>
            <span class="season-month-price">
                <?php if ($has_price): ?>
                    <?php if (is_numeric($raw_price)): ?>
                        &euro;&nbsp;<?php echo esc_html(number_format((float) $raw_price, 0, ',', '&thinsp;')); ?>
                    <?php else: ?>
                        <?php echo esc_html($raw_price); ?>
                    <?php endif; ?>
                    <span class="season-per-week">/<?php echo esc_html($per_period_label); ?></span>
                <?php else: ?>
                    &mdash;
                <?php endif; ?>
            </span>
        </div>
        <?php if ($has_extra): ?>
            <div id="<?php echo esc_attr($detail_id); ?>" class="season-month-detail" hidden>
                <?php if ($m['date_from'] || $m['date_to']): ?>
                    <span class="season-detail-dates">
                        <?php echo esc_html(plh_t('Available')); ?>
                        <?php if ($m['date_from']): ?><?php echo esc_html($m['date_from']); ?><?php endif; ?>
                        <?php if ($m['date_from'] && $m['date_to']): ?> &mdash; <?php endif; ?>
                        <?php if ($m['date_to']): ?><?php echo esc_html($m['date_to']); ?><?php endif; ?>
                    </span>
                <?php endif; ?>
                <?php if ($m['min_stay']): ?>
                    <span class="season-detail-minstay"><?php echo esc_html($m['min_stay']); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
}
?>

<section class="season-prices" id="season-prices">
    <div class="season-prices-header">
        <h2 class="must-have-title season-rates-title"><?php echo esc_html($rates_label); ?> <span class="season-year-display"><?php echo esc_html($year); ?></span></h2>
        <?php if ($show_tabs): ?>
        <div class="season-year-tabs" role="tablist">
            <button class="season-year-tab is-active" data-year="2026" role="tab" aria-selected="true">2026</button>
            <?php if ($has_2027): ?>
            <button class="season-year-tab" data-year="2027" role="tab" aria-selected="false">2027</button>
            <?php endif; ?>
            <?php if ($has_2028): ?>
            <button class="season-year-tab" data-year="2028" role="tab" aria-selected="false">2028</button>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <?php
    $sp_location = get_field('villa_location_1', $pid);
    $sp_beds     = get_field('beds_1', $pid);
    $sp_guests   = get_field('guests_1', $pid);
    if ($sp_location || $sp_beds || $sp_guests): ?>
    <div class="season-villa-info">
        <?php if ($sp_location): ?>
            <span class="season-villa-info-item"><?php echo esc_html($sp_location); ?></span>
        <?php endif; ?>
        <?php if ($sp_beds): ?>
            <span class="season-villa-info-sep">&mdash;</span>
            <span class="season-villa-info-item"><?php echo esc_html($sp_beds); ?> <?php echo esc_html(plh_t('Bedrooms')); ?></span>
        <?php endif; ?>
        <?php if ($sp_guests): ?>
            <span class="season-villa-info-sep">&mdash;</span>
            <span class="season-villa-info-item"><?php echo esc_html($sp_guests); ?> <?php echo esc_html(plh_t('guests')); ?> <?php echo esc_html(plh_t('max')); ?></span>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php
    $min_stay_1 = get_field('season_min_stay_1', $pid);
    $min_stay_2 = get_field('season_min_stay_2', $pid);
    if ($min_stay_1 || $min_stay_2): ?>
    <div class="season-minstay-row season-panel" data-panel="2026">
        <?php if ($min_stay_1): ?>
            <span class="season-minstay-tag"><?php echo esc_html($min_stay_1); ?></span>
        <?php endif; ?>
        <?php if ($min_stay_2): ?>
            <span class="season-minstay-tag"><?php echo esc_html($min_stay_2); ?></span>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($has_2027):
    $min_stay27_1 = get_field('season27_min_stay_1', $pid);
    $min_stay27_2 = get_field('season27_min_stay_2', $pid);
    if ($min_stay27_1 || $min_stay27_2): ?>
    <div class="season-minstay-row season-panel season-panel--hidden" data-panel="2027">
        <?php if ($min_stay27_1): ?>
            <span class="season-minstay-tag"><?php echo esc_html($min_stay27_1); ?></span>
        <?php endif; ?>
        <?php if ($min_stay27_2): ?>
            <span class="season-minstay-tag"><?php echo esc_html($min_stay27_2); ?></span>
        <?php endif; ?>
    </div>
    <?php endif; endif; ?>

    <?php if ($has_2028):
    $min_stay28_1 = get_field('season28_min_stay_1', $pid);
    $min_stay28_2 = get_field('season28_min_stay_2', $pid);
    if ($min_stay28_1 || $min_stay28_2): ?>
    <div class="season-minstay-row season-panel season-panel--hidden" data-panel="2028">
        <?php if ($min_stay28_1): ?>
            <span class="season-minstay-tag"><?php echo esc_html($min_stay28_1); ?></span>
        <?php endif; ?>
        <?php if ($min_stay28_2): ?>
            <span class="season-minstay-tag"><?php echo esc_html($min_stay28_2); ?></span>
        <?php endif; ?>
    </div>
    <?php endif; endif; ?>

    <div class="season-legend">
        <div class="season-legend-item">
            <span class="season-bar season-bar--h season-dot--low"></span>
            <span class="season-legend-label"><?php echo esc_html(plh_t('Low season')); ?></span>
        </div>
        <div class="season-legend-item">
            <span class="season-bar season-bar--h season-dot--mid"></span>
            <span class="season-legend-label"><?php echo esc_html(plh_t('Mid season')); ?></span>
        </div>
        <div class="season-legend-item">
            <span class="season-bar season-bar--h season-dot--high"></span>
            <span class="season-legend-label"><?php echo esc_html(plh_t('High season')); ?></span>
        </div>
        <div class="season-legend-item">
            <span class="season-bar season-bar--h season-dot--veryhigh"></span>
            <span class="season-legend-label"><?php echo esc_html(plh_t('Very high season')); ?></span>
        </div>
    </div>

    <!-- 2026 grid -->
    <div class="season-grid season-panel" data-panel="2026">
        <div class="season-col">
            <div class="season-col-header">
                <span class="season-col-range"><?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,1,1)))); ?> &ndash; <?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,6,1)))); ?></span>
                <span class="season-col-price-label"><?php echo esc_html(plh_t('Price')); ?> / <?php echo esc_html($per_period_label); ?></span>
            </div>
            <?php foreach ($first_half as $m): plh_render_season_row($m, $color_class, $per_period_label, ''); endforeach; ?>
        </div>
        <div class="season-col">
            <div class="season-col-header">
                <span class="season-col-range"><?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,7,1)))); ?> &ndash; <?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,12,1)))); ?></span>
                <span class="season-col-price-label"><?php echo esc_html(plh_t('Price')); ?> / <?php echo esc_html($per_period_label); ?></span>
            </div>
            <?php foreach ($second_half as $m): plh_render_season_row($m, $color_class, $per_period_label, ''); endforeach; ?>
        </div>
    </div>

    <?php if ($has_2027): ?>
    <!-- 2027 grid -->
    <div class="season-grid season-panel season-panel--hidden" data-panel="2027">
        <div class="season-col">
            <div class="season-col-header">
                <span class="season-col-range"><?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,1,1)))); ?> &ndash; <?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,6,1)))); ?></span>
                <span class="season-col-price-label"><?php echo esc_html(plh_t('Price')); ?> / <?php echo esc_html($per_period_label27); ?></span>
            </div>
            <?php foreach ($first_half27 as $m): plh_render_season_row($m, $color_class, $per_period_label27, '-27'); endforeach; ?>
        </div>
        <div class="season-col">
            <div class="season-col-header">
                <span class="season-col-range"><?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,7,1)))); ?> &ndash; <?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,12,1)))); ?></span>
                <span class="season-col-price-label"><?php echo esc_html(plh_t('Price')); ?> / <?php echo esc_html($per_period_label27); ?></span>
            </div>
            <?php foreach ($second_half27 as $m): plh_render_season_row($m, $color_class, $per_period_label27, '-27'); endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($has_2028): ?>
    <!-- 2028 grid -->
    <div class="season-grid season-panel season-panel--hidden" data-panel="2028">
        <div class="season-col">
            <div class="season-col-header">
                <span class="season-col-range"><?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,1,1)))); ?> &ndash; <?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,6,1)))); ?></span>
                <span class="season-col-price-label"><?php echo esc_html(plh_t('Price')); ?> / <?php echo esc_html($per_period_label28); ?></span>
            </div>
            <?php foreach ($first_half28 as $m): plh_render_season_row($m, $color_class, $per_period_label28, '-28'); endforeach; ?>
        </div>
        <div class="season-col">
            <div class="season-col-header">
                <span class="season-col-range"><?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,7,1)))); ?> &ndash; <?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,12,1)))); ?></span>
                <span class="season-col-price-label"><?php echo esc_html(plh_t('Price')); ?> / <?php echo esc_html($per_period_label28); ?></span>
            </div>
            <?php foreach ($second_half28 as $m): plh_render_season_row($m, $color_class, $per_period_label28, '-28'); endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php
    $footer_note  = get_field('season_footer_note', $pid);
    $price_from   = get_field('season_price_from', $pid);
    $book_label   = get_field('season_book_label', $pid);
    $book_url     = get_field('season_book_url', $pid);
    if ($footer_note || $price_from): ?>
    <div class="season-footer season-panel" data-panel="2026">
        <div class="season-footer-left">
            <?php if ($footer_note): ?>
                <p class="season-footer-note"><?php echo nl2br(esc_html($footer_note)); ?></p>
            <?php endif; ?>
        </div>
        <div class="season-footer-right">
            <?php if ($price_from): ?>
                <p class="season-footer-price"><?php echo esc_html($price_from); ?></p>
            <?php endif; ?>
            <?php if ($book_label && $book_url): ?>
                <a href="<?php echo esc_url($book_url); ?>" class="season-footer-book"><?php echo esc_html($book_label); ?></a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($has_2027):
    $footer_note27 = get_field('season27_footer_note', $pid);
    $price_from27  = get_field('season27_price_from', $pid);
    $book_label27  = get_field('season27_book_label', $pid);
    $book_url27    = get_field('season27_book_url', $pid);
    if ($footer_note27 || $price_from27): ?>
    <div class="season-footer season-panel season-panel--hidden" data-panel="2027">
        <div class="season-footer-left">
            <?php if ($footer_note27): ?>
                <p class="season-footer-note"><?php echo nl2br(esc_html($footer_note27)); ?></p>
            <?php endif; ?>
        </div>
        <div class="season-footer-right">
            <?php if ($price_from27): ?>
                <p class="season-footer-price"><?php echo esc_html($price_from27); ?></p>
            <?php endif; ?>
            <?php if ($book_label27 && $book_url27): ?>
                <a href="<?php echo esc_url($book_url27); ?>" class="season-footer-book"><?php echo esc_html($book_label27); ?></a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; endif; ?>

    <?php if ($has_2028):
    $footer_note28 = get_field('season28_footer_note', $pid);
    $price_from28  = get_field('season28_price_from', $pid);
    $book_label28  = get_field('season28_book_label', $pid);
    $book_url28    = get_field('season28_book_url', $pid);
    if ($footer_note28 || $price_from28): ?>
    <div class="season-footer season-panel season-panel--hidden" data-panel="2028">
        <div class="season-footer-left">
            <?php if ($footer_note28): ?>
                <p class="season-footer-note"><?php echo nl2br(esc_html($footer_note28)); ?></p>
            <?php endif; ?>
        </div>
        <div class="season-footer-right">
            <?php if ($price_from28): ?>
                <p class="season-footer-price"><?php echo esc_html($price_from28); ?></p>
            <?php endif; ?>
            <?php if ($book_label28 && $book_url28): ?>
                <a href="<?php echo esc_url($book_url28); ?>" class="season-footer-book"><?php echo esc_html($book_label28); ?></a>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; endif; ?>

</section>

<script>
document.addEventListener('click', function(e) {
    // Expand/collapse month detail rows
    var row = e.target.closest('[data-expand]');
    if (row) {
        var panel = document.getElementById(row.getAttribute('data-expand'));
        if (panel) panel.hidden = !panel.hidden;
        return;
    }

    // Year tab switching
    var tab = e.target.closest('.season-year-tab');
    if (!tab) return;
    var section = tab.closest('.season-prices');
    if (!section) return;
    var yr = tab.dataset.year;

    // Update tab button states
    section.querySelectorAll('.season-year-tab').forEach(function(t) {
        var active = t.dataset.year === yr;
        t.classList.toggle('is-active', active);
        t.setAttribute('aria-selected', active ? 'true' : 'false');
    });

    // Update year in section title
    var display = section.querySelector('.season-year-display');
    if (display) display.textContent = yr;

    // Show/hide year panels
    section.querySelectorAll('.season-panel').forEach(function(p) {
        p.classList.toggle('season-panel--hidden', p.dataset.panel !== yr);
    });
});
</script>

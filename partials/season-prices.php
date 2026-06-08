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

$month_slugs = ['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'];
$month_nums  = [1,2,3,4,5,6,7,8,9,10,11,12];

$color_class = [
    'low'      => 'season-dot--low',
    'mid'      => 'season-dot--mid',
    'high'     => 'season-dot--high',
    'veryhigh' => 'season-dot--veryhigh',
];

// Build month data array
$months = [];
foreach ($month_slugs as $i => $slug) {
    $num   = $month_nums[$i];
    $price = get_field("season_{$slug}_price", $pid);
    $months[] = [
        'slug'      => $slug,
        'num'       => $num,
        'name'      => ucfirst(date_i18n('F', mktime(0, 0, 0, $num, 1))),
        'price'     => $price !== '' && $price !== null ? (int) $price : null,
        'label'     => get_field("season_{$slug}_label", $pid),
        'color'     => get_field("season_{$slug}_color", $pid),
        'date_from' => get_field("season_{$slug}_date_from", $pid),
        'date_to'   => get_field("season_{$slug}_date_to", $pid),
        'min_stay'  => get_field("season_{$slug}_min_stay", $pid),
    ];
}

$first_half  = array_slice($months, 0, 6);
$second_half = array_slice($months, 6, 6);

// Helper to render a single month row
function plh_render_season_row($m, $color_class, $per_period_label = '') {
    $slug      = $m['slug'];
    $has_price = $m['price'] !== null && $m['price'] > 0;
    $has_extra = $has_price && ($m['date_from'] || $m['date_to'] || $m['min_stay']);
    $dot_class = isset($color_class[$m['color']]) ? $color_class[$m['color']] : '';
    $detail_id = 'season-detail-' . $slug;
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
                    &euro;&nbsp;<?php echo esc_html(number_format($m['price'], 0, ',', '&thinsp;')); ?>
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
?>

<section class="season-prices" id="season-prices">
    <h2 class="must-have-title"><?php echo esc_html($rates_label); ?> <?php echo esc_html($year); ?></h2>
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
    <div class="season-minstay-row">
        <?php if ($min_stay_1): ?>
            <span class="season-minstay-tag"><?php echo esc_html($min_stay_1); ?></span>
        <?php endif; ?>
        <?php if ($min_stay_2): ?>
            <span class="season-minstay-tag"><?php echo esc_html($min_stay_2); ?></span>
        <?php endif; ?>
    </div>
    <?php endif; ?>

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

    <div class="season-grid">
        <div class="season-col">
            <div class="season-col-header">
                <span class="season-col-range"><?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,1,1)))); ?> &ndash; <?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,6,1)))); ?></span>
                <span class="season-col-price-label"><?php echo esc_html(plh_t('Price')); ?> / <?php echo esc_html($per_period_label); ?></span>
            </div>
            <?php foreach ($first_half as $m): ?>
                <?php plh_render_season_row($m, $color_class, $per_period_label); ?>
            <?php endforeach; ?>
        </div>
        <div class="season-col">
            <div class="season-col-header">
                <span class="season-col-range"><?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,7,1)))); ?> &ndash; <?php echo esc_html(ucfirst(date_i18n('F', mktime(0,0,0,12,1)))); ?></span>
                <span class="season-col-price-label"><?php echo esc_html(plh_t('Price')); ?> / <?php echo esc_html($per_period_label); ?></span>
            </div>
            <?php foreach ($second_half as $m): ?>
                <?php plh_render_season_row($m, $color_class, $per_period_label); ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
    $footer_note  = get_field('season_footer_note', $pid);
    $price_from   = get_field('season_price_from', $pid);
    $book_label   = get_field('season_book_label', $pid);
    $book_url     = get_field('season_book_url', $pid);
    if ($footer_note || $price_from): ?>
    <div class="season-footer">
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

</section>

<script>
document.addEventListener('click', function(e) {
    const row = e.target.closest('[data-expand]');
    if (!row) return;
    const panel = document.getElementById(row.getAttribute('data-expand'));
    if (!panel) return;
    panel.hidden = !panel.hidden;
});
</script>

<?php
/** 
 * Template Name: The villas
 */
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<?php
$all_villas = new WP_Query([
        'post_type'      => 'villa',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
]);
?>

<style>
.villa-filters {
    max-width: 1400px;
    margin: 0 auto;
    padding: 30px 5vw;
}
.villa-filters h3 {
    font-family: 'Raleway';
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
}
.filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: flex-end;
}
.filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.filter-group label {
    font-family: 'Raleway';
    font-size: 14px;
    font-weight: 500;
    color: #666;
}
.collection-filters {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.collection-btn {
    padding: 10px 20px;
    border: 1.5px solid #ddd;
    background: #fff;
    font-family: 'Raleway';
    font-size: 14px;
    font-weight: 500;
    color: #333;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.collection-btn:hover {
    border-color: #999;
    background: #f9f9f9;
}
.collection-btn.active {
    background: #333;
    color: #fff;
    border-color: #333;
}
.filter-select {
    padding: 12px 40px 12px 20px;
    font-family: 'Raleway', sans-serif;
    font-size: 16px;
    font-weight: 300;
    border: 1px solid #ddd;
    border-radius: 0;
    background: white;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 20px;
    transition: border-color 0.3s ease;
    min-width: 200px;
}
.filter-select:hover {
    border-color: #999;
}
.filter-select:focus {
    border-color: #666;
    outline: none;
}
.reset-filters {
    padding: 10px 20px;
    border: 1.5px solid #333;
    background: transparent;
    font-family: 'Raleway';
    font-size: 14px;
    font-weight: 500;
    color: #333;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-left: auto;
}
.reset-filters:hover {
    background: #333;
    color: #fff;
}
.all-villas-grid {
    padding: 0 5vw 60px;
}
.all-villas-grid .villas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 28px;
    transition: opacity 0.3s ease;
}
.all-villas-grid .villas-grid.loading {
    opacity: 0.5;
    pointer-events: none;
}
@media (min-width: 1024px) {
    .all-villas-grid .villas-grid { grid-template-columns: repeat(3, 1fr); }
}
.all-villas-grid .villa-grid-item { height: 100%; }
.no-villas {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    font-family: 'Raleway';
    font-size: 16px;
    color: #666;
}
@media (max-width: 768px) {
    .filter-row {
        flex-direction: column;
        align-items: stretch;
    }
    .collection-filters {
        width: 100%;
    }
    .collection-btn {
        flex: 1;
        text-align: center;
    }
    .filter-select {
        width: 100%;
        min-width: auto;
    }
    .reset-filters {
        width: 100%;
        margin-left: 0;
    }
}
</style>

<div class="homepage">
    
    <section class="villa-filters">
        <h3><?php echo esc_html( function_exists('pll__') ? pll__('Filter Villas') : 'Filter Villas' ); ?></h3>
        <div class="filter-row">
            <div class="filter-group">
                <label for="collection-filter"><?php echo esc_html(plh_t('Collection')); ?></label>
                <select id="collection-filter" class="filter-select">
                    <option value=""><?php echo esc_html( function_exists('pll__') ? pll__('All') : 'All' ); ?></option>
                    <option value="sea"><?php echo esc_html(plh_t('Seaside')); ?></option>
                    <option value="land"><?php echo esc_html(plh_t('Countryside')); ?></option>
                    <option value="city"><?php echo esc_html(plh_t('Historic center')); ?></option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="guests-filter"><?php echo esc_html(plh_t('Capacity')); ?></label>
                <select id="guests-filter" class="filter-select">
                    <option value=""><?php echo esc_html( function_exists('pll__') ? pll__('Any') : 'Any' ); ?></option>
                    <option value="6"><?php echo esc_html(plh_t('Up to 6 guests')); ?></option>
                    <option value="8"><?php echo esc_html(plh_t('Up to 8 guests')); ?></option>
                    <option value="10"><?php echo esc_html(plh_t('Up to 10 guests')); ?></option>
                    <option value="12"><?php echo esc_html(plh_t('Up to 12 guests')); ?></option>
                    <option value="15"><?php echo esc_html(plh_t('Up to 15 guests')); ?></option>
                    <option value="16"><?php echo esc_html(plh_t('16 + guests')); ?></option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="price-filter"><?php echo esc_html(plh_t('Price per night (from)')); ?></label>
                <select id="price-filter" class="filter-select">
                    <option value=""><?php echo esc_html( function_exists('pll__') ? pll__('Any') : 'Any' ); ?></option>
                    <option value="0-600"><?php echo esc_html(plh_t('Up to €600')); ?></option>
                    <option value="600-1200"><?php echo esc_html(plh_t('€600 – €1,200')); ?></option>
                    <option value="1200-2000"><?php echo esc_html(plh_t('€1,200 – €2,000')); ?></option>
                    <option value="2000-3000"><?php echo esc_html(plh_t('€2,000 – €3,000')); ?></option>
                    <option value="3000-5000"><?php echo esc_html(plh_t('€3,000 – €5,000')); ?></option>
                    <option value="5000-999999"><?php echo esc_html(plh_t('More than €5,000')); ?></option>
                </select>
            </div>
            
            <button class="reset-filters"><?php echo esc_html( function_exists('pll__') ? pll__('Reset Filters') : 'Reset Filters' ); ?></button>
        </div>
    </section>

    <section class="all-villas-grid">
        <div class="villas-grid" id="villas-container">
            <?php if ($all_villas->have_posts()): while ($all_villas->have_posts()): $all_villas->the_post(); ?>
                <article class="villa-grid-item">
                    <?php get_template_part('partials/villa-card', null, ['post_id' => get_the_ID()]); ?>
                </article>
            <?php endwhile; wp_reset_postdata(); else: ?>
                <p class="no-villas"><?php echo esc_html__('No villas found', 'plh'); ?></p>
            <?php endif; ?>
        </div>
    </section>
</div>

<script>
(function() {
    const collectionFilter = document.getElementById('collection-filter');
    const guestsFilter = document.getElementById('guests-filter');
    const priceFilter = document.getElementById('price-filter');
    const resetBtn = document.querySelector('.reset-filters');
    const villasContainer = document.getElementById('villas-container');
    
    let currentFilters = {
        collection: '',
        guests: '',
        price: ''
    };
    
    // Dropdown changes
    collectionFilter.addEventListener('change', function() {
        currentFilters.collection = this.value;
        fetchVillas();
    });
    
    guestsFilter.addEventListener('change', function() {
        currentFilters.guests = this.value;
        fetchVillas();
    });
    
    priceFilter.addEventListener('change', function() {
        currentFilters.price = this.value;
        fetchVillas();
    });
    
    // Reset filters
    resetBtn.addEventListener('click', function() {
        currentFilters = { collection: '', guests: '', price: '' };
        collectionFilter.value = '';
        guestsFilter.value = '';
        priceFilter.value = '';
        fetchVillas();
    });
    
    // Fetch filtered villas
    function fetchVillas() {
        villasContainer.classList.add('loading');
        
        const formData = new FormData();
        formData.append('action', 'filter_villas');
        formData.append('nonce', '<?php echo wp_create_nonce('filter_villas_nonce'); ?>');
        formData.append('collection', currentFilters.collection);
        formData.append('guests', currentFilters.guests);
        formData.append('price', currentFilters.price);
        
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            villasContainer.innerHTML = html;
            villasContainer.classList.remove('loading');
        })
        .catch(error => {
            console.error('Filter error:', error);
            villasContainer.classList.remove('loading');
        });
    }
})();
</script>

<?php get_footer(); ?>
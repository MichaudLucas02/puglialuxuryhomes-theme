<?php
/**
 * Template Name: Concierge Template
 */
get_header(); ?>

<?php get_template_part('partials/small-hero'); ?>
<div class="homepage">

    <?php get_template_part('partials/process'); ?>

    <section class="services-title">
        <div class="services-title-content">
            <h2><?php 
            $title = get_field('concierge_title');
            echo esc_html($title ?: plh_t('Get inspired')); 
            ?></h2>
            <p><?php 
            $subtitle = get_field('concierge_subtitle');
            echo esc_html($subtitle ?: plh_t('Top experiences for your itinerary')); 
            ?></p>
        </div>
        <a href="#all-services" class="discover-services-btn">
            <?php 
            $button_text = get_field('concierge_button_text');
            echo esc_html($button_text ?: plh_t('Discover All Services')); 
            ?>
        </a>
    </section>

    <?php
    // Array of 4 services with ACF field mapping
    $services = [];
    for ($i = 1; $i <= 4; $i++) {
        $slides = array_filter([
            get_field("service_{$i}_image"),
            get_field("service_{$i}_image_2"),
            get_field("service_{$i}_image_3"),
            get_field("service_{$i}_image_4"),
        ]);
        $service_data = [
            'slides' => $slides,
            'title' => get_field("service_{$i}_title"),
            'description' => get_field("service_{$i}_description"),
        ];
        if (!empty($service_data['title']) || !empty($slides)) {
            $services[] = $service_data;
        }
    }

    if (!empty($services)) {
        foreach ($services as $index => $service) {
            $is_mirrored = ($index % 2) === 1;
            $wrapper_class = $is_mirrored ? 'service-wrapper mirrored' : 'service-wrapper';
            $section_class = $index === 0 ? 'offered-services' : '';
            ?>
            <section <?php echo $section_class ? 'class="' . esc_attr($section_class) . '"' : ''; ?>>
                <div class="<?php echo esc_attr($wrapper_class); ?>">
                    <div class="service-image">
                        <?php if (!empty($service['slides'])) : ?>
                            <div class="swiper service-image-carousel service-carousel-<?php echo $index; ?>">
                                <div class="swiper-wrapper service-carousel-wrapper">
                                    <?php foreach ($service['slides'] as $image_id) : ?>
                                        <div class="swiper-slide service-carousel-slide">
                                            <?php echo wp_get_attachment_image($image_id, 'large', false, [
                                                'alt' => esc_attr($service['title']),
                                                'class' => 'service-img',
                                            ]); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="swiper-pagination service-carousel-pagination"></div>
                                <div class="swiper-button-prev service-carousel-prev"></div>
                                <div class="swiper-button-next service-carousel-next"></div>
                            </div>
                        <?php else : ?>
                            <img src="https://via.placeholder.com/600x400" alt="<?php echo esc_attr($service['title']); ?>" />
                        <?php endif; ?>
                    </div>
                    <div class="service-content">
                        <h4><?php echo esc_html($service['title']); ?></h4>
                        <p><?php echo wp_kses_post($service['description']); ?></p>
                    </div>
                </div>
            </section>
            <?php
        }
    } else {
        // Fallback with 4 hardcoded placeholder services
        $fallback_services = [
            [
                'title' => 'Supercar Grand Tour',
                'description' => 'Unleash the thrill of the open road with a full-day guided supercar tour, starting from your private villa on Lake Como.',
            ],
            [
                'title' => 'Private Chef Experience',
                'description' => 'Enjoy a bespoke culinary experience curated by a private chef in your villa with locally sourced ingredients.',
            ],
            [
                'title' => 'Yacht Adventure',
                'description' => 'Explore the pristine waters of the Italian lakes aboard a luxury yacht with professional crew and water sports.',
            ],
            [
                'title' => 'Wine Tasting Tour',
                'description' => 'Visit renowned vineyards and wine estates with an expert sommelier for an exclusive tasting experience.',
            ],
        ];
        
        foreach ($fallback_services as $index => $service) {
            $is_mirrored = ($index % 2) === 1;
            $wrapper_class = $is_mirrored ? 'service-wrapper mirrored' : 'service-wrapper';
            $section_class = $index === 0 ? 'offered-services' : '';
            ?>
            <section <?php echo $section_class ? 'class="' . esc_attr($section_class) . '"' : ''; ?>>
                <div class="<?php echo esc_attr($wrapper_class); ?>">
                    <div class="service-image">
                        <img src="https://via.placeholder.com/600x400" alt="<?php echo esc_attr($service['title']); ?>" />
                    </div>
                    <div class="service-content">
                        <h4><?php echo esc_html($service['title']); ?></h4>
                        <p><?php echo esc_html($service['description']); ?></p>
                    </div>
                </div>
            </section>
            <?php
        }
    }
    ?>

        <?php if (!empty($services)) : ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        if (typeof Swiper === 'undefined') return;
                        
                        // Initialize carousels with proper element selection
                        var carousels = document.querySelectorAll('.service-image-carousel');
                        
                        carousels.forEach(function(carousel) {
                            new Swiper(carousel, {
                                loop: false,
                                slidesPerView: 1,
                                spaceBetween: 0,
                                pagination: {
                                    el: carousel.querySelector('.service-carousel-pagination'),
                                    clickable: true
                                },
                                navigation: {
                                    nextEl: carousel.querySelector('.service-carousel-next'),
                                    prevEl: carousel.querySelector('.service-carousel-prev')
                                },
                                watchOverflow: true,
                                observer: true,
                                observeParents: true,
                                observeSlideChildren: true,
                                watchSlidesProgress: true
                            });
                        });
                    });
                </script>
        <?php endif; ?>
</div>


<?php get_footer(); ?>
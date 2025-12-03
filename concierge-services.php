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
            <h2><?php echo esc_html( plh_t('Get inspired') ); ?></h2>
            <p><?php echo esc_html( plh_t('Top experiences for your itinerary') ); ?></p>
        </div>
        <a href="#all-services" class="discover-services-btn"><?php echo esc_html( plh_t('Discover All Services') ); ?></a>
    </section>
    <section class="offered-services">
        
        <div class="service-wrapper">
            <div class="service-image">
                <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/10/redcharlie-vQVWIsIBafA-unsplash-scaled.jpg">
            </div>
            <div class="service-content">
                <h4>Supercar Grand Tour</h4>
                <p>Unleash the thrill of the open road with a full-day guided supercar tour, starting from your private villa on Lake Como. Slide into the driver’s seat of an iconic Italian supercar and embark on an exhilarating journey through winding lakefront roads, alpine passes, and picturesque countryside.

    Led by an expert guide, this bespoke tour can be tailored to your preferences, whether it’s a high-speed drive through the legendary Stelvio Pass, a scenic cruise along the shores of Lake Como, or a stop at a renowned vineyard for a private tasting. Enjoy the perfect blend of adrenaline, luxury, and breathtaking scenery as you explore Italy in style.</p>
            </div>
        </div>
        
    </section>
    <section>
        
        <div class="service-wrapper mirrored">
            <div class="service-image">
                <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/10/redcharlie-vQVWIsIBafA-unsplash-scaled.jpg">
            </div>
            <div class="service-content">
                <h4>Supercar Grand Tour</h4>
                <p>Unleash the thrill of the open road with a full-day guided supercar tour, starting from your private villa on Lake Como. Slide into the driver’s seat of an iconic Italian supercar and embark on an exhilarating journey through winding lakefront roads, alpine passes, and picturesque countryside.

    Led by an expert guide, this bespoke tour can be tailored to your preferences, whether it’s a high-speed drive through the legendary Stelvio Pass, a scenic cruise along the shores of Lake Como, or a stop at a renowned vineyard for a private tasting. Enjoy the perfect blend of adrenaline, luxury, and breathtaking scenery as you explore Italy in style.</p>
            </div>
        </div>
        
    </section>
</div>

<?php get_footer(); ?>
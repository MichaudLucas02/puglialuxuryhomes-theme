<?php
/**
 * Template Name: Villa Template
 */

get_header(); ?>

<?php
    $bedrooms = get_field('beds');
    $bathrooms = get_field('baths');
    $guests = get_field('guests');
    $sqm = get_field('sqm');
?>


<?php get_template_part('partials/large-hero'); ?>


<div class="villa-page-menu">
    <ul>
        <li><a href="">L'essentiel</li>
        <li><a href="">Description du bien</li>
        <li><a href="">Experience</li>
        <li><a href="">Avis</li>
        <li><a href="">Photo</li>
    </ul>
</div>
<section class="villa-content">
    <div class="villa-content-left">
        <div class="villa-kpis">
            <div class="single-kpi">
                <img src="http://puglialuxuryhomes.local/wp-content/uploads/2025/09/Bedrooms.png">
                <p><?php echo esc_html($beds); ?></p>
            </div>
        </div>
    </div>
    <div class="villa-content-right">
        <div class="booking-box">
            <?php the_title(); ?>
            <p>Some random content about the villa I dont know about</p>
            <h2>Add dates to view exact prices</h2>
            <p>Want to check if your dates are available?
Send us a quick enquiry - no strings attached.</p>
            <button>Send Enquiry</button>

        </div>
    </div>
</section>
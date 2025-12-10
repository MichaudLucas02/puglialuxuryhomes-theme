<?php
/**
 * Template Name: Policies
 */
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<div class="cgl-page">
    <div class="cgl-content">
        <?php 
        $cgl_content = get_field('cgl_content');
        if ($cgl_content) {
            echo wp_kses_post($cgl_content);
        } else {
            echo '<p>Please add your general conditions content in the WordPress editor.</p>';
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>

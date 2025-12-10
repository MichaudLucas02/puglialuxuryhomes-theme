<?php
/**
 * Template Name: Policies
 */
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<div class="cgl-page">
    <div class="cgl-content">
        <?php 
        $conditions = get_field('cgl_content');
        $confidentiality = get_field('confidentiality_content');

        if ($conditions) {
            echo wp_kses_post($conditions);
        } elseif ($confidentiality) {
            echo wp_kses_post($confidentiality);
        } else {
            echo '<p>Please add your policy content in the WordPress editor.</p>';
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>

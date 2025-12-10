<?php
/**
 * Template Name: Confidentiality Policy
 */
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<div class="cgl-page">
    <div class="cgl-content">
        <?php 
        $policy_content = get_field('confidentiality_content');
        if ($policy_content) {
            echo wp_kses_post($policy_content);
        } else {
            echo '<p>Please add your confidentiality policy content in the WordPress editor.</p>';
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>

<?php
/**
 * Template Name: Our Story
 */
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>
<div class="homepage">
    <section class="our-story-content">
        <div class="our-story-col">
            <img src="<?php echo esc_url( get_field('story_image') ?: 'https://www.puglialuxuryhomes.com/wp-content/uploads/2023/12/les-3-fondateurs-scaled.webp' ); ?>"/>
        </div>
        <div class="our-story-col">
            <h4><?php echo esc_html( get_field('story_subtitle') ?: 'The Story' ); ?></h4>
            <h2><?php echo esc_html( get_field('story_title') ?: 'Once Upon a Time...' ); ?></h2>
            <p><?php echo wp_kses_post( get_field('story_paragraph_1') ?: 'It all started with Villa Acquamarina...' ); ?></p>
            <p><?php echo wp_kses_post( get_field('story_paragraph_2') ?: 'But what captivated us most...' ); ?></p>

            <a href="<?php echo esc_url( get_field('story_button_url') ?: '/contact' ); ?>" class="discover-services-btn"><?php echo esc_html( get_field('story_button_text') ?: 'Contact Us' ); ?></a>
        </div>
    </section>
    <section class="our-story-content grey">
        <div class="our-story-col">
            <h4><?php echo esc_html( get_field('adventure_subtitle') ?: 'The Adventure' ); ?></h4>
            <h2><?php echo esc_html( get_field('adventure_title') ?: 'The desire to live there...' ); ?></h2>
            <p><?php echo wp_kses_post( get_field('adventure_paragraph_1') ?: 'Seeing it as a unique opportunity...' ); ?></p>
            <p><?php echo wp_kses_post( get_field('adventure_paragraph_2') ?: 'After Acquamarina, our passion...' ); ?></p>

        </div>
        <div class="our-story-col">
            <img src="<?php echo esc_url( get_field('adventure_image') ?: '' ); ?>"/>
        </div>
    </section>
    <section class="our-story-content">
        <div class="our-story-col narrow">
            <div class="video-container">
                <iframe src="https://www.youtube.com/embed/<?php echo esc_attr( get_field('mission_video_id') ?: 'HsHxR7onVnE' ); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <div class="our-story-col wide">
            <h4><?php echo esc_html( get_field('mission_subtitle') ?: 'Our Mission' ); ?></h4>
            <h2><?php echo esc_html( get_field('mission_title') ?: 'Share our paradise...' ); ?></h2>
            <p><?php echo wp_kses_post( get_field('mission_paragraph_1') ?: 'Today, our mission is...' ); ?></p>
            <p><?php echo wp_kses_post( get_field('mission_paragraph_2') ?: 'So, we hope you\'ll find...' ); ?></p>
            <p><?php echo esc_html( get_field('mission_signature') ?: 'Sébastien & Augustine' ); ?></p>

        </div>
    </section>
    <section class="our-story-central-content">
        <h4><?php echo esc_html( get_field('portrait_subtitle') ?: 'The portrait' ); ?></h4>
        <h2><?php echo esc_html( get_field('portrait_title') ?: '"Born out of love...' ); ?></h2>
        <div class="video-container-standard">
            <iframe src="https://www.youtube.com/embed/<?php echo esc_attr( get_field('portrait_video_id') ?: '0xpYqmAWEvs' ); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <p>Test for the github setup</p>

    </section>

</div>
<?php get_footer(); ?>

<?php
$large_hero_title =  get_field('large_hero_title');
$large_hero_button = get_field('large_hero_button');


$large_hero_image = get_field('large_hero_image');

?>

<section class="large-hero">
    <img src="<?php echo esc_url($large_hero_image); ?>">
    <div class="large-hero-content">
        <h2><?php the_title(); ?></h2>
        <a href="<?php echo $large_hero_button['url']; ?>"><?php echo $large_hero_button['title']; ?></a>
    </div>

</section>
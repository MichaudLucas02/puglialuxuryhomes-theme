<?php
/*
Template Name: Blog
*/
get_header();

// Query blog post type
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = [
    'post_type' => 'blog',
    'posts_per_page' => 10,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
];
$blog_query = new WP_Query($args);
?>
<div class="blog-listing">
    <h1>Blog</h1>
    <?php if ( $blog_query->have_posts() ) : ?>
        <div class="posts">
            <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="blog-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="meta">
                        <span>By <?php the_author(); ?></span> |
                        <span><?php the_time('F j, Y'); ?></span>
                    </div>
                    <div class="excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                </article>
            <?php endwhile; ?>
        </div>
        <div class="pagination">
            <?php
                echo paginate_links([
                    'total' => $blog_query->max_num_pages,
                    'current' => $paged,
                    'type' => 'list',
                ]);
            ?>
        </div>
    <?php else : ?>
        <p>No blog posts found.</p>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</div>
<?php get_footer(); ?>

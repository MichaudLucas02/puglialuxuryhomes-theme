<?php
/**
 * Archive template for Blog CPT
 */
get_header();
?>
<div class="blog-archive">
  <header class="archive-header">
    <h1>Blog</h1>
    <?php if ( is_search() ) : ?>
      <p>Search results</p>
    <?php endif; ?>
  </header>
  <?php if ( have_posts() ) : ?>
    <div class="blog-archive-grid">
      <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('blog-card'); ?>>
          <a class="thumb" href="<?php the_permalink(); ?>">
            <?php if ( has_post_thumbnail() ) {
              the_post_thumbnail('medium');
            } else {
              echo '<div class="placeholder-thumb"></div>';
            } ?>
          </a>
          <div class="blog-card-body">
            <h2 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="meta">
              <span class="date"><?php echo get_the_date(); ?></span>
              <span class="sep">•</span>
              <span class="author"><?php the_author(); ?></span>
            </div>
            <div class="excerpt"><?php the_excerpt(); ?></div>
            <a class="read-more" href="<?php the_permalink(); ?>">Read more →</a>
          </div>
        </article>
      <?php endwhile; ?>
    </div>
    <nav class="pagination">
      <?php the_posts_pagination(); ?>
    </nav>
  <?php else : ?>
    <p>No blog posts yet.</p>
  <?php endif; ?>
</div>
<?php
get_footer();

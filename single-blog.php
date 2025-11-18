<?php
/**
 * Single Blog Post template - Dynamic content from WordPress editor
 */
get_header();
?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

  <div class="homepage">
    <article id="post-<?php the_ID(); ?>" <?php post_class('single-blog'); ?>>
      
      <?php 
      // Include hero only if the image field is set
      if ( get_field('large_hero_image') ) {
        get_template_part('partials/large-hero');
      }
      ?>
      
      <section class="blog-navigation">
        <div class="blog-breadcrumbs">
          <a href="<?php echo home_url('/'); ?>"><?php _e('Accueil', 'plh'); ?></a>
          <span class="sep">></span>
          <a href="<?php echo get_post_type_archive_link('blog'); ?>"><?php _e('Blog', 'plh'); ?></a>
          <span class="sep">></span>
          <span class="current"><?php the_title(); ?></span>
        </div>
        <div class="blog-tags">
          <?php 
          $tags = get_the_terms(get_the_ID(), 'post_tag');
          if ($tags && !is_wp_error($tags)) {
            foreach ($tags as $tag) {
              echo '<a href="'.get_term_link($tag).'" class="tag">'.esc_html($tag->name).'</a>';
            }
          }
          ?>
        </div>
      </section>
    
      <section class="single-blog-wrapper">
        <div class="table-content" role="navigation" aria-label="Sommaire"></div>
        <div class="single-blog-content-wrapper">
            <?php 
            // Display meta description if set
            $meta_desc = get_post_meta(get_the_ID(), '_plh_meta_description', true);
            if ($meta_desc) : ?>
            <p class="meta-description"><?php echo esc_html($meta_desc); ?></p>
            <?php endif; ?>
            
            <div class="single-blog-content">
            <?php the_content(); ?>
            </div>

            <footer class="single-blog-footer">
            <div class="blog-footer-meta">
                <?php if (get_the_category()) : ?>
                <div class="categories">
                    <?php _e('Catégories:', 'plh'); ?> 
                    <?php echo get_the_category_list(', '); ?>
                </div>
                <?php endif; ?>
                <?php if (has_tag()) : ?>
                <div class="tags">
                    <?php _e('Tags:', 'plh'); ?> 
                    <?php echo get_the_tag_list('', ', '); ?>
                </div>
                <?php endif; ?>
            </div>
            
            <nav class="post-nav" aria-label="<?php _e('Navigation des articles', 'plh'); ?>">
                <div class="prev">
                <?php previous_post_link('%link', '← %title'); ?>
                </div>
                <div class="next">
                <?php next_post_link('%link', '%title →'); ?>
                </div>
            </nav>
            
            
            </footer>
        </div>
      </section>
      
    </article>
  </div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const content = document.querySelector('.single-blog-content');
  const toc = document.querySelector('.table-content');
  if (!content || !toc) return;

  const headings = content.querySelectorAll('h2');
  if (!headings.length) {
    toc.style.display = 'none';
    return;
  }

  // Slugify helper
  const slugify = (str) => str
    .toString()
    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
    .toLowerCase()
    .replace(/[^a-z0-9\s-]/g, '')
    .trim()
    .replace(/\s+/g, '-');

  // Assign IDs and build list
  const used = new Set();
  const list = document.createElement('ol');
  list.className = 'toc-list';

  headings.forEach((h, i) => {
    let text = h.textContent.trim();
    let base = slugify(text) || 'section-' + (i+1);
    let id = base;
    let n = 2;
    while (used.has(id) || document.getElementById(id)) {
      id = base + '-' + n++;
    }
    used.add(id);
    if (!h.id) h.id = id;

    const li = document.createElement('li');
    const a = document.createElement('a');
    a.href = '#' + id;
    a.textContent = text;
    li.appendChild(a);
    list.appendChild(li);
  });

  // Render TOC
  const title = document.createElement('strong');
  title.textContent = 'Sommaire';
  toc.appendChild(title);
  toc.appendChild(list);

  // Smooth scroll with header offset
  toc.addEventListener('click', (e) => {
    const a = e.target.closest('a[href^="#"]');
    if (!a) return;
    const target = document.querySelector(a.getAttribute('href'));
    if (!target) return;
    e.preventDefault();

    // Compute offset: fixed header height variable if set, else 70px
    const rootStyles = getComputedStyle(document.documentElement);
    const headerVar = rootStyles.getPropertyValue('--header-height').trim();
    const offset = parseInt(headerVar || '70', 10) + 10; // add small gap

    const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
    window.scrollTo({ top, behavior: 'smooth' });
    history.replaceState(null, '', a.getAttribute('href'));
  });
});
</script>
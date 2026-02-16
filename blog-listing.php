<?php
/** 
 * Template Name: Blog Listing
 */
get_header(); ?>
<?php get_template_part('partials/small-hero'); ?>

<div class="homepage">

    <section class="blog-listing">
        <div class="blog-header">
            <h2><?php pll_e('Latest Blog Posts'); ?></h2>
            
            <div class="blog-category-filter">
                <?php
                // Get all categories used in blog posts
                $categories = get_terms([
                    'taxonomy' => 'category',
                    'hide_empty' => true,
                ]);
                
                $current_cat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
                $current_url = get_permalink();
                ?>
                <select id="blog-category-filter" onchange="window.location.href=this.value">
                    <option value="<?php echo esc_url($current_url); ?>" <?php selected($current_cat, 0); ?>><?php pll_e('All Categories'); ?></option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo esc_url(add_query_arg('cat', $category->term_id, $current_url)); ?>" <?php selected($current_cat, $category->term_id); ?>>
                            <?php echo esc_html($category->name); ?> (<?php echo $category->count; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <?php
        // Query blog posts
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : (get_query_var('paged') ? get_query_var('paged') : 1);
        $current_cat = isset($_GET['cat']) ? intval($_GET['cat']) : 0;
        
        $args = [
            'post_type'      => 'blog',
            'posts_per_page' => 9,
            'paged'          => $paged,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];
        
        if ($current_cat > 0) {
            $args['cat'] = $current_cat;
        }
        
        $q = new WP_Query($args);
        
        if ($q->have_posts()):
            // Collect all posts
            $posts = [];
            while ($q->have_posts()): 
                $q->the_post();
                $posts[] = [
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(get_the_ID(), 'large'),
                    'category' => wp_get_post_terms(get_the_ID(), 'category') ? wp_get_post_terms(get_the_ID(), 'category')[0]->name : 'Blog',
                ];
            endwhile;
            wp_reset_postdata();
            
            // Desktop version: 1 featured + 3 cards + 1 wide + 3 cards (repeating)
            ?>
            <div class="blog-desktop">
            <?php
            $total_posts = count($posts);
            $post_index = 0;
            $pattern_iteration = 0;
            
            while ($post_index < $total_posts) {
                if ($pattern_iteration === 0) {
                    // First featured section (normal)
                    if ($post_index < $total_posts) {
                        $featured = $posts[$post_index];
                        ?>
                        <section class="featured-blog-section">
                            <?php 
                            set_query_var('featured_post', $featured);
                            get_template_part('partials/feature-blog-section'); 
                            ?>
                        </section>
                        <?php
                        $post_index++;
                    }
                    
                    // 3 blog cards row
                    ?>
                    <section class="blog-cards-row">
                        <div class="blog-cards-container">
                            <?php 
                            for ($i = 0; $i < 3 && $post_index < $total_posts; $i++) {
                                $card = $posts[$post_index];
                                get_template_part('partials/simple-blog-card', null, [
                                    'image_url' => $card['image'],
                                    'image_alt' => $card['title'],
                                    'category' => $card['category'],
                                    'title' => $card['title'],
                                    'excerpt' => wp_trim_words($card['excerpt'], 15),
                                    'link' => $card['permalink'],
                                    'read_more_text' => pll__('Read more'),
                                ]);
                                $post_index++;
                            }
                            ?>
                        </div>
                    </section>
                    <?php
                    $pattern_iteration++;
                } else {
                    // Wide blog section
                    if ($post_index < $total_posts) {
                        $wide = $posts[$post_index];
                        ?>
                        <section class="wide-blog-section-wrapper">
                            <?php
                            get_template_part('partials/wide-blog-section', null, [
                                'image_url' => $wide['image'],
                                'image_alt' => $wide['title'],
                                'category' => $wide['category'],
                                'title' => $wide['title'],
                                'excerpt' => wp_trim_words($wide['excerpt'], 25),
                                'link' => $wide['permalink'],
                                'read_more_text' => pll__('Read more'),
                            ]);
                            ?>
                        </section>
                        <?php
                        $post_index++;
                    }
                    
                    // 3 blog cards row
                    ?>
                    <section class="blog-cards-row">
                        <div class="blog-cards-container">
                            <?php 
                            for ($i = 0; $i < 3 && $post_index < $total_posts; $i++) {
                                $card = $posts[$post_index];
                                get_template_part('partials/simple-blog-card', null, [
                                    'image_url' => $card['image'],
                                    'image_alt' => $card['title'],
                                    'category' => $card['category'],
                                    'title' => $card['title'],
                                    'excerpt' => wp_trim_words($card['excerpt'], 15),
                                    'link' => $card['permalink'],
                                    'read_more_text' => pll__('Read more'),
                                ]);
                                $post_index++;
                            }
                            ?>
                        </div>
                    </section>
                    <?php
                    $pattern_iteration = 0;
                }
            }
            ?>
            </div>
            
            <!-- Mobile version: Only 3 cards repeating -->
            <div class="blog-mobile">
            <?php
            $post_index = 0;
            while ($post_index < $total_posts) {
                ?>
                <section class="blog-cards-row">
                    <div class="blog-cards-container">
                        <?php 
                        for ($i = 0; $i < 3 && $post_index < $total_posts; $i++) {
                            $card = $posts[$post_index];
                            get_template_part('partials/simple-blog-card', null, [
                                'image_url' => $card['image'],
                                'image_alt' => $card['title'],
                                'category' => $card['category'],
                                'title' => $card['title'],
                                'excerpt' => wp_trim_words($card['excerpt'], 15),
                                'link' => $card['permalink'],
                                'read_more_text' => pll__('Read more'),
                            ]);
                            $post_index++;
                        }
                        ?>
                    </div>
                </section>
                <?php
            }
            ?>
            </div>
            
            <?php
            // Pagination
            $current_url = get_permalink();
            if ($current_cat > 0) {
                $current_url = add_query_arg('cat', $current_cat, $current_url);
            }
            
            echo '<div class="pagination" style="text-align: center; margin: 60px 0;">';
            echo paginate_links([
                'base' => add_query_arg('paged', '%#%', $current_url),
                'format' => '',
                'total' => $q->max_num_pages,
                'current' => $paged,
                'type' => 'list',
                'prev_text' => '← ' . pll__('Previous'),
                'next_text' => pll__('Next') . ' →',
            ]);
            echo '</div>';
            
        else:
            echo '<p style="text-align: center; margin: 40px;">' . pll__('No blog posts found.') . '</p>';
        endif;
        ?>
    </section>
</div>

<?php get_footer(); ?>
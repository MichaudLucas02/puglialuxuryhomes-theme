<?php
/**
 * Google Reviews Section
 * Displays up to 6 Google reviews in a grid
 */

$post_id = $args['post_id'] ?? get_the_ID();
$reviews = [];

// Gather up to 6 reviews
for ($i = 1; $i <= 6; $i++) {
    $review = get_field("google_review_$i", $post_id);
    if (is_array($review) && !empty($review['reviewer_name'])) {
        $reviews[] = $review;
    }
}

if (empty($reviews)) return; // Don't show section if no reviews
?>

<section id="avis" class="google-reviews-section">
    <div class="google-reviews-wrapper">
        <div class="reviews-header">
            <h2>Guest Reviews</h2>
            <a href="https://www.google.com/search?q=puglia+luxury+homes" target="_blank" rel="noopener" class="google-badge">
                <i class="fa-brands fa-google"></i>
                <span>Google Reviews</span>
            </a>
        </div>

        <div class="reviews-grid">
            <?php foreach ($reviews as $review): 
                $name = esc_html($review['reviewer_name'] ?? '');
                $rating = (int)($review['rating'] ?? 5);
                $date = esc_html($review['review_date'] ?? '');
                $text = wp_kses_post($review['review_text'] ?? '');
                $photo = $review['reviewer_photo'] ?? '';
            ?>
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-info">
                        <?php if ($photo): ?>
                            <?php echo wp_get_attachment_image($photo, 'thumbnail', false, ['class' => 'reviewer-photo', 'alt' => $name]); ?>
                        <?php else: ?>
                            <div class="reviewer-photo-placeholder">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        <?php endif; ?>
                        <div class="reviewer-details">
                            <h4 class="reviewer-name"><?php echo $name; ?></h4>
                            <?php if ($date): ?>
                                <p class="review-date"><?php echo $date; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="review-rating">
                        <?php for ($s = 1; $s <= 5; $s++): ?>
                            <i class="fa-solid fa-star<?php echo $s <= $rating ? ' filled' : ' empty'; ?>"></i>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="review-body">
                    <p><?php echo $text; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="reviews-cta">
            <a href="https://www.google.com/search?q=puglia+luxury+homes" target="_blank" rel="noopener" class="view-all-reviews">
                View all reviews on Google
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

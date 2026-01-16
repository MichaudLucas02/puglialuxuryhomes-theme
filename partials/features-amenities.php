<?php
$pid = $args['post_id'] ?? get_the_ID();
// Increased per-group rows from 10 to 15
plh_render_features_4x4($pid, 15);

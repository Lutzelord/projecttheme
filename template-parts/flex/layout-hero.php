<?php
/**
 * Partial: Hero
 * ACF-Feld: image (image ID)
 */

$image_id = get_sub_field('image');

if (!$image_id) {
  return;
}
?>
<div class="hero">
  <?php
  echo wp_get_attachment_image($image_id, 'full', false, [
    'class'    => 'hero-image img-fluid w-100',
    'loading'  => 'eager',
    'decoding' => 'async',
  ]);
  ?>
</div>

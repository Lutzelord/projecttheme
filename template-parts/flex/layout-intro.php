<?php
/**
 * Partial: Intro (Hero)
 * ACF-Felder: text (wysiwyg), background_image (image id), cta (link)
 */

$body   = get_sub_field('text');
$img_id = get_sub_field('background_image');  // Attachment ID
$cta    = get_sub_field('cta');

?>
<div class="row g-4">
  <div class="col-12 intro-content">
    <?php if (is_array($cta) && (!empty($cta['url']) || !empty($cta['title']))): ?>
      <?php get_template_part('template-parts/flex/layout', 'cta-button', ['link' => $cta, 'embedded' => true]); ?>
    <?php endif; ?>

    <?php if ($body): ?>
      <div class="intro-text rte">
        <?php echo wp_kses_post($body); ?>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($img_id): ?>
    <div class="col-12 intro-image-column">
      <?php
      // Wenn du einen Helper wie theme_img() hast, nutze den:
      if (function_exists('theme_img')) {
        echo theme_img($img_id, 'large', ['class' => 'intro-image img-fluid rounded-3', 'loading' => 'lazy', 'decoding' => 'async']);
      } else {
        echo wp_get_attachment_image($img_id, 'large', false, [
          'class'    => 'intro-image img-fluid rounded-3',
          'loading'  => 'lazy',
          'decoding' => 'async',
        ]);
      }
      ?>
    </div>
  <?php endif; ?>
</div>
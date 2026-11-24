<?php
/**
 * Partial: Intro (Hero)
 * ACF-Felder: text (wysiwyg), background_image (image id),
 *             cta (ACFE button)
 */

$body   = get_sub_field('text');
$img_id = get_sub_field('background_image');  // Attachment ID
$cta    = get_sub_field('cta');

$cta_url = is_array($cta) && !empty($cta['url']) ? $cta['url'] : '';
$cta_title = is_array($cta)
  ? ($cta['title'] ?? $cta['text'] ?? $cta['label'] ?? $cta['button_value'] ?? '')
  : (is_string($cta) ? $cta : '');
$cta_target = is_array($cta) && !empty($cta['target']) ? $cta['target'] : '_self';
$cta_rel    = $cta_target === '_blank' ? 'noopener noreferrer' : '';

?>
<div class="row g-5">
  <div class="col-12 intro-content">
    <?php if ($cta_title): ?>
      <?php if ($cta_url): ?>
        <a class="intro-cta"
           href="<?php echo esc_url($cta_url); ?>"
           target="<?php echo esc_attr($cta_target); ?>"
           rel="<?php echo esc_attr($cta_rel); ?>">
          <span><?php echo esc_html($cta_title); ?></span>
          <span class="intro-cta-icon" aria-hidden="true">&#8599;</span>
        </a>
      <?php else: ?>
        <div class="intro-cta">
          <span><?php echo esc_html($cta_title); ?></span>
          <span class="intro-cta-icon" aria-hidden="true">&#8599;</span>
        </div>
      <?php endif; ?>
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
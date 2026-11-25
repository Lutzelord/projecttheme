<?php
/**
 * CTA Button component.
 */

$args = isset($args) && is_array($args) ? $args : [];
$link = $args['link'] ?? get_sub_field('link');
$title = is_array($link) ? ($link['title'] ?? '') : '';
$url = is_array($link) ? ($link['url'] ?? '') : '';
$target = is_array($link) && !empty($link['target']) ? $link['target'] : '_self';
$rel = $target === '_blank' ? 'noopener noreferrer' : '';
$tag = $url ? 'a' : 'div';
$embedded = !empty($args['embedded']);

if (!$title) {
  return;
}

if (!$embedded):
?>
<div class="cta-button__container">
<?php endif; ?>
  <<?php echo $tag; ?> class="intro-cta cta-button"<?php if ($url): ?>
    href="<?php echo esc_url($url); ?>"
    target="<?php echo esc_attr($target); ?>"
    rel="<?php echo esc_attr($rel); ?>"
  <?php endif; ?>>
    <span><?php echo esc_html($title); ?></span>
    <span class="intro-cta-icon" aria-hidden="true">
      <?php get_template_part('template-parts/components/icon-arrow-up-right'); ?>
    </span>
  </<?php echo $tag; ?>>
<?php if (!$embedded): ?>
</div>
<?php endif; ?>

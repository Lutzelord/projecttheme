<?php
/**
 * Main Content: local and special flea market links.
 */

$local_heading = get_sub_field('local_flea_market_text');
$local_markets = get_sub_field('local_market_items') ?: [];
$special_heading = get_sub_field('special_flea_markets_text');
$special_markets = get_sub_field('special_market_items') ?: [];

$render_market_links = static function ($items) {
  if (!is_array($items) || empty($items)) {
    return;
  }

  echo '<div class="main-content__links">';
  foreach ($items as $item) {
    $title = $item['title'] ?? '';
    $description = $item['description'] ?? '';
    $link = $item['link'] ?? [];
    $url = is_array($link) ? ($link['url'] ?? '') : '';
    $target = is_array($link) && !empty($link['target']) ? $link['target'] : '_self';
    $rel = $target === '_blank' ? 'noopener noreferrer' : '';

    if (!$title && !$description) {
      continue;
    }

    $tag = $url ? 'a' : 'div';
    echo '<' . $tag . ' class="main-content__link"';
    if ($url) {
      echo ' href="' . esc_url($url) . '" target="' . esc_attr($target) . '" rel="' . esc_attr($rel) . '"';
    }
    echo '>';
    echo '<span class="main-content__link-copy">';
    if ($title) {
      echo '<span class="main-content__link-title">' . esc_html($title) . '</span>';
    }
    if ($description) {
      echo '<span class="main-content__link-description">' . esc_html($description) . '</span>';
    }
    echo '</span>';
    echo '<span class="main-content__link-arrow" aria-hidden="true">&#8599;</span>';
    echo '</' . $tag . '>';
  }
  echo '</div>';
};
?>
<div class="main-content__inner">
  <?php if ($local_heading || !empty($local_markets)): ?>
    <div class="main-content__group">
      <h2 class="main-content__heading"><?php echo esc_html($local_heading); ?></h2>
      <?php $render_market_links($local_markets); ?>
    </div>
  <?php endif; ?>

  <?php if ($special_heading || !empty($special_markets)): ?>
    <div class="main-content__group">
      <h2 class="main-content__heading"><?php echo esc_html($special_heading); ?></h2>
      <?php $render_market_links($special_markets); ?>
    </div>
  <?php endif; ?>
</div>

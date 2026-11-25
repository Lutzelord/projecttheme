<?php
/**
 * Market Button linking to the Market_Subpage.
 */

$args = isset($args) && is_array($args) ? $args : [];
$title = $args['title'] ?? get_sub_field('title');
$description = $args['description'] ?? get_sub_field('description');
$page_link = $args['market_subpage'] ?? get_sub_field('market_subpage');
$fallback_link = $args['fallback_link'] ?? get_sub_field('fallback_link');

$url = is_string($page_link) ? $page_link : '';
if (!$url) {
  $market_page = get_page_by_path('market_subpage', OBJECT, 'page');
  if (!$market_page) {
    $market_page = get_page_by_path('market-subpage', OBJECT, 'page');
  }
  if (!$market_page) {
    $market_pages = get_posts([
      'post_type' => 'page',
      'post_status' => 'publish',
      'title' => 'Market_Subpage',
      'numberposts' => 1,
    ]);
    $market_page = $market_pages ? $market_pages[0] : null;
  }
  $url = $market_page ? get_permalink($market_page) : '';
}

$target = is_array($fallback_link) && !empty($fallback_link['target'])
  ? $fallback_link['target']
  : '_self';
if (!$url && is_array($fallback_link)) {
  $url = $fallback_link['url'] ?? '';
}
$rel = $target === '_blank' ? 'noopener noreferrer' : '';
$embedded = !empty($args['embedded']);

if (!$embedded):
?>
<div class="market-button__container">
<?php endif; ?>
  <?php if ($title || $description): ?>
    <?php $tag = $url ? 'a' : 'div'; ?>
    <<?php echo $tag; ?> class="main-content__link market-button"<?php if ($url): ?>
      href="<?php echo esc_url($url); ?>"
      target="<?php echo esc_attr($target); ?>"
      rel="<?php echo esc_attr($rel); ?>"
    <?php endif; ?>>
      <span class="main-content__link-copy">
        <?php if ($title): ?>
          <span class="main-content__link-title"><?php echo esc_html($title); ?></span>
        <?php endif; ?>
        <?php if ($description): ?>
          <span class="main-content__link-description"><?php echo esc_html($description); ?></span>
        <?php endif; ?>
      </span>
      <span class="main-content__link-arrow" aria-hidden="true">
        <?php get_template_part('template-parts/components/icon-arrow-up-right'); ?>
      </span>
    </<?php echo $tag; ?>>
  <?php endif; ?>
<?php if (!$embedded): ?>
</div>
<?php endif; ?>

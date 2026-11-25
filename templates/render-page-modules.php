<?php
/**
 * Rendert die ACF Flexible-Content-Felder aus `page_modules`
 * Erwartet pro Layout ein Partial unter: /template-parts/flex/layout-*.php
 */

if (!function_exists('have_rows') || !have_rows('page_modules')) {
  return;
}

$rendered_modules = [];

while (have_rows('page_modules')) : the_row();
  $layout = get_row_layout();
  ob_start();

  // Section-Optionen 
  $opts = [
    'name'       => $layout,
    'container'  => get_sub_field('container') ?: 'container-lg',
    'padding_y'  => get_sub_field('padding_y') ?: 'py-5',
    'bg'         => get_sub_field('background') ?: 'none',
    'id'         => get_sub_field('id-anchor') ?: '',
    'show_on'    => get_sub_field('show-on') ?: 'everywhere',
  ];

  if ($layout === 'hero') {
    $opts['container'] = 'none';
    $opts['padding_y'] = '0';
  }

  // Öffne Section-Hülle nur, wenn Helper existieren – sonst simple Wrapper
  if (function_exists('section_open')) {
    section_open($opts);
  } else {
    $name = $opts['name'];
    $id   = $opts['id'] ? ' id="'.esc_attr($opts['id']).'"' : '';
    $cont = $opts['container'];
    $py   = $opts['padding_y'];
    echo '<section'.$id.' class="'.$name.' '.$py.'">';
    if ($cont !== 'none') echo '<div class="'.$cont.'">';
  }

  switch ($layout) {
    case 'hero':
      get_template_part('template-parts/flex/layout', 'hero'); break;

    case 'intro':
      get_template_part('template-parts/flex/layout', 'intro'); break;

    case 'cta_button':
      get_template_part('template-parts/flex/layout', 'cta-button'); break;

    case 'main_content':
      get_template_part('template-parts/flex/layout', 'main-content'); break;

    case 'market_button':
      get_template_part('template-parts/flex/layout', 'market-button'); break;

    case 'text_1col':
      get_template_part('template-parts/flex/layout', 'text-1col'); break;

    case 'text_2col':
      get_template_part('template-parts/flex/layout', 'text-2col'); break;

    case 'text_3col':
      get_template_part('template-parts/flex/layout', 'text-3col'); break;

    case 'text_4col':
      get_template_part('template-parts/flex/layout', 'text-4col'); break;

    case 'text_left_image_right':
      get_template_part('template-parts/flex/layout', 'text-left-image-right'); break;

    case 'image_left_text_right':
      get_template_part('template-parts/flex/layout', 'image-left-text-right'); break;

    case 'image_slider':
      get_template_part('template-parts/flex/layout', 'image-slider'); break;

    case 'bildboxen':
      get_template_part('template-parts/flex/layout', 'bildboxen'); break;

    case 'galerie':
      get_template_part('template-parts/flex/layout', 'galerie'); break;

    case 'tabs':
      get_template_part('template-parts/flex/layout', 'tabs'); break;

    case 'akkordeon':
      get_template_part('template-parts/flex/layout', 'akkordeon'); break;

    case 'breaker':
      get_template_part('template-parts/flex/layout', 'breaker'); break;

    case 'code_editor':
      get_template_part('template-parts/flex/layout', 'code-editor'); break;

    case 'google_map':
      get_template_part('template-parts/flex/layout', 'google-map'); break;

     case 'project_highlight':
      get_template_part('template-parts/flex/layout', 'project-highlight'); break;
  }

  if (function_exists('section_close')) {
    section_close($opts);
  } else {
    if ($opts['container'] !== 'none') echo '</div>';
    echo '</section>';
  }

  $rendered_modules[] = [
    'layout' => $layout,
    'output' => ob_get_clean(),
  ];

endwhile;

$hero_index = null;
$intro_index = null;
$main_content_index = null;
foreach ($rendered_modules as $index => $module) {
  if ($module['layout'] === 'hero' && $hero_index === null) {
    $hero_index = $index;
  }
  if ($module['layout'] === 'intro' && $intro_index === null) {
    $intro_index = $index;
  }
  if ($module['layout'] === 'main_content' && $main_content_index === null) {
    $main_content_index = $index;
  }
}

$anchor_index = $intro_index;
$anchor_layout = 'intro';
if ($hero_index !== null && ($anchor_index === null || $hero_index > $anchor_index)) {
  $anchor_index = $hero_index;
  $anchor_layout = 'hero';
}

if ($anchor_index !== null && $main_content_index !== null && $main_content_index < $anchor_index) {
  $main_content = array_splice($rendered_modules, $main_content_index, 1);
  $anchor_index = array_search($anchor_layout, array_column($rendered_modules, 'layout'), true);
  array_splice($rendered_modules, $anchor_index + 1, 0, $main_content);
}

foreach ($rendered_modules as $module) {
  echo $module['output'];
}
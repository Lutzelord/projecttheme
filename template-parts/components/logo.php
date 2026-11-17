<?php
/**
 * Site logo component.
 *
 */

$logo_url  = get_template_directory_uri() . '/assets/images/logo.svg';
$site_name = get_bloginfo( 'name' );
?>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( $site_name ); ?>">
  Local Flea Markets
  </a>

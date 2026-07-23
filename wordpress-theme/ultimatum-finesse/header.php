<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>document.documentElement.classList.add('js');</script><!-- gates .reveal hidden state on JS so content is never stuck invisible -->
<link rel="icon" href="<?php echo esc_url( get_template_directory_uri() . '/assets/logo-mark.jpg' ); ?>" type="image/jpeg">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php if ( uf_page_uses_leaflet() ) : ?>
<link rel="preconnect" href="https://unpkg.com">
<link rel="preconnect" href="https://server.arcgisonline.com">
<?php endif; ?>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600;700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600;700&display=swap" rel="stylesheet">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<a class="skip-link" href="#main">Skip to content</a>

<header class="site-header">
  <div class="container">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="brand">
      <span class="brand-logo-badge"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/logo-full.jpg' ); ?>" width="1200" height="335" alt="Ultimatum Finesse: Providing Geospatial Knowledge"><span class="logo-spark" aria-hidden="true"></span></span>
    </a>
    <nav class="main-nav">
      <?php
      wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'items_wrap'     => '<ul>%3$s</ul>',
        'fallback_cb'    => false,
      ) );
      ?>
    </nav>
    <div class="header-actions">
      <a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="btn btn-primary">Get a Quote</a>
      <button class="nav-toggle" aria-label="Toggle menu"><span></span></button>
    </div>
  </div>
</header>

<main id="main">

<?php get_header(); ?>

<section class="page-hero">
  <div class="container">
    <div class="breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> / <?php the_title(); ?></div>
    <?php while ( have_posts() ) : the_post(); ?>
    <h1><?php the_title(); ?></h1>
    <?php endwhile; ?>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="page-content-block reveal">
      <?php
      if ( have_posts() ) :
        while ( have_posts() ) : the_post();
          the_content();
        endwhile;
      endif;
      ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>

<?php
/**
 * Fallback template. This theme's real templates are front-page.php,
 * page.php, and the page-*.php Page Attribute templates; index.php is
 * WordPress's required catch-all (and is what WP checks for to confirm
 * a valid theme), used for anything those don't cover.
 */
get_header();
?>

<section class="section">
  <div class="container">
    <?php if ( have_posts() ) : ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class(); ?>>
          <h1><?php the_title(); ?></h1>
          <?php the_content(); ?>
        </article>
      <?php endwhile; ?>
    <?php else : ?>
      <p><?php esc_html_e( 'Nothing found.', 'ultimatum-finesse' ); ?></p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>

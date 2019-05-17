<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */


  get_header();
?> 

  <main id="main" class="site-main container" role="main">
  	    
  	<section class="error-404 not-found">
  		<img src="<?php bloginfo( 'template_directory' ); ?>/imagens/erro-404.jpg" class="img-responsive">
	</section><!-- .error-404 -->

  </main><!-- #main -->

<?php get_footer(); ?>
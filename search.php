<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
global $wp_query;
get_header(); ?> 

	<section id="primary" class="content-area">
		<header id="pagina_cabecalho"><div class="container"><div class="col-md-12">';
        <h1 id="titulo_pagina">Pesquisa</h1>
   		</div></div></header>
		<main id="search_page" class="site-main container" role="main">
			<div class="col-md-8">
				<div class="col-md-8 tipo_3 destaque_categorias">
					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h2 class="page-title"><?php printf( 'Resultados para: %s', get_search_query() ); ?></h2>
						</header><!-- .page-header -->

						<?php
						// Start the loop.
						while ( have_posts() ) : the_post(); ?>

							<?php
							/*
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'content', 'search' );

						// End the loop.
						endwhile;

					// If no content, include the "No posts found" template.
					else :
						get_template_part( 'content', 'none' );

					endif;
					?>

					<?php 
						if (function_exists("wp_bs_pagination"))
						    {
						         //wp_bs_pagination($the_query->max_num_pages);
						         wp_bs_pagination();
						}
					?> 
				</div>
			</div>
			 <?php get_sidebar(); ?>
		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>

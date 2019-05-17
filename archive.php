<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?> 

 <main id="main" class="site-main container" role="main">
 <div class="col-md-8">
                <header id="pagina_cabecalho">
                    <div class="col-md-12">
                        <span class="meta-category"><a href="<?php echo $link_categoria;?>" class="category-2"><?php echo ($Id_categoria != 1 ? strtolower($Nome_categoria) : ''); ?></a></span>
                        <?php  
                            the_title( '<h1 id="titulo_pagina">', '</h1>' );
                            echo '
                                <div class="col-md-12 entry-meta">
                                    <div class="meta-item date">
                                        <span class="updated">
                                            '.data_amigavel().'
                                        </span>
                                    </div>
                                    <div class="meta-item comments">
                                        <a href="#comments">
                                            '.get_comments_number().' Comentarios
                                        </a>
                                    </div>
                                    <div class="meta-item author">
                                        <span class="vcard author">
                                            <span class="fn">
                                                Por '.get_the_author_link().'
                                            </span>
                                        </span>
                                    </div>
                                    <div class="meta-item views">
                                        '.$views.' Visualizações
                                    </div>
                                </div>';
                        ?>


                    </div>
                </header>

                <section id="post_thumbnail" class="">
                        <img src="<?php echo $img; ?>" alt="" id="post_thumbnail">
                        <div id="topo_mostra_autor">
                            <img src="<?php echo get_avatar_url(get_the_author_ID());?>" alt="">
                            <div class="meta-author-wrapped">Escrito por <span class="vcard author"><span class="fn"><?php echo get_the_author_link(); ?></span></span></div>
                        </div>
                </section>
                <section class="conteudo_post">


                    <div id="texto_post">
                        <?php  the_content(); ?>
                    </div>
                    
                    <?php 
                        // If comments are open or we have at least one comment, load up the comment template.
                        // if ( comments_open() || get_comments_number() ) :
                        //     comments_template();
                        // endif;
                    ?> 
                </section>
                <section id="comenarios">
                    <div class="barra_coment"><div class="topo_coment"><i class="fa fa-comments" aria-hidden="true"></i><b>COMENTE</b></div></div>
                    <div class="fb-comments" data-href="<?php echo get_permalink();?>" data-width="100%" data-numposts="15"></div>
                </section>
            </div>
            <?php get_sidebar(); ?>

            

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentyfifteen' ),
				'next_text'          => __( 'Next page', 'twentyfifteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyfifteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_footer(); ?>

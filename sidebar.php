<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */ 

	if ( has_nav_menu( 'primary' ) || has_nav_menu( 'social' ) || is_active_sidebar( 'barra_lateral' )  ) : ?>



	<?php
		if(is_page('blog')){
			if ( is_active_sidebar( 'sidebar_blog' ) ) : ?>
				<div class="sidebar col-md-4">	 
					<?php dynamic_sidebar( 'sidebar_blog' ); ?>
			    </div>
			<?php endif; 

		}else{
		?>
			<?php if ( is_active_sidebar( 'barra_lateral' ) ) : ?>
				<div class="sidebar col-md-4">	 
					<?php dynamic_sidebar( 'barra_lateral' ); ?>
			    </div>
			<?php endif;

		} ?>

			 


<?php endif; ?>


	

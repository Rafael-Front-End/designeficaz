<?php
/**
* A Simple Category Template
*/

get_header(); 


if(isset($_GET['author_name'])) :
	$curauth = get_userdatabylogin($author_name);
else :
	$curauth = get_userdata(intval($author));
endif;

?> 


<main id="pagina_author" class="site-main container" role="main">
	<div class="col-md-12">
		<div class="meta-item author">
			
            <img class="img-thumbnail" src='<?php echo get_avatar_url(get_the_author_ID());?>'>
            <span class="vcard author">
                <span class="fn">
                <h4><?php echo $curauth->display_name; ?></h4>
        		<p><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></p>
        		<?php if($curauth->user_description != NULL){ ?>
        		<p><h4>Informações biográficas</h4></p>
        		<p><?php echo $curauth->user_description; ?></p>
        		<?php } ?>
                	<div class="social-link-info clearfix nav-social-wrap">
	                	<?php  
	                		if($curauth->twitter){
	                			echo '<a class="color-twitter" href="'.$curauth->twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>';
	                		}

	                		if($curauth->facebook){
	                			echo '<a class="color-facebook" href="'.$curauth->facebook.'" target="_blank"><i class="fa fa-facebook"></i></a>';
	                		}
	                		if($curauth->g_plus){
	                			echo '<a class="color-plus" href="'.$curauth->g_plus.'" target="_blank"><i class="fa fa-google-plus"></i></a>';
	                		}
	                		if($curauth->pinterest){
	                			echo '<a class="color-pinterest" href="'.$curauth->pinterest.'" target="_blank"><i class="fa fa-pinterest"></i></a>';
	                		}
	                		if($curauth->instagram){
	                			echo '<a class="color-instagram" href="'.$curauth->instagram.'"><i class="fa fa-instagram"></i></a>
	';
	                		}
	                		if($curauth->youtube){
	                			echo '<a class="color-youtube" href="'.$curauth->youtube.'" target="_blank"><i class="fa fa-youtube"></i></a>';
	                		}
	                	?>    
		            </div>

		            <hr>

                </span>
            </span>
        </div>


	</div>
	<div class="col-md-12">
		<div class="destaque_categorias">
			<h3><span>Posts escritos pelo autor</span></h3>
			<?php 

			// query_posts('posts_per_page=6');
			// Check if there are any posts to display
			// $the_query = new WP_Query(array('posts_per_page'=>6,'author'=>get_the_author_ID()) );
			if ( have_posts() ) : 
			$contador = 0;
			// The Loop
			while ( have_posts() ) : the_post(); 
				$contador++;

              	if ( has_post_thumbnail() ) {
               		$the_post_thumbnail = get_the_post_thumbnail_url();
              	} else { 
	            	$the_post_thumbnail = get_bloginfo('template_directory')."/imagens/default-image.png";
	            } 

				$cat_inf    = get_the_category();
                $cat_inf    = $cat_inf[0];
                $url        = get_permalink();
                $img        = $the_post_thumbnail;
                $cat_name   = get_cat_name($cat_inf->cat_ID);
                $cat_link   = get_category_link($cat_inf->cat_ID);
                $titulo     = get_the_title();
                $titulo     = resumo_txt($titulo,120,0);
                $resumo     = resumo_txt(get_the_excerpt(),120,0);
                $data_post  = get_the_date('d').' de '.get_the_date('M').' de '.get_the_date('Y');
                $autor      = get_the_author();
                $autor_link = get_author_posts_url(get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));
                $id_post    = get_the_ID();
                $html_link_cat = "<a class='titlecat'  href='{$cat_link}'>{$cat_name}</a>";


				$html_categoria_cultura .='
                      <div class="bloco_post esquerda col-md-4">
                        '.$html_link_cat.'
                        <a href="'.$url.'" class="thumbnail_post" style="background-image:url('.$img.');"></a>
                        <a href="'.$url.'"><span style="'.$cor_txt.$fontes.'">'.$titulo.'</span></a>
                        <p>por <a href="'.$autor_link.'" class="author">'.$autor.'</a> | '.$data_post.'</p>
                      </div>
                    ';
	           
			 endwhile; 
			 echo $html_categoria_cultura;

				if (function_exists("wp_bs_pagination")):
				
				         //wp_bs_pagination($the_query->max_num_pages);
					echo "<div class='col-md-12'>";
				         wp_bs_pagination();
		         	echo "</div>";
				endif;
	 

			else: ?>
				<p>Não existem posts para esta categoria!</p>
			<?php endif; wp_reset_postdata();?>

		</div>
	</div>
</main>
<?php get_footer(); ?>

<?php
/**
* A Simple Category Template
*/

get_header(); 

?> 


<main id="pagina_categoria" class="site-main container" role="main">
	<div class="col-md-8">
		<div class="destaque_categorias">
		<?php 
			// Check if there are any posts to display
		if ( have_posts() ) : 
	 

			echo '<h3 id="titulo_pagina"><span>'.single_tag_title( '', false ).'</span><div class="theme-border-color"></div></h3>'; 
			
			if ( tag_description() ) : 
				echo "<p class='txt_descricao'>".strip_tags(tag_description())."</p><h3></h3>"; 
			endif; 
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
				$url        = get_permalink();
				$img        = $the_post_thumbnail;
				$cat_name   = get_cat_name($cat_inf->cat_ID);
				$titulo     = resumo_txt(get_the_title(),45,0);
				$resumo     = resumo_txt(get_the_excerpt(),70,0);
				$data_post  = get_the_date('d M Y');
				$autor      = get_the_author();
				$id_post    = $post->ID;
			

				if(TEMA_TAG == 2){
					$html_categoria_cultura .='
				        <div class="tipo_1	 destaque_categorias">
				            '.($contador == 1 ? '' : '<h3></h3>').'
		                    <div class="bloco_post">
		                    	<a href="'.$url.'"  class="thumbnail_post" style="background-image:url('.$img.');"></a>
		                        <div class="content_post">
		                          <h4>'.$titulo.'</h4>
		                          <p>'.$resumo.'...</p>
		                          <p>
		                          	<a href="'.$url.'" class="btn btn-default bloco_post">Leia mais</a></a>
		                          </p>
		                        </div>
		                    </div>
				        </div>
	                  ';
	            }else if(TEMA_TAG == 3){
					$html_categoria_cultura .='
						<a class="bloco_post esquerda col-md-6" href="'.$url.'">
							<div  class="thumbnail_post" style="background-image:url('.$img.');"></div>
							<h4>'.$titulo.'</h4>
	                    </a>
	                  ';
	            }else if(TEMA_TAG == 4){
					$html_categoria_cultura .='
				        <div class="bloco_post esquerda col-md-4">
	                      <a href="'.$url.'"  class="thumbnail_post" style="background-image:url('.$img.');"></a>
	                      <h4>'.$titulo.'</h4>
	                      <p>'.$resumo.'</p>
	                    </div>
	                  ';
	            }else if(TEMA_TAG == 5){

	            	$html_categoria_cultura .='
		        		<a href="'.$url.'" class="bloco_categoria col-md-6" style="background-image: url('.$img.');">
		                    <div class="content-post">
		                      <h3>'.$titulo.'</h3>
		                      <p>'.$resumo.'...</p>
		                    </div>
		                </a>
		              ';
					
	            }else{
		        	

		              $html_categoria_cultura .='
				        <div class="tipo_1 destaque_categorias">
				            '.($contador == 1 ? '' : '<h3></h3>').'
		                    <div class="bloco_post">
		                    	<a href="'.$url.'"  class="thumbnail_post" style="background-image:url('.$img.');"></a>
		                        <a href="'.$url.'" class="content_post">
		                          <h4>'.$titulo.'</h4>
		                          <p>'.$resumo.'...</p>
		                        </a>
		                    </div>
				        </div>
	                  ';
	            }
			 endwhile; 
			 echo $html_categoria_cultura;

				if (function_exists("wp_bs_pagination")):
				
				         //wp_bs_pagination($the_query->max_num_pages);
				         					echo "<div class='col-md-12'>";
				         wp_bs_pagination();
		         	echo "</div>";
				endif;
	 

			else: ?>
				<p>Desculpe, nenhum post corresponde aos seus critérios de busca.</p>
			<?php endif; ?>

		</div>
	</div>
	<?php get_sidebar(); ?>
</main>
<?php get_footer(); ?>

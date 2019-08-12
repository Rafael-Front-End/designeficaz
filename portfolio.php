<?php
/**
Template Name: Portfólio
*/
  
get_header(); 

    echo '<header id="pagina_cabecalho"><div class="container"><div class="col-md-12">';
        the_title( '<h1 id="titulo_pagina">', '</h1>' );
    echo '</div></div></header>';
?> 
    <div id='pagina_portfolio'>
            <?php

              if(get_option('tema_zflag_galeria')){
                $tema_zflag_galeria = json_decode(get_option('tema_zflag_galeria'));
                $tema_zflag_galeria = (array) $tema_zflag_galeria;
                 
                foreach ($tema_zflag_galeria as $key => $value) {
                  $vetor_galeria  = (array) $value;
                  $titulo = $vetor_galeria['titulo'];
                  $slug = str_replace(" ", "_", trim($titulo));

                   $html_categorias .= '<li>
                                  <a href="#" data-filter=".'.$slug.'">'.$titulo.'</a>
                                </li>';


                  $imagem = $vetor_galeria['imagem'];
                  if($imagem != NULL){
                    $vetor_img = explode(', ', $imagem);
                    
                    foreach ($vetor_img as $key => $value) {
                      $thumbnail   =   wp_get_attachment_image_src(intval($value));
                      $img         =   wp_get_attachment_url($value);
                      
                     
                      $html_galeria .='
                        <!-- single-awesome-project start -->
                          <div class="col-md-4 col-sm-4 col-xs-12 photo '.$slug.'">

                            <div class="single-awesome-project">
                              <div class="awesome-img">
                                <a href="#"><img class="hovercinza" width="100%" height="auto" src="'.$thumbnail[0].'" alt="" />
                            <div class="degrade"></div>
                            </a>
                                <div class="add-actions text-center">
                                  <div class="project-dec">
                                    <a class="venobox" data-gall="myGallery" href="'.$img.'">
                                      <h4>'.get_the_title( intval($value) ).'</h4>
                                      <span></span>
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- single-awesome-project end -->
                       ';

                    }
                  }

                  

                }

                $galeria_html = '
                  <!-- Start portfolio Area -->
                  <div id="portfolio" class="portfolio-area area-padding fix">
                      <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="section-headline text-center">
                            <h2>'.$title.'</h2>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <!-- Start Portfolio -page -->
                        <div class="awesome-project-1 fix">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="awesome-menu ">
                              <ul class="project-menu">
                                '.$html_categorias.'
                              </ul>
                            </div>
                          </div>
                        </div>
                        <div class="awesome-project-content">
                          '.$html_galeria.'
                        </div>
                      </div>
                  </div>
                  <!-- awesome-portfolio end -->
                ';

                  echo do_shortcode($galeria_html);
              }

            ?>
          </div>

 <div class="col-md-12 social_footer">
    <h3>Também estamos aqui</h3>
    <p>Acompanhe nosso trabalho em outras plataformas</p>
    <div id="rodape_social_icons" class="social-links">
      <a target="_blank" href="https://www.facebook.com/designeficaz/"><img class="img-responsive" src="<?php echo get_bloginfo('url'); ?>/wp-content/themes/designeficaz/imagens/espera/redes-sociais-facebook.jpg"></a>
      
      <a target="_blank" href="https://www.instagram.com/designeficaz/"><img class="img-responsive" src="<?php echo get_bloginfo('url'); ?>/wp-content/themes/designeficaz/imagens/espera/redes-sociais-instagram.jpg"></a>
      
      <a target="_blank" href="https://www.behance.net/danieldesouz4"><img class="img-responsive" src="<?php echo get_bloginfo('url'); ?>/wp-content/themes/designeficaz/imagens/espera/redes-sociais-behance.jpg"></a>
      <a target="_blank" href="https://www.colab55.com/@danieldesouz4"><img class="img-responsive" src="<?php echo get_bloginfo('url'); ?>/wp-content/themes/designeficaz/imagens/espera/redes-sociais-colab55.jpg"></a>
      
      
    </div>
<?php get_footer(); ?>

<?php

/* Widget para ZflagGalerias com posts recentes */

class ZflagGaleriaHome extends WP_Widget
{
    function __construct()
    {
        parent::__construct("ZflagGaleria_home", "Zflag portfólio", array('description' => "Exibe o porfólio principal"));
    }

  public function widget($args, $instance)
  {
        echo $args["before_widget"];

        $title = $instance['title'];
        $html_categorias = '';
        $html_galeria_home = '';
        if(get_option('tema_zflag_galeria_home')){
          $tema_zflag_galeria_home = json_decode(get_option('tema_zflag_galeria_home'));
          $tema_zflag_galeria_home = (array) $tema_zflag_galeria_home;
           
          foreach ($tema_zflag_galeria_home as $key => $value) {
            $vetor_galeria_home  = (array) $value;
            $titulo = $vetor_galeria_home['titulo'];
            $slug = str_replace(" ", "_", trim($titulo));

             $html_categorias .= '<li>
                            <a href="#" data-filter=".'.$slug.'">'.$titulo.'</a>
                          </li>';


            $imagem = $vetor_galeria_home['imagem'];
            if($imagem != NULL){
              $vetor_img = explode(', ', $imagem);
              
              foreach ($vetor_img as $key => $value) {
                $thumbnail   =   wp_get_attachment_image_src(intval($value), 'medium');
                $img         =   wp_get_attachment_url($value);
                
               
                $html_galeria_home .='
                  <!-- single-awesome-project start -->
                    <div class="col-md-4 col-sm-4 col-xs-12 photo '.$slug.'">
                      <div class="single-awesome-project">
                        <div class="awesome-img">
                          <a href="#"><img width="100%" height="auto" src="'.$thumbnail[0].'" alt="" /></a>
                          <div class="add-actions text-center">
                            <div class="project-dec">
                              <a class="venobox" data-gall="myGallery" href="'.$img.'">
                                <h4>'.get_the_title( intval($value) ).'</h4>
                                <span>'.wp_get_attachment_caption( intval($value) ).'</span>
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

          $galeria_home_html = '
            <!-- Start portfolio Area -->
            <div id="pagina_portfolio">
              <div id="portfolio" class="portfolio-area area-padding fix">
                <div class="row">
                  <!-- Start Portfolio -page -->
                  <div class="awesome-project-content">
                    '.$html_galeria_home.'
                    <a class="link_de_indicacao" href="'.get_permalink( get_page_by_path( 'portfolio' ) ).'">Ver Portfólio completo<span class="right-arrow"></span></a>
                  </div>
                </div>
              </div>
            </div>
            <!-- awesome-portfolio end -->
          ';

            echo do_shortcode($galeria_home_html);
        }
           
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {


    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }
    else
    {
      $title = "";
    }


    echo 'As configurações estão presentes no menu "Configurações do tema" -> "Galeria_home", é necessario esta com o tema zflag instalado no wordpress';
  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();

    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("ZflagGaleriaHome"); });
<?php

/* Widget para ZflagGalerias com posts recentes */

class ZflagGaleria extends WP_Widget
{
    function __construct()
    {
        parent::__construct("ZflagGaleria", "Zflag Galeria", array('description' => "Exibe o galeria principal"));
    }

  public function widget($args, $instance)
  {
        echo $args["before_widget"];

        $title = $instance['title'];
        $html_categorias = '';
        $html_galeria = '';
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
                $thumbnail   =   wp_get_attachment_image_src(intval($value), 'medium');
                $img         =   wp_get_attachment_url($value);
                
               
                $html_galeria .='
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

          $galeria_html = '
            <!-- Start portfolio Area -->
            <div id="portfolio" class="portfolio-area area-padding fix">
              <div class="container">
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
                          <li>
                            <a href="#" class="active" data-filter="*">All</a>
                          </li>
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
            </div>
            <!-- awesome-portfolio end -->
          ';

            echo do_shortcode($galeria_html);
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

    ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>" > <?php _e("Titulo:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
            <div style="font:12px; color:#666;"> </div>
        </p>
    <?php
    echo 'As configurações estão presentes no menu "Configurações do tema" -> "Galeria", é necessario esta com o tema zflag instalado no wordpress';
  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title']        = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');

    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("ZflagGaleria"); });
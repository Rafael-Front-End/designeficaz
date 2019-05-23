<?php

/* Widget para slide_pagina_inicials com posts recentes */

class slide_pagina_inicial extends WP_Widget
{
    function __construct()
    {
        parent::__construct("slide_pagina_inicial", "Zflag Slide principal", array('description' => "Exibe o slide principal"));
    }

  public function widget($args, $instance)
  {
       echo $args["before_widget"];

       
        if(get_option('tema_zflag_slide_principal')){
          $tema_zflag_slide_principal = json_decode(get_option('tema_zflag_slide_principal'));
          $tema_zflag_slide_principal = (array) $tema_zflag_slide_principal;
           $contador_de_post = 0;
           $html_slide_img = $html_slide_txt = '';

          foreach ($tema_zflag_slide_principal as $key => $value) {
            $contador_de_post++;
            $value = (array) $value;
            $titulo = $value['titulo'];
            $texto = '<h1 class="title2">'.stripslashes($value['texto']).'</h1>';
            $imagem = $value['imagem'];
            $video = $value['video'];

            if($video != NULL){
              $texto = '
              <div class="video_slide">
              <div class="embed-responsive embed-responsive-16by9 p-t-16">
                <div class="videoWrapper">
                  <iframe width="640" height="360" src="'.$video.'" frameborder="0" allowfullscreen="" builderautoplay="0"></iframe>
                </div>
              </div>
              </div>


              ';
            }


            $html_slide_img .= '<img src="'.$imagem.'" alt="" title="#slider-direction-'.$key.'" />';
            if(count($tema_zflag_slide_principal) > 1){
                $html_slide_txt .= '

                  <!-- direction '.$key.' -->
                  <div id="slider-direction-'.$key.'" class="slider-direction slider-two">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="slider-content text-center">
                              <!-- layer 1 -->
                              <div class="layer-1-1 hidden-xs wow slideInDown" data-wow-duration="2s" data-wow-delay=".2s">
                                <h2 class="title1">'.$titulo.'</h2>
                              </div>

                              <!-- layer 2 -->
                              <div class="layer-1-2 wow slideInUp" data-wow-duration="2s" data-wow-delay=".1s">
                                '.$texto.'
                              </div>

                              <!-- layer 3 -->
                              <div class="layer-1-3 wow slideInUp" data-wow-duration="2s" data-wow-delay=".2s">
                                <a class="ready-btn page-scroll" href="#about">Quero fazer parte</a>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                ';
              }else{
                $html_slide_txt .= '

                  <!-- direction '.$key.' -->
                  <div id="slider-direction-'.$key.'" class="slider-direction slider-two">
                    <div class="container">
                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="slider-content text-center">
                              <!-- layer 1 -->
                              <div class="layer-1-1 hidden-xs wow" data-wow-duration="2s" data-wow-delay=".2s">
                                <h2 class="title1">'.$titulo.'</h2>
                              </div>

                              <!-- layer 2 -->
                              <div class="layer-1-2 wow" data-wow-duration="2s" data-wow-delay=".1s">
                                <h1 class="title2">'.$texto.'</h1>
                              </div>

                              <!-- layer 3 -->
                              <div class="layer-1-3 wow" data-wow-duration="2s" data-wow-delay=".2s">
                                <a class="ready-btn page-scroll" href="#about">Quero fazer parte</a>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <style>
                  .nivo-controlNav,
                    .nivo-directionNav {
                        display: none;
                    }
                  </style>
                ';
              }
          }

         

          $slide_html = 
          '<!-- Start Slider Area -->
            <div id="home" class="slider-area">
              <div class="bend niceties preview-2">
                <div id="ensign-nivoslider" class="slides">
                  '.$html_slide_img.'
                </div>
                '.$html_slide_txt.'    
              </div>
            </div>';

            echo do_shortcode($slide_html);
        }
           
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {
    echo 'As configurações estão presentes no menu "Configurações do tema" -> "Slide", é necessario esta com o tema zflag instalado no wordpress';
  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();

    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("slide_pagina_inicial"); });
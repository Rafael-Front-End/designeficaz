<?php

/* Widget para zflag_planos com posts recentes */

class zflag_planos extends WP_Widget
{
    function __construct()
    {
        parent::__construct("zflag_planos", "Zflag Pacotes/Planos", array('description' => "Exibe o bloco de serviços"));
    }

  public function widget($args, $instance)
  {
        echo $args["before_widget"];

     
         if(get_option('tema_zflag_planos')){
            $tema_zflag_planos = json_decode(get_option('tema_zflag_planos'));
            $tema_zflag_planos = (array) $tema_zflag_planos;
             $contador_de_post = 0;
             $html_planos = $li_menu = '';
            foreach ($tema_zflag_planos as $key => $value) {
              $contador_de_post++;
              $value = (array) $value;
              $titulo = $value['titulo'];
              $texto = stripslashes($value['texto']);
              $link = $value['link'];
              $li_menu .=    '<li class="'.($contador_de_post == 1 ? 'active' : '').'">
                        <a href="#p-view-'.$contador_de_post.'" role="tab" data-toggle="tab">'.$titulo.'</a>
                      </li>';
              $html_planos .='
                <div class="tab-pane '.($contador_de_post == 1 ? 'active' : '').'" id="p-view-'.$contador_de_post.'">
                  <div class="tab-inner">
                    <div class="event-content head-team">
                      <h4>'.$titulo.'</h4>
                      <p>'.$texto.'</p>
                      <a href="'.$link.'" class="ready-btn">Quero fazer parte</a>
                    </div>
                  </div>
                </div>
                '; 
            }

           

            $html = 
            '<!-- Faq area start -->
          <div id="faq-area" class="faq-area area-padding">
            <div class="container">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="section-headline text-center">
                    <h4 style="margin-bottom:0;">Conheça</h4>
                    <h2>Nossos pacotes</h2>
                  </div>
                </div>
              </div>
              <div class="row">
                
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="tab-menu">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                      '.$li_menu.'
                    </ul>
                  </div>
                  <div class="tab-content">
                    '.$html_planos.'
                  </div>
                </div>
              </div>
              <!-- end Row -->
            </div>
          </div>
          <!-- End Faq Area -->';

              echo do_shortcode($html);
          }

    echo $args["after_widget"];
  }
 
  public function form($instance)
  {
    echo 'As configurações estão presentes no menu "Configurações do tema" -> "Pacotes/Planos", é necessario esta com o tema zflag instalado no wordpress';
  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();

    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("zflag_planos"); });
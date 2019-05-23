<?php

/* Widget para zflag_servicoss com posts recentes */

class zflag_servicos extends WP_Widget
{
    function __construct()
    {
        parent::__construct("zflag_servicos", "Zflag Serviços", array('description' => "Exibe o bloco de serviços"));
    }

  public function widget($args, $instance)
  {
        echo $args["before_widget"];

        $title = !empty( $instance['title'] ) ? $instance['title'] : '';
        if(get_option('tema_zflag_servicos')){
          $tema_zflag_servicos = json_decode(get_option('tema_zflag_servicos'));
          $tema_zflag_servicos = (array) $tema_zflag_servicos;
           $contador_de_post = 0;
           $html_servicos = '';
          foreach ($tema_zflag_servicos as $key => $value) {
            $contador_de_post++;
            $value = (array) $value;
            $titulo = $value['titulo'];
            $texto = stripslashes($value['texto']);
            $link = $value['link'];
            $icone = $value['icone'];

            $html_servicos .='
                <!-- Start Left services -->
                <div class="col-md-4 col-sm-4 col-xs-12">
                  <div class="about-move">
                    <div class="services-details">
                      <div class="single-services">
                        <a class="services-icon" href="'.$link.'">
                            <i class="fa '.$icone.'"></i>
                          </a>
                        <h4>'.$titulo.'</h4>
                        <p>
                          '.$texto.'
                        </p>
                      </div>
                    </div>
                    <!-- end about-details -->
                  </div>
                </div>';
           
          }

         

          $html = 
          '<!-- Start Service area -->
        <div id="services" class="services-area area-padding">
          <div class="container">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section-headline services-head text-center">
                  <h2>'.$title.'</h2>
                </div>
              </div>
            </div>
            <div class="row text-center">
              <div class="services-contents">
                '.$html_servicos.'
              </div>
            </div>
          </div>
        </div>
        <!-- End Service area -->';

            echo do_shortcode($html);
        }

    echo $args["after_widget"];
  }
  
  public function form($instance)
  {

    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
    $title = sanitize_text_field( $instance['title'] );
    ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
    
    <?php

    echo 'As configurações estão presentes no menu "Configurações do tema" -> "Serviços", é necessario esta com o tema zflag instalado no wordpress';
  }

  public function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = sanitize_text_field( $new_instance['title'] );
    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("zflag_servicos"); });
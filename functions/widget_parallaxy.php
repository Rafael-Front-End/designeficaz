<?php

/* Widget para parallaxys com posts recentes */

class parallaxy extends WP_Widget
{
    function __construct()
    {
        parent::__construct("parallaxy", "parallaxy", array('description' => "Exibe conteudo de texto ou de shortcode com efeito de parallaxy"));
    }

  public function widget($args, $instance)
  {
        echo $args["before_widget"];

       
       // $instance['design']
        $data_slide_to = 0.;

        $conteudo = do_shortcode($instance['conteudo']);
        $title = $instance['title'];

        echo '
        <!-- Start Wellcome Area -->
        <div class="wellcome-area">
          <div class="well-bg">
            <div class="test-overly"></div>
            <div class="container">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="wellcome-text">
                    <div class="well-text text-center">
                      <h2>'.$title.'</h2>
                      <p>'.$conteudo.'</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Wellcome Area -->';

           
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['conteudo']))
    {
        $conteudo = $instance['conteudo'];
    }

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

         <p>
            <label for="<?php echo $this->get_field_id('conteudo'); ?>" > <?php _e("Conteudo:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('conteudo'); ?>" name="<?php echo $this->get_field_name('conteudo'); ?>" class="widefat" value="<?php echo esc_attr($conteudo); ?>">
        </p>
      




        
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title']        = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    $instance['conteudo']   = (!empty($new_instance['conteudo'])   ?   strip_tags($new_instance['conteudo']) : '');

    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("parallaxy"); });
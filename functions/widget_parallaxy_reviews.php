<?php

/* Widget para widget_parallaxy_reviewss com posts recentes */

class widget_parallaxy_reviews extends WP_Widget
{
    function __construct()
    {
        parent::__construct("widget_parallaxy_reviews", "Zflag Parallaxy Reviews", array('description' => "Exibe conteudo de texto com imagem e efeito parallaxy"));
    }

  public function widget($args, $instance)
  {
        echo $args["before_widget"];

       
       // $instance['design']
        $data_slide_to = 0.;

        $conteudo = do_shortcode($instance['conteudo']);
        $title = $instance['title'];
        $link = $instance['link'];
        $imagem = $instance['image'];

        echo '
          <!-- Start reviews Area -->
          <div class="reviews-area hidden-xs">
            <div class="work-us">
              <div class="work-left-text">
                <a href="'.$link.'">
                    <img src="'.$imagem.'" alt="">
                  </a>
              </div>
              <div class="work-right-text text-center">
                 <h2>'.$title.'</h2>
                <h5>'.$conteudo.'</h5>
                <a href="'.$link.'" class="ready-btn">Conheça nossos protutos</a>
              </div>
            </div>
          </div>
          <!-- End reviews Area -->';

           
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

    if(isset($instance['image']))
    {
      $image = $instance['image'];
    }
    else
    {
      $image = "";
    }

    if(isset($instance['link']))
    {
      $link = $instance['link'];
    }
    else
    {
      $link = "";
    }


    ?>        

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>" > <?php _e("Titulo:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
            <div style="font:12px; color:#666;"> </div>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('link'); ?>" > <?php _e("Link:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" class="widefat" value="<?php echo esc_attr($link); ?>">
            <div style="font:12px; color:#666;"> </div>
        </p>

        <p>
          <label for="<?php echo $this->get_field_id( 'Image' ); ?>"><?php _e( 'Imagem:' ); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_url( $image ); ?>" />
          <button class="upload_image_button button button-primary">Upload Imagem</button>
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
    $instance['link']        = (!empty($new_instance['link'])   ?   strip_tags($new_instance['link']) : '');
    $instance['image']        = (!empty($new_instance['image'])   ?   strip_tags($new_instance['image']) : '');
    $instance['conteudo']   = (!empty($new_instance['conteudo'])   ?   strip_tags($new_instance['conteudo']) : '');

    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("widget_parallaxy_reviews"); });
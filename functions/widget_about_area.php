<?php




class zflag_widget_aboutarea extends WP_Widget {

    function __construct()
    {
        parent::__construct("zflag_widget_aboutarea", "Zflag Bloco Sobre", array('description' => "Bloco para texto sobre empresa."));
    }

  public function widget( $args, $instance ) {

    echo $args["before_widget"];


    /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
    $title = !empty( $instance['title'] ) ? $instance['title'] : '';

    $text = !empty( $instance['text'] ) ? $instance['text'] : '';
    $image = !empty( $instance['image'] ) ? $instance['image'] : '';

      echo '
        <!-- Start About area -->
        <div id="about" class="about-area area-padding">
          <div class="container">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="section-headline text-center">
                  <h2>Sobre nós</h2>
                </div>
              </div>
            </div>
            <div class="row">
              <!-- single-well start-->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="well-left">
                  <div class="single-well">
                    <a href="#">
                        <img src="'.$image.'" alt="">
                      </a>
                  </div>
                </div>
              </div>
              <!-- single-well end-->
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="well-middle">
                  <div class="single-well">
                    <a href="#">
                      <h4 class="sec-head">'.$title.'</h4>
                    </a>
                    <p>
                      '.do_shortcode((!empty( $instance['filter'] ) ? wpautop( $text ) : $text)).'
                    </p>
                    <ul>
                    '.(!empty( $instance['lista1'] ) ? '<li>
                        <i class="fa fa-check"></i> '.$instance['lista1'].'
                      </li>' : '').'
                      '.(!empty( $instance['lista2'] ) ? '<li>
                        <i class="fa fa-check"></i> '.$instance['lista2'].'
                      </li>' : '').'
                      '.(!empty( $instance['lista3'] ) ? '<li>
                        <i class="fa fa-check"></i> '.$instance['lista3'].'
                      </li>' : '').'
                      '.(!empty( $instance['lista4'] ) ? '<li>
                        <i class="fa fa-check"></i> '.$instance['lista4'].'
                      </li>' : '').'
                      '.(!empty( $instance['lista5'] ) ? '<li>
                        <i class="fa fa-check"></i> '.$instance['lista5'].'
                      </li>' : '').'
                    </ul>
                  </div>
                </div>
              </div>
              <!-- End col-->
            </div>
          </div>
        </div>
        <!-- End About area -->  
      ';

echo $args["after_widget"];
  }

 
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = sanitize_text_field( $new_instance['title'] );
    if ( current_user_can( 'unfiltered_html' ) ) {
      $instance['text'] = $new_instance['text'];
    } else {
      $instance['text'] = wp_kses_post( $new_instance['text'] );
    }
    $instance['filter'] = $new_instance['filter'];
    $instance['lista1'] = $new_instance['lista1'];
    $instance['lista2'] = $new_instance['lista2'];
    $instance['lista3'] = $new_instance['lista3'];
    $instance['lista4'] = $new_instance['lista4'];
    $instance['lista5'] = $new_instance['lista5'];
    $instance['image'] = $new_instance['image'];
    return $instance;
  }

  public function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
    $filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
    $lista1 = isset( $instance['lista1'] ) ? $instance['lista1'] : '';
    $lista2 = isset( $instance['lista2'] ) ? $instance['lista2'] : '';
    $lista3 = isset( $instance['lista3'] ) ? $instance['lista3'] : '';
    $lista4 = isset( $instance['lista4'] ) ? $instance['lista4'] : '';
    $lista5 = isset( $instance['lista5'] ) ? $instance['lista5'] : '';
    $image = isset( $instance['image'] ) ? $instance['image'] : '';
    $title = sanitize_text_field( $instance['title'] );
    ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
    <p>
      <label for="<?php echo $this->get_field_id( ' ' ); ?>"><?php _e( 'Imagem:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_url( $image ); ?>" />
      <button class="upload_image_button button button-primary">Upload Imagem</button>
   </p>

    <p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:' ); ?></label>
    <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>

    <p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
    <p><label for="<?php echo $this->get_field_id('lista1'); ?>"><?php _e('Adicione um link de lista ou deixe em branco'); ?></label></p>
    <p><input class="widefat" id="<?php echo $this->get_field_id('lista1'); ?>" name="<?php echo $this->get_field_name('lista1'); ?>" type="text" value="<?php echo esc_attr($lista1); ?>" /></p>
    <p><input class="widefat" id="<?php echo $this->get_field_id('lista2'); ?>" name="<?php echo $this->get_field_name('lista2'); ?>" type="text" value="<?php echo esc_attr($lista2); ?>" /></p>
    <p><input class="widefat" id="<?php echo $this->get_field_id('lista3'); ?>" name="<?php echo $this->get_field_name('lista3'); ?>" type="text" value="<?php echo esc_attr($lista3); ?>" /></p>
    <p><input class="widefat" id="<?php echo $this->get_field_id('lista4'); ?>" name="<?php echo $this->get_field_name('lista4'); ?>" type="text" value="<?php echo esc_attr($lista4); ?>" /></p>
    <p><input class="widefat" id="<?php echo $this->get_field_id('lista5'); ?>" name="<?php echo $this->get_field_name('lista5'); ?>" type="text" value="<?php echo esc_attr($lista5); ?>" /></p>
    
    <?php
  }
}
add_action("widgets_init",function(){register_widget("zflag_widget_aboutarea"); });


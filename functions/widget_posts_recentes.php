<?php

/* Widget para posts recentes */

 

class widget_posts_recentes extends WP_Widget 

{

    function __construct()

    {

        parent::__construct("widget_posts_recentes", "Zflag Posts Recentes", array('description' => "Exibe os posts recentes"));

    }



  public function widget($args, $instance)

  {

        echo $args["before_widget"];



        if(isset($instance['title'])){

            $title = apply_filters('widget_title', $instance["title"]);

        }

        



        $quantidade = (!empty($instance['quantidade']) ? $instance['quantidade'] : 1);

 

        $cor_txt = (!empty($instance['cor_txt']) ? "color:".$instance['cor_txt'].";" : ""); 

        $filtro = $instance['filtro'];

 

        query_posts('showposts='.$quantidade.$categoria);





        if(!empty($instance['categoria']) && ($instance['categoria'] != 'todas-categorias'))

        {

          $vetor_args['category_name'] = $instance['categoria'];

        }



        if(!empty($instance['tag']) && ($instance['tag'] != 'todas-categorias'))

        {

          $vetor_args['tag'] = $instance['tag'];

        }



        //1 = posts recentes, 2 Posts mais visualizados

        

        switch ($filtro) { 

          case 1:

            $vetor_args['posts_per_page'] = $quantidade;

          break; 



          case 2:

            $vetor_args['meta_key'] = 'post_views_count';

            $vetor_args['orderby'] = 'meta_value_num';

            $vetor_args['posts_per_page'] = $quantidade;

          break;

          

          default:

            $vetor_args['posts_per_page'] = $quantidade;

          break;

        }

        



        query_posts($vetor_args);

        $contador_de_post = 0;

        $num_post = 0;

        if (have_posts()) : 



            while (have_posts()) : the_post(); $contador_de_post++;





              if ( has_post_thumbnail() ) {

                $the_post_thumbnail = get_the_post_thumbnail_url();

              } else { 

                $the_post_thumbnail = get_bloginfo('template_directory')."/imagens/default-image.png";

              } 



              $cat_inf    = get_the_category();

              $cat_inf    = $cat_inf[0];

              $url        = get_permalink();

              $img        = $the_post_thumbnail;

              $cat_name   = get_cat_name($cat_inf->cat_ID);

              $cat_link   = get_category_link($cat_inf->cat_ID);

              $titulo     = get_the_title();

              $titulo     = resumo_txt($titulo,120,0);

              $resumo     = resumo_txt(get_the_excerpt(),120,0);

              $data_post  = get_the_date('d').' de '.get_the_date('M').' de '.get_the_date('Y');

              $autor      = get_the_author();

              $autor_link = get_author_posts_url(get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));

              $id_post    = get_the_ID();





              $html_categoria_cultura .='

                <!-- start single post -->

                  <div class="recent-single-post">

                      <div class="post-img">

                          <a href="'.$url.'">

                 <img src="'.$img.'" alt="">

              </a>

                      </div>

                      <div class="pst-content">

                        <p><a href="'.$url.'">'.$titulo.'</a></p>

                      </div>

                  </div>

                  <!-- End single post -->';



               

            endwhile;

            wp_reset_postdata();

            wp_reset_query();

        endif;



       

        $titulo_plugin = $instance['title'];



        echo '

          <!-- recent start -->

              <div class="left-blog">

                <h4>'.$titulo_plugin.'</h4>

                <div class="recent-post">

                  '.$html_categoria_cultura.'

                </div>

              </div>

          ';

        

           



    echo $args["after_widget"];

  }

 

  public function form($instance)

  {



    if(isset($instance['filtro']))

    {

      $filtro = $instance['filtro'];

    }



    if(isset($instance['categoria']))

    {

      $categoria = $instance['categoria'];

    }



    if(isset($instance['tag']))

    {

      $tag = $instance['tag'];

    }



    if(isset($instance['title']))

    {

      $title = $instance['title'];

    }

    else

    {

      $title = "Novo titulo";

    }



    if(isset($instance['quantidade']))

    {

        $quantidade = $instance['quantidade'];

    }



    ?>      



        <p>

            <label for="<?php echo $this->get_field_id('title'); ?>" > <?php _e("Titulo:"); ?></label>

            <input type='text' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">

            <div style="font:12px; color:#666;"> </div>

        </p>



        <p>

            <label for="<?php echo $this->get_field_id('quantidade'); ?>" > <?php _e("Quantidade de posts:"); ?></label>

            <input type='text' id="<?php echo $this->get_field_id('quantidade'); ?>" name="<?php echo $this->get_field_name('quantidade'); ?>" class="widefat" value="<?php echo esc_attr($quantidade); ?>">

            <div style="font:12px; color:#666;">Digite o numero máximo de posts para serem exibidos</div>

        </p>



        <p>

            <label for="<?php echo $this->get_field_id('filtro'); ?>" > <?php _e("Filtrar por:"); ?></label>

            

            <select name="<?php echo $this->get_field_name('filtro'); ?>" id="<?php echo $this->get_field_id('filtro'); ?>" class="postform">

              <option <?php echo (esc_attr($filtro) == 1 ? 'selected="selected"' : ''); ?> class="level-0" value="1">Posts recentes</option>

              <option <?php echo (esc_attr($filtro) == 2 ? 'selected="selected"' : ''); ?> class="level-0" value="2">Posts mais visualizados</option>

            </select>



        </p>

        <p>

            <label for="<?php echo $this->get_field_id('categoria'); ?>" > <?php _e("Categoria:"); ?></label>



            <?php 



              $args = array(

                'walker'             => new SH_Walker_TaxonomyDropdown(),

                'show_option_all'    => '',

                'show_option_none'   => '',

                'option_none_value'  => '-1',

                'orderby'            => 'ID',

                'order'              => 'ASC',

                'show_count'         => 0,

                'hide_empty'         => 1,

                'child_of'           => 0,

                'exclude'            => '',

                'include'            => '',

                'echo'               => 1,

                'selected'           => esc_attr($categoria),

                'hierarchical'       => 0,

                'name'               => $this->get_field_name('categoria'),

                'id'                 => $this->get_field_id('categoria'),

                'class'              => 'postform',

                'depth'              => 0,

                'tab_index'          => 0,

                'taxonomy'           => 'category',

                'hide_if_empty'      => false,

                'value_field'        => 'slug',

                'value'              => 'slug'

              ); 



              wp_dropdown_categories( $args ); 

            ?> 

            <div style="font:12px; color:#666;">Caso queira exibir uma categoria especifica selecione uma categoria, só sera exibida as postagens desta categoria.<br>Deixe como "Todas Categorias" para exibir todos os posts com ou sem categorias.</div>

        </p>

        <p>

            <label for="<?php echo $this->get_field_id('tag'); ?>" > <?php _e("tag:"); ?></label>



            <?php 



              $args = array(

                'walker'             => new SH_Walker_TaxonomyDropdown(),

                'show_option_all'    => '',

                'show_option_none'   => '',

                'option_none_value'  => '-1',

                'orderby'            => 'ID',

                'order'              => 'ASC',

                'show_count'         => 0,

                'hide_empty'         => 1,

                'child_of'           => 0,

                'exclude'            => '',

                'include'            => '',

                'echo'               => 1,

                'selected'           => esc_attr($tag),

                'hierarchical'       => 0,

                'name'               => $this->get_field_name('tag'),

                'id'                 => $this->get_field_id('tag'),

                'class'              => 'postform',

                'depth'              => 0,

                'tab_index'          => 0,

                'taxonomy'           => 'post_tag',

                'hide_if_empty'      => false,

                'value_field'        => 'slug',

                'value'              => 'slug'

              ); 



              wp_dropdown_categories( $args ); 

            ?> 

            <div style="font:12px; color:#666;">Caso queira exibir um post de uma tag especifica selecione uma tag, só será exibida as postagens desta tag.<br>Deixe como "Todas tags" para exibir todos os posts com ou sem tags.</div>

        </p>





        

    <?php



  }



  public function update($new_instance, $old_instance)

  {

    $instance = array();

    $instance['tag']          = (!empty($new_instance['tag'])    ?   strip_tags($new_instance['tag'])  : '');

    $instance['categoria']    = (!empty($new_instance['categoria'])    ?   strip_tags($new_instance['categoria'])  : '');

    $instance['title']        = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');

    $instance['quantidade']   = (!empty($new_instance['quantidade'])   ?   strip_tags($new_instance['quantidade']) : '');

    $instance['filtro']       = (!empty($new_instance['filtro'])   ?   strip_tags($new_instance['filtro']) : '');

    return $instance;

  } 

}

 

add_action("widgets_init",function(){register_widget("widget_posts_recentes"); });






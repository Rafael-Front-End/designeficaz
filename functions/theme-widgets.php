<?php
// http://g1.globo.com/sao-paulo/sao-jose-do-rio-preto-aracatuba/noticia/2016/11/equipe-da-tv-tem-sofre-ameaca-em-reportagem-sobre-morte-em-motel.html
function remove_text_widget() {//remove o widget padrão text para ser adicionar o novo
  unregister_widget('WP_Widget_Text');
  unregister_widget('WP_Widget_Tag_Cloud'); 
}  
    
add_action( 'widgets_init', 'remove_text_widget' );
    
    
// load css into the admin pages
function mytheme_enqueue_options_style() {   
    wp_enqueue_script( 'jquery' ); 
    wp_enqueue_script('jquerytools');
    wp_enqueue_script('jquery-ui-person');
    wp_enqueue_script('jqueryform'); 
    wp_enqueue_script('sprinkle');
    wp_enqueue_script('custom');
    // wp_enqueue_script( 'custom_js_script', get_template_directory_uri().'/js/jquery.js', array('jquery')); 
    // wp_enqueue_style( 'mytheme-options-style', get_template_directory_uri() . '/css/style_admin.css' ); 
}
add_action( 'admin_enqueue_scripts', 'mytheme_enqueue_options_style' );


/* Widgetable Functions  */
 
function under_widgets_init() {

  register_sidebar(array(
    'id' => 'abaixo_menu',
    'name'=>_('Topo abaixo do menu'),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => ''
  ));

  register_sidebar(array(
    'id' => 'topo_publicidade',
    'name'=>_('Campo de publicidade - topo'),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => ''
  ));

  register_sidebar(array(
    'id' => 'inner_post_widget',
    'name'=>_('Corpo dos posts'),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => ''
  ));


    register_sidebar(array(
    'id' => 'config_geral',
    'name'=>_('Widgets de Configurações'),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => ''
  ));

 
  register_sidebar(array(
    'id' => 'topo_pagina_inicial',
    'name'=>_('Topo da página inicial'),
    'before_widget' => '',
    'after_widget' => '', 
    'before_title' => '',
    'after_title' => ''
  ));

  register_sidebar(array(
    'id' => 'pagina_inicial',
    'name'=>_('Página Inicial'),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => ''
  ));

  register_sidebar(array(
    'name' => _('Barra lateral'),
    'id' => 'barra_lateral',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '', 
    'after_title' => ''
  ));   
  register_sidebar(array(
    'id' => 'rodape',
    'name'=>'Rodapé',
    'before_widget' => '<li id="%1$s" class="%2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h2>',
    'after_title' => '</h2>'
  ));


  register_sidebar(array(
    'id' => 'rodape2',
    'name'=>'Rodapé copyright',
    'before_widget' => '<div id="%1$s" class="%2$s">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => ''
  ));

}
add_action( 'widgets_init', 'under_widgets_init' );

require('category_widget.php');


/* More About Us Widget */
class banner extends WP_Widget
{
    function __construct()
    {
        parent::__construct("banner", "Banner/Imagem", array('description' => "Adicione uma imagem ou um texto com link",'customize_selective_refresh' => true));
        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
    }

    /**
    * Upload the Javascripts for the media uploader
    */
    public function upload_scripts()
    {
      wp_enqueue_script('media-new');
      wp_enqueue_script('thickbox');
      wp_enqueue_script('upload_media_widget',get_template_directory_uri().'/js/upload-media.js',array('jquery'));
      wp_enqueue_style('thickbox');
      wp_enqueue_script( 'media-upload' );
      wp_enqueue_media();
      wp_enqueue_script('our_admin', get_template_directory_uri() . '/assets/js/our_admin.js', array('jquery'));

    }


  public function widget($args, $instance)
  {
    if(isset($instance['title'])){
        $title = apply_filters('widget_title', $instance["title"]);
    }
        if(!empty($instance['link']))
        {
            echo '<a href="'.$instance['link'].'" target="_blank" class="banner imagem">';
        }
        else if(!empty($instance['image'])) 
        {
            echo '<a href="'.$instance['image'].'" rel="lightbox-0" class="banner imagem">';
        }
        if(!empty($instance['title'])){
            echo "<h3>".$args['before_title'] . $title . $args["after_title"]."</h3>";
        } 

        if(!empty($instance['image'])){
            $largura  = ((!empty($instance['largura'])) ? "width:{$instance['largura']};" : "");
            $altura   = ((!empty($instance['altura'])) ? "height:{$instance['altura']};" : "");
            echo '<img style="'.$largura.' '.$altura.'" class="img-responsive" src="'.$instance['image'].'" />';
        }
        if(!empty($instance['link']) || !empty($instance['image']))
        {
            echo '</a>';
        }

  }
 
  public function form($instance)
  {
    if(isset($instance['link']))
    {
      $link = $instance['link'];
    }

    if(isset($instance['largura']))
    {
      $largura = $instance['largura'];
    }

    if(isset($instance['altura']))
    {
      $altura = $instance['altura'];
    }

    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    $image = '';
    if(isset($instance['image']))
    {
        $image = $instance['image'];
    }

    ?>

        <p>
            <label for="<?php echo $this->get_field_id('link'); ?>" ><b> <?php _e("Link:"); ?></b></label>
            <input type='text' class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" value="<?php echo esc_attr($link); ?>">
            <div style="font:12px; color:#666;"> Caso não tenha um link deixe em branco </div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>" ><b> <?php _e("Titulo:"); ?></b></label>
            <input type='text' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
            <div style="font:12px; color:#666;"> Este título será exibido no banner!<br/>Caso não queira exibir o título deixo o campo em branco.</div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>"><b><?php _e( 'Imagem:' ); ?></b></label>
            <input name="<?php echo $this->get_field_name('image'); ?>" id="<?php echo $this->get_field_id('image'); ?>" class="widefat image-uploaded-x" type="text" size="36"  value="<?php echo esc_url($image); ?>" placeholder="" />
            <!--input class="upload_image_button widefat button button-primary" type="button" value="Adicionar imagem" /-->
            <div style="font:12px; color:#666;"> Adicione a url da imagem ou faça o upload da imagem no botão abaixo.</div>
        </p>
        <p>
            <label style='width:50%; float:left;' for="<?php echo $this->get_field_id('largura'); ?>"><b><?php _e( 'Largura:' ); ?></b></label>
            <label style='width:50%; float:left;' for="<?php echo $this->get_field_id('altura'); ?>"><b><?php _e( 'Altura:' ); ?></b></label>
            <input style='width:48%; float:left;' name="<?php echo $this->get_field_name('largura'); ?>" id="<?php echo $this->get_field_id('largura'); ?>" type="text" size="36"  value="<?php echo esc_attr($largura); ?>" placeholder="" />
            <input style='width:48%; float:left;'name="<?php echo $this->get_field_name('altura'); ?>" id="<?php echo $this->get_field_id('altura'); ?>" type="text" size="36"  value="<?php echo esc_attr($altura); ?>" placeholder="" />
        </p>
        <p style="font:12px; color:#666;">Deixe o campo vazio para manter a altura ou largura real da imagem.<br> Para definir o tamanho use pixels exemplo '250px' com 'px' no final ou porcentagem '100%' com % no final do valor.</p>
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['link']     = (!empty($new_instance['link'])    ?   strip_tags($new_instance['link'])  : '');
    $instance['title']    = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    $instance['image']    = (!empty($new_instance['image'])   ?   strip_tags($new_instance['image']) : '');
    $instance['largura']  = (!empty($new_instance['largura'])   ?   strip_tags($new_instance['largura']) : '');
    $instance['altura']   = (!empty($new_instance['altura'])   ?   strip_tags($new_instance['altura']) : '');
    return $instance;
  }

}

add_action("widgets_init",function(){register_widget("banner"); });



/* Widget para posts recentes */
 
class posts_recentes extends WP_Widget 
{
    function __construct()
    {
        parent::__construct("posts_recentes", "Posts Recentes", array('description' => "Exibe os posts recentes"));
    }

  public function widget($args, $instance)
  {
        if(isset($instance['title'])){
            $title = apply_filters('widget_title', $instance["title"]);
        }
        echo $args[" "];
        
        // $categoria = (!empty($instance['categoria']) && ($instance['categoria'] != 'todas-categorias') ? "&category_name=".$instance['categoria'] : "");
        
        $quantidade = (!empty($instance['quantidade']) ? $instance['quantidade'] : 1);
        $cor_b = (!empty($instance['cor_b']) ? "style='border-color:".$instance['cor_b'].";background-color:".$instance['cor_b']."'" : "");
        $cor_t = (!empty($instance['cor_b']) ? "style='border-color: -moz-use-text-color -moz-use-text-color ".$instance['cor_b']." !important;color:".$instance['cor_t']."'" : "");
        $cor_txt = (!empty($instance['cor_txt']) ? "color:".$instance['cor_txt'].";" : "");
        $fontes = ((!empty($instance['fontes']) && $instance['fontes'] != 'defaut') ? "font-family: '".$instance['fontes']."' !important;" : "");
        
        $design = $instance['design']; 
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
              $html_link_cat = "<a class='titlecat'  href='{$cat_link}'>{$cat_name}</a>";

              switch($design):
                case 1: 
                  $html_categoria_cultura .="
                      <a href=\"{$url}\" class=\"bloco_post\">
                        <div class=\"thumbnail_post\" style=\"background-image:url($img);\"></div>
                        <div class=\"content_post\">
                          <span style='".$cor_txt.$fontes."'>{$titulo}</span>
                          <!-- p><span>{$data_post}</span></p -->
                        </div>
                      </a>
                  ";
                break;
                case 2: 

                  $html_categoria_cultura .='
                    <div class="bloco_post texto_direita esquerda col-md-4">
                      <div class="coluna1">'.$html_link_cat.'
                        <a href="'.$url.'" class="thumbnail"><img src="'.$img.'"></a>
                      </div>
                      <div class="content_post">
                        <span style="'.$cor_txt.$fontes.'">'.$titulo.'</span>
                        <p>por <a href="'.$autor_link.'" class="author">'.$autor.'</a> | '.$data_post.'</p>
                      </div>
                    </div>
                  ';

                break;
                case 3: 
                  $html_categoria_cultura .='
                    <a href="'.$url.'" class="bloco_post esquerda col-md-6">
                      <div class="thumbnail_post" style="background-image:url('.$img.');"></div>
                      <span style="'.$cor_txt.$fontes.'">'.$titulo.'</span>
                      <!-- p>'.$autor.'<span> - '.$data_post.'</span></p -->
                    </a>
                  ';
                break;   
                case 4: 
                  $html_categoria_cultura .='
                    <div class="bloco_post esquerda col-md-4">
                      '.$html_link_cat.'
                      <a href="'.$url.'" class="thumbnail_post" style="background-image:url('.$img.');"></a>
                      <span style="'.$cor_txt.$fontes.'">'.$titulo.'</span>
                      <p>por <a href="'.$autor_link.'" class="author">'.$autor.'</a> | '.$data_post.'</p>
                    </div>
                  ';
                break;

                case 5: 
                  $num_post++;
                  $html_categoria_cultura .='
                    <div class="dados_post">
                      <div class="inner_dados_post">
                        <p class="trenging_post_cat ">
                          <a href="'.$cat_link.'"> '.$cat_name.' </a>
                        </p>
                        <span class="title">
                          <a style="'.$cor_txt.$fontes.'" href="'.$url.'">
                            '.$titulo.'
                          </a>
                        </span>
                        <a href="'.$autor_link.'" class="author">
                          '.$autor.'
                        </a>
                      </div>
                    </div>
                  ';
                break;
              endswitch;
            endwhile;
            wp_reset_postdata();
            wp_reset_query();
        endif;

        switch($design):
          case 1: 
            $tipo_layout = 'tipo_1'; 
          break;
          case 2: 
            $tipo_layout = 'tipo_2'; 
          break;
          case 3: 
            $tipo_layout = 'tipo_3'; 
          break;
          case 4: 
            $tipo_layout = 'tipo_4'; 
          break; 
          case 5: 
            $tipo_layout = 'tipo_5'; 
          break;
        endswitch;
        $titulo_plugin = $instance['title'];


        if($design == 5){

          $titulo_plugin_html = !empty($titulo_plugin) ? "<a title=\"$title\"><h3 class=\"titulo_widget\">$title</h3></a>" : '';
          echo " 
          <div class=\"".$tipo_layout." destaque_categorias\">
            $titulo_plugin_html
            <div class=\"post_recente tipo_6\">
              $html_categoria_cultura
            </div>
          </div>
          ";

        }else{
          $titulo_plugin_html = !empty($titulo_plugin) ? "<h3 $cor_t><span>".$titulo_plugin."</span></h3>" : '';
          echo "
          <div class=\"".$tipo_layout." destaque_categorias\">
              $titulo_plugin_html
              $html_categoria_cultura
              <a class='link_de_indicacao' href='".get_permalink( get_page_by_path( 'blog' ) )."'>Ver todos os artigos<span class='right-arrow'></span></a>
          </div>
          ";
        }
           

    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['design']))
    {
      $design = $instance['design'];
    }

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

    if(isset($instance['fontes']))
    {
      $fontes = $instance['fontes'];
    }

    if(isset($instance['cor_t']))
    {
      $cor_t = $instance['cor_t'];
    }
    
    if(isset($instance['cor_txt']))
    {
      $cor_txt = $instance['cor_txt'];
    }

    if(isset($instance['cor_b']))
    {
      $cor_b = $instance['cor_b'];
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

    $options = options_fontes(esc_attr($fontes));

    ?>      

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>" > <?php _e("Titulo:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
            <div style="font:12px; color:#666;"> </div>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('cor_t'); ?>" > <?php _e("Cor titulo:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('cor_t'); ?>" name="<?php echo $this->get_field_name('cor_t'); ?>" class="widefat" value="<?php echo esc_attr($cor_t); ?>">
            <div style="font:12px; color:#666;"> </div>
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('cor_b'); ?>" > <?php _e("Cor barra:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('cor_b'); ?>" name="<?php echo $this->get_field_name('cor_b'); ?>" class="widefat" value="<?php echo esc_attr($cor_b); ?>">
            <div style="font:12px; color:#666;"> </div>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('cor_txt'); ?>" > <?php _e("Cor texto:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('cor_txt'); ?>" name="<?php echo $this->get_field_name('cor_txt'); ?>" class="widefat" value="<?php echo esc_attr($cor_txt); ?>">
            <div style="font:12px; color:#666;"> </div>
        </p>

        <div id='select_fontes'>
          <p>
              <label for="<?php echo $this->get_field_id('fontes'); ?>" > <?php _e("Fonte:"); ?></label>
              
              <select name="<?php echo $this->get_field_name('fontes'); ?>" id="<?php echo $this->get_field_id('fontes'); ?>" class="postform">
                <option <?php echo (esc_attr($fontes) == 'defaut' ? 'selected="selected"' : ''); ?> class="level-0" value="defaut">Padrão do tema</option>
                <?php echo $options;?>
              </select>
          </p>
        </div>

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

        <p>
            <label for="<?php echo $this->get_field_id('design'); ?>" > <?php _e("Layout do Widget:"); ?></label>
            
            <select name="<?php echo $this->get_field_name('design'); ?>" id="<?php echo $this->get_field_id('design'); ?>" class="postform">
              <option <?php echo (esc_attr($design) == 1 ? 'selected="selected"' : ''); ?> class="level-0" value="1">Design Padrão</option>
              <option <?php echo (esc_attr($design) == 2 ? 'selected="selected"' : ''); ?> class="level-1" value="2">Design 2</option>
              <option <?php echo (esc_attr($design) == 3 ? 'selected="selected"' : ''); ?> class="level-2" value="3">Design 3</option>
              <option <?php echo (esc_attr($design) == 4 ? 'selected="selected"' : ''); ?> class="level-2" value="4">Design 4</option>
              <option <?php echo (esc_attr($design) == 5 ? 'selected="selected"' : ''); ?> class="level-2" value="5">Design 5</option>

            </select>
 
            </p>

        
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['tag']          = (!empty($new_instance['tag'])    ?   strip_tags($new_instance['tag'])  : '');
    $instance['cor_b']        = (!empty($new_instance['cor_b'])    ?   strip_tags($new_instance['cor_b'])  : '');
    $instance['cor_t']        = (!empty($new_instance['cor_t'])    ?   strip_tags($new_instance['cor_t'])  : '');
    $instance['cor_txt']      = (!empty($new_instance['cor_txt'])    ?   strip_tags($new_instance['cor_txt'])  : '');
    $instance['fontes']      = (!empty($new_instance['fontes'])    ?   strip_tags($new_instance['fontes'])  : '');
    $instance['categoria']    = (!empty($new_instance['categoria'])    ?   strip_tags($new_instance['categoria'])  : '');
    $instance['title']        = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    $instance['quantidade']   = (!empty($new_instance['quantidade'])   ?   strip_tags($new_instance['quantidade']) : '');
    $instance['design']       = (!empty($new_instance['design'])   ?   strip_tags($new_instance['design']) : '');
    $instance['filtro']       = (!empty($new_instance['filtro'])   ?   strip_tags($new_instance['filtro']) : '');
    return $instance;
  } 
}
 
add_action("widgets_init",function(){register_widget("posts_recentes"); });








/* Widget para posts recentes */

class posts_destacados extends WP_Widget
{
    function __construct()
    {
        parent::__construct("posts_destacados", "Destaques", array('description' => "Exibe os posts recentes ou destacados"));
    }

  public function widget($args, $instance)
  {
        echo $args[" "];
       
       // $instance['design']


        $categoria = (!empty($instance['categoria']) && ($instance['categoria'] != 'todas-categorias') ? "&category_name=".$instance['categoria'] : "");

        if(isset($instance['bloco_1']))
        {
          $bloco_1 = $instance['bloco_1'];
        }

        if(isset($instance['bloco_2']))
        {
          $bloco_2 = $instance['bloco_2'];
        }

        if(isset($instance['bloco_3']))
        {
          $bloco_3 = $instance['bloco_3'];
        }

        $vetor_posts = array($bloco_1, $bloco_2, $bloco_3);

        $args = array(
           'showposts' => '3',
           'post__in'      => $vetor_posts,
           'orderby' => 'post__in'
        );

        query_posts($args);
        $contador_de_post = 0;
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
              $titulo     = get_the_title();
              $titulo     = resumo_txt($titulo,90,0);
              $resumo     = resumo_txt(get_the_excerpt(),90,0);
              $data_post  = get_the_date('d M Y');
              $autor      = get_the_author();
              $id_post    = get_the_ID();
              $tipo_media = get_post_meta($id_post, "meta-box-tipo-featured_media", true);
              $url_media  = get_post_meta($id_post, "meta-box-url-featured_media", true);
              $media_style = NULL;
              if($url_media != NULL){
                if($tipo_media == 1){
                  $media_style  = (($url_media) ? 'video_post' : '');
                }else if($tipo_media == 2){
                  $media_style = "";
                }
              }else{
                $wp_post_template  = get_post_meta($id_post, "_wp_post_template", true);
                $media_style = (($wp_post_template == 'single-carrousel_galeria.php') ? 'imagem_post' : '');
              }

              
             



              $html_destaques .= '
                <a href="'.$url.'" class="item_destaque col-md-4">
                  <div id="img_destaque" class=""><div class="circular" style="background-image:url('.$img.');"></div></div>
                  <div id="conteudo_item_destaque" class="">
                    <h3>'.get_the_author().'</h3>
                    <h4>'.$titulo.'</h4>
                  </div>
                </a>';

            endwhile;
            wp_reset_query();
        endif;
        if(isset($instance['title']))
        {
          $title = $instance['title'];
        }


        echo "
          <div id=\"exibe_destaques\" >
            <h2>$title</h2>
            <div class=\"barra_destaques\">
              <div class=\" col-md-12\">  
                $html_destaques
              </div>
            </div>
          </div>  
        ";
           
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['categoria']))
    {
      $categoria = $instance['categoria'];
    }

    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    if(isset($instance['bloco_1']))
    {
      $bloco_1 = $instance['bloco_1'];
    }

    if(isset($instance['bloco_2']))
    {
      $bloco_2 = $instance['bloco_2'];
    }

    if(isset($instance['bloco_3']))
    {
      $bloco_3 = $instance['bloco_3'];
    }
    wp_reset_query();
    query_posts('orderby=title&posts_per_page=999999');
    if (have_posts()) : 

        while (have_posts()) : the_post(); 
          $bloco_1_html .= "<option ".(esc_attr($bloco_1) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
          $bloco_2_html .= "<option ".(esc_attr($bloco_2) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
          $bloco_3_html .= "<option ".(esc_attr($bloco_3) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
        endwhile;
    endif;
    wp_reset_query();


    ?>     


        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>" ><b> <?php _e("Titulo:"); ?></b></label>
            <input  type='text' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
            <div style="font:12px; color:#666;"></div>
        </p> 


        <p>
            <label for="<?php echo $this->get_field_id('bloco_1'); ?>" > <?php _e("Bloco 1:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_1'); ?>" id="<?php echo $this->get_field_id('bloco_1'); ?>" class="postform">
              <?php echo $bloco_1_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  

        <p>
            <label for="<?php echo $this->get_field_id('bloco_2'); ?>" > <?php _e("Bloco 2:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_2'); ?>" id="<?php echo $this->get_field_id('bloco_2'); ?>" class="postform">
              <?php echo $bloco_2_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  

        <p>
            <label for="<?php echo $this->get_field_id('bloco_3'); ?>" > <?php _e("Bloco 3:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_3'); ?>" id="<?php echo $this->get_field_id('bloco_3'); ?>" class="postform">
              <?php echo $bloco_3_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  


        <!-- p>
            <label for="<?php //echo $this->get_field_id('categoria'); ?>" > <?php //_e("Categoria:"); ?></label>

            <?php 

              // $args = array(
              //   'walker'             => new SH_Walker_TaxonomyDropdown(),
              //   'show_option_all'    => '',
              //   'show_option_none'   => '',
              //   'option_none_value'  => '-1',
              //   'orderby'            => 'ID',
              //   'order'              => 'ASC',
              //   'show_count'         => 0,
              //   'hide_empty'         => 1,
              //   'child_of'           => 0,
              //   'exclude'            => '',
              //   'include'            => '',
              //   'echo'               => 1,
              //   'selected'           => esc_attr($categoria),
              //   'hierarchical'       => 0,
              //   'name'               => $this->get_field_name('categoria'),
              //   'id'                 => $this->get_field_id('categoria'),
              //   'class'              => 'postform',
              //   'depth'              => 0,
              //   'tab_index'          => 0,
              //   'taxonomy'           => 'category',
              //   'hide_if_empty'      => false,
              //   'value_field'        => 'slug',
              //   'value'              => 'slug'
              // ); 

              // wp_dropdown_categories( $args ); 
            ?> 
            <div style="font:12px; color:#666;">Caso queira exibir uma categoria especifica selecione uma categoria, só sera exibida as postagens desta categoria.<br>Deixe como "Todas Categorias" para exibir todos os posts com ou sem categorias.</div>
        </p -->
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['bloco_3']    = (!empty($new_instance['bloco_3'])   ?   strip_tags($new_instance['bloco_3']) : '');
    $instance['bloco_2']    = (!empty($new_instance['bloco_2'])   ?   strip_tags($new_instance['bloco_2']) : '');
    $instance['bloco_1']    = (!empty($new_instance['bloco_1'])   ?   strip_tags($new_instance['bloco_1']) : '');
    $instance['title']    = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    $instance['categoria']    = (!empty($new_instance['categoria'])    ?   strip_tags($new_instance['categoria'])  : '');
    return $instance;
  }

}

add_action("widgets_init",function(){register_widget("posts_destacados"); });





/* Widget para posts recentes */

class posts_destacados_2 extends WP_Widget
{
  function __construct()
  {
      parent::__construct("posts_destacados_2", "Destaques 2", array('description' => "Exibe os posts recentes ou destacados"));
  }

  public function widget($args, $instance)
  {
        echo $args[" "];
       
        $categoria = (!empty($instance['categoria']) && ($instance['categoria'] != 'todas-categorias') ? "&category_name=".$instance['categoria'] : "");

        if(isset($instance['bloco_1']))
        {
          $bloco_1 = $instance['bloco_1'];
        }

        if(isset($instance['bloco_2']))
        {
          $bloco_2 = $instance['bloco_2'];
        }

        if(isset($instance['bloco_3']))
        {
          $bloco_3 = $instance['bloco_3'];
        }

        $vetor_posts = array($bloco_1, $bloco_2, $bloco_3);

        $args = array(
           'showposts' => '3',
           'post__in'      => $vetor_posts,
           'orderby' => 'post__in'
        );


        // $categoria = (!empty($instance['categoria']) && ($instance['categoria'] != 'todas-categorias') ? "&category_name=".$instance['categoria'] : "");
        // query_posts('showposts=5'.$categoria);
        

        query_posts($args);
        $contador_de_post = 0;
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
              $titulo     = get_the_title();
              $titulo_resumo     = resumo_txt($titulo,90,0);
              $resumo     = resumo_txt(get_the_excerpt(),90,0);
              $data_post  = get_the_date('d M Y');
              $autor      = get_the_author();
              $id_post = get_the_ID();

              switch($contador_de_post):
                case 1:
                $html_destaques .= "
                  <a href=\"{$url}\" class=\"bloco_destaque item_1 col-md-6\" style=\"background-image: url({$the_post_thumbnail})\">
                    <div class=\"content-post\">
                      <div class=\"content-txt\">
                        <h3>{$titulo_resumo}</h3>
                        <p><b>{$autor}</b> <span>- {$data_post}</span></p>
                      </div>
                    </div>
                  </a>
                ";
                break;
                case 2:
                $html_destaques .= "
                  <a href=\"{$url}\" class=\"bloco_destaque item_2 col-md-6\" style=\"background-image: url({$the_post_thumbnail})\">
                    <div class=\"content-post\">
                      <div class=\"content-txt\">
                        <h3>{$titulo_resumo}</h3>
                        <p><b>{$autor}</b> <span>- {$data_post}</span></p>
                      </div>
                    </div>
                  </a>
                ";
                break;
                case 3:
                $html_destaques .= "
                  <a href=\"{$url}\" class=\"bloco_destaque item_2 col-md-6\" style=\"background-image: url({$the_post_thumbnail})\">
                    <div class=\"content-post\">
                      <div class=\"content-txt\">
                        <h3>{$titulo_resumo}</h3>
                        <p><b>{$autor}</b> <span>- {$data_post}</span></p>
                      </div>
                    </div>
                  </a>
                ";
                break;
                // case 4:
                // $html_destaques .= "
                //   <a href=\"{$url}\" class=\"bloco_destaque item_4 col-md-3\" style=\"background-image: url({$the_post_thumbnail})\">
                //     <div class=\"content-post\">
                //       <div class=\"content-txt\">
                //         <h3>{$resumo}</h3>
                //         <p><b>{$autor}</b> <span>- {$data_post}</span></p>
                //       </div>
                //     </div>
                //   </a>
                // ";
                break;

                break;
              endswitch;

            endwhile;
            wp_reset_query();
        endif;



        echo "
          <div class=\"destaque_2\">
              $html_destaques
          </div>
        ";
           
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['categoria']))
    {
      $categoria = $instance['categoria'];
    }

    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    if(isset($instance['bloco_1']))
    {
      $bloco_1 = $instance['bloco_1'];
    }

    if(isset($instance['bloco_2']))
    {
      $bloco_2 = $instance['bloco_2'];
    }

    if(isset($instance['bloco_3']))
    {
      $bloco_3 = $instance['bloco_3'];
    }
    wp_reset_query();
    query_posts('orderby=title&posts_per_page=999999');
    if (have_posts()) : 

        while (have_posts()) : the_post(); 
          $bloco_1_html .= "<option ".(esc_attr($bloco_1) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
          $bloco_2_html .= "<option ".(esc_attr($bloco_2) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
          $bloco_3_html .= "<option ".(esc_attr($bloco_3) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
        endwhile;
    endif;
    wp_reset_query();


    ?>     


<!--         <p>
            <label for="<?php //echo $this->get_field_id('title'); ?>" ><b> <?php //_e("Titulo:"); ?></b></label>
            <input  type='text' id="<?php //echo $this->get_field_id('title'); ?>" name="<?php //echo $this->get_field_name('title'); ?>" class="widefat" value="<?php //echo esc_attr($title); ?>">
            <div style="font:12px; color:#666;"></div>
        </p>  -->


        <p>
            <label for="<?php echo $this->get_field_id('bloco_1'); ?>" > <?php _e("Bloco 1:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_1'); ?>" id="<?php echo $this->get_field_id('bloco_1'); ?>" class="postform">
              <?php echo $bloco_1_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  

        <p>
            <label for="<?php echo $this->get_field_id('bloco_2'); ?>" > <?php _e("Bloco 2:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_2'); ?>" id="<?php echo $this->get_field_id('bloco_2'); ?>" class="postform">
              <?php echo $bloco_2_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  

        <p>
            <label for="<?php echo $this->get_field_id('bloco_3'); ?>" > <?php _e("Bloco 3:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_3'); ?>" id="<?php echo $this->get_field_id('bloco_3'); ?>" class="postform">
              <?php echo $bloco_3_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  


        <!-- p>
            <label for="<?php //echo $this->get_field_id('categoria'); ?>" > <?php //_e("Categoria:"); ?></label>

            <?php 

              // $args = array(
              //   'walker'             => new SH_Walker_TaxonomyDropdown(),
              //   'show_option_all'    => '',
              //   'show_option_none'   => '',
              //   'option_none_value'  => '-1',
              //   'orderby'            => 'ID',
              //   'order'              => 'ASC',
              //   'show_count'         => 0,
              //   'hide_empty'         => 1,
              //   'child_of'           => 0,
              //   'exclude'            => '',
              //   'include'            => '',
              //   'echo'               => 1,
              //   'selected'           => esc_attr($categoria),
              //   'hierarchical'       => 0,
              //   'name'               => $this->get_field_name('categoria'),
              //   'id'                 => $this->get_field_id('categoria'),
              //   'class'              => 'postform',
              //   'depth'              => 0,
              //   'tab_index'          => 0,
              //   'taxonomy'           => 'category',
              //   'hide_if_empty'      => false,
              //   'value_field'        => 'slug',
              //   'value'              => 'slug'
              // ); 

              // wp_dropdown_categories( $args ); 
            ?> 
            <div style="font:12px; color:#666;">Caso queira exibir uma categoria especifica selecione uma categoria, só sera exibida as postagens desta categoria.<br>Deixe como "Todas Categorias" para exibir todos os posts com ou sem categorias.</div>
        </p -->
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['bloco_3']    = (!empty($new_instance['bloco_3'])   ?   strip_tags($new_instance['bloco_3']) : '');
    $instance['bloco_2']    = (!empty($new_instance['bloco_2'])   ?   strip_tags($new_instance['bloco_2']) : '');
    $instance['bloco_1']    = (!empty($new_instance['bloco_1'])   ?   strip_tags($new_instance['bloco_1']) : '');
    $instance['title']    = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    $instance['categoria']    = (!empty($new_instance['categoria'])    ?   strip_tags($new_instance['categoria'])  : '');
    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("posts_destacados_2"); });






/* Widget Social icones */

class social_icons extends WP_Widget
{
    function __construct()
    {
        parent::__construct("social_icons", "Dados de Redes Sociais", array('description' => "(Widget de configurações) gerais de dados de redes sociais"));
    }

    public function widget($args, $instance)
    {
          $facebook   = (!empty($instance['facebook']) ? $instance['facebook'] : "");
          $id_facebook   = (!empty($instance['id_facebook']) ? $instance['id_facebook'] : "");
          $token_facebook   = (!empty($instance['token_facebook']) ? $instance['token_facebook'] : "");
          $key_facebook   = (!empty($instance['key_facebook']) ? $instance['key_facebook'] : "");
          $id_twitter    = (!empty($instance['id_twitter']) ? $instance['id_twitter'] : "");
          $twitter    = (!empty($instance['twitter']) ? $instance['twitter'] : "");
          $instagram  = (!empty($instance['instagram']) ? $instance['instagram'] : "");
          $youtube    = (!empty($instance['youtube']) ? $instance['youtube'] : "");
          $behance  = (!empty($instance['behance']) ? $instance['behance'] : "");
          $colab55  = (!empty($instance['colab55']) ? $instance['colab55'] : "");
          $email      = (!empty($instance['email']) ? $instance['email'] : "");

          define(CONFIG_SOCIAL_LINK_FACEBOOK,   $facebook);
          define(CONFIG_SOCIAL_ID_FACEBOOK,   $id_facebook);
          define(CONFIG_SOCIAL_KEY_FACEBOOK,   $key_facebook);
          define(CONFIG_SOCIAL_TOKEN_FACEBOOK,   $token_facebook);
          define(CONFIG_SOCIAL_LINK_TWITTER,    $twitter);
          define(CONFIG_SOCIAL_ID_TWITTER,    $id_twitter);
          define(CONFIG_SOCIAL_LINK_INSTAGRAM,  $instagram);
          define(CONFIG_SOCIAL_LINK_YOUTUBE,    $youtube);
          define(CONFIG_SOCIAL_LINK_behance,  $behance);
          define(CONFIG_SOCIAL_colab55,       $colab55);
          define(CONFIG_SOCIAL_EMAIL,           $email);
    }
 
  public function form($instance)
  {

    if(isset($instance['facebook']))
    {
      $facebook = $instance['facebook'];
    }
    if(isset($instance['twitter']))
    {
      $twitter = $instance['twitter'];
    }
    if(isset($instance['instagram']))
    {
      $instagram = $instance['instagram'];
    }
    if(isset($instance['youtube']))
    {
      $youtube = $instance['youtube'];
    }
    if(isset($instance['behance']))
    {
      $behance = $instance['behance'];
    }
    if(isset($instance['email']))
    {
      $email = $instance['email'];
    }
    if(isset($instance['colab55']))
    {
      $colab55 = $instance['colab55'];
    }

    ?>      
    <p>
        <label for="<?php echo $this->get_field_id('facebook'); ?>" > <?php _e("Facebook:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" class="widefat" value="<?php echo esc_attr($facebook); ?>">
        <div style="font:12px; color:#666;"></div>

        <label for="<?php echo $this->get_field_id('twitter'); ?>" > <?php _e("Twitter:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" class="widefat" value="<?php echo esc_attr($twitter); ?>">
        <div style="font:12px; color:#666;"></div>
        
        <label for="<?php echo $this->get_field_id('instagram'); ?>" > <?php _e("Instagram:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" class="widefat" value="<?php echo esc_attr($instagram); ?>">
        <div style="font:12px; color:#666;"></div>
                
        <label for="<?php echo $this->get_field_id('youtube'); ?>" > <?php _e("Youtube:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" class="widefat" value="<?php echo esc_attr($youtube); ?>">
        <div style="font:12px; color:#666;"></div>
                
        <label for="<?php echo $this->get_field_id('behance'); ?>" > <?php _e("behance:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('behance'); ?>" name="<?php echo $this->get_field_name('behance'); ?>" class="widefat" value="<?php echo esc_attr($behance); ?>">
        <div style="font:12px; color:#666;"></div>

        <label for="<?php echo $this->get_field_id('colab55'); ?>" > <?php _e("colab55:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('colab55'); ?>" name="<?php echo $this->get_field_name('colab55'); ?>" class="widefat" value="<?php echo esc_attr($colab55); ?>">
        <div style="font:12px; color:#666;"></div>

        <label for="<?php echo $this->get_field_id('email'); ?>" > <?php _e("Email:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" class="widefat" value="<?php echo esc_attr($email); ?>">
        <div style="font:12px; color:#666;"></div>
    </p>



        
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['facebook']     = (!empty($new_instance['facebook'])      ?   strip_tags($new_instance['facebook'])  : '');
    $instance['twitter']      = (!empty($new_instance['twitter'])       ?   strip_tags($new_instance['twitter'])  : '');
    $instance['instagram']    = (!empty($new_instance['instagram'])     ?   strip_tags($new_instance['instagram'])  : '');
    $instance['youtube']      = (!empty($new_instance['youtube'])       ?   strip_tags($new_instance['youtube'])  : '');
    $instance['behance']    = (!empty($new_instance['behance'])     ?   strip_tags($new_instance['behance'])  : '');
    $instance['colab55']    = (!empty($new_instance['colab55'])     ?   strip_tags($new_instance['colab55'])  : '');
    $instance['email']        = (!empty($new_instance['email'])         ?   strip_tags($new_instance['email'])  : '');
    return $instance;
  }

}

add_action("widgets_init",function(){register_widget("social_icons"); });






add_action("widgets_init",function(){register_widget("category_template"); });
/* Widget para posts recentes */
class category_template extends WP_Widget
{
    function __construct()
    {
        parent::__construct("category_template", "Temas para categoria", array('description' => "(Widget de configurações) Escolha um tema para a pagina de categoria"));
    }

  public function widget($args, $instance)
  {
    echo $args[" "];
    global $sapoha;
    $sapoha = $instance['design'];
    define(TEMA_CATEGORIA, $instance['design']);        
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['design']))
    {
      $design = $instance['design'];
    }

    ?> 
    <p>
      <label for="<?php echo $this->get_field_id('design'); ?>" > <?php _e("Layout do Widget:"); ?></label> 
      <select name="<?php echo $this->get_field_name('design'); ?>" id="<?php echo $this->get_field_id('design'); ?>" class="postform">
          <option <?php echo (esc_attr($design) == 1 ? 'selected="selected"' : ''); ?> class="level-0" value="1">Padrão</option>
          <option <?php echo (esc_attr($design) == 2 ? 'selected="selected"' : ''); ?> class="level-1" value="2">Tema 2</option>
          <option <?php echo (esc_attr($design) == 3 ? 'selected="selected"' : ''); ?> class="level-2" value="3">Tema 3</option>
          <option <?php echo (esc_attr($design) == 4 ? 'selected="selected"' : ''); ?> class="level-3" value="4">Tema 4</option>
          <option <?php echo (esc_attr($design) == 5 ? 'selected="selected"' : ''); ?> class="level-5" value="5">Tema 5</option>
      </select>
    </p>
    <?php
  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['design']    = (!empty($new_instance['design'])    ?   strip_tags($new_instance['design'])  : '');
    return $instance;
  }

}





/* Widget para posts recentes */

class tag_template extends WP_Widget
{
    function __construct()
    {
        parent::__construct("tag_template", "Temas para Tags", array('description' => "(Widget de configurações) Escolha um tema para a pagina de tag"));
    }

  public function widget($args, $instance)
  {
    echo $args[" "];
    define(TEMA_TAG, $instance['design']); 
                 
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['design']))
    {
      $design = $instance['design'];
    }

    ?> 
    <p>
      <label for="<?php echo $this->get_field_id('design'); ?>" > <?php _e("Layout do Widget:"); ?></label> 
      <select name="<?php echo $this->get_field_name('design'); ?>" id="<?php echo $this->get_field_id('design'); ?>" class="postform">
          <option <?php echo (esc_attr($design) == 1 ? 'selected="selected"' : ''); ?> class="level-0" value="1">Padrão</option>
          <option <?php echo (esc_attr($design) == 2 ? 'selected="selected"' : ''); ?> class="level-1" value="2">Tema 2</option>
          <option <?php echo (esc_attr($design) == 3 ? 'selected="selected"' : ''); ?> class="level-2" value="3">Tema 3</option>
          <option <?php echo (esc_attr($design) == 4 ? 'selected="selected"' : ''); ?> class="level-3" value="4">Tema 4</option>
          <option <?php echo (esc_attr($design) == 5 ? 'selected="selected"' : ''); ?> class="level-5" value="5">Tema 5</option>
      </select>
    </p>
    <?php
  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['design']    = (!empty($new_instance['design'])    ?   strip_tags($new_instance['design'])  : '');
    return $instance;
  }

}

add_action("widgets_init",function(){register_widget("tag_template"); });






/* Widget para sliders com posts recentes */

class slider_posts extends WP_Widget
{
    function __construct()
    {
        parent::__construct("slider_posts", "Slider", array('description' => "Exibe os posts recentes ou posts por categoria."));
    }

  public function widget($args, $instance)
  {
        echo $args[" "];
       
       // $instance['design']
        $data_slide_to = 0.;

        $categoria = (!empty($instance['categoria']) && ($instance['categoria'] != 'todas-categorias') ? "&category_name=".$instance['categoria'] : "");
        $quantidade = (is_numeric($instance['quantidade']) && $instance['quantidade'] > 0) ? $instance['quantidade'] : 3;
        $design = $instance['design'];
        $title = $instance['title'];

        query_posts("showposts={$quantidade}{$categoria}");
        $contador_de_post = 0;
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
              $titulo     = get_the_title();
              $resumo     = resumo_txt(get_the_excerpt(),90,0);
              $resumo_titulo     = resumo_txt($titulo,60,0);
              $data_post  = get_the_date('d M Y');
              $autor      = get_the_author();
              $id_post    = get_the_ID();

              switch ($design)
              {
                case 1:
                    $html_destaques .= "
                  <div class=\"ls-slide\" data-ls=\"slidedelay:8000;transition2d:75,79;\">
                    <img src=\"".get_bloginfo( 'template_directory' )."/sliderimages/bg".($contador_de_post == 6 ? 1 : $contador_de_post).".jpg\" class=\"ls-bg\" alt=\"\"/>
                    <h1 class=\"ls-l\" style=\"top:15px;left:70px;white-space: nowrap;\" data-ls=\"offsetxin:50;durationin:2000;rotateyin:60;transformoriginin:right 50% 0;offsetxout:-50;durationout:6000;rotateyout:-60;transformoriginout:left 50% 0;\">$resumo_titulo</h1>
                    <p class=\"ls-l descricao_post\" style=\"top:130px;left:80%;\" data-ls=\"offsetxin:50;durationin:2000;rotateyin:60;transformoriginin:right 50% 0;offsetxout:-50;durationout:6000;rotateyout:-60;transformoriginout:left 50% 0;\">$resumo</p>
                    
                    <img class=\"thunbnail_post ls-l\" src=\"$the_post_thumbnail\" style=\"width:500px; top:130px;left:70px;white-space: nowrap;\" data-ls=\"offsetxin:0;rotateyin:60;durationin:2000;easingin:linear;offsetxout:0;durationout:6000;easingout:linear;\" alt=\"\">
                    <a href='$url' class='ls-l btn btn-default'  style=\"top:450px;left:900px;font-weight: 300; background: white; background: rgba(255,255,255,.85);height:40px;padding-right:10px;padding-left:10px;font-size:30px;line-height:37px;color:#bd5949;white-space: nowrap;\" data-ls=\"offsetxin:-50;durationin:2000;delayin:1000;offsetxout:-50;durationout:6000;\">Veja +</a>
                  </div>
                  ";

                  break;

                case 2:
                  $html_destaques .= " 
                  <div style=\"background-image: url('$img')\" class=\"item ".($contador_de_post == 1 ? 'active' : '')."\">
                    <div class=\"container\">
                      <div class=\"carousel-caption\">
                        <h1><a href=\"{$url}\">{$resumo_titulo}</a></h1>
                        <!--p>$resumo</p>
                        <p><a class=\"btn btn-lg btn-primary\" href=\"{$url}\" role=\"button\">Leia mais</a></p -->
                      </div>
                    </div>
                  </div>
                   ";
                
                break;

                case 3:
                  $html_destaques .= " 
                   <li><a href=\"$url\" style='background-image:url({$img});'></a></li>
                  ";
                
                break;

                case 4:
                  
                  $html_destaques .= " 
                   <div class=\"item ".($data_slide_to == 0 ? 'active' : '')."\" style='background-image: url({$img});'>
                       <div class=\"carousel-caption\">
                        <h4><a href=\"{$url}\">{$resumo_titulo}</a></h4>
                        <p>$resumo</p>
                        <a href='$url' class='pull-right ls-l btn btn-default' >Veja +</a>
                      </div>
                    </div><!-- End Item -->
                  ";

                  $lis_slider .= "<li data-target=\"#news_carousel\" data-slide-to=\"{$data_slide_to}\" class=\"list-group-item ".($data_slide_to == 0 ? 'active' : '')."\"><h4>{$resumo_titulo }</h4></li>";
                  $data_slide_to += 1; 
                break;

                
                default:
                  $html_destaques .= "
                  <div class=\"ls-slide\" data-ls=\"slidedelay:8000;transition2d:75,79;\">
                    <img src=\"".get_bloginfo( 'template_directory' )."/sliderimages/bg".($contador_de_post == 6 ? 1 : $contador_de_post).".jpg\" class=\"ls-bg\" alt=\"\"/>
                    <h1 class=\"ls-l\" style=\"top:15px;left:70px;white-space: nowrap;\" data-ls=\"offsetxin:50;durationin:2000;rotateyin:60;transformoriginin:right 50% 0;offsetxout:-50;durationout:6000;rotateyout:-60;transformoriginout:left 50% 0;\">$resumo_titulo</h1>
                    <p class=\"ls-l descricao_post\" style=\"top:130px;left:80%;\" data-ls=\"offsetxin:50;durationin:2000;rotateyin:60;transformoriginin:right 50% 0;offsetxout:-50;durationout:6000;rotateyout:-60;transformoriginout:left 50% 0;\">$resumo</p>
                    
                    <img class=\"thunbnail_post ls-l\" src=\"$the_post_thumbnail\" style=\"width:500px; top:130px;left:70px;white-space: nowrap;\" data-ls=\"offsetxin:0;rotateyin:60;durationin:2000;easingin:linear;offsetxout:0;durationout:6000;easingout:linear;\" alt=\"\">
                    <a href='$url' class='ls-l btn btn-default'  style=\"top:450px;left:900px;font-weight: 300; background: white; background: rgba(255,255,255,.85);height:40px;padding-right:10px;padding-left:10px;font-size:30px;line-height:37px;color:#bd5949;white-space: nowrap;\" data-ls=\"offsetxin:-50;durationin:2000;delayin:1000;offsetxout:-50;durationout:6000;\">Veja +</a>
                  </div>
                  ";
                  break;
              }

            endwhile;
            wp_reset_query();
        endif;
  

        switch ($design)
              {
                case 1:
                    $id_slider_wrapper = rand(0, 10000);
                    echo "
                      <div class=\"slider-wrapper\">
                        <div id=\"layerslider{$id_slider_wrapper}\" style=\"width:1280px;height:720px;max-width: 1280px;\">
                           $html_destaques
                        </div>
                      </div>
                      <script>
                        $(function(){ 
                          jQuery(\"#layerslider{$id_slider_wrapper}\").layerSlider({
                            pauseOnHover: false,
                            autoPlayVideos: false,
                            skinsPath: '".get_bloginfo( 'template_directory' )."/assets/skins/'
                          });
                          $('.ls-slide img').rotate(30);
                        });
                      </script>
                    ";
                  break;
                case 2:
                   $id_bootstrap_carousel = rand(0, 10000);
                   echo "
                    <div class='carousel_tipo_1'>
                      <div id=\"myCarousel{$id_bootstrap_carousel}\" class=\"carousel slide\" data-ride=\"carousel\">
                        <!-- Indicators -->
                        <!-- ol class=\"carousel-indicators\">
                          <li data-target=\"#myCarousel{$id_bootstrap_carousel}\" data-slide-to=\"0\" class=\"\"></li>
                          <li data-target=\"#myCarousel{$id_bootstrap_carousel}\" data-slide-to=\"1\" class=\"\"></li>
                          <li data-target=\"#myCarousel{$id_bootstrap_carousel}\" data-slide-to=\"2\" class=\"active\"></li>
                        </ol -->
                        <div class=\"carousel-inner\" role=\"listbox\">
                          $html_destaques
                        </div>
                        <a class=\"left carousel-control\" href=\"#myCarousel{$id_bootstrap_carousel}\" role=\"button\" data-slide=\"prev\">
                          <span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>
                          <span class=\"sr-only\">Previous</span>
                        </a>
                        <a class=\"right carousel-control\" href=\"#myCarousel{$id_bootstrap_carousel}\" role=\"button\" data-slide=\"next\">
                          <span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>
                          <span class=\"sr-only\">Next</span>
                        </a>
                      </div>
                    </div>
                   ";
                  break;

                  case 3: 
                   $id_slider = rand(0, 10000); 
                   echo "<div class=\"clearfix\"></div>
                    <div class='tipo_4 carousel_slider' style=\"position: relative;\">
                        ".($title == NULL ? "<div style='height:28px;'></div>" : "
                        <h3 class='subline_title'><span>$title</span></h3>")."

                        <ul id=\"clients-scroller-$id_slider\" class=\"our-clients clearfix\">
                        
                            $html_destaques
                        
                        </ul>
                        
                        <div class=\"widget-scroll-prev\" id=\"ourclients_prev$id_slider\"></div>
                        <div class=\"widget-scroll-next\" id=\"ourclients_next$id_slider\"></div>
                        
                        <script type=\"text/javascript\">
                            jQuery(document).ready(function($) {
                                
                                var clientsCarousel$id_slider = $(\"#clients-scroller-$id_slider\");
                                
                                clientsCarousel$id_slider.carouFredSel({
                                    width : \"100%\",
                                    height : \"auto\",
                                    circular : false,
                                    responsive : true,
                                    infinite : false,
                                    auto : false,
                                    items : {
                                        width : 160,
                                        visible: {
                                            min: 1,
                                            max: 6
                                        }
                                    },
                                    scroll : {
                                        wipe : true
                                    },
                                    prev : {  
                                        button : \"#ourclients_prev$id_slider\",
                                        key : \"left\"
                                    },
                                    next : { 
                                        button : \"#ourclients_next$id_slider\",
                                        key : \"right\"
                                    },
                                    onCreate : function () {
                                        $(window).on('resize', function(){
                                            clientsCarousel$id_slider.parent().add(clientsCarousel$id_slider).css('height', clientsCarousel$id_slider.children().first().outerHeight() + 'px');
                                        }).trigger('resize');
                                    }
                                });

                            });
                        
                        </script>
                    
                    </div>
                  ";
                  break;

                  case 4: 
                   $id_slider = rand(0, 10000); 
                   echo "
                    <div class=\"clearfix\"></div>
                    <div id=\"\" class=\"carousel news_carousel slide\" >
                      <div id=\"news_carousel\" class=\"carousel slide myCarousel\" data-ride=\"carousel\">
      
                        <!-- Wrapper for slides -->
                        <div class=\"carousel-inner\">
                        
                          {$html_destaques}
                                  
                        </div><!-- End Carousel Inner -->


                      <ul class=\"list-group col-sm-4\">
                        
                        {$lis_slider}

                      </ul>

                        <!-- Controls -->
                        <div class=\"carousel-controls\">
                            <a class=\"left carousel-control\" href=\"#news_carousel\" data-slide=\"prev\">
                              <span class=\"glyphicon glyphicon-chevron-left\"></span>
                            </a>
                            <a class=\"right carousel-control\" href=\"#news_carousel\" data-slide=\"next\">
                              <span class=\"glyphicon glyphicon-chevron-right\"></span>
                            </a>
                        </div>

                      </div>
                    </div><!-- End Carousel -->
                  ";
                  break;
                
                default:
                    $id_slider_wrapper = rand(0, 10000);
                    echo "
                      <div class=\"slider-wrapper\">
                        <div id=\"layerslider{$id_slider_wrapper}\" style=\"width:1280px;height:720px;max-width: 1280px;\">
                           $html_destaques
                        </div>
                      </div>
                      <script>
                        $(function(){ 
                          jQuery(\"#layerslider{$id_slider_wrapper}\").layerSlider({
                            pauseOnHover: false,
                            autoPlayVideos: false,
                            skinsPath: '".get_bloginfo( 'template_directory' )."/assets/skins/'
                          });
                        });
                      </script>
                    ";
                  break;
              }

           
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['categoria']))
    {
      $categoria = $instance['categoria'];
    }

    if(isset($instance['design']))
    {
      $design = $instance['design'];
    }

    if(isset($instance['quantidade']))
    {
        $quantidade = $instance['quantidade'];
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
            <label for="<?php echo $this->get_field_id('quantidade'); ?>" > <?php _e("Quantidade de posts:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('quantidade'); ?>" name="<?php echo $this->get_field_name('quantidade'); ?>" class="widefat" value="<?php echo esc_attr($quantidade); ?>">
            <div style="font:12px; color:#666;">Digite o numero máximo de posts para serem exibidos</div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('design'); ?>" > <?php _e("Layout do Slider:"); ?></label>
            
            <select name="<?php echo $this->get_field_name('design'); ?>" id="<?php echo $this->get_field_id('design'); ?>" class="postform">
              <option <?php echo (esc_attr($design) == 2 ? 'selected="selected"' : ''); ?> class="level-1" value="2">Padrão com setas</option>
              <option <?php echo (esc_attr($design) == 4 ? 'selected="selected"' : ''); ?> class="level-2" value="4">Com menu lateral</option>
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
            <div style="font:12px; color:#666;">Caso queira exibir uma categoria especifica selecione uma categoria, só sera exibida as postagens desta categoria.<br>Deixe como "Todas Categorias" para exibir todos os posts com ou sem categorias.<br><b>Dica:</b><p>Crie uma categoria chamada slider e adicione nos posts que deseja exibir no slider.</p></div>
        </p>




        
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title']        = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    $instance['categoria']    = (!empty($new_instance['categoria'])    ?   strip_tags($new_instance['categoria'])  : '');
    $instance['quantidade']   = (!empty($new_instance['quantidade'])   ?   strip_tags($new_instance['quantidade']) : '');
    $instance['design']       = (!empty($new_instance['design'])   ?   strip_tags($new_instance['design']) : '');
    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("slider_posts"); });



class New_Widget_Text extends WP_Widget {

  /**
   * Sets up a new Text widget instance.
   *
   * @since 2.8.0
   * @access public
   */
  public function __construct() {
    $widget_ops = array(
      'classname' => 'widget_text',
      'description' => __( 'Arbitrary text or HTML.' ),
      'customize_selective_refresh' => true,
    );
    $control_ops = array( 'width' => 400, 'height' => 350 );
    parent::__construct( 'text', __( 'Text' ), $widget_ops, $control_ops );
  }

  /**
   * Outputs the content for the current Text widget instance.
   *
   * @since 2.8.0
   * @access public
   *
   * @param array $args     Display arguments including 'before_title', 'after_title',
   *                        'before_widget', and 'after_widget'.
   * @param array $instance Settings for the current Text widget instance.
   */
  public function widget( $args, $instance ) {

    /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
    $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

    $widget_text = ! empty( $instance['text'] ) ? $instance['text'] : '';

    /**
     * Filters the content of the Text widget.
     *
     * @since 2.3.0
     * @since 4.4.0 Added the `$this` parameter.
     *
     * @param string         $widget_text The widget content.
     * @param array          $instance    Array of settings for the current widget.
     * @param WP_Widget_Text $this        Current Text widget instance.
     */
    $text = apply_filters( 'widget_text', $widget_text, $instance, $this );


      echo '<div class="textwidget">';
      if ( ! empty( $title ) ) {
        echo "<h3><span>$title</span></h3>"; 
      }
      echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text;
      echo '</div>';
  }

  /**
   * Handles updating settings for the current Text widget instance.
   *
   * @since 2.8.0
   * @access public
   *
   * @param array $new_instance New settings for this instance as input by the user via
   *                            WP_Widget::form().
   * @param array $old_instance Old settings for this instance.
   * @return array Settings to save or bool false to cancel saving.
   */
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = sanitize_text_field( $new_instance['title'] );
    if ( current_user_can( 'unfiltered_html' ) ) {
      $instance['text'] = $new_instance['text'];
    } else {
      $instance['text'] = wp_kses_post( $new_instance['text'] );
    }
    $instance['filter'] = ! empty( $new_instance['filter'] );
    return $instance;
  }

  /**
   * Outputs the Text widget settings form.
   *
   * @since 2.8.0
   * @access public
   *
   * @param array $instance Current settings.
   */
  public function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
    $filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
    $title = sanitize_text_field( $instance['title'] );
    ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

    <p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Content:' ); ?></label>
    <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>

    <p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
    <?php
  }
}
add_action("widgets_init",function(){register_widget("New_Widget_Text"); });



class Widget_link extends WP_Widget {

  public function __construct()
  {
      parent::__construct("Widget_link*", "Link", array('description' => "Exibe um link"));
  }

  public function widget( $args, $instance ) {
    $title = !empty( $instance['title'] ) ? $instance['title'] : '';
    $text = !empty( $instance['text'] ) ? $instance['text'] : '';
    $link = !empty( $instance['link'] ) ? $instance['link'] : '';

    echo '<div class="widget_link">';
      if ( ! empty( $title ) ) {
        echo "<h3><span>$title</span></h3>"; 
      }
      echo "<a href='$link'>";
      echo !empty( $instance['filter'] ) ? wpautop( $text ) : $text;
      echo "</a></div>";
  }


  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title']  = sanitize_text_field( $new_instance['title'] );
    if ( current_user_can( 'unfiltered_html' ) ) {
      $instance['text'] = $new_instance['text'];
    } else {
      $instance['text'] = wp_kses_post( $new_instance['text'] );
    }
    $instance['link']    = (!empty($new_instance['link'])    ?   strip_tags($new_instance['link'])  : '');
    return $instance;
  }

  public function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
    $link     =  $instance['link'];
    $title    = sanitize_text_field( $instance['title'] );
    ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

    <p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('link:'); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></p>

    <p><label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Texto:' ); ?></label>
    <input name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_textarea( $instance['text'] ); ?>" class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"></p>

    <?php
  }
}
add_action("widgets_init",function(){register_widget("Widget_link"); });





/* Widget para posts recentes */
class widget_social_icons extends WP_Widget
{
  function __construct()
  {
      parent::__construct("widget_social_icons*", "Redes Sociais", array('description' => "Exibe os icones de Redes Sociais"));
  }

  public function widget($args, $instance)
  {


    if(isset($instance['twitter']))
    {
      $twitter = $instance['twitter'];
    }

    if(isset($instance['instagram']))
    {
      $instagram = $instance['instagram'];
    }

    if(isset($instance['youtube']))
    {
      $youtube = $instance['youtube'];
    }

    if(isset($instance['colab55']))
    {
      $colab55 = $instance['colab55'];
    }

     if(isset($instance['behance']))
    {
      $behance = $instance['behance'];
    }

    if(isset($instance['facebook']))
    {
      $facebook = $instance['facebook'];
    }

    if(isset($instance['design']))
    {
      $design = $instance['design'];
    }

    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    if(isset($instance['colab55']))
    {
      $colab55 = $instance['colab55'];
    }

    if(isset($instance['google_plus']))
    {
      $google_plus = $instance['google_plus'];
    }

    if(isset($instance['email']))
    {
      $email = $instance['email'];
    }



        switch($design):
          case 1:
          $html_destaques .= "
           <div class=\"col-md-12\">
             <div class=\"social_footer\">
                <h3>$title</h3>
                <p>Acompanhe nosso trabalho em outras plataformas</p>
                <div id=\"rodape_social_icons\" class=\"social-links\">
                  ".(($facebook != NULL) ? "<a target=\"_blank\" href=\"$facebook\"><img class=\"img-responsive\" src=\"".get_bloginfo('template_directory')."/imagens/espera/redes-sociais-facebook.jpg\"></a>" : "")."
                  ".(($twitter != NULL) ? "<a target=\"_blank\" href=\"$twitter\"><img class=\"img-responsive\" src=\"".get_bloginfo('template_directory')."/imagens/twitter_logo.jpg\"></a>" : "")."
                  ".(($instagram != NULL) ? "<a target=\"_blank\" href=\"$instagram\"><img class=\"img-responsive\" src=\"".get_bloginfo('template_directory')."/imagens/espera/redes-sociais-instagram.jpg\"></a>" : "")."
                  ".(($youtube != NULL) ? "<a target=\"_blank\" href=\"$youtube\"><img class=\"img-responsive\" src=\"".get_bloginfo('template_directory')."/imagens/youtube_logo2.jpg\"></a>" : "")."
                  ".(($behance != NULL) ? "<a target=\"_blank\" href=\"$behance\"><img class=\"img-responsive\" src=\"".get_bloginfo('template_directory')."/imagens/espera/redes-sociais-behance.jpg\"></a>" : "")."
                  ".(($colab55 != NULL) ? "<a target=\"_blank\" href=\"$colab55\"><img class=\"img-responsive\" src=\"".get_bloginfo('template_directory')."/imagens/espera/redes-sociais-colab55.jpg\"></a>" : "")."
                  ".(($google_plus != NULL) ? "<a target=\"_blank\" href=\"$google_plus\"><img class=\"img-responsive\" src=\"".get_bloginfo('template_directory')."/imagens/plus_logo.png\"></a>" : "")."
                  ".(($email != NULL) ? "<a target=\"_blank\" href=\"$email\"><img class=\"img-responsive\" src=\"".get_bloginfo('template_directory')."/imagens/envelope_logo.png\"></a>" : "")."
                </div>
              </div>
            </div>
          ";
          break;
          case 2:
          $html_destaques .= "
            <div id=\"social_icons_top\" class=\"\">
              <h3>$title</h3>
              ".(($facebook != NULL) ? "<a href=\"$facebook\"><img src=\"".get_bloginfo( 'template_directory' )."/imagens/facebook_logo2.jpg\"></a>" : "")."
              ".(($twitter != NULL) ? "<a href=\"$twitter\"><img src=\"".get_bloginfo( 'template_directory' )."/imagens/twitter_logo2.jpg\"></a>" : "")."
              ".(($email != NULL) ? "<a href=\"mailto:$email\"><img src=\"".get_bloginfo( 'template_directory' )."/imagens/envelope_logo.jpg\"></a>" : "")."
              ".(($instagram != NULL) ? "<a href=\"$instagram\"><img src=\"".get_bloginfo( 'template_directory' )."/imagens/instagram_logo.jpg\"></a>" : "")."
              ".(($youtube != NULL) ? "<a href=\"$youtube\"><img src=\"".get_bloginfo( 'template_directory' )."/imagens/youtube_logo.jpg\"></a>" : "")."
              ".(($google_plus != NULL) ? "<a href=\"$google_plus\"><img src=\"".get_bloginfo( 'template_directory' )."/imagens/plus_logo2.jpg\"></a>" : "")."
              ".(($behance != NULL) ? "<a href=\"$behance\"><img src=\"".get_bloginfo( 'template_directory' )."/imagens/behance_logo2.jpg\"></a>" : "")."
              ".(($colab55 != NULL) ? "<a href=\"$colab55\"><img src=\"".get_bloginfo( 'template_directory' )."/imagens/vk_logo2.jpg\"></a>" : "")."
            </div>
          ";
          break;
          case 3:
          $html_destaques .= "
            <div class=\"social-link-info clearfix nav-social-wrap\">
                ".(($facebook != NULL) ? "<a class=\"color-facebook\" href=\"$facebook\" target=\"_blank\"><i class=\"fa fa-facebook\"></i></a>" : "")."
                ".(($twitter != NULL) ? "<a class=\"color-twitter\" href=\"$twitter\" target=\"_blank\"><i class=\"fa fa-twitter\"></i></a>" : "")."
                ".(($behance != NULL) ? "<a class=\"color-behance\" href=\"$behance\" target=\"_blank\"><i class=\"fa fa-behance\"></i></a>" : "")."
                ".(($google_plus != NULL) ? "<a class=\"color-plus\" href=\"$google_plus\" target=\"_blank\"><i class=\"fa fa-google-plus\"></i></a>" : "")."
                ".(($instagram != NULL) ? "<a class=\"color-instagram\" href=\"$instagram\" target=\"_blank\"><i class=\"fa fa-instagram\"></i></a>" : "")."
                ".(($colab55 != NULL) ? "<a class=\"color-vk\" href=\"$colab55\" target=\"_blank\"><i class=\"fa fa-vk\"></i></a>" : "")."
                ".(($youtube != NULL) ? "<a class=\"color-youtube\" href=\"$youtube\" target=\"_blank\"><i class=\"fa fa-youtube\"></i></a>" : "")."
                <a class=\"color-rss\" href=\"".get_bloginfo('rss_url')."\" target=\"_blank\"><i class=\"fa fa-rss\"></i></a>
            </div>
          ";
          break;
          case 4:
          $html_destaques .= "
            <div class=\"social-link-info social_icons_2 clearfix nav-social-wrap\">
                ".(($facebook != NULL) ? "<a class=\"color-facebook\" href=\"$facebook\" target=\"_blank\"><i class=\"fa fa-facebook\"></i></a>" : "")."
                ".(($twitter != NULL) ? "<a class=\"color-twitter\" href=\"$twitter\" target=\"_blank\"><i class=\"fa fa-twitter\"></i></a>" : "")."
                ".(($behance != NULL) ? "<a class=\"color-behance\" href=\"$behance\" target=\"_blank\"><i class=\"fa fa-behance\"></i></a>" : "")."
                ".(($google_plus != NULL) ? "<a class=\"color-plus\" href=\"$google_plus\" target=\"_blank\"><i class=\"fa fa-google-plus\"></i></a>" : "")."
                ".(($instagram != NULL) ? "<a class=\"color-instagram\" href=\"$instagram\" target=\"_blank\"><i class=\"fa fa-instagram\"></i></a>" : "")."
                ".(($colab55 != NULL) ? "<a class=\"color-vk\" href=\"$colab55\" target=\"_blank\"><i class=\"fa fa-vk\"></i></a>" : "")."
                ".(($youtube != NULL) ? "<a class=\"color-youtube\" href=\"$youtube\" target=\"_blank\"><i class=\"fa fa-youtube\"></i></a>" : "")."
                <a class=\"color-rss\" href=\"".get_bloginfo('rss_url')."\" target=\"_blank\"><i class=\"fa fa-rss\"></i></a>
            </div>
          ";
          break;
        endswitch;

        echo "$html_destaques";   
  }
 
  public function form($instance)
  {
    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    if(isset($instance['email']))
    {
      $email = $instance['email'];
    }

     if(isset($instance['design']))
    {
      $design = $instance['design'];
    }
    
    if(isset($instance['twitter']))
    {
      $twitter = $instance['twitter'];
    }

    if(isset($instance['instagram']))
    {
      $instagram = $instance['instagram'];
    }

    if(isset($instance['youtube']))
    {
      $youtube = $instance['youtube'];
    }

    if(isset($instance['behance']))
    {
      $behance = $instance['behance'];
    }

    if(isset($instance['facebook']))
    { 
      $facebook = $instance['facebook'];
    }

    if(isset($instance['colab55']))
    { 
      $colab55 = $instance['colab55'];
    }

    if(isset($instance['google_plus']))
    { 
      $google_plus = $instance['google_plus'];
    }
    ?> 
    <p>
      <label for="<?php echo $this->get_field_id('title'); ?>" > <?php _e("Titulo:"); ?></label>
      <input type='text' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
      <div style="font:12px; color:#666;"> </div>
    </p>     
    <p>
      <label for="<?php echo $this->get_field_id('design'); ?>" > <?php _e("Desing:"); ?></label>
      
      <select name="<?php echo $this->get_field_name('design'); ?>" id="<?php echo $this->get_field_id('design'); ?>" class="widget_social_design postform">
        <option <?php echo (esc_attr($design) == 1 ? 'selected="selected"' : ''); ?> class="level-0" value="1">Design 1</option>
        <option <?php echo (esc_attr($design) == 2 ? 'selected="selected"' : ''); ?> class="level-1" value="2">Design 2</option>
        <option <?php echo (esc_attr($design) == 3 ? 'selected="selected"' : ''); ?> class="level-2" value="3">Design 3</option>
        <option <?php echo (esc_attr($design) == 4 ? 'selected="selected"' : ''); ?> class="level-3" value="4">Design 4</option>
      </select>
    </p>
    <div class='links_sociais'>
      <p>
        <label for="<?php echo $this->get_field_id('facebook'); ?>" > <?php _e("Facebook:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" class="widefat" value="<?php echo esc_attr($facebook); ?>">
        <div style="font:12px; color:#666;"></div>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('email'); ?>" > <?php _e("E-mail:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" class="widefat" value="<?php echo esc_attr($email); ?>">
        <div style="font:12px; color:#666;"> </div>
      </p> 
      <p>
        <label for="<?php echo $this->get_field_id('twitter'); ?>" > <?php _e("twitter:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" class="widefat" value="<?php echo esc_attr($twitter); ?>">
        <div style="font:12px; color:#666;"></div>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('instagram'); ?>" > <?php _e("instagram:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" class="widefat" value="<?php echo esc_attr($instagram); ?>">
        <div style="font:12px; color:#666;"></div>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('youtube'); ?>" > <?php _e("youtube:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" class="widefat" value="<?php echo esc_attr($youtube); ?>">
        <div style="font:12px; color:#666;"></div>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('behance'); ?>" > <?php _e("behance:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('behance'); ?>" name="<?php echo $this->get_field_name('behance'); ?>" class="widefat" value="<?php echo esc_attr($behance); ?>">
        <div style="font:12px; color:#666;"></div>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('colab55'); ?>" > <?php _e("colab55:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('colab55'); ?>" name="<?php echo $this->get_field_name('colab55'); ?>" class="widefat" value="<?php echo esc_attr($colab55); ?>">
        <div style="font:12px; color:#666;"></div>
      </p>
      <p>
        <label for="<?php echo $this->get_field_id('google_plus'); ?>" > <?php _e("Google Plus:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('google_plus'); ?>" name="<?php echo $this->get_field_name('google_plus'); ?>" class="widefat" value="<?php echo esc_attr($google_plus); ?>">
        <div style="font:12px; color:#666;"></div>
      </p>
    </div>
    <?php
  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title']    = (!empty($new_instance['title'])    ?   strip_tags($new_instance['title'])  : '');
    $instance['email']    = (!empty($new_instance['email'])    ?   strip_tags($new_instance['email'])  : '');
    $instance['design']    = (!empty($new_instance['design'])    ?   strip_tags($new_instance['design'])  : '');
    $instance['facebook']    = (!empty($new_instance['facebook'])    ?   strip_tags($new_instance['facebook'])  : '');
    $instance['twitter']    = (!empty($new_instance['twitter'])    ?   strip_tags($new_instance['twitter'])  : '');
    $instance['instagram']    = (!empty($new_instance['instagram'])    ?   strip_tags($new_instance['instagram'])  : '');
    $instance['youtube']    = (!empty($new_instance['youtube'])    ?   strip_tags($new_instance['youtube'])  : '');
    $instance['behance']    = (!empty($new_instance['behance'])    ?   strip_tags($new_instance['behance'])  : '');
    $instance['colab55']    = (!empty($new_instance['colab55'])    ?   strip_tags($new_instance['colab55'])  : '');
    $instance['google_plus']    = (!empty($new_instance['google_plus'])    ?   strip_tags($new_instance['google_plus'])  : '');

    return $instance;
  }

}

add_action("widgets_init",function(){register_widget("widget_social_icons"); });





/* Widget para posts recentes */

class listar_tags_post extends WP_Widget
{
    function __construct()
    {
        parent::__construct("listar_tags_post", "Listar Tags ou Categorias", array('description' => "Exibe os posts recentes"));
    }

  public function widget($args, $instance)
  {
        if(isset($instance['title'])){
            $title = apply_filters('widget_title', $instance["title"]);
        }
        echo $args[" "];
        
        $taxonomia =$instance['taxonomia'];
        $design = $instance['design'];
        $titulo_plugin = $instance['title'];

        switch($design):
          case 1: 
            if($taxonomia == 'category'){
              $tag_ids = wp_get_post_categories(get_the_ID(), array( 'fields' => 'ids' ) );
            }else{
               $tag_ids = wp_get_post_tags(get_the_ID(), array( 'fields' => 'ids' ) );
            }


            $titulo_plugin_html = !empty($titulo_plugin) ? "<h3><span>".$titulo_plugin."</span></h3>" : '';
            if(is_single()){
              if(count($tag_ids) > 0){
                $html_widget = wp_tag_cloud( apply_filters( 'listar_tags_post', array(
                          'taxonomy' => $taxonomia,
                          'echo' => false,
                          'include'  => $tag_ids
                )));
              }else{
                if($taxonomia == 'category'){
                  $html_widget = '&nbsp;&nbsp;Sem Categorias';
                }else{
                  $html_widget = '&nbsp;&nbsp;Sem Tags';
                }
              }
            }else{
              $html_widget = wp_tag_cloud( apply_filters( 'listar_tags_post', array(
                        'taxonomy' => $taxonomia,
                        'echo' => false
              )));
            }
            echo "
              <div class=\"tagcloud\">
                  $titulo_plugin_html
                  $html_widget
              </div>
              "; 
          break;
          case 2:            
            if($taxonomia == 'category'){
              $tag_ids = wp_get_post_categories(get_the_ID(), array( 'fields' => 'ids' ) );
            }else{
               $tag_ids = wp_get_post_tags(get_the_ID(), array( 'fields' => 'ids' ) );
            }

            $titulo_plugin_html = !empty($titulo_plugin) ? "<span>".$titulo_plugin."</span>" : '';
            
            if(is_single()){
              if(count($tag_ids) > 0){
                $html_widget = wp_tag_cloud( apply_filters( 'listar_tags_post', array(
                          'taxonomy' => $taxonomia,
                          'echo' => false,
                          'include'  => $tag_ids
                )));
              }else{
                if($taxonomia == 'category'){
                  $html_widget = '&nbsp;&nbsp;Sem Categorias';
                }else{
                  $html_widget = '&nbsp;&nbsp;Sem Tags';
                }
              }
            }else{
              $html_widget = wp_tag_cloud( apply_filters( 'listar_tags_post', array(
                        'taxonomy' => $taxonomia,
                        'echo' => false
              )));
            }
            $html_widget = preg_replace("/style='font-size: [0-9.]*pt;'/i", "", $html_widget);
            echo "
              <div class=\"bt_tags\">
                  $titulo_plugin_html
                  $html_widget
              </div>
              "; 
          break;
        endswitch;                

    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['design']))
    {
      $design = $instance['design'];
    }

    if(isset($instance['taxonomia']))
    {
      $taxonomia = $instance['taxonomia'];
    }

    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }
    else
    {
      $title = "";
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
            <label for="<?php echo $this->get_field_id('taxonomia'); ?>" > <?php _e("Taxonomia:"); ?></label>
            
            <select name="<?php echo $this->get_field_name('taxonomia'); ?>" id="<?php echo $this->get_field_id('taxonomia'); ?>" class="postform">
              <option <?php echo (esc_attr($taxonomia) == 'post_tag' ? 'selected="selected"' : ''); ?> class="level-0" value="post_tag">Tags</option>
              <option <?php echo (esc_attr($taxonomia) == 'category' ? 'selected="selected"' : ''); ?> class="level-1" value="category">Categorias</option>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('design'); ?>" > <?php _e("Design:"); ?></label>
            
            <select name="<?php echo $this->get_field_name('design'); ?>" id="<?php echo $this->get_field_id('design'); ?>" class="postform">
              <option <?php echo (esc_attr($design) == 1 ? 'selected="selected"' : ''); ?> class="level-0" value="1">Nuvem</option>
              <option <?php echo (esc_attr($design) == 2 ? 'selected="selected"' : ''); ?> class="level-1" value="2">Botões</option>
            </select>
        </p>

        
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['taxonomia']    = (!empty($new_instance['taxonomia'])    ?   strip_tags($new_instance['taxonomia'])  : '');
    $instance['title']        = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    $instance['quantidade']   = (!empty($new_instance['quantidade'])   ?   strip_tags($new_instance['quantidade']) : '');
    $instance['design']       = (!empty($new_instance['design'])   ?   strip_tags($new_instance['design']) : '');
    return $instance;
  }

}

add_action("widgets_init",function(){register_widget("listar_tags_post"); });

/* Widget para posts recentes */

class config_fontes extends WP_Widget
{
    function __construct()
    {
        parent::__construct("config_fontes", "Fontes", array('description' => "(Widget de configurações) Modifica as fontes padrões do tema"));
    }

  public function widget($args, $instance)
  {
     $title    = sanitize_text_field( $instance['title'] );
    $fontes   = (!empty($instance['fontes']) ? $instance['fontes'] : "");
    $tipo_texto   = (!empty($instance['tipo_texto']) ? $instance['tipo_texto'] : "");
    $link   = (!empty($instance['link']) ? $instance['link'] : "");
    $nome   = (!empty($instance['nome']) ? $instance['nome'] : "");
    $cor   = (!empty($instance['cor']) ? $instance['cor'] : "");
    $estilo   = (!empty($instance['estilo']) ? $instance['estilo'] : "");
    $size   = (!empty($instance['size']) ? $instance['size'] : "");
    $_SESSION['fontes_config'][$tipo_texto][] = array('fontes' => $fontes, 'link' => $link, 'nome' => $nome, 'cor' => $cor, 'size' => $size, 'estilo' => $estilo);
  }
 
  public function form($instance)
  {
     $title    = sanitize_text_field( $instance['title'] );

    if(isset($instance['fontes']))
    {
      $fontes = $instance['fontes'];
    }

    if(isset($instance['tipo_texto']))
    {
      $tipo_texto = $instance['tipo_texto'];
    }

    if(isset($instance['link']))
    {
      $link = $instance['link'];
    }

    if(isset($instance['nome']))
    {
      $nome = $instance['nome'];
    }

    if(isset($instance['cor']))
    {
      $cor = $instance['cor'];
    }

    if(isset($instance['estilo']))
    {
      $estilo = $instance['estilo'];
    }

    if(isset($instance['size']))
    {
      $size = $instance['size'];
    }

      $options = options_fontes(esc_attr($fontes));

    $instance['title'] = $tipo_texto;
    $title    = sanitize_text_field( $instance['title'] );


    ?>  <input type='hidden' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
        <p>
            <label for="<?php echo $this->get_field_id('tipo_texto'); ?>" > <?php _e("Selecione o tipo de texto:"); ?></label>
            
            <select name="<?php echo $this->get_field_name('tipo_texto'); ?>" id="<?php echo $this->get_field_id('tipo_texto'); ?>" class="postform">
              <option <?php echo (esc_attr($tipo_texto) == 'Títulos das Paginas' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Títulos das Paginas">Títulos das Paginas</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Texto geral' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Texto geral">Texto geral</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Links' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Links">Links</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Destaques' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Destaques">Widget Destaques</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Destacar post' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Destacar post">Widget Destacar post</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Slider - Titulo' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Slider - Titulo">Widget Slider - Titulo</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Slider - Descrição' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Slider - Descrição">Widget Slider - Descrição</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Slider - Menu lateral' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Slider - Menu lateral">Widget Slider - Menu lateral</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Destaques 2' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Destaques 2">Widget Destaques 2</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Posts Recentes' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Posts Recentes">Widget Posts Recentes</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Texto' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Texto">Widget Texto</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Menu topo' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Menu topo">Menu topo</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Titulos - Rodape' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Titulos - Rodape">Titulos - Rodape</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Textos - Rodape' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Textos - Rodape">Textos - Rodape</option>
              
              <option <?php echo (esc_attr($tipo_texto) == 'gontes padrões' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Titulo - Rodape copytight">Titulo - Rodape copytight</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('estilo'); ?>" > <?php _e("Estilo de fonte:"); ?></label>
            
            <select name="<?php echo $this->get_field_name('estilo'); ?>" id="<?php echo $this->get_field_id('estilo'); ?>" class="postform">
              <option <?php echo (esc_attr($estilo) == 'normal' ? 'selected="selected"' : ''); ?> class="level-0" value="normal">Regular</option>
              <option <?php echo (esc_attr($estilo) == 'bold' ? 'selected="selected"' : ''); ?> class="level-0" value="bold">bold</option>
              <option <?php echo (esc_attr($estilo) == 'lighter' ? 'selected="selected"' : ''); ?> class="level-0" value="lighter">Lighter</option>
              <option <?php echo (esc_attr($estilo) == 'italic' ? 'selected="selected"' : ''); ?> class="level-0" value="italic">Italic</option>
            </select>
        </p>
        <div id='select_fontes'>
          <p>
              <label for="<?php echo $this->get_field_id('fontes'); ?>" > <?php _e("fontes:"); ?></label>
              
              <select name="<?php echo $this->get_field_name('fontes'); ?>" id="<?php echo $this->get_field_id('fontes'); ?>" class="postform">
                <option <?php echo (esc_attr($fontes) == 'defaut' ? 'selected="selected"' : ''); ?> class="level-0" value="defaut">Padrão do tema</option>
                <?php echo $options;?>
              </select>
          </p>
        </div>
        <p>
            <label for="<?php echo $this->get_field_id('size'); ?>" > <?php _e("Tamanho do texto:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" class="widefat" value="<?php echo esc_attr($size); ?>">
            <div style="font:12px; color:#666;">Use 'px' ou 'em', exemplo 16px, 1.5em. Deixe em branco caso queira manter o valor padrão do tema.</div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cor'); ?>" > <?php _e("Cor do texto:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('cor'); ?>" name="<?php echo $this->get_field_name('cor'); ?>" class="widefat" value="<?php echo esc_attr($cor); ?>">
            <div style="font:12px; color:#666;">Use valor hexadecimal, exemplo: '#333333' ou o nome da cor em inglês, exemplo: 'red'. Deixe em branco caso queira manter o valor padrão do tema.</div>
        </p>
        <hr>
        
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title']    = (!empty($new_instance['title'])    ?   strip_tags($new_instance['title'])  : '');
    $instance['fontes']    = (!empty($new_instance['fontes'])    ?   strip_tags($new_instance['fontes'])  : '');
    $instance['tipo_texto']        = (!empty($new_instance['tipo_texto'])   ?   strip_tags($new_instance['tipo_texto']) : '');
    $instance['link']        = (!empty($new_instance['link'])   ?   strip_tags($new_instance['link']) : '');
    $instance['estilo']        = (!empty($new_instance['estilo'])   ?   strip_tags($new_instance['estilo']) : '');
    $instance['nome']        = (!empty($new_instance['nome'])   ?   strip_tags($new_instance['nome']) : '');
    $instance['cor']        = (!empty($new_instance['cor'])   ?   strip_tags($new_instance['cor']) : '');
    $instance['size']        = (!empty($new_instance['size'])   ?   strip_tags($new_instance['size']) : '');
    return $instance;
  }

}

add_action("widgets_init",function(){register_widget("config_fontes"); });

add_action("widgets_init",function(){register_widget("video"); });

/* Widget para posts recentes */
class video extends WP_Widget
{
  function __construct()
  {
      parent::__construct("video", "Video", array('description' => "Para adicionar videos como do youtube"));
  }

  public function widget($args, $instance)
  {
    echo $args["before_widget"];
    
    if(isset($instance['link_video']))
    {
      $link_video = $instance['link_video'];
    } 

    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    if(isset($instance['width']))
    {
      $width = $instance['width'];
      $width = "width:$width;";
    }

    if(isset($instance['height']))
    {
      $height = $instance['height'];
      $height = "height:$height;";
    }

    if(!empty($height) || !empty($width)){
      $style  = "style='$width $height'";
    }



    if (!empty( $title )) {
      $titulo = "<h3><span>$title</span></h3>"; 
    }
    echo "
    <div class=\"textwidget\">
      $titulo
      <div $style class=\"embed-responsive embed-responsive-16by9\">
        <iframe class=\"embed-responsive-item\" src=\"$link_video\" width=\"300\" height=\"150\"></iframe>
      </div>
    </div>
    ";   

    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['link_video']))
    {
      $link_video = $instance['link_video'];
    }

    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    if(isset($instance['height']))
    {
      $height = $instance['height'];
    }

    if(isset($instance['width']))
    {
      $width = $instance['width'];
    }

   

    ?> 

    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>" > <?php _e("Titulo:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
        <div style="font:12px; color:#666;"> </div>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id('link_video'); ?>" > <?php _e("Link do video:"); ?></label>
      <input type='text' id="<?php echo $this->get_field_id('link_video'); ?>" name="<?php echo $this->get_field_name('link_video'); ?>" class="widefat" value="<?php echo esc_attr($link_video); ?>">
      <div style="font:12px; color:#666;"></div>
    </p>

     <p>
        <label for="<?php echo $this->get_field_id('width'); ?>" > <?php _e("Largura:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" class="widefat" value="<?php echo esc_attr($width); ?>">
        <div style="font:12px; color:#666;">Exemplo 500px ou 100%</div>
    </p>

     <p>
        <label for="<?php echo $this->get_field_id('height'); ?>" > <?php _e("Altura:"); ?></label>
        <input type='text' id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" class="widefat" value="<?php echo esc_attr($height); ?>">
        <div style="font:12px; color:#666;">Exemplo 500px ou 100%</div>
    </p>
    <?php
  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title']    = (!empty($new_instance['title'])    ?   strip_tags($new_instance['title'])  : '');
    $instance['width']    = (!empty($new_instance['width'])    ?   strip_tags($new_instance['width'])  : '');
    $instance['height']    = (!empty($new_instance['height'])    ?   strip_tags($new_instance['height'])  : '');
    $instance['link_video']    = (!empty($new_instance['link_video'])    ?   strip_tags($new_instance['link_video'])  : '');
    return $instance;
  }

}













/* Widget para posts recentes */

class destaca_post_unico extends WP_Widget
{
    function __construct()
    {
        parent::__construct("destaca_post_unico", "Destacar Post", array('description' => "Destaca um post"));
    }

  public function widget($args, $instance)
  {
        echo $args[" "];

        if(isset($instance['bloco_1']))
        {
          $bloco_1 = $instance['bloco_1'];
        }

        $vetor_posts = array($bloco_1);

        $args = array(
           'showposts' => '1',
           'post__in'      => $vetor_posts,
           'orderby' => 'post__in'
        );

        query_posts($args);
        $contador_de_post = 0;
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
              $titulo     = get_the_title();
              $titulo_resumo     = resumo_txt($titulo,90,0);
              $resumo     = resumo_txt(get_the_excerpt(),90,0);
              $data_post  = get_the_date('d M Y');
              $autor      = get_the_author();
              $id_post    = get_the_ID();
              $tipo_media = get_post_meta($id_post, "meta-box-tipo-featured_media", true);
              $url_media  = get_post_meta($id_post, "meta-box-url-featured_media", true);
              $media_style = NULL;
              if($url_media != NULL){
                if($tipo_media == 1){
                  $media_style  = (($url_media) ? 'video_post' : '');
                }else if($tipo_media == 2){
                  $media_style = "";
                }
              }else{
                $wp_post_template  = get_post_meta($id_post, "_wp_post_template", true);
                $media_style = (($wp_post_template == 'single-carrousel_galeria.php') ? 'imagem_post' : '');
              }

              
             



              $html_destaques .= "
                <a href=\"{$url}\" class=\"bloco_destaque item_1\" style=\"background-image: url({$the_post_thumbnail})\">
                  <div class=\"content-post\">
                    <div class=\"content-txt\">
                      <h3>{$titulo_resumo}</h3>
                      <p><b>{$autor}</b> <span>- {$data_post}</span></p>
                    </div>
                  </div>
                </a>
                ";

            endwhile;
            wp_reset_query();
        endif;

        if(isset($instance['title']))
        {
          $title = "<h3><span>".$instance['title']."</span></h3>";
        }


        echo "
          <div class='destaca_post_unico textwidget'>
            $title
            <div class=\"barra_destaques\">
                $html_destaques
            </div>
          </div>  
        ";
           
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['categoria']))
    {
      $categoria = $instance['categoria'];
    }

    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    if(isset($instance['bloco_1']))
    {
      $bloco_1 = $instance['bloco_1'];
    }

    wp_reset_query();
    query_posts('orderby=title&posts_per_page=999999');
    if (have_posts()) : 

        while (have_posts()) : the_post(); 
          $bloco_1_html .= "<option ".(esc_attr($bloco_1) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
        endwhile;
    endif;
    wp_reset_query();


    ?>     


        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>" ><b> <?php _e("Titulo:"); ?></b></label>
            <input  type='text' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
            <div style="font:12px; color:#666;"></div>
        </p> 


        <p>
            <label for="<?php echo $this->get_field_id('bloco_1'); ?>" > <?php _e("Post:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_1'); ?>" id="<?php echo $this->get_field_id('bloco_1'); ?>" class="postform">
              <?php echo $bloco_1_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  

    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['bloco_1']    = (!empty($new_instance['bloco_1'])   ?   strip_tags($new_instance['bloco_1']) : '');
    $instance['title']      = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    return $instance;
  }

}

add_action("widgets_init",function(){register_widget("destaca_post_unico"); });





/* Widget para posts recentes */

class colunistas extends WP_Widget
{
  function __construct()
  {
      parent::__construct("colunistas", "Colunistas", array('description' => "Exibe os colunistas"));
  }

  public function widget($args, $instance)
  {
        echo $args[" "];

        if(isset($instance['img_1']))
        {
          $img_1 = $instance['img_1'];
        }

        if(isset($instance['img_2']))
        {
          $img_2 = $instance['img_2'];
        }

        if(isset($instance['img_3']))
        {
          $img_3 = $instance['img_3'];
        }


        //--------------------------------

        if(isset($instance['nome_1']))
        {
          $nome_1 = $instance['nome_1'];
        }

        if(isset($instance['nome_2']))
        {
          $nome_2 = $instance['nome_2'];
        }

        if(isset($instance['nome_3']))
        {
          $nome_3 = $instance['nome_3'];
        }

        //--------------------------------

        if(isset($instance['link_1']))
        {
          $link_1 = $instance['link_1'];
        }

        if(isset($instance['link_2']))
        {
          $link_2 = $instance['link_2'];
        }

        if(isset($instance['link_3']))
        {
          $link_3 = $instance['link_3'];
        }




              $html_destaques .= '
                <div class="item_destaque col-md-4">
                  <div id="img_destaque" class=""><div class="circular" style="background-image:url('.$img_1.');"></div></div>
                  <div id="conteudo_item_destaque" class="">
                    <a href="'.$link_1.'" >'.$nome_1.'</a>
                  </div>
                  <div id="conteudo_item_autor" class="">
                    <a href="'.$link_1.'" class="post_autor">Este é o titulo do ultimo post deste colunista</a>
                    <p>Este é o resumo do post Lorem ipsum dolor sit amet, consectetur adipiscing elit. In suscipit nulla quis sapien...</p>
                  </div>
                </div>';   
             
              $html_destaques .= '
                <div class="item_destaque col-md-4">
                  <div id="img_destaque" class=""><div class="circular" style="background-image:url('.$img_1.');"></div></div>
                  <div id="conteudo_item_destaque" class="">
                    <a href="'.$link_1.'" >'.$nome_1.'</a><a href="'.$link_1.'" class="post_autor">Este é o titulo do ultimo post deste colunista</a>
                  </div>
                </div>';

                $html_destaques .= '
                <div class="item_destaque col-md-4">
                  <div id="img_destaque" class=""><div class="circular" style="background-image:url('.$img_2.');"></div></div>
                  <div id="conteudo_item_destaque" class="">
                    <a href="'.$link_2.'">'.$nome_2.'</a><a href="'.$link_2.'" class="post_autor">Este é o titulo do ultimo post deste colunista</a>
                  </div>
                </div>';


                $html_destaques .= '
                <div class="item_destaque col-md-4">
                  <div id="img_destaque" class=""><div class="circular" style="background-image:url('.$img_3.');"></div></div>
                  <div id="conteudo_item_destaque" class="">
                    <a href="'.$link_3.'">'.$nome_3.'</a><a href="'.$link_3.'" class="post_autor">Este é o titulo do ultimo post deste colunista</a>
                  </div>
                </div>';





       if(isset($instance['title']))
        {
          $title = $instance['title'];
        }

        echo "
          <div id=\"exibe_destaques\" class=\"exibe_colunistas exibe_colunistas2\">
            <h2>$title</h2>
            <div class=\"barra_destaques\">
              <div class=\" col-md-12\">  
                $html_destaques
              </div>
            </div>
          </div>  
        ";
           
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {


    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    if(isset($instance['img_1']))
    {
      $img_1 = $instance['img_1'];
    }

    if(isset($instance['img_1']))
    {
      $img_1 = $instance['img_1'];
    }

    if(isset($instance['img_2']))
    {
      $img_2 = $instance['img_2'];
    }

    if(isset($instance['img_3']))
    {
      $img_3 = $instance['img_3'];
    }

    if(isset($instance['nome_1']))
    {
      $nome_1 = $instance['nome_1'];
    }

    if(isset($instance['nome_1']))
    {
      $nome_1 = $instance['nome_1'];
    }

    if(isset($instance['nome_2']))
    {
      $nome_2 = $instance['nome_2'];
    }

    if(isset($instance['nome_3']))
    {
      $nome_3 = $instance['nome_3'];
    }


    if(isset($instance['link_1']))
    {
      $link_1 = $instance['link_1'];
    }

    if(isset($instance['link_1']))
    {
      $link_1 = $instance['link_1'];
    }

    if(isset($instance['link_2']))
    {
      $link_2 = $instance['link_2'];
    }

    if(isset($instance['link_3']))
    {
      $link_3 = $instance['link_3'];
    }



    ?>     
          <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titulo:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>

          <b>Colunista 1</b>
          <p>
          <label for="<?php echo $this->get_field_id('nome_1'); ?>"><?php _e('Nome:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('nome_1'); ?>" name="<?php echo $this->get_field_name('nome_1'); ?>" type="text" value="<?php echo esc_attr($nome_1); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('link_1'); ?>"><?php _e('Link:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('link_1'); ?>" name="<?php echo $this->get_field_name('link_1'); ?>" type="text" value="<?php echo esc_attr($link_1); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('img_1'); ?>"><?php _e('Imagem:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('img_1'); ?>" name="<?php echo $this->get_field_name('img_1'); ?>" type="text" value="<?php echo esc_attr($img_1); ?>" /></p>
          <hr>
          <b>Colunista 2</b>
          <p>
          <label for="<?php echo $this->get_field_id('nome_2'); ?>"><?php _e('Nome:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('nome_2'); ?>" name="<?php echo $this->get_field_name('nome_2'); ?>" type="text" value="<?php echo esc_attr($nome_2); ?>" /></p>
          <p>
          <p>
          <label for="<?php echo $this->get_field_id('link_2'); ?>"><?php _e('Link:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('link_2'); ?>" name="<?php echo $this->get_field_name('link_2'); ?>" type="text" value="<?php echo esc_attr($link_2); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('img_2'); ?>"><?php _e('Imagem:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('img_2'); ?>" name="<?php echo $this->get_field_name('img_2'); ?>" type="text" value="<?php echo esc_attr($img_2); ?>" /></p>
          <hr>
          <b>Colunista 3</b>
          <p>
          <label for="<?php echo $this->get_field_id('nome_3'); ?>"><?php _e('Nome:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('nome_3'); ?>" name="<?php echo $this->get_field_name('nome_3'); ?>" type="text" value="<?php echo esc_attr($nome_3); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('link_3'); ?>"><?php _e('Link:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('link_3'); ?>" name="<?php echo $this->get_field_name('link_3'); ?>" type="text" value="<?php echo esc_attr($link_3); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('img_3'); ?>"><?php _e('Imagem:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('img_3'); ?>" name="<?php echo $this->get_field_name('img_3'); ?>" type="text" value="<?php echo esc_attr($img_3); ?>" /></p>
 

        
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['link_3']    = (!empty($new_instance['link_3'])   ?   strip_tags($new_instance['link_3']) : '');
    $instance['link_2']    = (!empty($new_instance['link_2'])   ?   strip_tags($new_instance['link_2']) : '');
    $instance['link_1']    = (!empty($new_instance['link_1'])   ?   strip_tags($new_instance['link_1']) : '');
    $instance['nome_3']    = (!empty($new_instance['nome_3'])   ?   strip_tags($new_instance['nome_3']) : '');
    $instance['nome_2']    = (!empty($new_instance['nome_2'])   ?   strip_tags($new_instance['nome_2']) : '');
    $instance['nome_1']    = (!empty($new_instance['nome_1'])   ?   strip_tags($new_instance['nome_1']) : '');
    $instance['img_3']    = (!empty($new_instance['img_3'])   ?   strip_tags($new_instance['img_3']) : '');
    $instance['img_2']    = (!empty($new_instance['img_2'])   ?   strip_tags($new_instance['img_2']) : '');
    $instance['img_1']    = (!empty($new_instance['img_1'])   ?   strip_tags($new_instance['img_1']) : '');
    $instance['title']    = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    $instance['categoria']    = (!empty($new_instance['categoria'])    ?   strip_tags($new_instance['categoria'])  : '');
    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("colunistas"); });





/* Widget para posts recentes */

class posts_destacados3 extends WP_Widget
{
    function __construct()
    {
        parent::__construct("posts_destacados3", "Destaques 3", array('description' => "Exibe os posts recentes ou destacados com 6 posts"));
    }

  public function widget($args, $instance)
  {
        echo $args[" "];
       
       // $instance['design']


        $categoria = (!empty($instance['categoria']) && ($instance['categoria'] != 'todas-categorias') ? "&category_name=".$instance['categoria'] : "");

        if(isset($instance['bloco_1']))
        {
          $bloco_1 = $instance['bloco_1'];
        }

        if(isset($instance['bloco_2']))
        {
          $bloco_2 = $instance['bloco_2'];
        }

        if(isset($instance['bloco_3']))
        {
          $bloco_3 = $instance['bloco_3'];
        }


        if(isset($instance['bloco_4']))
        {
          $bloco_4 = $instance['bloco_4'];
        }


        if(isset($instance['bloco_5']))
        {
          $bloco_5 = $instance['bloco_5'];
        }

        if(isset($instance['bloco_6']))
        {
          $bloco_6 = $instance['bloco_6'];
        }

        $vetor_posts = array($bloco_1, $bloco_2, $bloco_3, $bloco_4, $bloco_5, $bloco_6);

        $args = array(
           'showposts' => '6',
           'post__in'      => $vetor_posts,
           'orderby' => 'post__in'
        );

        query_posts($args);
        $contador_de_post = 0;
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
              $titulo     = get_the_title();
              $titulo     = resumo_txt($titulo,50,0);
              $resumo     = resumo_txt(get_the_excerpt(),50,0);
              $data_post  = get_the_date('d M Y');
              $autor      = get_the_author();
              $id_post    = get_the_ID();
              $tipo_media = get_post_meta($id_post, "meta-box-tipo-featured_media", true);
              $url_media  = get_post_meta($id_post, "meta-box-url-featured_media", true);
              $media_style = NULL;
              if($url_media != NULL){
                if($tipo_media == 1){
                  $media_style  = (($url_media) ? 'video_post' : '');
                }else if($tipo_media == 2){
                  $media_style = "";
                }
              }else{
                $wp_post_template  = get_post_meta($id_post, "_wp_post_template", true);
                $media_style = (($wp_post_template == 'single-carrousel_galeria.php') ? 'imagem_post' : '');
              }


              $html_destaques .= '
                <a href="'.$url.'" class="item_destaque col-md-2">
                  <div id="img_destaque" class=""><div class="circular" style="background-image:url('.$img.');"></div></div>
                  <div id="conteudo_item_destaque" class="">
                    <h4>'.$titulo.'</h4>
                  </div>
                </a>';
                
            endwhile;
            wp_reset_query();
        endif;
        if(isset($instance['title']))
        {
          $title = $instance['title'];
        }


        echo "
          <div id=\"exibe_destaques\" class=\"design_2\">
            <div class=\"barra_destaques\">
              <div class=\" col-md-12\">  
                $html_destaques
              </div>
            </div>
          </div>  
        ";
           
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {

    if(isset($instance['categoria']))
    {
      $categoria = $instance['categoria'];
    }

    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    if(isset($instance['bloco_1']))
    {
      $bloco_1 = $instance['bloco_1'];
    }

    if(isset($instance['bloco_2']))
    {
      $bloco_2 = $instance['bloco_2'];
    }

    if(isset($instance['bloco_3']))
    {
      $bloco_3 = $instance['bloco_3'];
    }

    if(isset($instance['bloco_4']))
    {
      $bloco_4 = $instance['bloco_4'];
    }

    if(isset($instance['bloco_5']))
    {
      $bloco_5 = $instance['bloco_5'];
    }

    if(isset($instance['bloco_6']))
    {
      $bloco_6 = $instance['bloco_6'];
    }

    wp_reset_query();
    query_posts('orderby=title&posts_per_page=999999');
    if (have_posts()) : 

        while (have_posts()) : the_post(); 
          $bloco_1_html .= "<option ".(esc_attr($bloco_1) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
          $bloco_2_html .= "<option ".(esc_attr($bloco_2) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
          $bloco_3_html .= "<option ".(esc_attr($bloco_3) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
          $bloco_4_html .= "<option ".(esc_attr($bloco_4) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
          $bloco_5_html .= "<option ".(esc_attr($bloco_5) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
          $bloco_6_html .= "<option ".(esc_attr($bloco_6) == get_the_ID() ? 'selected="selected"' : '')." class='level-0' value='".get_the_ID()."'>".get_the_title()."</option>"; 
        endwhile;
    endif;
    wp_reset_query();


    ?>     


        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>" ><b> <?php _e("Titulo:"); ?></b></label>
            <input  type='text' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
            <div style="font:12px; color:#666;"></div>
        </p> 


        <p>
            <label for="<?php echo $this->get_field_id('bloco_1'); ?>" > <?php _e("Bloco 1:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_1'); ?>" id="<?php echo $this->get_field_id('bloco_1'); ?>" class="postform">
              <?php echo $bloco_1_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  

        <p>
            <label for="<?php echo $this->get_field_id('bloco_2'); ?>" > <?php _e("Bloco 2:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_2'); ?>" id="<?php echo $this->get_field_id('bloco_2'); ?>" class="postform">
              <?php echo $bloco_2_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  

        <p>
            <label for="<?php echo $this->get_field_id('bloco_3'); ?>" > <?php _e("Bloco 3:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_3'); ?>" id="<?php echo $this->get_field_id('bloco_3'); ?>" class="postform">
              <?php echo $bloco_3_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  

        <p>
            <label for="<?php echo $this->get_field_id('bloco_4'); ?>" > <?php _e("Bloco 4:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_4'); ?>" id="<?php echo $this->get_field_id('bloco_4'); ?>" class="postform">
              <?php echo $bloco_4_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  

        <p>
            <label for="<?php echo $this->get_field_id('bloco_5'); ?>" > <?php _e("Bloco 5:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_5'); ?>" id="<?php echo $this->get_field_id('bloco_5'); ?>" class="postform">
              <?php echo $bloco_5_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  

        <p>
            <label for="<?php echo $this->get_field_id('bloco_6'); ?>" > <?php _e("Bloco 6:"); ?></label>
            <select style='max-width: 100%;' name="<?php echo $this->get_field_name('bloco_6'); ?>" id="<?php echo $this->get_field_id('bloco_6'); ?>" class="postform">
              <?php echo $bloco_6_html; ?>
            </select>
            <div style="font:12px; color:#666;"></div>
        </p>  


        <!-- p>
            <label for="<?php //echo $this->get_field_id('categoria'); ?>" > <?php //_e("Categoria:"); ?></label>

            <?php 

              // $args = array(
              //   'walker'             => new SH_Walker_TaxonomyDropdown(),
              //   'show_option_all'    => '',
              //   'show_option_none'   => '',
              //   'option_none_value'  => '-1',
              //   'orderby'            => 'ID',
              //   'order'              => 'ASC',
              //   'show_count'         => 0,
              //   'hide_empty'         => 1,
              //   'child_of'           => 0,
              //   'exclude'            => '',
              //   'include'            => '',
              //   'echo'               => 1,
              //   'selected'           => esc_attr($categoria),
              //   'hierarchical'       => 0,
              //   'name'               => $this->get_field_name('categoria'),
              //   'id'                 => $this->get_field_id('categoria'),
              //   'class'              => 'postform',
              //   'depth'              => 0,
              //   'tab_index'          => 0,
              //   'taxonomy'           => 'category',
              //   'hide_if_empty'      => false,
              //   'value_field'        => 'slug',
              //   'value'              => 'slug'
              // ); 

              // wp_dropdown_categories( $args ); 
            ?> 
            <div style="font:12px; color:#666;">Caso queira exibir uma categoria especifica selecione uma categoria, só sera exibida as postagens desta categoria.<br>Deixe como "Todas Categorias" para exibir todos os posts com ou sem categorias.</div>
        </p -->
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['bloco_6']    = (!empty($new_instance['bloco_6'])   ?   strip_tags($new_instance['bloco_6']) : '');
    $instance['bloco_5']    = (!empty($new_instance['bloco_5'])   ?   strip_tags($new_instance['bloco_5']) : '');
    $instance['bloco_4']    = (!empty($new_instance['bloco_4'])   ?   strip_tags($new_instance['bloco_4']) : '');
    $instance['bloco_3']    = (!empty($new_instance['bloco_3'])   ?   strip_tags($new_instance['bloco_3']) : '');
    $instance['bloco_2']    = (!empty($new_instance['bloco_2'])   ?   strip_tags($new_instance['bloco_2']) : '');
    $instance['bloco_1']    = (!empty($new_instance['bloco_1'])   ?   strip_tags($new_instance['bloco_1']) : '');
    $instance['title']    = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    $instance['categoria']    = (!empty($new_instance['categoria'])    ?   strip_tags($new_instance['categoria'])  : '');
    return $instance;
  }

}

add_action("widgets_init",function(){register_widget("posts_destacados3"); });

/* Widget para Colunistas */
class colunistas2 extends WP_Widget
{
  function __construct()
  {
      parent::__construct("colunistas2", "Colunistas2", array('description' => "Exibe os colunistas"));
  }

  public function widget($args, $instance)
  {
        echo $args[" "];
 
        //--------------------------------

        if(isset($instance['link_1']))
        {
          $link_1 = $instance['link_1'];
        }

        if(isset($instance['link_2']))
        {
          $link_2 = $instance['link_2'];
        }

        if(isset($instance['link_3']))
        {
          $link_3 = $instance['link_3'];
        }

        if(isset($instance['link_4']))
        {
          $link_4 = $instance['link_4'];
        }


        //--------------------------------

        if(isset($instance['id_autor_1']))
        {
          $id_autor_1 = $instance['id_autor_1'];
        }

        if(isset($instance['id_autor_2']))
        {
          $id_autor_2 = $instance['id_autor_2'];
        }

        if(isset($instance['id_autor_3']))
        {
          $id_autor_3 = $instance['id_autor_3'];
        }

        if(isset($instance['author_1']))
        {
          $author_1 = $instance['author_1'];
        }

         if(isset($instance['author_2']))
        {
          $author_2 = $instance['author_2'];
        }

         if(isset($instance['author_3']))
        {
          $author_3 = $instance['author_3'];
        }

         if(isset($instance['author_4']))
        {
          $author_4 = $instance['author_4'];
        }
        
        if(isset($instance['post_1']))
        {
          $post_1 = $instance['post_1'];
        }
 
        if(isset($instance['post_2']))
        {
          $post_2 = $instance['post_2'];
        }
 
        if(isset($instance['post_3']))
        {
          $post_3 = $instance['post_3'];
        }
 
        if(isset($instance['post_4']))
        {
          $post_4 = $instance['post_4'];
        }

        

        $post_id_1 = url_to_postid( $link_1 );
        $post_id_2 = url_to_postid( $link_2 );
        $post_id_3 = url_to_postid( $link_3 );        
        $post_id_4 = url_to_postid( $link_4 ); 

        $post_id[] = $post_id_1;
        $post_id[] = $post_id_2;
        $post_id[] = $post_id_3;        
        $post_id[] = $post_id_4; 

             
        
    wp_enqueue_style( 'style1', get_template_directory_uri().'/colaboradores.css' );
      
        $design = $instance['design'];
        $title = $instance['title'];

    $query_posts_args=array(
      'post_type' => 'page',
      'post_status' => 'publish',
      'post__in'      => $post_id
    );

    query_posts($query_posts_args);
    $contador_de_post = 0;
    if (have_posts()){

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
        $titulo     = get_the_title();
        $resumo     = resumo_txt(get_the_excerpt(),90,0);
        $resumo_titulo     = resumo_txt($titulo,60,0);
        $data_post  = get_the_date('d M Y');
        $id_post    = get_the_ID();
        $vetor_ids_usuarios[] = "-".get_the_author_meta('ID');

        $nome_user  = $value->display_name;

        switch ($id_post) {
          case $post_id_1:
            $autor_link = get_author_posts_url($author_1);
            $autor      = get_author_name($author_1);

              if($post_1 != NULL){
                $query_posts_args1=array(
                  'showposts' => 1,
                  'post_type' => 'post',
                  'post_id'      => url_to_postid($post_1)
                );

                $posts_array1 = get_posts($query_posts_args1);

                foreach ($posts_array1 as $key => $value) {
                  $titulo_post     = $value->post_title;
                  $resumo_post     = resumo_txt(get_the_excerpt($value->ID),90,0);
                  $link_post = $value->guid;
                }

              }

              $vetor_html_destaques[1] .= '
                <div class="item_destaque col-md-4">
                  <div id="img_destaque" class=""><div class="circular" style="background-image:url('.get_avatar_url($author_1).');"></div></div>
                  <div id="conteudo_item_destaque" class="">
                    <a href="'.get_post_permalink().'" >'.ucfirst(strtolower($titulo)).'</a>
                  </div>
                  <div id="conteudo_item_autor" class="">
                    <a href="'.$link_post.'" class="post_autor">'.$titulo_post.'</a>
                    <p>'.$resumo_post.'</p>
                  </div>
                </div>'; 

          break;

          case $post_id_2:


            if($post_2 != NULL){
                $query_posts_args2=array(
                  'showposts' => 1,
                  'post_type' => 'post',
                  'post_id'      => url_to_postid($post_2)
                );

                $posts_array2 = get_posts($query_posts_args2);

                foreach ($posts_array2 as $key => $value) {
                  $titulo_post     = $value->post_title;
                  $resumo_post     = resumo_txt(get_the_excerpt($value->ID),90,0);
                  $link_post = $value->guid;
                }
              }


            $autor_link = get_author_posts_url($author_2);
            $autor      = get_author_name($author_2);

            $vetor_html_destaques[2] .= '
              <div class="item_destaque col-md-4">
                <div id="img_destaque" class=""><div class="circular" style="background-image:url('.get_avatar_url($author_2).');"></div></div>
                <div id="conteudo_item_destaque" class="">
                  <a href="'.get_post_permalink().'">'.ucfirst(strtolower($titulo)).' </a><a href="'.$link_post.'" class="post_autor">'.$titulo_post.'</a>
                </div>
              </div>';

          break;

          case $post_id_3:
            $autor_link = get_author_posts_url($author_3);
            $autor      = get_author_name($author_3);

            if($post_3 != NULL){
               $query_posts_args3=array(
                  'showposts' => 1,
                  'post_type' => 'post',
                  'post_id'      => url_to_postid($post_3)
                );

                $posts_array3 = get_posts($query_posts_args3);

                foreach ($posts_array3 as $key => $value) {
                  $titulo_post     = $value->post_title;
                  $resumo_post     = resumo_txt(get_the_excerpt($value->ID),90,0);
                  $link_post = $value->guid;
                }
              }

            $vetor_html_destaques[3] .= '
              <div class="item_destaque col-md-4">
                <div id="img_destaque" class=""><div class="circular" style="background-image:url('.get_avatar_url($author_3).');"></div></div>
                <div id="conteudo_item_destaque" class="">
                  <a href="'.get_post_permalink().'">'.ucfirst(strtolower($titulo)).' </a><a href="'.$link_post.'" class="post_autor">'.$titulo_post.'</a>
                </div>
              </div>';

          break;

          case $post_id_4:
            $autor_link = get_author_posts_url($author_4);
            $autor      = get_author_name($author_4);

            if($post_4 != NULL){
                $query_posts_args4=array(
                  'showposts' => 1,
                  'post_type' => 'post',
                  'post_id'      => url_to_postid($post_4)
                );

                $posts_array4 = get_posts($query_posts_args4);

                foreach ($posts_array4 as $key => $value) {
                  $titulo_post     = $value->post_title;
                  $resumo_post     = resumo_txt(get_the_excerpt($value->ID),90,0);
                  $link_post = $value->guid;
                }
              }

            $vetor_html_destaques[4] .= '
              <div class="item_destaque col-md-4">
                <div id="img_destaque" class=""><div class="circular" style="background-image:url('.get_avatar_url($author_4).');"></div></div>
                <div id="conteudo_item_destaque" class="">
                  <a href="'.get_post_permalink().'">'.ucfirst(strtolower($titulo)).' </a><a href="'.$link_post.'" class="post_autor">'.$titulo_post.'</a>
                </div>
              </div>';

          break;
        }

      endwhile;
    }



       if(isset($instance['title']))
        {
          $title = $instance['title'];
        }

        
        if(is_array($vetor_html_destaques)){
          ksort($vetor_html_destaques);
          foreach ($vetor_html_destaques as $key => $value) {
            $html_destaques .= $value;
          }
        }

        echo "
          <div id=\"exibe_destaques\" class=\"exibe_colunistas exibe_colunistas2\">
            <h2>$title</h2>
            <div class=\"barra_destaques\">
              <div class=\" col-md-12\">  
                $html_destaques
              </div>
            </div>
          </div>  
        ";
           
    echo $args["after_widget"];
  }
 
  public function form($instance)
  {


    if(isset($instance['title']))
    {
      $title = $instance['title'];
    }

    if(isset($instance['link_1']))
    {
      $link_1 = $instance['link_1'];
    }

    if(isset($instance['link_2']))
    {
      $link_2 = $instance['link_2'];
    }

    if(isset($instance['link_3']))
    {
      $link_3 = $instance['link_3'];
    }

    if(isset($instance['link_4']))
    {
      $link_4 = $instance['link_4'];
    }

    if(isset($instance['author_1']))
    {
      $author_1 = $instance['author_1'];
    }

    if(isset($instance['author_2']))
    {
      $author_2 = $instance['author_2'];
    }


    if(isset($instance['author_3']))
    {
      $author_3 = $instance['author_3'];
    }
    
    if(isset($instance['author_4']))
    {
      $author_4 = $instance['author_4'];
    }


    if(isset($instance['post_1']))
    {
      $post_1 = $instance['post_1'];
    }


    if(isset($instance['post_2']))
    {
      $post_2 = $instance['post_2'];
    }


    if(isset($instance['post_3']))
    {
      $post_3 = $instance['post_3'];
    }


    if(isset($instance['post_4']))
    {
      $post_4 = $instance['post_4'];
    }




  $args = array(
    'role'         => '',
    'role__in'     => array(),
    'role__not_in' => array(),
    'meta_key'     => '',
    'meta_value'   => '',
    'meta_compare' => '',
    'meta_query'   => array(),
    'date_query'   => array(),        
    'include'      => array(),
    'exclude'      => array(),
    'orderby'      => 'login',
    'order'        => 'ASC',
    'offset'       => '',
    'search'       => '',
    'number'       => '',
    'count_total'  => false,
    'fields'       => 'all',
    'who'          => ''
  ); 
  $get_users = get_users( $args ); 

  foreach ($get_users as $key => $value) {
    $options_users_1 .= "<option  ".(esc_attr($author_1) == $value->ID ? 'selected="selected"' : '')." value='".($value->ID)."'>".($value->display_name)."</option>";
    $options_users_2 .= "<option  ".(esc_attr($author_2) == $value->ID ? 'selected="selected"' : '')." value='".($value->ID)."'>".($value->display_name)."</option>";
    $options_users_3 .= "<option  ".(esc_attr($author_3) == $value->ID ? 'selected="selected"' : '')." value='".($value->ID)."'>".($value->display_name)."</option>";
    $options_users_4 .= "<option  ".(esc_attr($author_4) == $value->ID ? 'selected="selected"' : '')." value='".($value->ID)."'>".($value->display_name)."</option>";
  }


?>    
          <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Titulo:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
          <hr>
          <b>Colunista 1</b>
          <p>
          <label for="<?php echo $this->get_field_id('link_1'); ?>"><?php _e('Link:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('link_1'); ?>" name="<?php echo $this->get_field_name('link_1'); ?>" type="text" value="<?php echo esc_attr($link_1); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('post_1'); ?>"><?php _e('Post:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('post_1'); ?>" name="<?php echo $this->get_field_name('post_1'); ?>" type="text" value="<?php echo esc_attr($post_1); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('author_1'); ?>"><?php _e('Usuário:'); ?></label>
          <?php echo "<select style='max-width: 100%;' name='".$this->get_field_name('author_1')."' id='".$this->get_field_id('author_1')."' class='postform'>$options_users_1</select>"; ?></p>
          <hr>
          <b>Colunista 2</b>
          <p>
          <label for="<?php echo $this->get_field_id('link_2'); ?>"><?php _e('Link:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('link_2'); ?>" name="<?php echo $this->get_field_name('link_2'); ?>" type="text" value="<?php echo esc_attr($link_2); ?>" /></p>
        <p>
          <label for="<?php echo $this->get_field_id('post_2'); ?>"><?php _e('Post:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('post_2'); ?>" name="<?php echo $this->get_field_name('post_2'); ?>" type="text" value="<?php echo esc_attr($post_2); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('author_2'); ?>"><?php _e('Usuário:'); ?></label>
        <?php echo "<select style='max-width: 100%;' name='".$this->get_field_name('author_2')."' id='".$this->get_field_id('author_2')."' class='postform'>$options_users_2</select>"; ?></p>
          <hr>
          <b>Colunista 3</b>
          <p>
          <label for="<?php echo $this->get_field_id('link_3'); ?>"><?php _e('Link:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('link_3'); ?>" name="<?php echo $this->get_field_name('link_3'); ?>" type="text" value="<?php echo esc_attr($link_3); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('post_3'); ?>"><?php _e('Post:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('post_3'); ?>" name="<?php echo $this->get_field_name('post_3'); ?>" type="text" value="<?php echo esc_attr($post_3); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('author_3'); ?>"><?php _e('Usuário:'); ?></label>
          <?php echo "<select style='max-width: 100%;' name='".$this->get_field_name('author_3')."' id='".$this->get_field_id('author_3')."' class='postform'>$options_users_3</select>"; ?></p> 
          <hr>
          <b>Colunista 4</b>
          <p>
          <label for="<?php echo $this->get_field_id('link_4'); ?>"><?php _e('Link:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('link_4'); ?>" name="<?php echo $this->get_field_name('link_4'); ?>" type="text" value="<?php echo esc_attr($link_4); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('post_4'); ?>"><?php _e('Post:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('post_4'); ?>" name="<?php echo $this->get_field_name('post_4'); ?>" type="text" value="<?php echo esc_attr($post_4); ?>" /></p>
          <p>
          <label for="<?php echo $this->get_field_id('author_4'); ?>"><?php _e('Usuário:'); ?></label>
          <?php echo "<select style='max-width: 100%;' name='".$this->get_field_name('author_4')."' id='".$this->get_field_id('author_4')."' class='postform'>$options_users_4</select>"; ?></p> 
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['post_1']    = (!empty($new_instance['post_1'])   ?   strip_tags($new_instance['post_1']) : '');
    $instance['post_2']    = (!empty($new_instance['post_2'])   ?   strip_tags($new_instance['post_2']) : '');
    $instance['post_3']    = (!empty($new_instance['post_3'])   ?   strip_tags($new_instance['post_3']) : '');
    $instance['post_4']    = (!empty($new_instance['post_4'])   ?   strip_tags($new_instance['post_4']) : '');
    $instance['author_1']    = (!empty($new_instance['author_1'])   ?   strip_tags($new_instance['author_1']) : '');
    $instance['author_2']    = (!empty($new_instance['author_2'])   ?   strip_tags($new_instance['author_2']) : '');
    $instance['author_3']    = (!empty($new_instance['author_3'])   ?   strip_tags($new_instance['author_3']) : '');
    $instance['author_4']    = (!empty($new_instance['author_4'])   ?   strip_tags($new_instance['author_4']) : '');
    $instance['link_4']    = (!empty($new_instance['link_4'])   ?   strip_tags($new_instance['link_4']) : '');
    $instance['link_3']    = (!empty($new_instance['link_3'])   ?   strip_tags($new_instance['link_3']) : '');
    $instance['link_2']    = (!empty($new_instance['link_2'])   ?   strip_tags($new_instance['link_2']) : '');
    $instance['link_1']    = (!empty($new_instance['link_1'])   ?   strip_tags($new_instance['link_1']) : '');
    $instance['title']    = (!empty($new_instance['title'])   ?   strip_tags($new_instance['title']) : '');
    return $instance;
  }
}

add_action("widgets_init",function(){register_widget("colunistas2"); });
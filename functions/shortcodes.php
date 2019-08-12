<?php 

function saibamais_shortcode($atts){
      $parametros = shortcode_atts( array(
          'titulo' => '',
          'quantidade' => '',
          'categoria' => '',
          'design' => '',
          'largura' => ''
        ), 
        $atts 
      );

      $data_slide_to = 0;
      $titulo       = $parametros['titulo'];
      $quantidade   = $parametros['quantidade'];
      $categoria    = $parametros['categoria'];
      $design       = $parametros['design'];
      $largura      = $parametros['largura'];

      $style_css    = (($largura != 0) ? "style=\"width:{$largura}%;\"" : "");  

        $cat_inf = get_the_category();
        $categoria = (!empty($cat_inf['slug']) && ($cat_inf['slug'] != 'todas-categorias') ? "&category_name=".$cat_inf['slug'] : "");

        query_posts('showposts='.$quantidade.$categoria);
        $contador_de_post = 0;
        if (have_posts()) : 

            while (have_posts()) : the_post(); $contador_de_post++; 

              if ( has_post_thumbnail() ) {
                $the_post_thumbnail = get_the_post_thumbnail_url();
              } else { 
                $the_post_thumbnail = get_bloginfo('template_directory')."/imagens/default-image.png";
              } 

              
              $cat_inf    = get_the_category();
              $url        = get_permalink();
              $img        = $the_post_thumbnail;
              $cat_name   = get_cat_name($cat_inf->cat_ID);
              $titulo_post     = get_the_title();
              $titulo_post     = resumo_txt($titulo_post,70,0);
              $resumo     = resumo_txt(get_the_excerpt(),90,0);
              $data_post  = get_the_date('d M Y');
              $autor      = get_the_author();
              $id_post    = get_the_ID();
                


            switch($design):
                case 1: 
                  $html_posts_links .="
                      <li>
                      <a href=\"{$url}\" target=\"_blank\">{$titulo_post}</a>
                  </li>
                  ";
                break;
                case 2: 
                  $titulo_post     = resumo_txt($titulo_post,60,0);
                  $html_posts_links .="
                    <a href=\"{$url}\" class=\"bloco_post esquerda col-md-6\">
                      <div class=\"thumbnail_post\" style=\"background-image:url($img);\"></div>
                      <div class=\"content_post\">
                        <h4>{$titulo_post}</h4>
                      </div>
                    </a>
                  ";
                break;
                case 3: 
                  $titulo_post     = resumo_txt($titulo_post,60,0);
                  $html_posts_links .='
                    <a href="'.$url.'" class="bloco_post esquerda col-md-6">
                      <div class="thumbnail_post" style="background-image:url('.$img.');"></div>
                      <h4>'.$titulo_post.'</h4>
                    </a>
                  ';
                break;   
                case 4: 
                  $titulo_post     = resumo_txt($titulo_post,58,0);
                  $html_posts_links .='
                    <a href="'.$url.'" class="bloco_post esquerda col-md-4">
                      <div class="thumbnail_post" style="background-image:url('.$img.');"></div>
                      <h4>'.$titulo_post.'</h4>
                    </a>
                  ';
                break;
                case 5: 
                  $html_posts_links .="
                      <a href=\"{$url}\" class=\"bloco_post\">
                        <div class=\"thumbnail_post\" style=\"background-image:url($img);\"></div>
                        <div class=\"content_post\">
                          <h4>{$titulo_post}</h4>
                        </div>
                      </a>
                  ";
                break;

                case 6: 
                  $html_posts_links .= " 
                   <li><a href=\"$url\" style='background-image:url({$img});'></a></li>
                  ";
                break;

                case 7: 
                  $titulo_post     = resumo_txt($titulo_post,50,0);
                  $html_destaques .= " 
                   <div class=\"item ".($data_slide_to == 0 ? 'active' : '')."\" style='background-image: url({$img});'>
                       <div class=\"carousel-caption\">
                        <h4><a href=\"{$url}\">{$titulo_post}</a></h4>
                        <p>$resumo</p>
                        <a href='$url' class='pull-right ls-l btn btn-default' >Veja +</a>
                      </div>
                    </div><!-- End Item -->
                  ";

                  $lis_slider .= "<li data-target=\"#news_carousel\" data-slide-to=\"{$data_slide_to}\" class=\"list-group-item ".($data_slide_to == 0 ? 'active' : '')."\"><h4>{$titulo_post }</h4></li>";

                  $data_slide_to += 1; 
                break;
              endswitch;
            endwhile;
            wp_reset_query();
        endif;    

        switch($design):
          case 1: 
            $tipo_layout = ''; 
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
            $tipo_layout = 'tipo_1'; 
          break;
        endswitch;

        $html_body = "
          <div {$style_css} class=\"saibamais componente_materia\">
        "; 
        switch($design):
          case 1: 
             $html_body .= "
                <strong>{$titulo}</strong>
                <ul>  
                  $html_posts_links
                </ul>
              "; 
          break;
          case 6: 
            $id_slider = rand(0, 10000); 
            $html_body .= "<div class=\"clearfix\"></div>
              <div class='tipo_4 carousel_slider' style=\"position: relative;\">
                  ".($title == NULL ? "<div style='height:28px;'></div>" : "
                  <h3 class='subline_title'><span>$title</span></h3>")."

                  <ul id=\"clients-scroller-$id_slider\" class=\"our-clients clearfix\">
                      $html_posts_links
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

          case 7: 
            $id_slider = rand(0, 10000); 
            $html_body .= "
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
            $html_body .= "
              <div class=\"".$tipo_layout." destaque_categorias saiba_mais\">
                <h3><span>".$titulo."</span></h3>
                $html_posts_links
              </div>
            ";
          break;
        endswitch;      
        $html_body .= "
          </div>
        "; 

        return $html_body;
}
add_shortcode( 'saibamais', 'saibamais_shortcode' ); 



add_shortcode( 'categoria_bloco_link', 'categoria_bloco_link_shortcode' ); 


function categoria_bloco_link_shortcode($atts){
      $parametros = shortcode_atts( array(
          'url' => '',
          'titl' => '',
          'txt' => '',
          'col' => ''
        ), 
        $atts 
      );

      $data_slide_to = 0;
      $url       = $parametros['url'];
      $titl       = $parametros['titl'];
      $txt       = $parametros['txt'];
      $col       = $parametros['col'];

      if($url != NULL){
        $html_body = "
          <a class='catbloclink col-xs-{$col} col-md-{$col}' href='{$url}' class='col-md-4'>
            <h4>{$titl}</h4> 
            {$txt}
          </a>
        ";
      }else{
         $html_body = "
          <div class='catbloclink col-xs-{$col} col-md-{$col}' class='col-md-4'>
            <h4>{$titl}</h4> 
            {$txt}
          </div>
        ";
      }

      return $html_body;
}

add_shortcode( 'catbloclink', 'categoria_bloco_link_shortcode' );
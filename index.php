<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Under
 */
  get_header();
  add_theme_support( 'post-thumbnails' );
  

  if(get_option('tema_zflag_slide_principal')){
    $tema_zflag_slide_principal = json_decode(get_option('tema_zflag_slide_principal'));
    $tema_zflag_slide_principal = (array) $tema_zflag_slide_principal;
     $contador_de_post = 0;
    foreach ($tema_zflag_slide_principal as $key => $value) {
      $contador_de_post++;
      $value = (array) $value;
      $titulo = $value['titulo'];
      $texto = stripslashes($value['texto']);
      $imagem = $value['imagem'];

      $html_destaques .= " 
          <div class=\"item ".($contador_de_post == 1 ? 'active' : '')."\">
            <div class=\"container\">
                <div class='col-md-6'>
                  <h1>{$titulo}</h1>
                  {$texto}
                </div>
                <div class='col-md-6 imagem_slide'>
                  <img src='{$imagem}'>
                </div>
            </div>
          </div>
      ";

    }

   

    $slide_html = 
    "<div class='slide_home carousel_tipo_1'>
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
      </div>";

      echo '<header id="pagina_cabecalho">'.do_shortcode($slide_html).'</header>';
  }

?> 
  <main id="main" class="site-main container" role="main">
    <div id='topo_home' class='col-md-12'><?php dynamic_sidebar('topo_pagina_inicial'); ?></div>

    <div id='pagina_inicial' class="col-md-12">
          <?php dynamic_sidebar('pagina_inicial'); ?>
    </div>
    
    <?php if (have_posts()) : ?>

      <?php /* Start the Loop */ ?>
      <?php while (have_posts()) : the_post(); ?>

        <?php
        /* Include the Post-Format-specific template for the content.
         * If you want to override this in a child theme, then include a file
         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
         */
        // get_template_part('content', get_post_format());
        ?>

      <?php endwhile; ?>


    <?php else : ?>

      <?php //get_template_part('content', 'none'); ?>

    <?php endif; ?>

  </main><!-- #main -->
<div class="col-md-12 social_footer">
    <h3>Também estamos aqui</h3>
    <p>Acompanhe nosso trabalho em outras plataformas</p>
    <div id="rodape_social_icons" class="social-links">
      <a target="_blank" href="https://www.facebook.com/designeficaz/"><img class="img-responsive" src="http://localhost/wordpress/wp-content/themes/designeficaz/imagens/espera/redes-sociais-facebook.jpg"></a>
      
      <a target="_blank" href="https://www.instagram.com/designeficaz/"><img class="img-responsive" src="http://localhost/wordpress/wp-content/themes/designeficaz/imagens/espera/redes-sociais-instagram.jpg"></a>
      
      <a target="_blank" href="https://www.behance.net/danieldesouz4"><img class="img-responsive" src="http://localhost/wordpress/wp-content/themes/designeficaz/imagens/espera/redes-sociais-behance.jpg"></a>
      <a target="_blank" href="https://www.colab55.com/@danieldesouz4"><img class="img-responsive" src="http://localhost/wordpress/wp-content/themes/designeficaz/imagens/espera/redes-sociais-colab55.jpg"></a>
      
      
    </div>
</div>
<?php get_footer(); ?>
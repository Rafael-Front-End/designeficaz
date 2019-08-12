<?php
/**
Template Name: Com Sidebar
*/

get_header(); 



    // Start the loop.
    while ( have_posts() ) : the_post();


  echo '<header id="pagina_cabecalho"><div class="container"><div class="col-md-12">';
        the_title( '<h1 id="titulo_pagina">', '</h1>' );
    echo '</div></div></header>';
?>
 <main id="main" class="site-main container" role="main">
    <div id="tema2" class="col-md-8">
        <section class="conteudo_post">

                 

                <?php  
                  // Include the page content template.

                  the_content(); 
                ?>


 
        </section>
    </div>


    <?php get_sidebar(); ?>       
</main><!-- #main -->
 <div class="col-md-12 social_footer">
    <h3>Também estamos aqui</h3>
    <p>Acompanhe nosso trabalho em outras plataformas</p>
    <div id="rodape_social_icons" class="social-links">
      <a target="_blank" href="https://www.facebook.com/designeficaz/"><img class="img-responsive" src="<?php echo get_bloginfo('url'); ?>/wp-content/themes/designeficaz/imagens/espera/redes-sociais-facebook.jpg"></a>
      
      <a target="_blank" href="https://www.instagram.com/designeficaz/"><img class="img-responsive" src="<?php echo get_bloginfo('url'); ?>/wp-content/themes/designeficaz/imagens/espera/redes-sociais-instagram.jpg"></a>
      
      <a target="_blank" href="https://www.behance.net/danieldesouz4"><img class="img-responsive" src="<?php echo get_bloginfo('url'); ?>/wp-content/themes/designeficaz/imagens/espera/redes-sociais-behance.jpg"></a>
      <a target="_blank" href="https://www.colab55.com/@danieldesouz4"><img class="img-responsive" src="<?php echo get_bloginfo('url'); ?>/wp-content/themes/designeficaz/imagens/espera/redes-sociais-colab55.jpg"></a>
      
      
    </div>
</div>


<?php 
                   // End the loop.
              endwhile;
              
get_footer(); ?>
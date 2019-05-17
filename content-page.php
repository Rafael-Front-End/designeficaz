<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
    
    echo '<header id="pagina_cabecalho"><div class="container"><div class="col-md-12">';
        the_title( '<h1 id="titulo_pagina">', '</h1>' );
    echo '</div></div></header>';
?>
 <main id="main" class="site-main container" role="main">
    <div id="tema2">
        <section class="conteudo_post">


            <div id="texto_post">
                <?php  the_content(); ?>
            </div>
            
            <?php 
                // If comments are open or we have at least one comment, load up the comment template.
                // if ( comments_open() || get_comments_number() ) :
                //     comments_template();
                // endif;
            ?> 
        </section>
    </div>


            
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
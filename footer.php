 <?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Under
 */
?> 
		<footer class="row" id="rodape"> 
			<div class="container">
				<?php dynamic_sidebar('rodape');?>
			     
			  	 
		    </div><!-- .container -->
		    <section class="container copyright">
            <div id='copyright' class="col-md-12">
              <div class="text-left col-md-6"> 
                <img  class="desktop logo-footer" src='<?php bloginfo( 'template_directory' ); ?>/imagens/footer.jpg'>
                <img  class="mobile logo-footer" src='<?php bloginfo( 'template_directory' ); ?>/imagens/marca_design_eficaz.jpg'>
                <span class="footer-copyright">Design Eficaz. Rio de Janeiro, 2019.<br>© Todos os direitos reservados</span>
              </div>
              <!-- div class="col-md-6" style="color:#999;font-size:16px; margin-top:30px;">Desenvolvido por Rafael Guimarães</div -->
            </div>
		    </section>
		</footer><!-- # -->
	</div><!-- #conteudo_site -->
</div><!-- #site -->


	<!-- Scrits do site -->
 


    <script type="text/javascript" language="javascript"></script>
    

    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/jquery-cover-master/jquery.cover.js" language="javascript"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/plugins.js" language="javascript"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/jssor/jssor.slider.min.js" language="javascript"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/assets/js/greensock.js" language="javascript"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/assets/js/layerslider.transitions.js" language="javascript"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/assets/js/layerslider.kreaturamedia.jquery.js" language="javascript"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/jQueryRotate.js" language="javascript"></script>
    <script src="<?php bloginfo( 'template_directory' ); ?>/lib/venobox/venobox.min.js"></script>
    <script src="<?php bloginfo( 'template_directory' ); ?>/lib/isotope/isotope.pkgd.min.js"></script>


    
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/script.js?version=0.0.0.6" language="javascript"></script>

 
	<div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.7&appId=1155300647892369";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    </script>



    

</body>
</html>
 
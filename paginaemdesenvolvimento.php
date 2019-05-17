<?php
/**
Template Name: Em Desenvolvimento
**/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js"> 
<head>
	<meta http-equiv="expires" content="-1" />
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php wp_title( '-', true, 'right' ); ?></title> 
    <?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
    <!--[if lt IE 9]>
    <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
    <![endif]--> 
    <?php  
      wp_head(); 
    ?>

    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/jquery-1.11.1.min.js" language="javascript"></script>        
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/bootstrap.min.js" language="javascript"></script>
    
     
    <!-- EstilizaÃ§Ãµes do site -->

    <!-- link rel="shortcut icon" href="<?php bloginfo( 'template_directory' ); ?>/img/favicon.png" type="image/x-icon" -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C400%2C600%2C700%7COswald%3A400%2C700%7CRoboto%3A400%2C700%7CRaleway%3A400%2C700&subset=arabic" />
    <link href="<?php bloginfo( 'template_directory' ); ?>/assets/css/layerslider.css" type="text/css" media="all" rel="stylesheet" />
    <link href="<?php bloginfo( 'template_directory' ); ?>/css/bootstrap.min.css" type="text/css" media="all" rel="stylesheet" />
    <link href="<?php bloginfo( 'template_directory' ); ?>/css/font-awesome.min.css" type="text/css" media="all" rel="stylesheet" />




    <link href="<?php bloginfo( 'template_directory' ); ?>/js/jqueryslimscroll/examples/libs/prettify/prettify.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/jqueryslimscroll/examples/libs/prettify/prettify.js"></script>
    <script type="text/javascript" src="<?php bloginfo( 'template_directory' ); ?>/js/jqueryslimscroll/jquery.slimscroll.js"></script>
    <link href="<?php bloginfo( 'template_directory' ); ?>/js/jqueryslimscroll/examples/style.css" type="text/css" rel="stylesheet" />




    <link href="<?php echo bloginfo('stylesheet_url'); ?>?version=2.4" type="text/css" media="all" rel="stylesheet" />
    <link rel="shortcut icon" href="<?php bloginfo('template_directory')?>/img/favicon.png" />
      

    <style>
      @media (min-width: 1024px){
    <?php 

        echo get_fontes_tema();

      

    ?> 
    }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head> 
<body>
	<section id="espera" class="content-area container">
		<div class="topo_espera col-md-12">
			<img src="<?php bloginfo( 'template_directory' ); ?>/imagens/espera/marca-design-eficaz.jpg">
		</div>
		
		<div class="col_espera text_espera col-md-6">
			<h1>Nosso site está em construção</h1>
			<p style="font-weight: normal !important;">Estamos preparando um site com várias dicas e com todos os detalhes sobre os nossos serviços de design.</p>
		</div>

		<a href="https://www.designeficaz.com.br/" class="img-espera col_espera col-md-6">
			<img src="<?php bloginfo( 'template_directory' ); ?>/imagens/espera/imagem-espera.jpg">
		</a>
		
		<p class="txt-espera-baixo col-md-12">Enquanto isso, você pode nos encontrar aqui:</p>
		<div class="col-md-12">
			<div class="social-links">
				<a target="_blank" href="https://www.instagram.com/designeficaz/"><img src="<?php bloginfo( 'template_directory' ); ?>/imagens/espera/redes-sociais-instagram.jpg"></a>
				<a target="_blank" href="https://www.facebook.com/designeficaz/"><img src="<?php bloginfo( 'template_directory' ); ?>/imagens/espera/redes-sociais-facebook.jpg"></a>
				<a target="_blank" href="https://www.colab55.com/@danieldesouz4"><img src="<?php bloginfo( 'template_directory' ); ?>/imagens/espera/redes-sociais-colab55.jpg"></a>
				<a target="_blank" href="https://www.behance.net/danieldesouz4"><img src="<?php bloginfo( 'template_directory' ); ?>/imagens/espera/redes-sociais-behance.jpg"></a>
			</div>
		</div>
	</section><!-- .content-area -->

</body>



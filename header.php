<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */   
dynamic_sidebar('config_geral');  
 
$fontes_config = $_SESSION['fontes_config'];

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js"> 
<head>
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




    <link href="<?php echo bloginfo('stylesheet_url'); ?>" type="text/css" media="all" rel="stylesheet" />
    <link rel="shortcut icon" href="<?php bloginfo('template_directory')?>/img/favicon.png" />
      
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head> 

<body>

  <?php

    $itens_menu_1 = (array) wp_get_nav_menu_items('menu_1');

    foreach ($itens_menu_1 as $key => $value) {
      $value = (array) $value;
      $html_li_menu_1 .= "<li><a href=\"".$value['url']."\"><span>".$value['title']."</span></a></li>";
    }

  ?>
<div id="site">
  <div id="conteudo_site" class=""> 
    <?php 

      // $link_facebook    = (CONFIG_SOCIAL_LINK_FACEBOOK != 'CONFIG_SOCIAL_LINK_FACEBOOK' ? CONFIG_SOCIAL_LINK_FACEBOOK : '');
      // $link_twitter     = (CONFIG_SOCIAL_LINK_TWITTER != 'CONFIG_SOCIAL_LINK_TWITTER' ? CONFIG_SOCIAL_LINK_TWITTER : '');
      // $link_email       = (CONFIG_SOCIAL_EMAIL != 'CONFIG_SOCIAL_EMAIL' ? CONFIG_SOCIAL_EMAIL : '');
      // $link_instagram   = (CONFIG_SOCIAL_LINK_INSTAGRAM != 'CONFIG_SOCIAL_LINK_INSTAGRAM' ? CONFIG_SOCIAL_LINK_INSTAGRAM : '');
      // $link_youtube     = (CONFIG_SOCIAL_LINK_YOUTUBE != 'CONFIG_SOCIAL_LINK_YOUTUBE' ? CONFIG_SOCIAL_LINK_YOUTUBE : '');
      // $link_pinterest   = (CONFIG_SOCIAL_LINK_PINTEREST != 'CONFIG_SOCIAL_LINK_PINTEREST' ? CONFIG_SOCIAL_LINK_PINTEREST : '');
      // $link_vkontakte   = (CONFIG_SOCIAL_VKONTAKTE != 'CONFIG_SOCIAL_VKONTAKTE' ? CONFIG_SOCIAL_VKONTAKTE : '');
      
      $link_facebook = $link_twitter = $link_email = $link_instagram = $link_youtube  = $link_pinterest = $link_vkontakte = NULL;
      
    ?>
    <!-- Static navbar -->
    <nav id="menu_topo" class="col-md-12 navbar navbar-default navbar-fixed-top">
      <div id='borda_header'>
        <div class="container">
          <div class="col-md-12">

            <a href="<?php echo esc_url( home_url( '/' ) ); ?>/" id='pequena_logo_topo'>
              <img class="img-responsive" alt="<?php echo( get_bloginfo( 'title' ) ); ?>"src="<?php echo( get_header_image() ); ?>">
            </a>
            
            <!-- div class="side-area-mask"></div -->
            <i id='botao_pesquisa' class="fa fa-search" aria-hidden="true"></i>
            <!-- div id="social_icons_top" class="desktop">
              <a href="<?php echo $link_facebook;?>"><img src="<?php bloginfo( 'template_directory' ); ?>/imagens/facebook_logo2.jpg"></a>
              <a href="<?php echo $link_twitter;?>"><img src="<?php bloginfo( 'template_directory' ); ?>/imagens/twitter_logo2.jpg"></a>
              <a href="<?php echo $link_email;?>"><img src="<?php bloginfo( 'template_directory' ); ?>/imagens/envelope_logo.jpg"></a>
              <a href="<?php echo $link_instagram;?>"><img src="<?php bloginfo( 'template_directory' ); ?>/imagens/instagram_logo.jpg"></a>
              <a href="<?php echo $link_youtube;?>"><img src="<?php bloginfo( 'template_directory' ); ?>/imagens/youtube_logo.jpg"></a>
            </div -->

            <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                      <span class="sr-only"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                  </button>
                  <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                  <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo $header_image_html; echo "<span>$site_title</span>";?></a>
              </div> 
              <!-- Collect the nav links, forms, and other content for toggling -->

            <?php
                    wp_nav_menu( array(
                        'menu'              => 'menu_1',
                        'theme_location'    => 'menu_1',
                        'depth'             => 3,
                        'container'         => 'div',
                        'container_class'   => 'collapse navbar-collapse',
                'container_id'      => 'navbar',
                        'menu_class'        => 'nav navbar-nav',
                        'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                        'walker'            => new wp_bootstrap_navwalker())
                    );
                ?>   
              <!-- /.navbar-collapse -->

          </div><!-- .container -->
        </div>
      </div>
      <div id='barra_pesquisa'><?php get_search_form(); ?></div>
    </nav>
    <div id="abaixo_menu">
    <?php dynamic_sidebar('abaixo_menu');?>
    </div>
  	<div id="topo_1" class="col-md-12"> 	
      
      <div class="container">
    		<div id="banner_topo" class="col-md-12">
          <?php dynamic_sidebar('topo_publicidade');?>
    		</div>
      </div><!-- .container -->
  	</div>
    
    <div class="clearfix"></div>  
<?php
	

	if(!empty($_GET['subpage'])){
		if($_GET['subpage'] == 'slide'){
			require('slide.php');
		}else if($_GET['subpage'] == 'servicos'){
			require('servicos.php');
		}else if($_GET['subpage'] == 'planos'){
			require('planos.php');
		}else if($_GET['subpage'] == 'galeria'){
			require('galeria.php');
		}else if($_GET['subpage'] == 'galeria_home'){
			require('galeria_home.php');
		}
	}else{
		$html = '<h2 style="text-align:center;">Nada aqui</h2>';
	}


   	wp_register_style( 'zflagtheme_fontawesome', get_template_directory_uri().'/lib/font-awesome/css/font-awesome.min.css' ); 
    wp_enqueue_style('zflagtheme_fontawesome');

    wp_register_style( 'zflagtheme_js_style', get_template_directory_uri().'/functions/admin/css/style.css' ); 
    wp_enqueue_style('zflagtheme_js_style');

	wp_register_script( 'bootstrapjs', get_template_directory_uri().'/js/bootstrap.min.js'); 
    wp_enqueue_script('bootstrapjs');

	wp_register_script( 'zflagtheme_js_script', get_template_directory_uri().'/functions/admin/scripts/script.js'); 
    wp_enqueue_script('zflagtheme_js_script');
    wp_localize_script( 'zflagtheme_js_script', 'zflagtheme_js_script_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

    wp_register_style( 'bootstrapcss', get_template_directory_uri().'/css/bootstrap.min.css' ); 
    wp_enqueue_style('bootstrapcss');

	$html = '
	<div id="bloco_thema_zflag">
		<div class="painel_zflag">
			<header class="">
				<h2 class="page-title">ZFLAG THEMAS</h2>
			</header>
			
	        <nav id="menu" class="sidebar-nav col-md-3">
				<ul class="nav">
					<li class="nav-item"> 
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
				          	<i class="glyphicon glyphicon-chevron-right"></i>
				          	<span>Slide</span>
				        </a>
				        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="">
				          	<div class="bg-white py-2 collapse-inner rounded">
					            <a class="collapse-item ajax_send" data-subpage="slide" data-acao="cadastro" href="?page=zflag_theme_admin_geral&subpage=slide&acao=cadastro">Cadastrar</a>
					            <a class="collapse-item ajax_send" data-subpage="slide" data-acao="listar"  href="?page=zflag_theme_admin_geral&subpage=slide&acao=listar">Editar</a>
					            <div class="collapse-divider"></div>
					        </div>
				        </div>

					</li>
					<li class="nav-item"> 
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage_servicos" aria-expanded="false" aria-controls="collapsePage_servicos">
				          	<i class="glyphicon glyphicon-chevron-right"></i>
				          	<span>Serviços</span>
				        </a>
				        <div id="collapsePage_servicos" class="collapse" aria-labelledby="headingPage_servicos" data-parent="#accordionSidebar" style="">
				          	<div class="bg-white py-2 collapse-inner rounded">
					            <a class="collapse-item ajax_send" data-subpage="servicos" data-acao="cadastro" href="?page=zflag_theme_admin_geral&subpage=servicos&acao=cadastro">Cadastrar</a>
					            <a class="collapse-item ajax_send" data-subpage="servicos" data-acao="listar"  href="?page=zflag_theme_admin_geral&subpage=servicos&acao=listar">Editar</a>
					            <div class="collapse-divider"></div>
					        </div>
				        </div>

					</li>
					<li class="nav-item"> 
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage_planos" aria-expanded="false" aria-controls="collapsePage_planos">
				          	<i class="glyphicon glyphicon-chevron-right"></i>
				          	<span>Pacotes/Planos</span>
				        </a>
				        <div id="collapsePage_planos" class="collapse" aria-labelledby="headingPage_planos" data-parent="#accordionSidebar" style="">
				          	<div class="bg-white py-2 collapse-inner rounded">
					            <a class="collapse-item ajax_send" data-subpage="planos" data-acao="cadastro" href="?page=zflag_theme_admin_geral&subpage=planos&acao=cadastro">Cadastrar</a>
					            <a class="collapse-item ajax_send" data-subpage="planos" data-acao="listar"  href="?page=zflag_theme_admin_geral&subpage=planos&acao=listar">Editar</a>
					            <div class="collapse-divider"></div>
					        </div>
				        </div>

					</li>
					<li class="nav-item"> 
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_galeria" aria-expanded="false" aria-controls="collapse_galeria">
				          	<i class="glyphicon glyphicon-chevron-right"></i>
				          	<span>Galeria</span>
				        </a>
				        <div id="collapse_galeria" class="collapse" aria-labelledby="heading_galeria" data-parent="#accordionSidebar" style="">
				          	<div class="bg-white py-2 collapse-inner rounded">
					            <a class="collapse-item ajax_send" data-subpage="galeria" data-acao="cadastro" href="?page=zflag_theme_admin_geral&subpage=galeria&acao=cadastro">Cadastrar</a>
					            <a class="collapse-item ajax_send" data-subpage="galeria" data-acao="listar"  href="?page=zflag_theme_admin_geral&subpage=galeria&acao=listar">Editar</a>
					            <div class="collapse-divider"></div>
					        </div>
				        </div>

					</li>
					<li class="nav-item"> 
						<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse_galeria_home" aria-expanded="false" aria-controls="collapse_galeria_home">
				          	<i class="glyphicon glyphicon-chevron-right"></i>
				          	<span>Galeria Home</span>
				        </a>
				        <div id="collapse_galeria_home" class="collapse" aria-labelledby="heading_galeria_home" data-parent="#accordionSidebar" style="">
				          	<div class="bg-white py-2 collapse-inner rounded">
					            <a class="collapse-item ajax_send" data-subpage="galeria_home" data-acao="cadastro" href="?page=zflag_theme_admin_geral&subpage=galeria_home&acao=cadastro">Cadastrar</a>
					            <a class="collapse-item ajax_send" data-subpage="galeria_home" data-acao="listar"  href="?page=zflag_theme_admin_geral&subpage=galeria_home&acao=listar">Editar</a>
					            <div class="collapse-divider"></div>
					        </div>
				        </div>

					</li>
				</ul>
			</nav>
			<div id="body" class="container-fluid col-md-9">
				'.$html.'
			</div>
			
		</div>
	</div>
	';

	echo $html;



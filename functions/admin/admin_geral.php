<?php
	

	if(!empty($_GET['subpage'])){
		if($_GET['subpage'] == 'slide'){
			require('slide.php');
		}
	}else{
		$html = '<h2 style="text-align:center;">Nada aqui</h2>';
	}


   	wp_register_style( 'zflagtheme_fontawesome', get_template_directory_uri().'/plugin/fontawesome/css/fontawesome.min.css' ); 
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
				</ul>
			</nav>
			<div id="body" class="container-fluid col-md-9">
				'.$html.'
			</div>
			
		</div>
	</div>
	';

	echo $html;



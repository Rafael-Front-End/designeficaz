<?php
 function zflag_theme_admin_menu(){
 	$admin_dir = get_template_directory_uri().'/functions/admin';
 	add_menu_page('Configurações do Tema', 'Configurações do Tema', 'manage_options', 'zflag_theme_admin_geral', 'zflag_theme_load_admin_geral', $admin_dir.'/logo.png', 6);
}

add_action('admin_menu', 'zflag_theme_admin_menu');

function zflag_theme_admin_submenu(){
    add_submenu_page('zflag_theme_admin_geral', 'Fontes', 'Fontes', 'manage_options', 'zflag_theme_geral_fontes', 'zflag_theme_load_admin_fontes');
}
add_action( 'admin_menu', 'zflag_theme_admin_submenu' );

function zflag_theme_load_admin_geral(){ require('admin_geral.php');}
function zflag_theme_load_admin_fontes(){ require('admin_fontes.php');} 
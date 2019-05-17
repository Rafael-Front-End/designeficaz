
jQuery(document).ready(function($) {
	
	$('input[name="meta_box_criar_shortcode"]').on('click', function(){
		var meta_box_titulo_crps, meta_box_quantidade_crps, meta_box_categoria_crps, meta_box_design_crps, txt_shortcode, msg_post_recent_copie;


		msg_post_recent_copie 		= $('.msg_post_recent_copie');
		meta_box_titulo_crps 		= $('input[name="meta_box_titulo_crps"]').val();
		meta_box_quantidade_crps 	= $('input[name="meta_box_quantidade_crps"]').val();
		meta_box_categoria_crps 	= $('select[name="meta_box_categoria_crps"]').val();
		meta_box_design_crps 		= $('select[name="meta_box_design_crps"]').val();
		meta_box_largura_crps 		= $('select[name="meta_box_largura_crps"]').val();

		txt_shortcode = "  [saibamais titulo='"+meta_box_titulo_crps+"' quantidade='"+meta_box_quantidade_crps+"' categoria='"+meta_box_categoria_crps+"' design='"+meta_box_design_crps+"' largura='"+meta_box_largura_crps+"']  ";
		msg_post_recent_copie.show();
		$('textarea.recente_post_shortcode').val('');
		$('textarea.recente_post_shortcode').val(txt_shortcode);
		$('textarea.recente_post_shortcode').animate({"border-color": "#FE0102"}, 500);
		$('textarea.recente_post_shortcode').animate({"color": "#FE0102"}, 500);
		msg_post_recent_copie.animate({"color": "#FE0102"}, 500);
		msg_post_recent_copie.animate({"color": "#000"}, 2000);
		$('textarea.recente_post_shortcode').animate({"color": "#000"}, 2000);
		$('textarea.recente_post_shortcode').animate({"border-color": "#ccc"}, 2000);
		// alert("Copie o código abaixo e cole no post \n"+txt_shortcode); 
	});
}); 
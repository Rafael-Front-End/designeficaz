<?php
 //  zflag_tema_config_ prefixo para variaveis de configurações do tema 

 // plugins_url() //url
 // plugin_dir_path(__FILE__) //diretorio
 // add_option($name, $value, $deprecated, $autoload); //salvar no banco de dados
 // get_option($name_option) //carrega os dados do banco de dados
 // update_option($option_name, $newvalue); //atualiza os dados no banco de dados


$vetor_font = get_option('zflag_tema_config_vetor_font');
if(isset($_POST['dados_fontes'])){
	if($vetor_font != false || $vetor_font == NULL){
	
		update_option('zflag_tema_config_vetor_font', $_POST['dados_fontes']);
		$vetor_font = get_option('zflag_tema_config_vetor_font');

	}else if(add_option('zflag_tema_config_vetor_font', $_POST['dados_fontes'])){
	
		$vetor_font = get_option('zflag_tema_config_vetor_font');
	
	}
}





$vetor_dados_form = array(
	"titulo_das_paginas" => array("titulo"=>"Títulos das Paginas", 'css'=> '#titulo_pagina'),
	"texto_geral" => array("titulo"=>"Texto geral", 'css'=>'#texto_post p, body, .conteudo_post'),
	"slider_menu_lateral" => array("titulo"=>"Slider menu lateral", 'css' => '.news_carousel .list-group-item > h4'),
	"slider_titulo" => array("titulo"=>"Slider titulo", 'css'=>'.carousel_tipo_1 .carousel-caption h1 a, .news_carousel .carousel-caption > h4, .news_carousel .carousel-caption > h4 > a'),
	"slider_descricao" => array("titulo"=>"Slider Descricao", 'css'=>'.news_carousel p, .carousel_tipo_1 .carousel-caption p'),
	"destacar_post" => array("titulo"=>"Destacar post", 'css'=>'.destaca_post_unico h3'),
	"links" => array("titulo"=>"Links", 'css'=>'a'),
	"destaques" => array("titulo"=>"Destaques", 'css'=>'#exibe_destaques > .barra_destaques .item_destaque > #conteudo_item_destaque > h3, #exibe_destaques > .barra_destaques .item_destaque > #conteudo_item_destaque > h4, #exibe_destaques > h2'),
	"destaques_2" => array("titulo"=>"Destaques 2", 'css'=>'.destaque_2 h3'),
	"posts_recentes" => array("titulo"=>"Posts Recentes", 'css'=>'.bloco_post h2, .bloco_post h3, .bloco_post h4'),
	"widget_texto" => array("titulo"=>"Widget Texto", 'css'=>'.textwidget'),
	"menu_topo" => array("titulo"=>"Menu topo", 'css'=>'#menu_topo li > a, #menu_topo.navbar-default .navbar-nav > li > a, #menu_topo #menu_1 li > a, #menu_topo #menu_2 li > a, #menu_topo #menu_3 li > a'),
	"titulos_rodape" => array("titulo"=>"Titulos - Rodapé", 'css'=>'footer#rodape .textwidget h3, footer#rodape #rodape.social_footer h3, footer#rodape #rodape_centro h3, footer#rodape h4, footer#rodape h1, footer#rodape h2, footer#rodape h3'),
	"textos_rodape" => array("titulo"=>"Textos - Rodapé", 'css'=>'footer .textwidget, footer'),
	"titulo_rodape_copyright" => array("titulo"=>"Titulo - Rodapé copyright", 'css'=>'footer section.copyright .textwidget h1, footer section.copyright .textwidget h2, footer section.copyright .textwidget h3, footer section.copyright .textwidget h4, footer section.copyright h3, footer section.copyright h2, footer section.copyright h4, footer section.copyright h3'),
);


foreach ($vetor_dados_form as $key => $value) {
	$options_fontes 			= options_fontes($vetor_font[$key]['nome_fonte']);
	$tabelas_form_font .= "
		<table class=\"widefat fixed\" cellspacing=\"0\">
			<thead>
				<tr>
					<th colspan='2'>
						<legend>
							<h3>{$value[titulo]}</h3>
						</legend>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class=\"alternate\">
					<td class=\"column-columnname\" style=\"vertical-align:middle\" colspan='2'>
						<h3>Títulos das Paginas</h3>
				        <p>
				            <label for=\"dados_fontes[$key][estilo_fonte]\" > Estilo de fonte:</label>
				            <select name=\"dados_fontes[$key][estilo_fonte]\" id=\"dados_fontes[$key][estilo_fonte]\" class=\"postform\">
				              <option ".($vetor_font[$key]['estilo_fonte'] == 'normal' ? 'selected="selected"' : '')." class=\"level-0\" value=\"normal\">Regular</option>
				              <option ".($vetor_font[$key]['estilo_fonte'] == 'bold' ? 'selected="selected"' : '')." class=\"level-0\" value=\"bold\">bold</option>
				              <option ".($vetor_font[$key]['estilo_fonte'] == 'lighter' ? 'selected="selected"' : '')." class=\"level-0\" value=\"lighter\">Lighter</option>
				              <option ".($vetor_font[$key]['estilo_fonte'] == 'italic' ? 'selected="selected"' : '')." class=\"level-0\" value=\"italic\">Italic</option>
				            </select>
				        </p>
				        <div id='select_fontes'>
				          <p>
				              <label for=\"dados_fontes[$key][nome_fonte]\" > fontes:</label>
				              
				              <select name=\"dados_fontes[$key][nome_fonte]\" id=\"dados_fontes[$key][nome_fonte]\" class=\"postform\">
				                <option ".($vetor_font[$key]['nome_fonte'] == 'defaut' ? 'selected="selected"' : '')." class=\"level-0\" value=\"defaut\">Padrão do tema</option>
				                $options_fontes
				              </select>
				          </p>
				        </div>
				        <p>
				            <label for=\"dados_fontes[$key][tamanho_texto]\">Tamanho do texto:</label>
				            <input type='text' id=\"dados_fontes[$key][tamanho_texto]\" name=\"dados_fontes[$key][tamanho_texto]\" class=\"widefat\" value=\"".(($vetor_font[$key]['tamanho_texto']) ? $vetor_font[$key]['tamanho_texto'] : '')."\">
				            <input type='hidden' id=\"dados_fontes[$key][css]\" name=\"dados_fontes[$key][css]\" class=\"widefat\" value=\"".(($value['css']) ? $value['css'] : '')."\">
				            <div style=\"font:12px; color:#666;\">Use 'px' ou 'em', exemplo 16px, 1.5em. Deixe em branco caso queira manter o valor padrão do tema.</div>
				        </p>
				        <p>
				            <label for=\"dados_fontes[$key][cor_texto]\" > Cor do texto:</label>
				            <input type='text' id=\"dados_fontes[$key][cor_texto]\" name=\"dados_fontes[$key][cor_texto]\" class=\"widefat\" value=\"".(($vetor_font[$key]['cor_texto']) ? $vetor_font[$key]['cor_texto'] : '')."\">
				            <div style=\"font:12px; color:#666;\">Use valor hexadecimal, exemplo: '#333333' ou o nome da cor em inglês, exemplo: 'red'. Deixe em branco caso queira manter o valor padrão do tema.</div>
				        </p>
					</td>
				</tr>
			</tbody>

			<tfoot>
				<tr>
					<th class=\"manage-column column-columnname\" scope=\"col\" colspan='2'><input name=\"saveconfig\" id=\"saveconfig\" class=\"button button-primary right\" value=\"Salvar\" type=\"submit\"></th>
				</tr>
			</tfoot>
		</table>
	"; 
} 


$html_form_fontes = "
	<div class=\"wrap\">
		<form method=\"post\">
			$tabelas_form_font
		</form>
	</div>
    <hr>";


        $html_pagina .= $html_form_fontes;

/* Widget para posts recentes */

class config_fontes2 extends WP_Widget
{
    function __construct()
    {
        parent::__construct("config_fontes", "Fontes", array('description' => "(Widget de configurações) Modifica as fontes padrões do tema"));
    }

  public function widget($args, $instance)
  {
     $title    = sanitize_text_field( $instance['title'] );
    $fontes   = (!empty($instance['fontes']) ? $instance['fontes'] : "");
    $tipo_texto   = (!empty($instance['tipo_texto']) ? $instance['tipo_texto'] : "");
    $link   = (!empty($instance['link']) ? $instance['link'] : "");
    $nome   = (!empty($instance['nome']) ? $instance['nome'] : "");
    $cor   = (!empty($instance['cor']) ? $instance['cor'] : "");
    $estilo   = (!empty($instance['estilo']) ? $instance['estilo'] : "");
    $size   = (!empty($instance['size']) ? $instance['size'] : "");
    $_SESSION['fontes_config'][$tipo_texto][] = array('fontes' => $fontes, 'link' => $link, 'nome' => $nome, 'cor' => $cor, 'size' => $size, 'estilo' => $estilo);
  }
 
  public function form($instance)
  {
     $title    = sanitize_text_field( $instance['title'] );

    if(isset($instance['fontes']))
    {
      $fontes = $instance['fontes'];
    }

    if(isset($instance['tipo_texto']))
    {
      $tipo_texto = $instance['tipo_texto'];
    }

    if(isset($instance['link']))
    {
      $link = $instance['link'];
    }

    if(isset($instance['nome']))
    {
      $nome = $instance['nome'];
    }

    if(isset($instance['cor']))
    {
      $cor = $instance['cor'];
    }

    if(isset($instance['estilo']))
    {
      $estilo = $instance['estilo'];
    }

    if(isset($instance['size']))
    {
      $size = $instance['size'];
    }

      $options = options_fontes(esc_attr($fontes));

    $instance['title'] = $tipo_texto;
    $title    = sanitize_text_field( $instance['title'] );


    ?>  <input type='hidden' id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($title); ?>">
        <p>
            <label for="<?php echo $this->get_field_id('tipo_texto'); ?>" > <?php _e("Selecione o tipo de texto:"); ?></label>
            
            <select name="<?php echo $this->get_field_name('tipo_texto'); ?>" id="<?php echo $this->get_field_id('tipo_texto'); ?>" class="postform">
              <option <?php echo (esc_attr($tipo_texto) == 'Títulos das Paginas' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Títulos das Paginas">Títulos das Paginas</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Texto geral' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Texto geral">Texto geral</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Links' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Links">Links</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Destaques' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Destaques">Widget Destaques</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Destacar post' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Destacar post">Widget Destacar post</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Slider - Titulo' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Slider - Titulo">Widget Slider - Titulo</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Slider - Descrição' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Slider - Descrição">Widget Slider - Descrição</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Slider - Menu lateral' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Slider - Menu lateral">Widget Slider - Menu lateral</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Destaques 2' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Destaques 2">Widget Destaques 2</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Posts Recentes' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Posts Recentes">Widget Posts Recentes</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Widget Texto' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Widget Texto">Widget Texto</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Menu topo' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Menu topo">Menu topo</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Titulos - Rodape' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Titulos - Rodape">Titulos - Rodape</option>
              <option <?php echo (esc_attr($tipo_texto) == 'Textos - Rodape' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Textos - Rodape">Textos - Rodape</option>
              
              <option <?php echo (esc_attr($tipo_texto) == 'gontes padrões' ? 'selected=\"selected\"' : ''); ?> class="level-0" value="Titulo - Rodape copytight">Titulo - Rodape copytight</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('estilo'); ?>" > <?php _e("Estilo de fonte:"); ?></label>
            
            <select name="<?php echo $this->get_field_name('estilo'); ?>" id="<?php echo $this->get_field_id('estilo'); ?>" class="postform">
              <option <?php echo (esc_attr($estilo) == 'normal' ? 'selected="selected"' : ''); ?> class="level-0" value="normal">Regular</option>
              <option <?php echo (esc_attr($estilo) == 'bold' ? 'selected="selected"' : ''); ?> class="level-0" value="bold">bold</option>
              <option <?php echo (esc_attr($estilo) == 'lighter' ? 'selected="selected"' : ''); ?> class="level-0" value="lighter">Lighter</option>
              <option <?php echo (esc_attr($estilo) == 'italic' ? 'selected="selected"' : ''); ?> class="level-0" value="italic">Italic</option>
            </select>
        </p>
        <div id='select_fontes'>
          <p>
              <label for="<?php echo $this->get_field_id('fontes'); ?>" > <?php _e("fontes:"); ?></label>
              
              <select name="<?php echo $this->get_field_name('fontes'); ?>" id="<?php echo $this->get_field_id('fontes'); ?>" class="postform">
                <option <?php echo (esc_attr($fontes) == 'defaut' ? 'selected="selected"' : ''); ?> class="level-0" value="defaut">Padrão do tema</option>
                <?php echo $options;?>
              </select>
          </p>
        </div>
        <p>
            <label for="<?php echo $this->get_field_id('size'); ?>" > <?php _e("Tamanho do texto:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('size'); ?>" name="<?php echo $this->get_field_name('size'); ?>" class="widefat" value="<?php echo esc_attr($size); ?>">
            <div style="font:12px; color:#666;">Use 'px' ou 'em', exemplo 16px, 1.5em. Deixe em branco caso queira manter o valor padrão do tema.</div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cor'); ?>" > <?php _e("Cor do texto:"); ?></label>
            <input type='text' id="<?php echo $this->get_field_id('cor'); ?>" name="<?php echo $this->get_field_name('cor'); ?>" class="widefat" value="<?php echo esc_attr($cor); ?>">
            <div style="font:12px; color:#666;">Use valor hexadecimal, exemplo: '#333333' ou o nome da cor em inglês, exemplo: 'red'. Deixe em branco caso queira manter o valor padrão do tema.</div>
        </p>
        <hr>
        
    <?php

  }

  public function update($new_instance, $old_instance)
  {
    $instance = array();
    $instance['title']    = (!empty($new_instance['title'])    ?   strip_tags($new_instance['title'])  : '');
    $instance['fontes']    = (!empty($new_instance['fontes'])    ?   strip_tags($new_instance['fontes'])  : '');
    $instance['tipo_texto']        = (!empty($new_instance['tipo_texto'])   ?   strip_tags($new_instance['tipo_texto']) : '');
    $instance['link']        = (!empty($new_instance['link'])   ?   strip_tags($new_instance['link']) : '');
    $instance['estilo']        = (!empty($new_instance['estilo'])   ?   strip_tags($new_instance['estilo']) : '');
    $instance['nome']        = (!empty($new_instance['nome'])   ?   strip_tags($new_instance['nome']) : '');
    $instance['cor']        = (!empty($new_instance['cor'])   ?   strip_tags($new_instance['cor']) : '');
    $instance['size']        = (!empty($new_instance['size'])   ?   strip_tags($new_instance['size']) : '');
    return $instance;
  }

}



echo $html_pagina;
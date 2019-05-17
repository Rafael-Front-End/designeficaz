<?php 

function add_meta_boxes()
{
    add_meta_box("midia_post", "Mídia", "featured_media_meta_box_markup", "post", "side", "high", null);
    add_meta_box("recente_posts_shortcodes", "Posts Recentes", "create_recente_post_shortcode_meta_box_markup", "post", "side", "high", null);
}
add_action("add_meta_boxes", "add_meta_boxes");
 
function featured_media_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
    $meta_box_tipo_featured_media = get_post_meta($object->ID, "meta-box-tipo-featured_media", true);
    ?>
        <div>
            <label for="meta-box-tipo-featured_media">Tipo de arquivo</label>

            <select name="meta-box-tipo-featured_media">
                <option <?php echo (($meta_box_tipo_featured_media == 0 || $meta_box_tipo_featured_media == NULL) ? 'selected="selected"' : ''); ?> class="level-0" value="0">Selecione</option>
                <option <?php echo ($meta_box_tipo_featured_media == 1 ? 'selected="selected"' : ''); ?> class="level-1" value="1">Vídeo</option>
                <option <?php echo ($meta_box_tipo_featured_media == 2 ? 'selected="selected"' : ''); ?> class="level-2" value="2">Audio</option>
            </select>
            <br>
            <label for="meta-box-url-featured_media">Link do vídeo</label>
            <input name="meta-box-url-featured_media" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-url-featured_media", true); ?>">
            <br>
           	<p>Adicione o link do vídeo ou audio, no  caso do youtube este link é obtido em:<br>
           	<i>Compartilhar > Incorporar, dentro da tag iframe existe um campo chamado src com o link do vídeo</i></p>
           	<p><b>Exemplo:</b><br>
           	&lt;iframe src="A url fica aqui!"&gt;</p>  
           	<p>O video será exibido como destaque.</p>
        </div>
    <?php  
}
 

function save_featured_media_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "post";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";
    $meta_box_tipo_featured_media_value = "";
    $meta_box_checkbox_value = "";

    if(isset($_POST["meta-box-url-featured_media"]))
    {
        $meta_box_text_value = $_POST["meta-box-url-featured_media"];
    }   
    update_post_meta($post_id, "meta-box-url-featured_media", $meta_box_text_value);

    if(isset($_POST["meta-box-tipo-featured_media"]))
    {
        $meta_box_tipo_featured_media_value = $_POST["meta-box-tipo-featured_media"];
    }   
    update_post_meta($post_id, "meta-box-tipo-featured_media", $meta_box_tipo_featured_media_value);

    if(isset($_POST["meta-box-checkbox"]))
    {
        $meta_box_checkbox_value = $_POST["meta-box-checkbox"];
    }   
    update_post_meta($post_id, "meta-box-checkbox", $meta_box_checkbox_value);
}

add_action("save_post", "save_featured_media_meta_box", 10, 3);

//==================================================================================================
//==================================================================================================
//==================================================================================================

/**
 * Loads the color picker javascript
 */
function recente_post_shortcode_meta_box_js() {
    wp_enqueue_style( 'recente_post_shortcode_js' );
    wp_enqueue_script( 'recente_post_shortcode_js', get_template_directory_uri().'/js/recente_post_shortcode.js', array( 'jquery' ) );
}
add_action( 'admin_enqueue_scripts', 'recente_post_shortcode_meta_box_js' );


function create_recente_post_shortcode_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");
    $meta_box_titulo_crps       = "Saiba mais";
    $meta_box_quantidade_crps   = 3;
    $meta_box_categoria_crps    = 'todas-categorias';
    $meta_box_design_crps       = 1;
    $meta_box_largura_crps       = 0;

    ?>
        <p>
            <label for="meta_box_titulo_crps" > <?php _e("Titulo:"); ?></label>
            <input type='text' id="meta_box_titulo_crps" name="meta_box_titulo_crps" class="widefat" value="<?php echo $meta_box_titulo_crps; ?>">
            <div style="font:12px; color:#666;"> </div>
        </p>


        <p>
            <label for="meta_box_quantidade_crps" > Quantidade de posts:</label>
            <input type='text' id="meta_box_quantidade_crps" name="meta_box_quantidade_crps" class="widefat" value="<?php echo $meta_box_quantidade_crps;?>">
            <div style="font:12px; color:#666;">Digite o numero máximo de posts para serem exibidos</div>
        </p>
        <p>
            <label for="meta_box_categoria_crps" > Categoria:</label>

            <?php 
              $args = array(
                'walker'             => new SH_Walker_TaxonomyDropdown(),
                'show_option_all'    => '',
                'show_option_none'   => '',
                'option_none_value'  => '-1',
                'orderby'            => 'ID',
                'order'              => 'ASC',
                'show_count'         => 0,
                'hide_empty'         => 1,
                'child_of'           => 0,
                'exclude'            => '',
                'include'            => '',
                'echo'               => 1,
                'selected'           => $meta_box_categoria_crps,
                'hierarchical'       => 0,
                'name'               => 'meta_box_categoria_crps',
                'id'                 => 'meta_box_categoria_crps',
                'class'              => 'postform',
                'depth'              => 0,
                'tab_index'          => 0,
                'taxonomy'           => 'category',
                'hide_if_empty'      => false,
                'value_field'        => 'slug',
                'value'              => 'slug'
              ); 

              wp_dropdown_categories( $args ); 
            ?> 
            <div style="font:12px; color:#666;">Caso queira exibir uma categoria especifica selecione uma categoria, só sera exibida as postagens desta categoria.<br>Deixe como "Todas Categorias" para exibir todos os posts com ou sem categorias.</div>
        </p>

        <p>
            <label for="meta_box_design_crps" > Layout do Widget:</label>
            <select name="meta_box_design_crps" id="meta_box_design_crps" class="postform">
              <option <?php echo ($meta_box_design_crps == 1 ? 'selected="selected"' : ''); ?> class="level-0" value="1">Design Padrão</option>
              <option <?php echo ($meta_box_design_crps == 2 ? 'selected="selected"' : ''); ?> class="level-1" value="2">Design 2</option>
              <option <?php echo ($meta_box_design_crps == 3 ? 'selected="selected"' : ''); ?> class="level-2" value="3">Design 3</option>
              <option <?php echo ($meta_box_design_crps == 4 ? 'selected="selected"' : ''); ?> class="level-2" value="4">Design 4</option>
              <option <?php echo ($meta_box_design_crps == 4 ? 'selected="selected"' : ''); ?> class="level-2" value="4">Slider 1</option>
            </select>
        </p>
        <p>
            <label for="meta_box_largura_crps" > Largura:</label>
            <select name="meta_box_largura_crps" id="meta_box_largura_crps" class="postform">
              <option class="level-0" value="0" selected="selected">Padrão</option>
              <option class="level-1" value="40"> 40%</option>
              <option class="level-2" value="50"> 50%</option>
              <option class="level-2" value="60"> 60%</option>
              <option class="level-2" value="70"> 70%</option>
              <option class="level-2" value="80"> 80%</option>
              <option class="level-2" value="90"> 90%</option>
              <option class="level-2" value="100"> 100%</option>
            </select>
        </p>
        <p style='display:none;' class='msg_post_recent_copie'>Copie o código abaixo e cole no post</p>
        <p><textarea class='recente_post_shortcode' style='min-height: 90px; width:100%;'></textarea></p>
        <p>
            <input type='button' name='meta_box_criar_shortcode' value='Criar shortcode'>
        </p>
    <?php  
}




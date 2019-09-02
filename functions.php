<?php 

$temp_query = clone $wp_query;

if(false === get_option("medium_crop")) {
    add_option("medium_crop", "1");
} else {
    update_option("medium_crop", "1");
}



if ( STYLESHEETPATH == TEMPLATEPATH ) {
    define('OF_FILEPATH', TEMPLATEPATH);
    define('OF_DIRECTORY', get_template_directory_uri());
} else {
    define('OF_FILEPATH', STYLESHEETPATH);
    define('OF_DIRECTORY', get_stylesheet_directory_uri());
}

add_theme_support( 'post-thumbnails' );//opção para adicionar imagnes de destaques nos posts 
 
require_once (OF_FILEPATH . '/functions/theme-widgets.php');
require_once (OF_FILEPATH . '/functions/admin/admin.php');

// Register Custom Navigation Walker
require_once('wp_bootstrap_navwalker.php');
require_once('functions/meta_box.php');
require_once('functions/social_config.php');
require_once('functions/shortcodes.php');

function resumo_txt($txt,$n_caracter,$strip){
    $conteudo = $txt;
    $num_caracteres_txt = strlen($txt);
    $conteudo_strip = ($strip == 0 ? $conteudo : strip_tags($conteudo));
    $corte = substr($conteudo_strip,0,$n_caracter);
    $conteudo_pos = ((strlen($corte) > $n_caracter) ? strrpos($corte, ' ') : strlen($corte));
    $conteudo_resumo = substr($conteudo_strip,0,$conteudo_pos);
    $conteudo_resumo = ($strip == 0 ? nl2br($conteudo_resumo) : $conteudo_resumo);
    $conteudo_resumo .= ($num_caracteres_txt >= $n_caracter ? "..." : "");
    return $conteudo_resumo;
}
 

/*Contact form 7 remove span*/
add_filter('wpcf7_form_elements', function($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

    $content = str_replace('<br />', '', $content);
        
    return $content;
});


$bmIgnorePosts = array();

/**
 * add a post id to the ignore list for future query_posts
 */
function bm_ignorePost ($id) {
    if (!is_page()) {
        global $bmIgnorePosts;
        $bmIgnorePosts[] = $id;
    }
}

/**
 * reset the ignore list
 */
function bm_ignorePostReset () { 
    global $bmIgnorePosts;
    $bmIgnorePosts = array();
}

/**
 * remove the posts from query_posts
 */
function bm_postStrip ($where) {
    global $bmIgnorePosts, $wpdb;
    if (count($bmIgnorePosts) > 0) {
        $where .= ' AND ' . $wpdb->posts . '.ID NOT IN(' . implode (',', $bmIgnorePosts) . ') ';
    }
    return $where;
}

add_filter ('posts_where', 'bm_postStrip');



function data_amigavel(){


    $days = round((date('U') - get_the_time('U')) / (60*60*24));
    $weeks = round((date('U') - get_the_time('U')) / (7 * (60*60*24)));
    $months = round((date('U') - get_the_time('U')) / (30 * (60*60*24)));
    $years = round((date('U') - get_the_time('U')) / (365 * (60*60*24)));
    if ($days==0) {
        return "Hoje"; 
    } elseif ($days==1) {
        return "Ontem"; 
    } elseif ($days<7) {
        return $days . " dias atrás";
    } elseif ($days==7) {
        return $weeks . " semana atrás";
    } elseif ($days>7 && $days<=14) {
        return $weeks . " semanas atrás";
    } elseif ($days>14 && $days <=30) {
        return $weeks . " semanas atrás";
    } elseif ($days>30 && $days<=60) {
        return $months . " mês atrás";
    } elseif ($days>60 && $days<=365) {
        return $months . " meses atrás";
    } elseif ($days>365 && $days <=730) {
        return $years . " ano atrás";
    } elseif ($days>730) {
        return $years . " anos atrás";
    } else {
        return get_the_time('d/m/Y');
    } 

}


function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return 0;
    }
    return $count;
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
// Remove issues with prefetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);




// Bootstrap pagination function
 
function wp_bs_pagination($pages = '', $range = 4)
 
{  
 
     $showitems = ($range * 2) + 1;  
 
 
 
     global $paged;
 
     if(empty($paged)) $paged = 1;
 
 
 
     if($pages == '')
 
     {
 
         global $wp_query; 
 
         $pages = $wp_query->max_num_pages;
 
         if(!$pages)
 
         {
 
             $pages = 1;
 
         }
 
     }   
 
 
 
     if(1 != $pages)
 
     {
 
        echo '<div class="text-center">'; 
        echo '<nav><ul class="pagination"><li class="disabled hidden-xs"><span><span aria-hidden="true">Pagina '.$paged.' de '.$pages.'</span></span></li>';
 
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."' aria-label='First'>&laquo;<span class='hidden-xs'> Primeiro</span></a></li>";
 
         if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."' aria-label='Previous'>&lsaquo;<span class='hidden-xs'> Anterior</span></a></li>";
 
 
 
         for ($i=1; $i <= $pages; $i++)
 
         {
 
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
 
             {
 
                 echo ($paged == $i)? "<li class=\"active\"><span>".$i." <span class=\"sr-only\">(current)</span></span>
 
    </li>":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
 
             }
 
         }
 
 
 
         if ($paged < $pages && $showitems < $pages) echo "<li><a href=\"".get_pagenum_link($paged + 1)."\"  aria-label='Next'><span class='hidden-xs'>Próximo </span>&rsaquo;</a></li>";  
 
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."' aria-label='Last'><span class='hidden-xs'>Último </span>&raquo;</a></li>";
 
         echo "</ul></nav>";
         echo "</div>";
     }
}

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
    require get_template_directory() . '/inc/back-compat.php';
}



/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/customizer.php';


// Register Custom Navigation Walker
require_once('wp_bootstrap_navwalker.php');


add_filter('post_gallery', 'my_post_gallery', 10, 2);
function my_post_gallery($output, $attr) {
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order) $orderby = 'none';

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }

    if (empty($attachments)) return '';

    // Here's your actual output, you may customize it to your need
    $output .= "
        <div id=\"jssor_1\" style=\"position: relative; margin: 0 auto; top: 0px; left: 0px; width: 960px; height: 500px; overflow: hidden; visibility: hidden;  background-color: #24262e;\">
        <!-- Loading Screen -->
        <div data-u=\"loading\" style=\"position: absolute; top: 0px; left: 0px;\">
            <div style=\"filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;\"></div>
            <div style=\"position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;\"></div>
        </div>
        <div data-u=\"slides\" style=\"cursor: default; position: relative; top: -10px; left: 350px; width: 500px; height: 500px; overflow: hidden;\">
    ";
    

    // Now you loop through each attachment
    foreach ($attachments as $id => $attachment) {
        // Fetch the thumbnail (or full image, it's up to you)
//      $img = wp_get_attachment_image_src($id, 'medium');
//      $img = wp_get_attachment_image_src($id, 'my-custom-image-size');
        $img_p = wp_get_attachment_image_src($id, 'medium');
        $img = wp_get_attachment_image_src($id, 'full');

        $output .= "
            <div data-p=\"150.00\">
                <img class='imagem' data-u=\"image\" src=\"{$img[0]}\" />
                <img data-u=\"thumb\" src=\"{$img_p[0]}\" />
            </div>
        ";
    }

    $output .= "
        </div>
        <!-- Thumbnail Navigator -->
        <div data-u=\"thumbnavigator\" class=\"jssort01-99-66\" style=\"position:absolute;left:0px;top:0px !important;width:240px;height:700px;\" data-autocenter=\"2\">
            <!-- Thumbnail Item Skin Begin -->
            <div data-u=\"slides\" style=\"cursor: default;\">
                <div data-u=\"prototype\" class=\"p\">
                    <div class=\"w\">
                        <div data-u=\"thumbnailtemplate\" class=\"t\"></div>
                    </div>
                    <div class=\"c\"></div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div>
        <!-- Arrow Navigator -->
        <span data-u=\"arrowleft\" class=\"jssora05l\" style=\"top:0px;left:248px;width:40px;height:40px;\" data-autocenter=\"2\"></span>
        <span data-u=\"arrowright\" class=\"jssora05r\" style=\"top:0px;right:8px;width:40px;height:40px;\" data-autocenter=\"2\"></span>
    ";

}





//=================================================================================
//==================== Exemplo simples de bootstrap ===============================
//=================================================================================
// add_filter('post_gallery', 'my_post_gallery', 10, 2);
// function my_post_gallery($output, $attr) {
//     global $post;

//     if (isset($attr['orderby'])) {
//         $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
//         if (!$attr['orderby'])
//             unset($attr['orderby']);
//     }

//     extract(shortcode_atts(array(
//         'order' => 'ASC',
//         'orderby' => 'menu_order ID',
//         'id' => $post->ID,
//         'itemtag' => 'dl',
//         'icontag' => 'dt',
//         'captiontag' => 'dd',
//         'columns' => 3,
//         'size' => 'thumbnail',
//         'include' => '',
//         'exclude' => ''
//     ), $attr));

//     $id = intval($id);
//     if ('RAND' == $order) $orderby = 'none';

//     if (!empty($include)) {
//         $include = preg_replace('/[^0-9,]+/', '', $include);
//         $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

//         $attachments = array();
//         foreach ($_attachments as $key => $val) {
//             $attachments[$val->ID] = $_attachments[$key];
//         }
//     }

//     if (empty($attachments)) return '';

//     // Here's your actual output, you may customize it to your need
//     $output .= "
//         <div id=\"jssor_1\" style=\"position: relative; margin: 0 auto; top: 0px; left: 0px; width: 960px; height: 500px; overflow: hidden; visibility: hidden;  background-color: #24262e;\">
//         <!-- Loading Screen -->
//         <div data-u=\"loading\" style=\"position: absolute; top: 0px; left: 0px;\">
//             <div style=\"filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;\"></div>
//             <div style=\"position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;\"></div>
//         </div>
//         <div data-u=\"slides\" style=\"cursor: default; position: relative; top: -10px; left: 350px; width: 500px; height: 500px; overflow: hidden;\">
//     ";
//     $id_bootstrap_carousel = rand(0, 10000);
//     $contador_de_post = 0;
//     // Now you loop through each attachment
//     foreach ($attachments as $id => $attachment) {
        
//         // Fetch the thumbnail (or full image, it's up to you)
// //      $img = wp_get_attachment_image_src($id, 'medium');
// //      $img = wp_get_attachment_image_src($id, 'my-custom-image-size');
//         $img_p = wp_get_attachment_image_src($id, 'medium');
//         $img = wp_get_attachment_image_src($id, 'full');

//         $imagens .= "
//             <div class=\"item ".($contador_de_post == 0 ? 'active' : '')."\">
//                 <img class=\"second-slide\" src=\"{$img[0]}\" alt=\"Second slide\">
//             </div>
//         ";
//         $thumbnail .= "<li data-target=\"#myCarousel{$id_bootstrap_carousel}\" data-slide-to=\"{$contador_de_post}\" class=\"\"></li>";
//         $contador_de_post += 1;
//     }

    
//     $output = "
//     <div class='carousel_tipo_1'>
//       <div id=\"myCarousel{$id_bootstrap_carousel}\" class=\"carousel slide\" data-ride=\"carousel\">
//         <!-- Indicators -->
//         <ol class=\"carousel-indicators\">
//           {$thumbnail}
//         </ol>
//         <div class=\"carousel-inner\" role=\"listbox\">
//           {$imagens}
//         </div>
//         <a class=\"left carousel-control\" href=\"#myCarousel{$id_bootstrap_carousel}\" role=\"button\" data-slide=\"prev\">
//           <span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>
//           <span class=\"sr-only\">Previous</span>
//         </a>
//         <a class=\"right carousel-control\" href=\"#myCarousel{$id_bootstrap_carousel}\" role=\"button\" data-slide=\"next\">
//           <span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>
//           <span class=\"sr-only\">Next</span>
//         </a>
//       </div>
//     </div>
//    ";

//     return $output;
// }




// add_filter('post_gallery', 'my_post_gallery', 10, 2);
// function my_post_gallery($output, $attr) {
//     global $post;

//     if (isset($attr['orderby'])) {
//         $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
//         if (!$attr['orderby'])
//             unset($attr['orderby']);
//     }

//     extract(shortcode_atts(array(
//         'order' => 'ASC',
//         'orderby' => 'menu_order ID',
//         'id' => $post->ID,
//         'itemtag' => 'dl',
//         'icontag' => 'dt',
//         'captiontag' => 'dd',
//         'columns' => 3,
//         'size' => 'thumbnail',
//         'include' => '',
//         'exclude' => ''
//     ), $attr));

//     $id = intval($id);
//     if ('RAND' == $order) $orderby = 'none';

//     if (!empty($include)) {
//         $include = preg_replace('/[^0-9,]+/', '', $include);
//         $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

//         $attachments = array();
//         foreach ($_attachments as $key => $val) {
//             $attachments[$val->ID] = $_attachments[$key];
//         }
//     }

//     if (empty($attachments)) return '';

   
//      $output .= '<session id="gallery_page">';

//     // Now you loop through each attachment
//     foreach ($attachments as $id => $attachment) {
//         $img = wp_get_attachment_image_src($id, 'full');
//         $output .= "
//             <img class='col-md-3 img-responsive' src=\"{$img[0]}\" />
//         ";
//     }

//     $output .= '</session>';

    
//     return $output;
// }


class SH_Walker_TaxonomyDropdown extends Walker_CategoryDropdown{

    function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {

        if($output == NULL){
            $output = "<option class=\"level-$depth\" ".( $value === (string) $args['selected'] ? 'selected="selected"' : '')."  value=\"todas-categorias\">Todas Categorias</option>";
        }
        $depth += 1;

        $pad = str_repeat('&nbsp;', $depth * 2);
        $cat_name = apply_filters('list_cats', $category->name, $category);

        if( !isset($args['value']) ){
            $args['value'] = ( $category->taxonomy != 'category' ? 'slug' : 'id' );
        }


        $value = ($args['value']=='slug' ? $category->slug : $category->term_id );

        $output .= "\t<option class=\"level-$depth\" value=\"".$value."\"";
        if ( $value === (string) $args['selected'] ){ 
            $output .= ' selected="selected"';
        }
        $output .= '>';
        $output .= $pad.$cat_name;
        if ( $args['show_count'] )
            $output .= '&nbsp;&nbsp;('. $category->count .')';

        $output .= "</option>\n";
    }
}



function my_new_contactmethods( $contactmethods ) {
$contactmethods['twitter'] = 'Twitter';
$contactmethods['facebook'] = 'Facebook';
$contactmethods['instagram'] = 'Instagram';
$contactmethods['pinterest'] = 'Pinterest';
$contactmethods['youtube'] = 'Youtube';
$contactmethods['g_plus'] = 'Google Plus';


 
return $contactmethods;
}
add_filter('user_contactmethods','my_new_contactmethods',10,1);





function options_fontes($checked){
    // retorna options para o campo select de fontes
      return "
      <option style='font-family: Raleway;' ".($checked == 'Raleway' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Raleway\">Raleway</option>

      <option style='font-family: Arial;' ".($checked == 'Arial' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Arial\">Arial</option>

      <option style='font-family: Roboto;' ".($checked == 'Roboto' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Roboto\">Roboto</option>
      
      <option style='font-family: Arial Narrow;' ".($checked == 'Arial Narrow' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Arial Narrow\">Arial Narrow</option>

      <option style='font-family: bebaskai;' ".($checked == 'bebaskai' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"bebaskai\">bebaskai</option>

      <option style='font-family: Oswald;' ".($checked == 'Oswald' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Oswald\">Oswald</option>

      <option style='font-family: Open Sans;' ".($checked == 'Open Sans' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Open Sans\">Open Sans</option>

      <option style=\"font-family: 'Helvetica';\" ".($checked == 'Helvetica' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Helvetica\">Helvetica</option>

      <option style=\"font-family: 'Times New Roman';\" ".($checked == 'Times New Roman' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Times New Roman\">Times New Roman</option>

      <option style=\"font-family: 'Times';\" ".($checked == 'Times' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Times\">Times</option>

      <option style=\"font-family: 'Courier New';\" ".($checked == 'Courier New' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Courier New\">Courier New</option>

      <option style=\"font-family: 'Courier';\" ".($checked == 'Courier' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Courier\">Courier</option>


      <option style=\"font-family: 'Palatino';\" ".($checked == 'Palatino' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Palatino\">Palatino</option>

      <option style=\"font-family: 'Palatino Linotype';\" ".($checked == 'Palatino Linotype' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Palatino Linotype\">Palatino Linotype</option>

      <option style=\"font-family: 'Garamond';\" ".($checked == 'Garamond' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Garamond\">Garamond</option>

      <option style=\"font-family: 'Bookman';\" ".($checked == 'Bookman' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Bookman\">Bookman</option>

      <option style=\"font-family: 'Avant Garde';\" ".($checked == 'Avant Garde' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Avant Garde\">Avant Garde</option>

      <option style=\"font-family: 'Verdana';\" ".($checked == 'Verdana' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Verdana\">Verdana</option>


      <option style=\"font-family: 'Tahoma';\" ".($checked == 'Tahoma' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Tahoma\">Tahoma</option>

      <option style=\"font-family: 'Georgia';\" ".($checked == 'Georgia' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Georgia\">Georgia</option>

      <option style=\"font-family: 'Comic Sans MS';\" ".($checked == 'Comic Sans MS' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Comic Sans MS\">Comic Sans MS</option>

      <option style=\"font-family: 'Trebuchet MS';\" ".($checked == 'Trebuchet MS' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Trebuchet MS\">Trebuchet MS</option>

      <option style=\"font-family: 'Arial Black';\" ".($checked == 'Arial Black' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Arial Black\">Arial Black</option>

      <option style=\"font-family: 'Impact';\" ".($checked == 'Impact' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Impact\">Impact</option>

      <option style=\"font-family: 'serif';\" ".($checked == 'serif' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"serif\">serif</option>

      <option style=\"font-family: 'sans-serif';\" ".($checked == 'sans-serif' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"sans-serif\">sans-serif</option>

      <option style=\"font-family: 'Tahoma';\" ".($checked == 'Tahoma' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Tahoma\">Tahoma</option>

      <option style=\"font-family: 'Geneva';\" ".($checked == 'Geneva' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Geneva\">Geneva</option>

      <option style=\"font-family: 'Trebuchet MS';\" ".($checked == 'Trebuchet MS' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Trebuchet MS\">Trebuchet MS</option>

      <option style=\"font-family: 'Lucida Sans Unicode';\" ".($checked == 'Lucida Sans Unicode' ? 'selected=\"selected\"' : '')." class=\"level-0\" value=\"Lucida Sans Unicode\">Lucida Sans Unicode</option>";

}



add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo "
  <link rel=\"stylesheet\" href=\"//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C400%2C600%2C700%7COswald%3A400%2C700%7CRoboto%3A400%2C700%7CRaleway%3A400%2C700&subset=arabic\" />
  <style>
   
        /* latin-ext */
        @font-face {
          font-family: 'Oswald';
          font-style: normal;
          font-weight: 400;
          src: local('Oswald Regular'), local('Oswald-Regular'), url('../wp-content/themes/eduardo/fonts/oswald/Oswald-Regular.woff2') format('woff2');
          unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Oswald';
          font-style: normal;
          font-weight: 400;
          src: local('Oswald Regular'), local('Oswald-Regular'), url('../wp-content/themes/eduardo/fonts/oswald/oswald-regular_latin.woff2') format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Oswald';
          font-style: normal;
          font-weight: 700;
          src: local('Oswald Bold'), local('Oswald-Bold'), url('../wp-content/themes/eduardo/fonts/oswald/oswald-regular_3.woff2') format('woff2');
          unicode-range: U+0100-024F, U+1E00-1EFF, U+20A0-20AB, U+20AD-20CF, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Oswald';
          font-style: normal;
          font-weight: 700;
          src: local('Oswald Bold'), local('Oswald-Bold'), url('../wp-content/themes/eduardo/fonts/oswald/oswald-regular_bold.woff2') format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
        }

        @font-face {
          font-family: 'Roboto';
          src: url('../wp-content/themes/eduardo/fonts/roboto/Roboto-Regular.ttf');
          src: url('../wp-content/themes/eduardo/fonts/roboto/Roboto-Regular.ttf') format('truetype');
          font-weight: normal;
          font-style: normal;
        }


        @font-face {
          font-family: 'Open Sans';
          src: url('../wp-content/themes/eduardo/fonts/OpenSans-Regular.ttf');
          src: url('../wp-content/themes/eduardo/fonts/OpenSans-Regular.ttf') format('truetype');
          font-weight: normal;
          font-style: normal;
        }

        @font-face {
          font-family: 'BebasKai';
          src: url('../wp-content/themes/eduardo/fonts/BebasKai.ttf');
          src: url('../wp-content/themes/eduardo/fonts/BebasKai.ttf') format('truetype');
          font-weight: normal;
          font-style: normal;
        }

        @font-face {
          font-family: 'Arial Narrow';
          src: url('../wp-content/themes/eduardo/fonts/Arial_Narrow.ttf');
          src: url('../wp-content/themes/eduardo/fonts/Arial_Narrow.ttf') format('truetype');
          font-weight: normal;
          font-style: normal;
        }
  </style>";

}






function get_fontes_tema(){
    $vetor_font = get_option('zflag_tema_config_vetor_font');

    foreach ($vetor_font as $key => $value) {
        $font_estilo = (($value['estilo_fonte'] != 'italic') ? "font-weight:" : "font-style:");
        $string_css.= $value['css']."{".(($value['estilo_fonte'] != NULL) ? "$font_estilo ".$value['estilo_fonte']." !important;" : "")."".(($value['nome_fonte'] != NULL && ($value['nome_fonte'] != 'defaut')) ? "font-family: '".$value['nome_fonte']."' !important;" : "")."".(($value['tamanho_texto'] != NULL) ? "font-size: ".$value['tamanho_texto']." !important;" : "")."".(($value['cor_texto'] != NULL) ? "color: ".$value['cor_texto']." !important;" : "")."}";     
    }

    return $string_css;
}



function getDomain($url){
    /******************************************************************************
    *   RECUPERA O DOMINIO DE UMA URL FORNECIDA
    *******************************************************************************/
    //tratamento para videos de redecanais
    if(preg_match("/[htps:\/]*([a-z0-9=]+.)(cloudfront.*)/i", $url, $match)){
        $url = !empty($match[2]) ? $match[2] : $url;
    }

    if($url != NULL){
        $ccTLD = array(
                "/\.ac$/","/\.ad$/", "/\.ae$/", "/\.af$/", "/\.ag$/", "/\.ai$/", "/\.al$/", "/\.am$/", "/\.an$/", "/\.ao$/", "/\.aq$/", "/\.ar$/", "/\.as$/",
                "/\.at$/", "/\.au$/", "/\.aw$/", "/\.az$/", "/\.ba$/", "/\.bb$/", "/\.bd$/", "/\.be$/", "/\.bf$/", "/\.bg$/", "/\.bh$/", "/\.bi$/", "/\.bj$/",
                "/\.bm$/", "/\.bn$/", "/\.bo$/", "/\.br$/", "/\.bs$/", "/\.bt$/", "/\.bv$/", "/\.bw$/", "/\.by$/", "/\.bz$/", "/\.ca$/", "/\.cc$/", "/\.cd$/",
                "/\.cf$/", "/\.cg$/", "/\.ch$/", "/\.ci$/", "/\.ck$/", "/\.cl$/", "/\.cm$/", "/\.cn$/", "/\.co$/", "/\.cr$/", "/\.cu$/", "/\.cv$/", "/\.cx$/",
                "/\.cy$/", "/\.cz$/", "/\.de$/", "/\.dj$/", "/\.dk$/", "/\.dm$/", "/\.do$/", "/\.dz$/", "/\.ec$/", "/\.ee$/", "/\.eg$/", "/\.er$/", "/\.es$/",
                "/\.et$/", "/\.eu$/", "/\.fi$/", "/\.fj$/", "/\.fk$/", "/\.fm$/", "/\.fo$/", "/\.fr$/", "/\.ga$/", "/\.gb$/", "/\.gd$/", "/\.ge$/","/\.gf$/",
                "/\.gg$/", "/\.gh$/", "/\.gi$/", "/\.gl$/", "/\.gm$/", "/\.gn$/", "/\.gp$/", "/\.gq$/", "/\.gr$/", "/\.gs$/", "/\.gt$/","/\.gu$/", "/\.gw$/",
                "/\.gy$/", "/\.hk$/", "/\.hm$/", "/\.hn$/", "/\.hr$/", "/\.ht$/", "/\.hu$/", "/\.id$/", "/\.ie$/", "/\.il$/","/\.im$/", "/\.in$/", "/\.io$/",
                "/\.iq$/", "/\.ir$/", "/\.is$/", "/\.it$/", "/\.je$/", "/\.jm$/", "/\.jo$/", "/\.jp$/", "/\.ke$/","/\.kg$/", "/\.kh$/", "/\.ki$/", "/\.km$/",
                "/\.kn$/", "/\.kr$/", "/\.kw$/", "/\.ky$/", "/\.kz$/", "/\.la$/", "/\.lb$/", "/\.lc$/","/\.li$/", "/\.lk$/", "/\.lr$/", "/\.ls$/", "/\.lt$/",
                "/\.lu$/", "/\.lv$/", "/\.ly$/", "/\.ma$/", "/\.mc$/", "/\.md$/", "/\.me$/","/\.mg$/", "/\.mh$/", "/\.mk$/", "/\.ml$/", "/\.mm$/", "/\.mn$/",
                "/\.mo$/", "/\.mp$/", "/\.mq$/", "/\.mr$/", "/\.ms$/", "/\.mt$/","/\.mu$/", "/\.mv$/", "/\.mw$/", "/\.mx$/", "/\.my$/", "/\.mz$/", "/\.nb$/",
                "/\.nc$/", "/\.ne$/", "/\.nf$/", "/\.ng$/", "/\.ni$/","/\.nl$/", "/\.no$/", "/\.np$/", "/\.nr$/", "/\.nu$/", "/\.nz$/", "/\.om$/", "/\.pa$/",
                "/\.pe$/", "/\.pf$/", "/\.pg$/", "/\.ph$/","/\.pk$/", "/\.pl$/", "/\.pm$/", "/\.pn$/", "/\.pr$/", "/\.ps$/", "/\.pt$/", "/\.pw$/", "/\.py$/",
                "/\.qa$/", "/\.re$/", "/\.ro$/", "/\.ru$/","/\.rw$/", "/\.sa$/", "/\.sb$/", "/\.sc$/", "/\.scot$/", "/\.sd$/", "/\.se$/", "/\.sg$/", "/\.sh$/",
                "/\.si$/", "/\.sj$/", "/\.sk$/", "/\.sl$/","/\.sm$/", "/\.sn$/", "/\.so$/", "/\.sr$/", "/\.ss$/", "/\.st$/", "/\.su$/", "/\.sv$/", "/\.sy$/", 
                "/\.sz$/", "/\.tc$/", "/\.td$/", "/\.tf$/","/\.tg$/", "/\.th$/", "/\.tj$/", "/\.tk$/", "/\.tl$/", "/\.tm$/", "/\.tn$/", "/\.to$/", "/\.tr$/", 
                "/\.tt$/", "/\.tv$/", "/\.tw$/", "/\.tz$/","/\.ua$/", "/\.ug$/", "/\.uk$/", "/\.um$/", "/\.us$/", "/\.uy$/", "/\.uz$/", "/\.va$/", "/\.vc$/", 
                "/\.ve$/", "/\.vg$/", "/\.vi$/", "/\.vn$/","/\.vu$/", "/\.wf$/", "/\.ws$/", "/\.ye$/", "/\.yt$/", "/\.yu$/", "/\.za$/", "/\.zm$/", "/\.zw/"
        );

        $gTLD = array(
                "/\.aero$/","/\.arpa$/","/\.biz$/","/\.com$/","/\.coop$/","/\.edu$/","/\.gov$/","/\.info$/","/\.int$/","/\.mil$/","/\.museum$/",
                "/\.name$/","/\.net$/","/\.org$/","/\.pro$/","/\.tel/","/\.stream/","/\.tv/", "/\.aaa/", "/\.aarp/", "/\.abarth/", "/\.abb/", "/\.abbott/", "/\.abbvie/", "/\.abc/", "/\.able/", "/\.abogado/", "/\.abudhabi/", "/\.ac/", "/\.academy/", "/\.accenture/", "/\.accountant/", "/\.accountants/", "/\.aco/", "/\.active/", "/\.actor/", "/\.ad/", "/\.adac/", "/\.ads/", "/\.adult/", "/\.ae/", "/\.aeg/", "/\.aero/", "/\.aetna/", "/\.af/", "/\.afamilycompany/", "/\.afl/", "/\.africa/", "/\.ag/", "/\.agakhan/", "/\.agency/", "/\.ai/", "/\.aig/", "/\.aigo/", "/\.airbus/", "/\.airforce/", "/\.airtel/", "/\.akdn/", "/\.al/", "/\.alfaromeo/", "/\.alibaba/", "/\.alipay/", "/\.allfinanz/", "/\.allstate/", "/\.ally/", "/\.alsace/", "/\.alstom/", "/\.am/", "/\.americanexpress/", "/\.americanfamily/", "/\.amex/", "/\.amfam/", "/\.amica/", "/\.amsterdam/", "/\.analytics/", "/\.android/", "/\.anquan/", "/\.anz/", "/\.ao/", "/\.aol/", "/\.apartments/", "/\.app/", "/\.apple/", "/\.aq/", "/\.aquarelle/", "/\.ar/", "/\.arab/", "/\.aramco/", "/\.archi/", "/\.army/", "/\.arpa/", "/\.art/", "/\.arte/", "/\.as/", "/\.asda/", "/\.asia/", "/\.associates/", "/\.at/", "/\.athleta/", "/\.attorney/", "/\.au/", "/\.auction/", "/\.audi/", "/\.audible/", "/\.audio/", "/\.auspost/", "/\.author/", "/\.auto/", "/\.autos/", "/\.avianca/", "/\.aw/", "/\.aws/", "/\.ax/", "/\.axa/", "/\.az/", "/\.azure/", "/\.ba/", "/\.baby/", "/\.baidu/", "/\.banamex/", "/\.bananarepublic/", "/\.band/", "/\.bank/", "/\.bar/", "/\.barcelona/", "/\.barclaycard/", "/\.barclays/", "/\.barefoot/", "/\.bargains/", "/\.baseball/", "/\.basketball/", "/\.bauhaus/", "/\.bayern/", "/\.bb/", "/\.bbc/", "/\.bbt/", "/\.bbva/", "/\.bcg/", "/\.bcn/", "/\.bd/", "/\.be/", "/\.beats/", "/\.beauty/", "/\.beer/", "/\.bentley/", "/\.berlin/", "/\.best/", "/\.bestbuy/", "/\.bet/", "/\.bf/", "/\.bg/", "/\.bh/", "/\.bharti/", "/\.bi/", "/\.bible/", "/\.bid/", "/\.bike/", "/\.bing/", "/\.bingo/", "/\.bio/", "/\.biz/", "/\.bj/", "/\.black/", "/\.blackfriday/", "/\.blanco/", "/\.blockbuster/", "/\.blog/", "/\.bloomberg/", "/\.blue/", "/\.bm/", "/\.bms/", "/\.bmw/", "/\.bn/", "/\.bnl/", "/\.bnpparibas/", "/\.bo/", "/\.boats/", "/\.boehringer/", "/\.bofa/", "/\.bom/", "/\.bond/", "/\.boo/", "/\.book/", "/\.booking/", "/\.bosch/", "/\.bostik/", "/\.boston/", "/\.bot/", "/\.boutique/", "/\.box/", "/\.br/", "/\.bradesco/", "/\.bridgestone/", "/\.broadway/", "/\.broker/", "/\.brother/", "/\.brussels/", "/\.bs/", "/\.bt/", "/\.budapest/", "/\.bugatti/", "/\.build/", "/\.builders/", "/\.business/", "/\.buy/", "/\.buzz/", "/\.bv/", "/\.bw/", "/\.by/", "/\.bz/", "/\.bzh/", "/\.ca/", "/\.cab/", "/\.cafe/", "/\.cal/", "/\.call/", "/\.calvinklein/", "/\.cam/", "/\.camera/", "/\.camp/", "/\.cancerresearch/", "/\.canon/", "/\.capetown/", "/\.capital/", "/\.capitalone/", "/\.car/", "/\.caravan/", "/\.cards/", "/\.care/", "/\.career/", "/\.careers/", "/\.cars/", "/\.cartier/", "/\.casa/", "/\.case/", "/\.caseih/", "/\.cash/", "/\.casino/", "/\.cat/", "/\.catering/", "/\.catholic/", "/\.cba/", "/\.cbn/", "/\.cbre/", "/\.cbs/", "/\.cc/", "/\.cd/", "/\.ceb/", "/\.center/", "/\.ceo/", "/\.cern/", "/\.cf/", "/\.cfa/", "/\.cfd/", "/\.cg/", "/\.ch/", "/\.chanel/", "/\.channel/", "/\.charity/", "/\.chase/", "/\.chat/", "/\.cheap/", "/\.chintai/", "/\.christmas/", "/\.chrome/", "/\.chrysler/", "/\.church/", "/\.ci/", "/\.cipriani/", "/\.circle/", "/\.cisco/", "/\.citadel/", "/\.citi/", "/\.citic/", "/\.city/", "/\.cityeats/", "/\.ck/", "/\.cl/", "/\.claims/", "/\.cleaning/", "/\.click/", "/\.clinic/", "/\.clinique/", "/\.clothing/", "/\.cloud/", "/\.club/", "/\.clubmed/", "/\.cm/", "/\.cn/", "/\.co/", "/\.coach/", "/\.codes/", "/\.coffee/", "/\.college/", "/\.cologne/", "/\.com/", "/\.comcast/", "/\.commbank/", "/\.community/", "/\.company/", "/\.compare/", "/\.computer/", "/\.comsec/", "/\.condos/", "/\.construction/", "/\.consulting/", "/\.contact/", "/\.contractors/", "/\.cooking/", "/\.cookingchannel/", "/\.cool/", "/\.coop/", "/\.corsica/", "/\.country/", "/\.coupon/", "/\.coupons/", "/\.courses/", "/\.cr/", "/\.credit/", "/\.creditcard/", "/\.creditunion/", "/\.cricket/", "/\.crown/", "/\.crs/", "/\.cruise/", "/\.cruises/", "/\.csc/", "/\.cu/", "/\.cuisinella/", "/\.cv/", "/\.cw/", "/\.cx/", "/\.cy/", "/\.cymru/", "/\.cyou/", "/\.cz/", "/\.dabur/", "/\.dad/", "/\.dance/", "/\.data/", "/\.date/", "/\.dating/", "/\.datsun/", "/\.day/", "/\.dclk/", "/\.dds/", "/\.de/", "/\.deal/", "/\.dealer/", "/\.deals/", "/\.degree/", "/\.delivery/", "/\.dell/", "/\.deloitte/", "/\.delta/", "/\.democrat/", "/\.dental/", "/\.dentist/", "/\.desi/", "/\.design/", "/\.dev/", "/\.dhl/", "/\.diamonds/", "/\.diet/", "/\.digital/", "/\.direct/", "/\.directory/", "/\.discount/", "/\.discover/", "/\.dish/", "/\.diy/", "/\.dj/", "/\.dk/", "/\.dm/", "/\.dnp/", "/\.do/", "/\.docs/", "/\.doctor/", "/\.dodge/", "/\.dog/", "/\.doha/", "/\.domains/", "/\.dot/", "/\.download/", "/\.drive/", "/\.dtv/", "/\.dubai/", "/\.duck/", "/\.dunlop/", "/\.duns/", "/\.dupont/", "/\.durban/", "/\.dvag/", "/\.dvr/", "/\.dz/", "/\.earth/", "/\.eat/", "/\.ec/", "/\.eco/", "/\.edeka/", "/\.edu/", "/\.education/", "/\.ee/", "/\.eg/", "/\.email/", "/\.emerck/", "/\.energy/", "/\.engineer/", "/\.engineering/", "/\.enterprises/", "/\.epost/", "/\.epson/", "/\.equipment/", "/\.er/", "/\.ericsson/", "/\.erni/", "/\.es/", "/\.esq/", "/\.estate/", "/\.esurance/", "/\.et/", "/\.etisalat/", "/\.eu/", "/\.eurovision/", "/\.eus/", "/\.events/", "/\.everbank/", "/\.exchange/", "/\.expert/", "/\.exposed/", "/\.express/", "/\.extraspace/", "/\.fage/", "/\.fail/", "/\.fairwinds/", "/\.faith/", "/\.family/", "/\.fan/", "/\.fans/", "/\.farm/", "/\.farmers/", "/\.fashion/", "/\.fast/", "/\.fedex/", "/\.feedback/", "/\.ferrari/", "/\.ferrero/", "/\.fi/", "/\.fiat/", "/\.fidelity/", "/\.fido/", "/\.film/", "/\.final/", "/\.finance/", "/\.financial/", "/\.fire/", "/\.firestone/", "/\.firmdale/", "/\.fish/", "/\.fishing/", "/\.fit/", "/\.fitness/", "/\.fj/", "/\.fk/", "/\.flickr/", "/\.flights/", "/\.flir/", "/\.florist/", "/\.flowers/", "/\.fly/", "/\.fm/", "/\.fo/", "/\.foo/", "/\.food/", "/\.foodnetwork/", "/\.football/", "/\.ford/", "/\.forex/", "/\.forsale/", "/\.forum/", "/\.foundation/", "/\.fox/", "/\.fr/", "/\.free/", "/\.fresenius/", "/\.frl/", "/\.frogans/", "/\.frontdoor/", "/\.frontier/", "/\.ftr/", "/\.fujitsu/", "/\.fujixerox/", "/\.fun/", "/\.fund/", "/\.furniture/", "/\.futbol/", "/\.fyi/", "/\.ga/", "/\.gal/", "/\.gallery/", "/\.gallo/", "/\.gallup/", "/\.game/", "/\.games/", "/\.gap/", "/\.garden/", "/\.gb/", "/\.gbiz/", "/\.gd/", "/\.gdn/", "/\.ge/", "/\.gea/", "/\.gent/", "/\.genting/", "/\.george/", "/\.gf/", "/\.gg/", "/\.ggee/", "/\.gh/", "/\.gi/", "/\.gift/", "/\.gifts/", "/\.gives/", "/\.giving/", "/\.gl/", "/\.glade/", "/\.glass/", "/\.gle/", "/\.global/", "/\.globo/", "/\.gm/", "/\.gmail/", "/\.gmbh/", "/\.gmo/", "/\.gmx/", "/\.gn/", "/\.godaddy/", "/\.gold/", "/\.goldpoint/", "/\.golf/", "/\.goo/", "/\.goodyear/", "/\.goog/", "/\.google/", "/\.gop/", "/\.got/", "/\.gov/", "/\.gp/", "/\.gq/", "/\.gr/", "/\.grainger/", "/\.graphics/", "/\.gratis/", "/\.green/", "/\.gripe/", "/\.grocery/", "/\.group/", "/\.gs/", "/\.gt/", "/\.gu/", "/\.guardian/", "/\.gucci/", "/\.guge/", "/\.guide/", "/\.guitars/", "/\.guru/", "/\.gw/", "/\.gy/", "/\.hair/", "/\.hamburg/", "/\.hangout/", "/\.haus/", "/\.hbo/", "/\.hdfc/", "/\.hdfcbank/", "/\.health/", "/\.healthcare/", "/\.help/", "/\.helsinki/", "/\.here/", "/\.hermes/", "/\.hgtv/", "/\.hiphop/", "/\.hisamitsu/", "/\.hitachi/", "/\.hiv/", "/\.hk/", "/\.hkt/", "/\.hm/", "/\.hn/", "/\.hockey/", "/\.holdings/", "/\.holiday/", "/\.homedepot/", "/\.homegoods/", "/\.homes/", "/\.homesense/", "/\.honda/", "/\.honeywell/", "/\.horse/", "/\.hospital/", "/\.host/", "/\.hosting/", "/\.hot/", "/\.hoteles/", "/\.hotels/", "/\.hotmail/", "/\.house/", "/\.how/", "/\.hr/", "/\.hsbc/", "/\.ht/", "/\.hu/", "/\.hughes/", "/\.hyatt/", "/\.hyundai/", "/\.ibm/", "/\.icbc/", "/\.ice/", "/\.icu/", "/\.id/", "/\.ie/", "/\.ieee/", "/\.ifm/", "/\.ikano/", "/\.il/", "/\.im/", "/\.imamat/", "/\.imdb/", "/\.immo/", "/\.immobilien/", "/\.in/", "/\.inc/", "/\.industries/", "/\.infiniti/", "/\.info/", "/\.ing/", "/\.ink/", "/\.institute/", "/\.insurance/", "/\.insure/", "/\.int/", "/\.intel/", "/\.international/", "/\.intuit/", "/\.investments/", "/\.io/", "/\.ipiranga/", "/\.iq/", "/\.ir/", "/\.irish/", "/\.is/", "/\.iselect/", "/\.ismaili/", "/\.ist/", "/\.istanbul/", "/\.it/", "/\.itau/", "/\.itv/", "/\.iveco/", "/\.jaguar/", "/\.java/", "/\.jcb/", "/\.jcp/", "/\.je/", "/\.jeep/", "/\.jetzt/", "/\.jewelry/", "/\.jio/", "/\.jll/", "/\.jm/", "/\.jmp/", "/\.jnj/", "/\.jo/", "/\.jobs/", "/\.joburg/", "/\.jot/", "/\.joy/", "/\.jp/", "/\.jpmorgan/", "/\.jprs/", "/\.juegos/", "/\.juniper/", "/\.kaufen/", "/\.kddi/", "/\.ke/", "/\.kerryhotels/", "/\.kerrylogistics/", "/\.kerryproperties/", "/\.kfh/", "/\.kg/", "/\.kh/", "/\.ki/", "/\.kia/", "/\.kim/", "/\.kinder/", "/\.kindle/", "/\.kitchen/", "/\.kiwi/", "/\.km/", "/\.kn/", "/\.koeln/", "/\.komatsu/", "/\.kosher/", "/\.kp/", "/\.kpmg/", "/\.kpn/", "/\.kr/", "/\.krd/", "/\.kred/", "/\.kuokgroup/", "/\.kw/", "/\.ky/", "/\.kyoto/", "/\.kz/", "/\.la/", "/\.lacaixa/", "/\.ladbrokes/", "/\.lamborghini/", "/\.lamer/", "/\.lancaster/", "/\.lancia/", "/\.lancome/", "/\.land/", "/\.landrover/", "/\.lanxess/", "/\.lasalle/", "/\.lat/", "/\.latino/", "/\.latrobe/", "/\.law/", "/\.lawyer/", "/\.lb/", "/\.lc/", "/\.lds/", "/\.lease/", "/\.leclerc/", "/\.lefrak/", "/\.legal/", "/\.lego/", "/\.lexus/", "/\.lgbt/", "/\.li/", "/\.liaison/", "/\.lidl/", "/\.life/", "/\.lifeinsurance/", "/\.lifestyle/", "/\.lighting/", "/\.like/", "/\.lilly/", "/\.limited/", "/\.limo/", "/\.lincoln/", "/\.linde/", "/\.link/", "/\.lipsy/", "/\.live/", "/\.living/", "/\.lixil/", "/\.lk/", "/\.llc/", "/\.loan/", "/\.loans/", "/\.locker/", "/\.locus/", "/\.loft/", "/\.lol/", "/\.london/", "/\.lotte/", "/\.lotto/", "/\.love/", "/\.lpl/", "/\.lplfinancial/", "/\.lr/", "/\.ls/", "/\.lt/", "/\.ltd/", "/\.ltda/", "/\.lu/", "/\.lundbeck/", "/\.lupin/", "/\.luxe/", "/\.luxury/", "/\.lv/", "/\.ly/", "/\.ma/", "/\.macys/", "/\.madrid/", "/\.maif/", "/\.maison/", "/\.makeup/", "/\.man/", "/\.management/", "/\.mango/", "/\.map/", "/\.market/", "/\.marketing/", "/\.markets/", "/\.marriott/", "/\.marshalls/", "/\.maserati/", "/\.mattel/", "/\.mba/", "/\.mc/", "/\.mckinsey/", "/\.md/", "/\.me/", "/\.med/", "/\.media/", "/\.meet/", "/\.melbourne/", "/\.meme/", "/\.memorial/", "/\.men/", "/\.menu/", "/\.merckmsd/", "/\.metlife/", "/\.mg/", "/\.mh/", "/\.miami/", "/\.microsoft/", "/\.mil/", "/\.mini/", "/\.mint/", "/\.mit/", "/\.mitsubishi/", "/\.mk/", "/\.ml/", "/\.mlb/", "/\.mls/", "/\.mm/", "/\.mma/", "/\.mn/", "/\.mo/", "/\.mobi/", "/\.mobile/", "/\.mobily/", "/\.moda/", "/\.moe/", "/\.moi/", "/\.mom/", "/\.monash/", "/\.money/", "/\.monster/", "/\.mopar/", "/\.mormon/", "/\.mortgage/", "/\.moscow/", "/\.moto/", "/\.motorcycles/", "/\.mov/", "/\.movie/", "/\.movistar/", "/\.mp/", "/\.mq/", "/\.mr/", "/\.ms/", "/\.msd/", "/\.mt/", "/\.mtn/", "/\.mtr/", "/\.mu/", "/\.museum/", "/\.mutual/", "/\.mv/", "/\.mw/", "/\.mx/", "/\.my/", "/\.mz/", "/\.na/", "/\.nab/", "/\.nadex/", "/\.nagoya/", "/\.name/", "/\.nationwide/", "/\.natura/", "/\.navy/", "/\.nba/", "/\.nc/", "/\.ne/", "/\.nec/", "/\.net/", "/\.netbank/", "/\.netflix/", "/\.network/", "/\.neustar/", "/\.new/", "/\.newholland/", "/\.news/", "/\.next/", "/\.nextdirect/", "/\.nexus/", "/\.nf/", "/\.nfl/", "/\.ng/", "/\.ngo/", "/\.nhk/", "/\.ni/", "/\.nico/", "/\.nike/", "/\.nikon/", "/\.ninja/", "/\.nissan/", "/\.nissay/", "/\.nl/", "/\.no/", "/\.nokia/", "/\.northwesternmutual/", "/\.norton/", "/\.now/", "/\.nowruz/", "/\.nowtv/", "/\.np/", "/\.nr/", "/\.nra/", "/\.nrw/", "/\.ntt/", "/\.nu/", "/\.nyc/", "/\.nz/", "/\.obi/", "/\.observer/", "/\.off/", "/\.office/", "/\.okinawa/", "/\.olayan/", "/\.olayangroup/", "/\.oldnavy/", "/\.ollo/", "/\.om/", "/\.omega/", "/\.one/", "/\.ong/", "/\.onl/", "/\.online/", "/\.onyourside/", "/\.ooo/", "/\.open/", "/\.oracle/", "/\.orange/", "/\.org/", "/\.organic/", "/\.origins/", "/\.osaka/", "/\.otsuka/", "/\.ott/", "/\.ovh/", "/\.pa/", "/\.page/", "/\.panasonic/", "/\.paris/", "/\.pars/", "/\.partners/", "/\.parts/", "/\.party/", "/\.passagens/", "/\.pay/", "/\.pccw/", "/\.pe/", "/\.pet/", "/\.pf/", "/\.pfizer/", "/\.pg/", "/\.ph/", "/\.pharmacy/", "/\.phd/", "/\.philips/", "/\.phone/", "/\.photo/", "/\.photography/", "/\.photos/", "/\.physio/", "/\.piaget/", "/\.pics/", "/\.pictet/", "/\.pictures/", "/\.pid/", "/\.pin/", "/\.ping/", "/\.pink/", "/\.pioneer/", "/\.pizza/", "/\.pk/", "/\.pl/", "/\.place/", "/\.play/", "/\.playstation/", "/\.plumbing/", "/\.plus/", "/\.pm/", "/\.pn/", "/\.pnc/", "/\.pohl/", "/\.poker/", "/\.politie/", "/\.porn/", "/\.post/", "/\.pr/", "/\.pramerica/", "/\.praxi/", "/\.press/", "/\.prime/", "/\.pro/", "/\.prod/", "/\.productions/", "/\.prof/", "/\.progressive/", "/\.promo/", "/\.properties/", "/\.property/", "/\.protection/", "/\.pru/", "/\.prudential/", "/\.ps/", "/\.pt/", "/\.pub/", "/\.pw/", "/\.pwc/", "/\.py/", "/\.qa/", "/\.qpon/", "/\.quebec/", "/\.quest/", "/\.qvc/", "/\.racing/", "/\.radio/", "/\.raid/", "/\.re/", "/\.read/", "/\.realestate/", "/\.realtor/", "/\.realty/", "/\.recipes/", "/\.red/", "/\.redstone/", "/\.redumbrella/", "/\.rehab/", "/\.reise/", "/\.reisen/", "/\.reit/", "/\.reliance/", "/\.ren/", "/\.rent/", "/\.rentals/", "/\.repair/", "/\.report/", "/\.republican/", "/\.rest/", "/\.restaurant/", "/\.review/", "/\.reviews/", "/\.rexroth/", "/\.rich/", "/\.richardli/", "/\.ricoh/", "/\.rightathome/", "/\.ril/", "/\.rio/", "/\.rip/", "/\.rmit/", "/\.ro/", "/\.rocher/", "/\.rocks/", "/\.rodeo/", "/\.rogers/", "/\.room/", "/\.rs/", "/\.rsvp/", "/\.ru/", "/\.rugby/", "/\.ruhr/", "/\.run/", "/\.rw/", "/\.rwe/", "/\.ryukyu/", "/\.sa/", "/\.saarland/", "/\.safe/", "/\.safety/", "/\.sakura/", "/\.sale/", "/\.salon/", "/\.samsclub/", "/\.samsung/", "/\.sandvik/", "/\.sandvikcoromant/", "/\.sanofi/", "/\.sap/", "/\.sarl/", "/\.sas/", "/\.save/", "/\.saxo/", "/\.sb/", "/\.sbi/", "/\.sbs/", "/\.sc/", "/\.sca/", "/\.scb/", "/\.schaeffler/", "/\.schmidt/", "/\.scholarships/", "/\.school/", "/\.schule/", "/\.schwarz/", "/\.science/", "/\.scjohnson/", "/\.scor/", "/\.scot/", "/\.sd/", "/\.se/", "/\.search/", "/\.seat/", "/\.secure/", "/\.security/", "/\.seek/", "/\.select/", "/\.sener/", "/\.services/", "/\.ses/", "/\.seven/", "/\.sew/", "/\.sex/", "/\.sexy/", "/\.sfr/", "/\.sg/", "/\.sh/", "/\.shangrila/", "/\.sharp/", "/\.shaw/", "/\.shell/", "/\.shia/", "/\.shiksha/", "/\.shoes/", "/\.shop/", "/\.shopping/", "/\.shouji/", "/\.show/", "/\.showtime/", "/\.shriram/", "/\.si/", "/\.silk/", "/\.sina/", "/\.singles/", "/\.site/", "/\.sj/", "/\.sk/", "/\.ski/", "/\.skin/", "/\.sky/", "/\.skype/", "/\.sl/", "/\.sling/", "/\.sm/", "/\.smart/", "/\.smile/", "/\.sn/", "/\.sncf/", "/\.so/", "/\.soccer/", "/\.social/", "/\.softbank/", "/\.software/", "/\.sohu/", "/\.solar/", "/\.solutions/", "/\.song/", "/\.sony/", "/\.soy/", "/\.space/", "/\.sport/", "/\.spot/", "/\.spreadbetting/", "/\.sr/", "/\.srl/", "/\.srt/", "/\.ss/", "/\.st/", "/\.stada/", "/\.staples/", "/\.star/", "/\.starhub/", "/\.statebank/", "/\.statefarm/", "/\.stc/", "/\.stcgroup/", "/\.stockholm/", "/\.storage/", "/\.store/", "/\.stream/", "/\.studio/", "/\.study/", "/\.style/", "/\.su/", "/\.sucks/", "/\.supplies/", "/\.supply/", "/\.support/", "/\.surf/", "/\.surgery/", "/\.suzuki/", "/\.sv/", "/\.swatch/", "/\.swiftcover/", "/\.swiss/", "/\.sx/", "/\.sy/", "/\.sydney/", "/\.symantec/", "/\.systems/", "/\.sz/", "/\.tab/", "/\.taipei/", "/\.talk/", "/\.taobao/", "/\.target/", "/\.tatamotors/", "/\.tatar/", "/\.tattoo/", "/\.tax/", "/\.taxi/", "/\.tc/", "/\.tci/", "/\.td/", "/\.tdk/", "/\.team/", "/\.tech/", "/\.technology/", "/\.tel/", "/\.telefonica/", "/\.temasek/", "/\.tennis/", "/\.teva/", "/\.tf/", "/\.tg/", "/\.th/", "/\.thd/", "/\.theater/", "/\.theatre/", "/\.tiaa/", "/\.tickets/", "/\.tienda/", "/\.tiffany/", "/\.tips/", "/\.tires/", "/\.tirol/", "/\.tj/", "/\.tjmaxx/", "/\.tjx/", "/\.tk/", "/\.tkmaxx/", "/\.tl/", "/\.tm/", "/\.tmall/", "/\.tn/", "/\.to/", "/\.today/", "/\.tokyo/", "/\.tools/", "/\.top/", "/\.toray/", "/\.toshiba/", "/\.total/", "/\.tours/", "/\.town/", "/\.toyota/", "/\.toys/", "/\.tr/", "/\.trade/",
        "/\.trading/",
        "/\.training/",
        "/\.travel/",
        "/\.travelchannel/",
        "/\.travelers/",
        "/\.travelersinsurance/",
        "/\.trust/",
        "/\.trv/",
        "/\.tt/",
        "/\.tube/",
        "/\.tui/",
        "/\.tunes/",
        "/\.tushu/",
        "/\.tv/",
        "/\.tvs/",
        "/\.tw/",
        "/\.tz/",
        "/\.ua/",
        "/\.ubank/",
        "/\.ubs/",
        "/\.uconnect/",
        "/\.ug/",
        "/\.uk/",
        "/\.unicom/",
        "/\.university/",
        "/\.uno/",
        "/\.uol/",
        "/\.ups/",
        "/\.us/",
        "/\.uy/",
        "/\.uz/",
        "/\.va/",
        "/\.vacations/",
        "/\.vana/",
        "/\.vanguard/",
        "/\.vc/",
        "/\.ve/",
        "/\.vegas/",
        "/\.ventures/",
        "/\.verisign/",
        "/\.versicherung/",
        "/\.vet/",
        "/\.vg/",
        "/\.vi/",
        "/\.viajes/",
        "/\.video/",
        "/\.vig/",
        "/\.viking/",
        "/\.villas/",
        "/\.vin/",
        "/\.vip/",
        "/\.virgin/",
        "/\.visa/",
        "/\.vision/",
        "/\.vistaprint/",
        "/\.viva/",
        "/\.vivo/",
        "/\.vlaanderen/",
        "/\.vn/",
        "/\.vodka/",
        "/\.volkswagen/",
        "/\.volvo/",
        "/\.vote/",
        "/\.voting/",
        "/\.voto/",
        "/\.voyage/",
        "/\.vu/",
        "/\.vuelos/",
        "/\.wales/",
        "/\.walmart/",
        "/\.walter/",
        "/\.wang/",
        "/\.wanggou/",
        "/\.warman/",
        "/\.watch/",
        "/\.watches/",
        "/\.weather/",
        "/\.weatherchannel/",
        "/\.webcam/",
        "/\.weber/",
        "/\.website/",
        "/\.wed/",
        "/\.wedding/",
        "/\.weibo/",
        "/\.weir/",
        "/\.wf/",
        "/\.whoswho/",
        "/\.wien/",
        "/\.wiki/",
        "/\.williamhill/",
        "/\.win/",
        "/\.windows/",
        "/\.wine/",
        "/\.winners/",
        "/\.wme/",
        "/\.wolterskluwer/",
        "/\.woodside/",
        "/\.work/",
        "/\.works/",
        "/\.world/",
        "/\.wow/",
        "/\.ws/",
        "/\.wtc/",
        "/\.wtf/",
        "/\.xbox/",
        "/\.xerox/",
        "/\.xfinity/",
        "/\.xihuan/",
        "/\.xin/",
        "/\.xxx/",
        "/\.xyz/",
        "/\.yachts/",
        "/\.yahoo/",
        "/\.yamaxun/",
        "/\.yandex/",
        "/\.ye/",
        "/\.yodobashi/",
        "/\.yoga/",
        "/\.yokohama/",
        "/\.you/",
        "/\.youtube/",
        "/\.yt/",
        "/\.yun/",
        "/\.za/",
        "/\.zappos/",
        "/\.zara/",
        "/\.zero/",
        "/\.zip/",
        "/\.zippo/",
        "/\.zm/",
        "/\.zone/",
        "/\.zuerich/",
        "/\.zw/");

        
        $url            =   trim($url);
        $url            =   (!preg_match("/^http/",$url)) ? "http://".$url : $url;

        $url            =   parse_url($url,PHP_URL_HOST); 
        if($url != NULL)
        {  
            $link           =   $url; // armazena o vendedor com os TLDs
            $url            =   preg_replace($ccTLD,"",$url); // remove o ccTLD se tiver 
            $url            =   preg_replace($gTLD,"",$url); // remove gTLD

            //$separador    =   strrpos($url,".");
            //$vendedor      =   substr($url, $separador+1);
            
            $url            =   explode(".",$url);
            $url            =   array_reverse($url); // o vendedor se encontra no indice 0
            $url_pos        =   strpos($link, $url[0]); // localisando o vendedor na url inteira
            $vendedor        =   substr($link, $url_pos);
            return $vendedor;
        }
    }else{
        return false;
    }
}


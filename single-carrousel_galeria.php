<?php
/*
Single Post Template: Galeria - Slider 
Description: This part is optional, but helpful for describing the Post Template
*/




add_filter('post_gallery', 'carrousel_galeria', 10, 2);
function carrousel_galeria($output, $attr) {
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
    $id_bootstrap_carousel = rand(0, 10000);
    $contador_de_post = 0;
    // Now you loop through each attachment
    foreach ($attachments as $id => $attachment) {
        
        // Fetch the thumbnail (or full image, it's up to you)
//      $img = wp_get_attachment_image_src($id, 'medium');
//      $img = wp_get_attachment_image_src($id, 'my-custom-image-size');
        $img_p = wp_get_attachment_image_src($id, 'medium');
        $img = wp_get_attachment_image_src($id, 'full');

        $imagens .= "
            <a href='{$img[0]}' data-rel='lightbox-0' style=\"background-image: url({$img[0]});\" class=\"item ".($contador_de_post == 0 ? 'active' : '')."\">
            </a>
        ";
        $thumbnail .= "<li style=\"background-image: url({$img_p[0]});\" data-target=\"#myCarousel{$id_bootstrap_carousel}\" data-slide-to=\"{$contador_de_post}\" class=\"\"></li>";
        $contador_de_post += 1;
    }

    
    $output = "
    <div class='carousel_com_carrosel'>
      <div id=\"myCarousel{$id_bootstrap_carousel}\" class=\"carousel slide\" data-ride=\"carousel\">
        <!-- Indicators -->
        <ol class=\"carousel-indicators\">
          {$thumbnail}
        </ol>
        <div class=\"carousel-inner\" role=\"listbox\">
          {$imagens}
        </div>
        <a class=\"left carousel-control\" href=\"#myCarousel{$id_bootstrap_carousel}\" role=\"button\" data-slide=\"prev\">
          <span class=\"glyphicon glyphicon-chevron-left\" aria-hidden=\"true\"></span>
          <span class=\"sr-only\">Previous</span>
        </a>
        <a class=\"right carousel-control\" href=\"#myCarousel{$id_bootstrap_carousel}\" role=\"button\" data-slide=\"next\">
          <span class=\"glyphicon glyphicon-chevron-right\" aria-hidden=\"true\"></span>
          <span class=\"sr-only\">Next</span>
        </a>
      </div>
    </div>
   ";

    return $output;
}


get_header();
while ( have_posts() ) : the_post();

    if ( has_post_thumbnail() ) {
        $the_post_thumbnail = get_the_post_thumbnail_url();
    } else { 
        $the_post_thumbnail = "";
    }  

    setPostViews(get_the_ID());
    $Categoria = get_the_category();
    $Nome_categoria = $Categoria[0] -> cat_name;
    $Id_categoria = $Categoria[0] -> cat_ID;
    $Id_categoria1 = $Categoria[1] -> cat_ID;
    $autor   = get_the_author();
    $autor_link = get_author_posts_url(get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));
    $contador_img_galeria = 0;
    $views = getPostViews(get_the_ID());
    $img   = $the_post_thumbnail;
?>
 <main id="main" class="site-main container" role="main">
    <div id="tema2" class="col-md-12">
        <section id="post_thumbnail">
                <img src="<?php echo $img; ?>" alt="" id="post_thumbnail">
        </section>
        <header id="pagina_cabecalho">
                <?php  
                    the_title( '<h1 id="titulo_pagina">', '</h1>' );
                    echo '<h4>'.get_nskw_subtitle().'</h4>';
                    echo '
                        <div class="col-md-12 entry-meta">
                            <a href="'.$autor_link.'" class="meta-item author">
                                <img src="'.get_avatar_url(get_the_author_ID()).'" alt="">
                                <span class="vcard author">
                                    <span class="fn">
                                        Por '.$autor.'
                                    </span> 
                                </span>
                            </a href="">
                            <div class="meta-item date">
                                <span class="updated">
                                    '.data_amigavel().'
                                </span>
                            </div>
                            <div class="meta-item comments">
                                <a href="#comments">
                                    '.get_comments_number().' Comentarios
                                </a>
                            </div>
                            <div class="meta-item views">
                                '.$views.' Visualizações
                            </div>
                        </div>';
                ?>
        </header>

        <section class="conteudo_post">


            <div id="texto_post">
                <?php  the_content(); ?>
            </div>
            
            <div id='inner_post_widget'> <?php dynamic_sidebar('inner_post_widget'); ?></div>
            <?php
                // If comments are open or we have at least one comment, load up the comment template.
                // if ( comments_open() || get_comments_number() ) :
                //     comments_template();
                // endif;
            ?> 
        </section>
        <section id="comenarios">
            <div class="barra_coment"><div class="topo_coment"><i class="fa fa-comments" aria-hidden="true"></i><b>COMENTE</b></div></div>
            <div class="fb-comments" data-href="<?php echo get_permalink();?>" data-width="100%" data-numposts="15"></div>
        </section>
    </div>
</main><!-- #main -->

<?php 
endwhile;
get_footer();
?>
<?php
/**
 * @package Under
 */   


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
    $link_categoria = get_category_link($Id_categoria);
    $autor   = get_the_author();
    $autor_link = get_author_posts_url(get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ));
    $contador_img_galeria = 0;
    $id_post = get_the_ID();
    $views = getPostViews($id_post);
    $img   = $the_post_thumbnail; 
    $tipo_media = get_post_meta($id_post, "meta-box-tipo-featured_media", true);
    $url_media = get_post_meta($id_post, "meta-box-url-featured_media", true);
    
    if($url_media != NULL){
        if($tipo_media == 1){
            $featured_video = "<iframe src=\"{$url_media}\" allowfullscreen width=\"100%\" height=\"380\" frameborder=\"0\"></iframe>";
        }else if($tipo_media == 2){
            $featured_audio = "
                <audio id='media_post' controls>
                    <source src=\"{$url_media}\" type=\"audio/mpeg\">
                </audio>
            ";
        }
    }
  
?>
 <main id="main" class="site-main container default_post" role="main">
        <div class="col-md-8">
            <header id="titulo_post">
                    <?php  
                        the_title( '<h1>', '</h1>' );
                    ?>
            </header>
            <div class=''>
                <section id="post_thumbnail" class="">
                <?php 
                    if($featured_video){
                        echo $featured_video;
                        
                    }else{
                        echo "<img src=\"{$img}\" alt=\"\" id=\"post_thumbnail\">";
                    }
                ?>

                </section>
                <?php echo $featured_audio;?>
                <section class="conteudo_post">

                    <div id="texto_post">
                        <?php  the_content(); ?>
                    </div>
                    
                    <div id='inner_post_widget'> <?php dynamic_sidebar('inner_post_widget'); ?></div>
                    <?php
                         echo '
                            <div class="entry-meta">
                                <a  href="'.$autor_link.'" class="link_avatar meta-item author">
                                    <img src="'.get_avatar_url(get_the_author_ID()).'" alt="">
                                </a>
                                <div class="bloco_text_autor">
                                    <span class="vcard author">
                                        <span class="fn">
                                            Por <a  href="'.$autor_link.'" class="meta-item author">'.$autor.'</a>
                                        </span>
                                    </span>
                                    
                                    <div class="meta-item date">
                                        <span class="updated">
                                            '.get_the_time(__('j \d\e F \d\e Y, H:i', 'kubrick')) .'
                                        </span>
                                    </div>
                                </div>
                            </div>
                                ';

                                $posttags = get_the_tags();
if ($posttags && count($posttags) > 0) {
    $n_tags = count($posttags);
    $i =0;
    foreach($posttags as $tag) {
        $i++;

        if($i == $n_tags){
            $html_tags .= $tag->name.'. '; 
        }else{
             $html_tags .=  $tag->name.', '; 
        }
    }
    echo "<div class='tags'><b>Tags:</b> {$html_tags}</div>"; 
}
                    ?>
                </section>
            </div>
        </div>
        <?php get_sidebar(); ?>
</main><!-- #main -->
 <div class="col-md-12 social_footer">
    <h3>Também estamos aqui</h3>
    <p>Acompanhe nosso trabalho em outras plataformas</p>
    <div id="rodape_social_icons" class="social-links">
      <a target="_blank" href="https://www.facebook.com/designeficaz/"><img class="img-responsive" src="http://localhost/wordpress/wp-content/themes/designeficaz/imagens/espera/redes-sociais-facebook.jpg"></a>
      
      <a target="_blank" href="https://www.instagram.com/designeficaz/"><img class="img-responsive" src="http://localhost/wordpress/wp-content/themes/designeficaz/imagens/espera/redes-sociais-instagram.jpg"></a>
      
      <a target="_blank" href="https://www.behance.net/danieldesouz4"><img class="img-responsive" src="http://localhost/wordpress/wp-content/themes/designeficaz/imagens/espera/redes-sociais-behance.jpg"></a>
      <a target="_blank" href="https://www.colab55.com/@danieldesouz4"><img class="img-responsive" src="http://localhost/wordpress/wp-content/themes/designeficaz/imagens/espera/redes-sociais-colab55.jpg"></a>
      
      
    </div>
</div>

<?php
	$html = '<h2>Slide</h2>';
	//Carrega os dados do slide
	$tema_zflag_slide_principal = array();
	if(get_option('tema_zflag_slide_principal')){
		$tema_zflag_slide_principal = json_decode(get_option('tema_zflag_slide_principal'));
		$tema_zflag_slide_principal = (array) $tema_zflag_slide_principal;
	}

	//Edita os dados
	if(!empty($_POST['titulo']) && !empty($_POST['texto'])){
		if(!empty($_POST['id'])){
			$new_key = $_POST['id'];
		}else{
			$new_key = end(array_keys($tema_zflag_slide_principal));
			$new_key = $new_key == 0 || $new_key == NULL ? 1 : $new_key+1;
		}

		$tema_zflag_slide_principal[$new_key] = ['background' => $_POST['background'], 'img_align' => $_POST['img_align'], 'titulo' => $_POST['titulo'], 'link' => $_POST['link'], 'texto' => $_POST['texto'], 'imagem' => $_POST['ad_image'], 'video' => $_POST['video']];
		
		delete_option('tema_zflag_slide_principal');
		if(add_option('tema_zflag_slide_principal', json_encode($tema_zflag_slide_principal))){
			$html .= "Item Salvo";
		}
	}



	if(!empty($_GET['acao'])){
		if($_GET['acao'] == 'cadastro' || $_GET['acao'] == 'editar'){
			
			$id = NULL;
			if(!empty($_GET['id'])){
				$id = $_GET['id'];
				foreach ($tema_zflag_slide_principal as $key => $value) {
					if($key == $_GET['id']){
						$value = (array) $value;
						$titulo = $value['titulo'];
						$link = $value['link'];
						$texto = $value['texto'];
						$imagem = $value['imagem'];
						$video = $value['video'];
						$background = !empty($value['background']) ? $value['background'] : '#77D9E2';
						$img_align = $value['img_align'];
					}
				}
			}
			


			$tabela_cadastro = 
			'
				<form id="zflag_form_slide" name="salvar" method="post" enctype="multipart/form-data">
				            <input type="hidden" id="id" class="form-control"  name="id" value="'.$id.'">
						<div class="form-group">
				            <label for="titulo">Titulo</label>
				            <input type="text" id="titulo" class="form-control"  name="titulo" value="'.$titulo.'">
				        </div>
				        <div class="form-group">
				            <label for="link">Link</label>
				            <input type="text" id="link" class="form-control"  name="link" value="'.$link.'">
				        </div>
				        <div class="form-group">
				            <label for="video">Video</label>
				            <input type="text" id="video" class="form-control"  name="video" value="'.$video.'">
				        </div> 

				        <div class="form-group">
				            <label for="background">Cor do fundo do slide em exadecimal</label>
				            <input type="text" placeholder="#77D9E2" id="background" class="form-control"  name="background" value="'.$background.'">
				        </div>
				        <div class="form-group">
				            <label for="img_align">Alinhar imagem</label>
				            <select name="img_align" id="img_align" class="postform">
				                <option '.($img_align == 'Direita' || $img_align == NULL ? 'selected="selected"' : '').' class="level-0" value="Direita">Direita</option>
				                <option '.($img_align == 'Esquerda' ? 'selected="selected"' : '').' class="level-0" value="Esquerda">Esquerda</option>
				              </select>

				        </div>
				        <div class="form-group">
				            <label class="texto">Texto</label>
				            <textarea id="texto" class="form-control" rows="2" name="texto">'.stripslashes($texto).'</textarea>
				        </div>
				        <div for="form-group">
				        	<label for="upload_image">Imagem</label>
						    <input style="width: 70%;" id="upload_image" type="text" size="36" name="ad_image" value="'.$imagem.'" /> 
						    <input style="width: 30%;" id="upload_image_button" class="button" type="button" value="Upload Image" />
						</div>
				        <div class="form-group">
				            <button name="salvar" class="salva btn btn-primary" />
				                Salvar
				            </button>
				        </div>
					</form>
			';

			$html .= $tabela_cadastro;
		}else if($_GET['acao'] == 'listar'){

			//Lista os sliders
			$li = '';
			if(is_array($tema_zflag_slide_principal)){
				$tema_zflag_slide_principal = (array) $tema_zflag_slide_principal;
				$i = 0;
				foreach ($tema_zflag_slide_principal  as $key => $value) {
					$value = (array) $value;

						$li .= '
							<tr role="row" class="'.(($i%2 == 0) ? 'odd' : 'even').'">
								<td>
									<strong>
										<a class="row-title" href="?page=zflag_theme_admin_geral&id='.$key.'&subpage=slide&acao=editar" aria-label="“'.$value['titulo'].'” (Editar)">'.$key.'</a>
									</strong>
								</td>
								<td>
									<strong>
										<a class="row-title" href="?page=zflag_theme_admin_geral&id='.$key.'&subpage=slide&acao=editar" aria-label="“'.$value['titulo'].'” (Editar)">'.$value['titulo'].'</a>
									</strong>
								</td>
								<td>
									<strong>
										<a class="row-title delete_row" href="?page=zflag_theme_admin_geral&id='.$key.'&subpage=slide&acao=excluir" aria-label="“'.$value['titulo'].'”"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
									</strong>
								</td>
							</tr>
						';
					
					$i++;

				}

				$html .= '
				<table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
					<thead>
						<tr role="row">
							<th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 244px;">ID</th>
							<th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 244px;">Titulo</th>
						</tr>
					</thead>
					<tbody>
						'.$li.'
				 	</tbody>
		        </table>';
			}
		}else if($_GET['acao'] == 'excluir'){
			if(!empty($_GET['id'])){
				if(get_option('tema_zflag_slide_principal')){
					$tema_zflag_slide_principal = json_decode(get_option('tema_zflag_slide_principal'));
					$tema_zflag_slide_principal = (array) $tema_zflag_slide_principal;
				}
				
				$new_tema_zflag_slide_principal = array();
				foreach ($tema_zflag_slide_principal as $key => $value) {

					if($key != $_GET['id']){
						$value = (array) $value;
						$titulo = $value['titulo'];
						$texto = $value['texto'];
						$imagem = $value['imagem'];
						$video = $value['video'];
						$img_align = $value['img_align'];
						$background = $value['background'];
						$link = $value['link'];

						$new_tema_zflag_slide_principal[$key] = ['background' => $background, 'img_align' => $img_align, 'titulo' => $titulo,'link' => $link, 'texto' => $texto, 'imagem' => $imagem];
					}
				}

				delete_option('tema_zflag_slide_principal');
				if(add_option('tema_zflag_slide_principal', json_encode($new_tema_zflag_slide_principal))){
					$html .= "Item Excluido";
				}
				
			}
		}

	}

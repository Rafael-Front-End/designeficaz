<?php
	$html = '<h2>Galeria Home</h2>';
	$html_img = '';
	//Carrega os dados do galeria_home
	$tema_zflag_galeria_home = array();
	if(get_option('tema_zflag_galeria_home')){
		$tema_zflag_galeria_home = json_decode(get_option('tema_zflag_galeria_home'));
		$tema_zflag_galeria_home = (array) $tema_zflag_galeria_home;
	}

	//Edita os dados
	if(!empty($_POST['titulo'])){
		if(!empty($_POST['id'])){
			$new_key = $_POST['id'];
		}else{
			$new_key = end(array_keys($tema_zflag_galeria_home));
			$new_key = $new_key == 0 || $new_key == NULL ? 1 : $new_key+1;
		}

		$tema_zflag_galeria_home[$new_key] = ['titulo' => $_POST['titulo'], 'imagem' => $_POST['ad_image']];
		
		delete_option('tema_zflag_galeria_home');
		if(add_option('tema_zflag_galeria_home', json_encode($tema_zflag_galeria_home))){
			$html .= "<div class=\"alert alert-success\" role=\"alert\">
					  <strong>Item Salvo!</strong> 
					</div>";
		}
	}



	if(!empty($_GET['acao'])){
		if($_GET['acao'] == 'cadastro' || $_GET['acao'] == 'editar'){
			
			$id = NULL;
			if(!empty($_GET['id'])){
				$id = $_GET['id'];
				foreach ($tema_zflag_galeria_home as $key => $value) {
					if($key == $_GET['id']){
						$value = (array) $value;
						$titulo = $value['titulo'];
						$imagem = $value['imagem'];

						if($imagem != NULL){
							$vetor_img = explode(', ', $imagem);
							
							foreach ($vetor_img as $key => $value) {
								$thumbnail   =   wp_get_attachment_image_src(intval($value));

								$html_img .= "<img width='150' height='150' src='".$thumbnail[0]."'>";
							}
						}
					}
				}
			}
			


			$tabela_cadastro = 
			'
				<form id="zflag_form_galeria" name="salvar" method="post" enctype="multipart/form-data">
				            <input type="hidden" id="id" class="form-control"  name="id" value="'.$id.'">
						<div class="form-group">
				            <label for="titulo">Titulo</label>
				            <input type="text" id="titulo" class="form-control"  name="titulo" value="'.$titulo.'">
				        </div>
				        <div for="form-group">
				        	<label for="upload_image">Imagem</label>
						    <input style="width: 70%;" id="upload_image" type="hidden" size="36" name="ad_image" value="'.$imagem.'" /> 
						    <div id="zflag_bloco_galeria_imagens">'.$html_img.'</div>
						    <input style="width: 100%;" id="upload_image_button" class="button" type="button" value="Upload Image" />
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

			//Lista a galeria_home
			$li = '';
			if(is_array($tema_zflag_galeria_home)){
				$tema_zflag_galeria_home = (array) $tema_zflag_galeria_home;
				$i = 0;
				foreach ($tema_zflag_galeria_home  as $key => $value) {
					$value = (array) $value;

						$li .= '
							<tr role="row" class="'.(($i%2 == 0) ? 'odd' : 'even').'">
								<td>
									<strong>
										<a class="row-title" href="?page=zflag_theme_admin_geral&id='.$key.'&subpage=galeria_home&acao=editar" aria-label="“'.$value['titulo'].'” (Editar)">'.$key.'</a>
									</strong>
								</td>
								<td>
									<strong>
										<a class="row-title" href="?page=zflag_theme_admin_geral&id='.$key.'&subpage=galeria_home&acao=editar" aria-label="“'.$value['titulo'].'” (Editar)">'.$value['titulo'].'</a>
									</strong>
								</td>
								<td>
									<strong>
										<a class="row-title delete_row" href="?page=zflag_theme_admin_geral&id='.$key.'&subpage=galeria_home&acao=excluir" aria-label="“'.$value['titulo'].'”"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
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
				if(get_option('tema_zflag_galeria_home')){
					$tema_zflag_galeria_home = json_decode(get_option('tema_zflag_galeria_home'));
					$tema_zflag_galeria_home = (array) $tema_zflag_galeria_home;
				}
				
				$new_tema_zflag_galeria_home = array();
				foreach ($tema_zflag_galeria_home as $key => $value) {

					if($key != $_GET['id']){
						$value = (array) $value;
						$titulo = $value['titulo'];
						$imagem = $value['imagem'];

						$new_tema_zflag_galeria_home[$key] = ['titulo' => $titulo, 'imagem' => $imagem];
					}
				}

				delete_option('tema_zflag_galeria_home');
				if(add_option('tema_zflag_galeria_home', json_encode($new_tema_zflag_galeria_home))){
					$html .= "
					<div class=\"alert alert-success\" role=\"alert\">
					  <strong>Item Excluido!</strong>
					</div>";
				}
				
			}
		}

	}

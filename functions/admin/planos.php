<?php
	$html = '<h2>Pacotes/Planos</h2>';
	//Carrega os dados do planos
	$tema_zflag_planos = array();
	if(get_option('tema_zflag_planos')){
		$tema_zflag_planos = json_decode(get_option('tema_zflag_planos'));
		$tema_zflag_planos = (array) $tema_zflag_planos;
	}

	//Edita os dados
	if(!empty($_POST['titulo']) && !empty($_POST['texto'])){
		if(!empty($_POST['id'])){
			$new_key = $_POST['id'];
		}else{
			$new_key = end(array_keys($tema_zflag_planos));
			$new_key = $new_key == 0 || $new_key == NULL ? 1 : $new_key+1;
		}

		$tema_zflag_planos[$new_key] = ['titulo' => $_POST['titulo'], 'link' => $_POST['link'], 'texto' => $_POST['texto']];

		delete_option('tema_zflag_planos');
		if(add_option('tema_zflag_planos', json_encode($tema_zflag_planos))){
			$html .= "Item Salvo";
		}
	}



	if(!empty($_GET['acao'])){
		if($_GET['acao'] == 'cadastro' || $_GET['acao'] == 'editar'){
			
			$id = NULL;
			if(!empty($_GET['id'])){
				$id = $_GET['id'];
				foreach ($tema_zflag_planos as $key => $value) {
					if($key == $_GET['id']){
						$value = (array) $value;
						$titulo = $value['titulo'];
						$link = $value['link'];
						$texto = $value['texto'];
					}
				}
			}
			


			$tabela_cadastro = 
			'
				<form id="salva_slide_thema_zflag" name="salvar" method="post" enctype="multipart/form-data">
				            <input type="hidden" id="id" class="form-control" required name="id" value="'.$id.'">
						<div class="form-group">
				            <label for="titulo">Titulo</label>
				            <input type="text" id="titulo" class="form-control"  name="titulo" value="'.$titulo.'">
				        </div>						
				        <div class="form-group">
				        	<label for="link">Link</label>
				        	<p>Caso não tenha link deixe em branco.</p>
				            	<input type="text" id="link" class="form-control" name="link" value="'.$link.'">
				        </div>
				        <div class="form-group">
				            <label class="texto">Texto</label>
				            <textarea id="texto" class="form-control" rows="2" name="texto">'.stripslashes($texto).'</textarea>
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
			if(is_array($tema_zflag_planos)){
				$tema_zflag_planos = (array) $tema_zflag_planos;
				$i = 0;
				foreach ($tema_zflag_planos  as $key => $value) {
					$value = (array) $value;

						$li .= '
							<tr role="row" class="'.(($i%2 == 0) ? 'odd' : 'even').'">
								<td>
									<strong>
										<a class="row-title" href="?page=zflag_theme_admin_geral&id='.$key.'&subpage=planos&acao=editar" aria-label="“'.$value['titulo'].'” (Editar)">'.$key.'</a>
									</strong>
								</td>
								<td>
									<strong>
										<a class="row-title" href="?page=zflag_theme_admin_geral&id='.$key.'&subpage=planos&acao=editar" aria-label="“'.$value['titulo'].'” (Editar)">'.$value['titulo'].'</a>
									</strong>
								</td>
								<td>
									<strong>
										<a class="row-title delete_row" href="?page=zflag_theme_admin_geral&id='.$key.'&subpage=planos&acao=excluir" aria-label="“'.$value['titulo'].'”"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
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
				if(get_option('tema_zflag_planos')){
					$tema_zflag_planos = json_decode(get_option('tema_zflag_planos'));
					$tema_zflag_planos = (array) $tema_zflag_planos;
				}
				
				$new_tema_zflag_planos = array();
				foreach ($tema_zflag_planos as $key => $value) {

					if($key != $_GET['id']){
						$value = (array) $value;
						$titulo = $value['titulo'];
						$link = $value['link'];
						$texto = $value['texto'];
						$icone = $value['icone'];

						$new_tema_zflag_planos[$key] = ['titulo' => $titulo, 'link' => $link, 'texto' => $texto, 'icone' => $icone];
					}
				}

				delete_option('tema_zflag_planos');
				if(add_option('tema_zflag_planos', json_encode($new_tema_zflag_planos))){
					$html .= "Item Excluido";
				}
				
			}
		}

	}

<?php
	
	if(!empty($_GET['subpage'])){
		if($_GET['subpage'] == 'slide'){
			require('slide.php');
		}
	}else{
		echo '<h2 style="text-align:center;">Nada aqui</h2>';
	}
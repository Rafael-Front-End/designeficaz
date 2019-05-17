<?php
/**
Template Name: Search Form
**/
?>

<form accept-charset="utf-8" role="search" class="form-100 col-md-12 col-lx-12 col-xs-12 col-sm-12 pull-right" method="GET" id="pesquisa_topo" name="form_search" role="form" action="<?php echo get_site_url();?>">
	<input class="" type="text" value="<?php the_search_query(); ?>" autocomplete="on" id="" name="s" placeholder="Pesquisar neste site">
	<button class="button-blue" id="" type="submit" value="submit">Buscar</button>
</form>
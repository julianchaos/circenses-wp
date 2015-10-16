<?php
/**
 * Deli engine room
 *
 * @package deli
 */

/**
 * Initialize all the things.
 */
require get_stylesheet_directory() . '/inc/init.php';

// crie a taxonomia cidade na functions do tema
add_action('init', 'register_locations');
function register_locations() {
	register_taxonomy( 'cidade',array (
	  0 => 'product',
	),
	array( 'hierarchical' => true,
		'label' => 'Cidades',
		'show_ui' => true,
		'show_in_menu' => false,
		'query_var' => true,
		'show_admin_column' => true,
		'labels' => array (
			'search_items' => 'Cidade',
			'popular_items' => 'Cidades populares',
			'all_items' => 'Todos as cidades',
			'edit_item' => 'Editar item',
			'update_item' => 'Atualizar cidade',
			'add_new_item' => 'Adicionar cidade'
			)
		) 
	); 
}


// coloque essa função na functions do seu tema, coloque a chamada em alguma página e acesse pelo browser uma única vez
function create_location_terms() {
	$feed = json_decode(file_get_contents('/var/www/ndrade/circenses-wp/wp-content/themes/circenses/brazil-cities-states.json')); //este arquivo você pode pegar aqui: https://gist.github.com/brunomarks/8851491
	foreach ($feed->estados as $key => $estado) {
		$sigla = $estado->sigla;
		$estado_term = wp_insert_term($estado->sigla, 'cidade');
		$current_term_id = $estado_term['term_id'];
		foreach ($estado->cidades as $key => $cidade) {
			wp_insert_term( $cidade, 'cidade', array( 'parent'=> $current_term_id ) );
		}
	}
}
// Verifique a taxonomia, deverá conter todas as cidades dentro dos respectivos estados

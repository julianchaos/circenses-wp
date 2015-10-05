<?php
/**
 * storefront engine room
 *
 * @package storefront
 */

/**
 * Initialize all the things.
 */
require get_template_directory() . '/inc/init.php';

/**
 * Note: Do not add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * http://codex.wordpress.org/Child_Themes
 */

// crie a taxonomia cidade na functions do tema
add_action('init', 'register_locations');
function register_locations() {
	register_taxonomy( 'cidade',array (
	  0 => 'product',
	),
	array( 'hierarchical' => true,
		'label' => 'Cidades',
		'show_ui' => true,
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
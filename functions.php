<?php

 ///// Retirer les éléments inutiles de wp /////


 function sgdelicio_remove_menu_pages() {
	//remove_menu_page( 'tools.php' );
    remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'sgdelicio_remove_menu_pages' );

//création d'1 constante pour la version. dans la fonction il ne faut pas //mettre les '' car c'est 1 constante !
define('sgdelicio_version', '2.3');
//chargement de scripts - dar 1 n. de fonction propre
//chargement dans le front-end
function sgdelicio_scripts()
{
//==========================================
	//======= chargement des styles =========
//==========================================

	//lien bootstrap qui se charge en 1er et ensuite le mien
	wp_enqueue_style(
		'sgdelicio_bootstrap-style',
		get_template_directory_uri() . '/css/bootstrap.min.css',
		array(), sgdelicio_version, 'all');
	//lien avec style
// 	add_action('init', 'sgtheme_custom');
// 	function sgtheme_custom () {
// 		wp_register_style('sgtheme_custom', get_stylesheet_directory_uri() . '/style.css', array(), sgdelicio_version, 'all');
// 		global $wp_styles; 
//     $wp_styles->add_data( 'my_theme_style', 'conditional', 'lte IE 7' );
// }
	 wp_enqueue_style(
		'parent_style',
		get_template_directory_uri() . './style.css',
		array('sgdelicio_bootstrap-style'), sgdelicio_version, 'all');
	// //lien avec js true pour qu'il aille dans le footer
	//là où doit se situer le js
	// chargement des scripts
	// pour que le menu hamburger fonctionne il faut télécharger la library js de bootstrap et donner son chemin
	wp_enqueue_script('popper-js', get_template_directory_uri() . '/js/popper.min.js', array('jquery'), sgdelicio_version, true);
	
	wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery', 'popper-js'), sgdelicio_version, true);
	//montheme.js est 1 fichier que g créé pour mettre des fonctions .js
	wp_enqueue_script('sgdelicio_script', get_template_directory_uri() . '/js/deliciozo.js', array('jquery', 'bootstrap-js'), sgdelicio_version, true);
}

add_action('wp_enqueue_scripts', 'sgdelicio_scripts');

// Ajouter la prise en charge des images mises en avant
add_theme_support('post-thumbnails');

// chargement dans l'admin. de wp
function sgdelicio_admin_scripts()
{

	// chargement des styles dans l'admin (can serve pr les créations de plugin)
	wp_enqueue_style('sgdelicio_bootstrap-style', get_template_directory_uri() . '/css/bootstrap.min.css', array(), sgdelicio_version);
}
add_action('admin_init', 'sgdelicio_admin_scripts');

//////////////////////////////// UTILITAIRES

function sgdelicio_setup()
{
	// support vignettes= images à la une
	add_theme_support('post-thumbnails');

	// taille image card smartphone
	add_image_size('smartph', 358, 200, true);
	add_image_size('slider', 1030, 650, true );
	add_image_size( 'fiche_y', 208, 208, true );

	// retirer la version de wp pour + de sécurité
	remove_action('wp_head', 'wp_generator');
	// enlève les guillemets à la française
	//remove_filter ('the_content', 'wptexturize');

	// support du titre - réduit les conflits avec les logiciels seo- ajouter auto le titre du site ds l'entête de celui-ci
	add_theme_support('title-tag');


// Register Custom Navigation Walker
	require_once('includes/bootstrap_5_wordpress-navbar_walker_main.php');
}
	//activer dans la dashboard de wp l'onglet 'menu' pour leur gestion. on y met principal ou en-tête, menu footer...
	register_nav_menu('main-menu', 'Main menu');


add_action('after_setup_theme', 'sgdelicio_setup');


/////////////////////////Affichage date + Catégories utiles pour les articles

//ce modèle d'affichage 29 novembre 2016 

// function sgdelicio_give_me_meta_01($date1, $date2, $cat, $tags)
// {
// 	$chaine = 'publié le <time class="entry-date" datetime="';
// 	$chaine .= $date1;
// 	$chaine .= '">';
// 	$chaine .= $date2;
// 	$chaine .= '</time> dans la catégorie ';
// 	$chaine .= $cat;
// 	$chaine .= ' avec les étiquettes: ' . $tags;

// 	return $chaine;
// }

////////////////// modifie le texte d'excerpt dans 1 article tronqué

// function sgdelicio_excerpt_more($more)
// {
// 	return ' <a class="more-link" href=" ' . get_permalink() . '">' . '[lire la suite]' . '</a>';
// }
// add_filter('excerpt_more', 'sgdelicio_excerpt_more');

//// faire apparaître les widgets et sidebares ds le dasboard

// function sgdelicio_widgets_init(){
// 	register_sidebar(array(
// 		'name' => 				'Footer Widget Zone',
// 		'description' => 		'Widget affichés dans le footer : 4 au max',
// 		'id' => 					'Widgetizd-footer',
// 		'before_widget' => 	'<div id="%1$s" class="col-xs-12 col-sm-6 col-md-3 %2$s"><div class="inside-widget">',//on rend responsive
// 		'after_widget' => 	'</div></div>',
// 		'before_title' => 	'<h2 class="h3 text-center">',
// 		'after_title' => 		'</h2>',
// 	));
// }
// add_action('widgets_init', 'sgdelicio_widgets_init');


function my_single_template($single) {
	// Récupère la variable globale $post qui contient les informations de l'article demandé
	global $post;

	// Récupère le chemin vers les fichiers de style du thème, ce qui nous donne le chemin exact du dossier du thème enfant
	// auquel nous ajoutons le dossier "/single" dans lequel se trouveront nos modèles spécifiques à chaque catégorie
	$single_path = get_stylesheet_directory() . '/single';
 
	// Cette boucle traverse toutes les catégories de l'article actuel
	foreach((array)get_the_category() as $cat) :
				
			  // Pour chaque catégorie le système va voir si un fichier existe pour cette catégorie
			  // Par exemple si cet article appartient à la catégorie "SEO" dont le slug est "seo"
			  // cette fonction regardera si le fichier "/single/single-seo.php" existe.
			  // Si ce fichier existe c'est cette valeur qui est retournée et WordPress utilisera ce modèle
			  if(file_exists($single_path . '/single-' . $cat->slug . '.php'))
			  return $single_path . '/single-' . $cat->slug . '.php';
	  
	endforeach;
}

// Enregistrement du filtre
add_filter('single_template', 'my_single_template');

// // Déclarer un bloc Gutenberg avec ACF
// function capitaine_register_acf_block_types() {

// 	capitaine_register_acf_block_types( array(
// 		 'name'              => 'plugin',
// 		 'title'             => 'Extension',
// 		 'description'       => "Présentation d'une extension WordPress",
// 		 'render_template'   => 'blocks/plugin.php',
// 		 'category'          => 'formatting', 
// 		 'icon'              => 'admin-plugins', 
// 		 'keywords'          => array( 'plugin', 'extension', 'add-on' ),
// 		 'enqueue_assets'    => function() {
// 			 wp_enqueue_style( 'capitaine-blocks', get_template_directory_uri() . '/css/blocks.css' );
// 		 }
// 	) );
// }

// add_action( 'acf/init', 'capitaine_register_acf_block_types' );

//include 1 fichier de fonctions mis à coté pr alléger le fichier functions principal.
// include('includes/build-options-page.php'); //contient la fonction 

// ///////Custom Post Type slider ds galerie photos ////////

function sgdelicio_slider_init () {
	$labels = array(
		'name' => 'Carousel',
		'singular_name' => 'Image',
		'add_new' => 'Ajoutez 1 image',
		'edit_item' => 'Modifiez',
		'new_item' => 'Nouveau',
		'all_items' => 'Voir liste',
		'view_item' => 'Voir l\' élément',
		'search_item' => 'Cherchez 1 image',
		'not_found' => 'Aucun élément trouvé',
		'not_found_in_trash' => 'Aucun élément dans la corbeille',
		'menu_name' => 'Slider'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'rewite' => true,
		'capability_type' => 'post',
		'has_archive' => false,
		'hierachical' => false,
		'menu_position' => 20,
		'menu_icon' => get_stylesheet_directory_uri(  ) . '/assets/picture-icon1.png',
		'publicly_queryable' => false,
		'show_in_nav_menus' => true,
		'exlude_from_search' => true,
		'supports' => array ('title', 'page-attributes', 'thumbnail') //editor fait 1 champs trop large provoquant le possible risque de mettre 3 tonnes de text pour 1 caption
	);
register_post_type('sgdelicio_slider', $args);
} //end function sgdelcio_slider_init

add_action('init', 'sgdelicio_slider_init');

/////////////////////////////////////////////////////////////////
/////////////AJOUT IMAGE ET RANG D'APPARITION DS LE CPT SLIDER///
////////////////////////////////////////////////////////////////
add_filter('manage_edit-sgdelicio_slider_columns', 'sgdelicio_col_change'); // cela ajoute des champs de noms de colonnes qui apparaitront ds le CPT. filter modifie la présentation ds le dashboard
function sgdelicio_col_change($columns) {
	$columns['sgdelicio_slider_image_order'] = "ordre";
	$columns['sgdelicio_slider_image'] = "image affichée";

	return $columns;
}
	add_action('manage_sgdelicio_slider_posts_custom_column', 'sgdelicio_content_show', 10,2); //affiche le contenu
function sgdelicio_content_show ($column, $post_id) {
		global $post;
		if($column == 'sgdelicio_slider_image') {
			echo the_post_thumbnail(array(100,100));// taille d'image 100/100
			}
		if($column == 'sgdelicio_slider_image_order') {
			echo $post->menu_order;
		}
}

/////////////////////////////////////////////////////////////////
/////////////tri auto sur l'ordre ds la colonne admin pr le CPT SLIDER///
////////////////////////////////////////////////////////////////
function sgdelicio_change_slides_order($query) {
	global $post_type, $pagenow;

	if($pagenow == 'edit.php' && $post_type == 'sgdelicio_slider') {
		$query-> query_vars['orderby'] = 'menu_order';
		$query-> query_vars['order'] = 'asc';
	}
}
add_action('pre_get_posts', 'sgdelicio_change_slides_order');
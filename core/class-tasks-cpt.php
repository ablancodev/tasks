<?php
class Tasks_CPT {

	public static function init() {
		self::register_cpts();
		self::register_taxes();
	}

	public static function register_cpts() {
	    $labels = array(
	        'name'                  => _x( 'Tasks', 'Post Type General Name', TASKS_PLUGIN_DOMAIN ),
	        'singular_name'         => _x( 'Task', 'Post Type Singular Name', TASKS_PLUGIN_DOMAIN ),
	        'menu_name'             => __( 'Tasks', TASKS_PLUGIN_DOMAIN ),
	        'name_admin_bar'        => __( 'Tasks', TASKS_PLUGIN_DOMAIN ),
	        'archives'              => __( 'Listado tasks', TASKS_PLUGIN_DOMAIN ),
	        'attributes'            => __( 'Atributos', TASKS_PLUGIN_DOMAIN ),
	        'parent_item_colon'     => __( 'Task padre:', TASKS_PLUGIN_DOMAIN ),
	        'all_items'             => __( 'Todos los tasks', TASKS_PLUGIN_DOMAIN ),
	        'add_new_item'          => __( 'Añadir nuevo task', TASKS_PLUGIN_DOMAIN ),
	        'add_new'               => __( 'Añadir nuevo', TASKS_PLUGIN_DOMAIN ),
	        'new_item'              => __( 'Nuevo task', TASKS_PLUGIN_DOMAIN ),
	        'edit_item'             => __( 'Editar task', TASKS_PLUGIN_DOMAIN ),
	        'update_item'           => __( 'Actualizar task', TASKS_PLUGIN_DOMAIN ),
	        'view_item'             => __( 'Ver task', TASKS_PLUGIN_DOMAIN ),
	        'view_items'            => __( 'Ver tasks', TASKS_PLUGIN_DOMAIN ),
	        'search_items'          => __( 'Buscar task', TASKS_PLUGIN_DOMAIN ),
	        'not_found'             => __( 'No encontrado', TASKS_PLUGIN_DOMAIN ),
	        'not_found_in_trash'    => __( 'No encontrado en la papelera', TASKS_PLUGIN_DOMAIN ),
	        'featured_image'        => __( 'Imagen destacada', TASKS_PLUGIN_DOMAIN ),
	        'set_featured_image'    => __( 'Establecer imagen destacada', TASKS_PLUGIN_DOMAIN ),
	        'remove_featured_image' => __( 'Borrar imagen destacada', TASKS_PLUGIN_DOMAIN ),
	        'use_featured_image'    => __( 'Usar como imagen destacada', TASKS_PLUGIN_DOMAIN ),
	        'insert_into_item'      => __( 'Insertar en tasks', TASKS_PLUGIN_DOMAIN ),
	        'uploaded_to_this_item' => __( 'Subir a tasks', TASKS_PLUGIN_DOMAIN ),
	        'items_list'            => __( 'Listado tasks', TASKS_PLUGIN_DOMAIN ),
	        'items_list_navigation' => __( 'Listado tasks', TASKS_PLUGIN_DOMAIN ),
	        'filter_items_list'     => __( 'Filtrado tasks', TASKS_PLUGIN_DOMAIN ),
	    );
	    
	    $rewrite = array(
	        'slug'                  => 'task',
	        'with_front'            => true,
	        'pages'                 => true,
	        'feeds'                 => true,
	    );
	    
	    $args = array(
	        'label'                 => __( 'Task', TASKS_PLUGIN_DOMAIN ),
	        'description'           => __( 'Task', TASKS_PLUGIN_DOMAIN ),
	        'labels'                => $labels,
	        'supports'              => array( 'title', 'editor', 'thumbnail' ),
	        'taxonomies'            => array(),
	        'hierarchical'          => false,
	        'public'                => true,
	        'show_ui'               => true,
	        'show_in_menu'          => true,
	        'menu_position'         => 5,
	        'menu_icon'             => 'dashicons-archive',
	        'show_in_admin_bar'     => true,
	        'show_in_nav_menus'     => true,
	        'can_export'            => true,
	        'has_archive'           => true,
	        'exclude_from_search'   => false,
	        'publicly_queryable'    => true,
	        'rewrite'               => $rewrite,
	        'capability_type'       => 'page',
	        'show_in_rest'          => true,
	    );

	    register_post_type( 'task', $args );

	}

	public static function register_taxes() {
	    
	    // Projects
	    $labels = array(
	        'name' => _x( 'Projects', 'taxonomy general name' ),
	        'singular_name' => _x( 'Project', 'taxonomy singular name' ),
	        'search_items' =>  __( 'Search Projects' ),
	        'popular_items' => __( 'Popular Projects' ),
	        'all_items' => __( 'All Projects' ),
	        'parent_item' => null,
	        'parent_item_colon' => null,
	        'edit_item' => __( 'Edit Project' ),
	        'update_item' => __( 'Update Project' ),
	        'add_new_item' => __( 'Add New Project' ),
	        'new_item_name' => __( 'New Project Name' ),
	        'separate_items_with_commas' => __( 'Separate projects with commas' ),
	        'add_or_remove_items' => __( 'Add or remove projects' ),
	        'choose_from_most_used' => __( 'Choose from the most used projects' ),
	        'menu_name' => __( 'Projects' ),
	    );
	    register_taxonomy( 'projects', 'task', array(
	        'hierarchical' => false,
	        'labels' => $labels,
	        'show_ui' => true,
	        'show_admin_column' => true,
	        'update_count_callback' => '_update_post_term_count',
	        'query_var' => true,
	        'show_in_rest' => true,
	        'rewrite' => array( 'slug' => 'project' ),
	    ));

	    // States
	    $labels = array(
	        'name' => _x( 'States', 'taxonomy general name' ),
	        'singular_name' => _x( 'State', 'taxonomy singular name' ),
	        'search_items' =>  __( 'Search States' ),
	        'popular_items' => __( 'Popular States' ),
	        'all_items' => __( 'All States' ),
	        'parent_item' => null,
	        'parent_item_colon' => null,
	        'edit_item' => __( 'Edit State' ),
	        'update_item' => __( 'Update State' ),
	        'add_new_item' => __( 'Add New State' ),
	        'new_item_name' => __( 'New State Name' ),
	        'separate_items_with_commas' => __( 'Separate States with commas' ),
	        'add_or_remove_items' => __( 'Add or remove States' ),
	        'choose_from_most_used' => __( 'Choose from the most used States' ),
	        'menu_name' => __( 'States' ),
	    );
	    register_taxonomy( 'state', 'task', array(
	        'hierarchical' => false,
	        'labels' => $labels,
	        'show_ui' => true,
	        'show_admin_column' => true,
	        'query_var' => true,
	        'show_in_rest' => true,
	        'rewrite' => array( 'slug' => 'state' ),
	    ));
	    
	
	}
}
Tasks_CPT::init();

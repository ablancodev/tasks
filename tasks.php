<?php
/**
 * tasks.php
 *
 * Copyright (c) 2011,2017 Antonio Blanco http://www.ablancodev.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author Antonio Blanco
 * @package tasks
 * @since tasks 1.0.0
 *
 * Plugin Name: Tasks
 * Plugin URI: http://www.eggemplo.com
 * Description: Simple catalog plugin
 * Version: 1.0.0
 * Author: eggemplo
 * Author URI: http://www.ablancodev.com
 * Text Domain: tasks
 * Domain Path: /languages
 * License: GPLv3
 */
if (! defined ( 'TASKS_CORE_DIR' )) {
	define ( 'TASKS_CORE_DIR', WP_PLUGIN_DIR . '/tasks' );
}
define ( 'TASKS_FILE', __FILE__ );

define ( 'TASKS_PLUGIN_URL', plugin_dir_url ( TASKS_FILE ) );

define ( 'TASKS_PLUGIN_DOMAIN', 'tasks' );

class Tasks_Plugin {

	public static $notices = array ();


	public static function init() {
		add_action ( 'init', array (
				__CLASS__,
				'wp_init' 
		) );
		add_action ( 'admin_notices', array (
				__CLASS__,
				'admin_notices' 
		) );

		add_action('admin_init', array ( __CLASS__, 'admin_init' ) );

		register_activation_hook( TASKS_FILE, array( __CLASS__, 'activate' ) );

	}
	public static function wp_init() {
		load_plugin_textdomain ( 'tasks', null, 'tasks/languages' );

		add_action ( 'admin_menu', array (
				__CLASS__,
				'admin_menu' 
		), 40 );

		require_once 'core/class-tasks-shortcode.php';
		require_once 'core/class-tasks-cpt.php';
		require_once 'core/class-tasks-metabox.php';

		// styles & javascript
		add_action ( 'wp_enqueue_scripts', array (
				__CLASS__,
				'wp_enqueue_scripts' 
		) );
	}

	public static function admin_init() {

	}


	public static function wp_enqueue_scripts($page) {
	    // js
	    // Our javascript
	    wp_register_script ( 'task-scripts', TASKS_PLUGIN_URL . '/js/tasks.js', array ( 'jquery' ), microtime(true), true );
	    wp_enqueue_script ( 'task-scripts' );
	    
	    // css
	    wp_register_style ( 'tasks-style', TASKS_PLUGIN_URL . '/css/tasks-style.css', array (), '1.0.0' );
	    wp_enqueue_style ( 'tasks-style' );
	    

	}

	public static function admin_notices() {
		if (! empty ( self::$notices )) {
			foreach ( self::$notices as $notice ) {
				echo $notice;
			}
		}
	}

	/**
	 * Adds the admin section.
	 */
	public static function admin_menu() {
		$admin_page = add_menu_page (
				__ ( 'Catáºlogo', 'tasks' ),
				__ ( 'Catálogo', 'tasks' ),
				'manage_options', 'tasks',
				array (
					__CLASS__,
					'tasks_menu_settings' 
				),
				TASKS_PLUGIN_URL . '/images/settings.png' );
	}

	public static function tasks_menu_settings() {
		// if submit
		if ( isset( $_POST ["tasks_settings"] ) && wp_verify_nonce ( $_POST ["tasks_settings"], "tasks_settings" ) ) {
			// name
			update_option ( "tasks_settings_name", sanitize_text_field ( $_POST ["tasks_settings_name"] ) );
		}
		?>
		<h2><?php echo __( 'Tasks', 'tasks' ); ?></h2>

		<form method="post" action="" enctype="multipart/form-data" >
			<div class="">
				<p>
					<label><?php echo __( "Name", 'tasks' );?></label> <input
						type="text" name="tasks_settings_name"
						value="<?php echo get_option( "tasks_settings_name" ); ?>" />
				</p>
				<p>
				<input type="text" value="" data-default-color="#444" class="color-field"></input>
				</p>
				<?php
				wp_nonce_field ( 'tasks_settings', 'tasks_settings' )?>
					<input type="submit"
					value="<?php echo __( "Save", 'tasks' );?>"
					class="button button-primary button-large" />
			</div>
		</form>
		<?php 
	}

	/**
	 * Plugin activation work.
	 *
	 */
	public static function activate() {
	}
}
Tasks_Plugin::init();

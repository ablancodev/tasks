<?php
class Tasks_Metabox {
    
    /**
     * Constructor.
     */
    public static function init() {
        add_action( 'add_meta_boxes', array( __CLASS__, 'add_metabox'  )        );
        add_action( 'save_post',      array( __CLASS__, 'save_metabox' ), 10, 2 );
        
        // Tax
        add_action( 'state_add_form_fields', array( __CLASS__, 'state_add_form_fields' ), 10, 2 );
        add_action( 'state_edit_form_fields', array( __CLASS__, 'state_edit_form_fields' ), 10, 2 );
        add_action( 'edited_state', array( __CLASS__, 'save_state' ), 10, 2 );
        add_action( 'create_state', array( __CLASS__, 'save_state' ), 10, 2 );
    }
    
    public static function save_state( $term_id ) {
        if ( isset( $_POST['term_meta'] ) ) {
            
            $t_id = $term_id;
            $term_meta = get_option( "taxonomy_$t_id" );
            $cat_keys = array_keys( $_POST['term_meta'] );
            foreach ( $cat_keys as $key ) {
                if ( isset ( $_POST['term_meta'][$key] ) ) {
                    $term_meta[$key] = $_POST['term_meta'][$key];
                }
            }
            // Save the option array.
            update_option( "taxonomy_$t_id", $term_meta );
        }
        
    } 
    
    public static function state_add_form_fields() {
        ?>
		<div class="form-field">
			<label for="term_meta[class_term_meta]"><?php _e( 'Color', 'tasks' ); ?></label>
			<input type="text" name="term_meta[color]" id="term_meta[color]" value="">
		</div>
	<?php
	}
    
	public static function state_edit_form_fields( $term ) {
	    
	    $t_id = $term->term_id;
	    $term_meta = get_option( "taxonomy_$t_id" );
	    ?>
		<tr class="form-field">
		<th scope="row" valign="top"><label for="term_meta[color]"><?php _e( 'Color', 'tasks' ); ?></label></th>
			<td>
				<input type="text" name="term_meta[color]" id="term_meta[color]" value="<?php echo esc_attr( $term_meta['color'] ) ? esc_attr( $term_meta['color'] ) : ''; ?>">
			</td>
		</tr>
	<?php
	}
    
    /**
     * Adds the metaboxes to 'tasks'
     */
    public static function add_metabox() {
        add_meta_box(
            'my-meta-box',
            __( 'User', TASKS_PLUGIN_DOMAIN ),
            array( __CLASS__, 'render_metabox' ),
            'task',
            'side',
            'default'
            );
        
    }
    
    /**
     * Renders the meta box.
     */
    public static function render_metabox( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
        ?>
        <label for="title_field" style="width:150px; display:inline-block;"><?php echo esc_html__('User', TASKS_PLUGIN_DOMAIN);?></label>
		<select id="user" name="user" class="title_field">
  		<?php 
  		$post_user_id = get_post_meta( $post->ID, 'user', true );
  		$users = get_users();
  		foreach ( $users as $user ) {
  		    $user_info = get_userdata( $user->ID );
  		    $selected = '';
  		    if ( $post_user_id == $user->ID ) {
  		        $selected = 'selected="selected"';    
  		    }
  		?>
  			<option value="<?php echo $user_info->ID;?>" <?php echo $selected;?> ><?php echo esc_html( $user_info->display_name );?></option>
  		<?php 
  		}
  		?>
  		</select>       
        
        <?php
        //$outline = '<label for="title_field" style="width:150px; display:inline-block;">'. esc_html__('User', TASKS_PLUGIN_DOMAIN) .'</label>';
        //$title_field = get_post_meta( $post->ID, 'precio', true );
        //$outline .= '<input type="text" name="precio" id="title_field" class="title_field" value="'. esc_attr($title_field) .'" />';
        //echo $outline;
    }
    
    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox( $post_id, $post ) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';
        
        // Check if nonce is set.
        if ( ! isset( $nonce_name ) ) {
            return;
        }
        
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }
        
        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        /*
        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }
        
        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }
        */
        $user_id   = isset( $_POST['user'] ) ? sanitize_text_field( $_POST['user'] ) : '';
        update_post_meta( $post_id, 'user', $user_id );
    }
}

Tasks_Metabox::init();

<?php
class Tasks_Resources {
    
    public static function getLoadsByDay ($currentDay, $month, $year) {
        $loads = array();
                
        $tasks = Tasks::getTasksByDay( $currentDay, $month, $year );
                
        if ( $tasks ) {
            foreach ( $tasks as $task ) {
                $user_id = get_post_meta( $task->ID, 'resource', true );
                                
                $load = get_post_meta( $task->ID, 'user_load', true );
            
                if ( isset($loads[$user_id]) ) {
                    $loads[$user_id]['value'] += intval($load);
                } else {
                    $user_info = get_userdata($user_id);
                                        
                    $loads[$user_id] = array();
                    $loads[$user_id]['username'] = $user_info->user_login;
                    $loads[$user_id]['value'] += intval($load);
              }
            }
        }
        // dummy content
        // $loads[] = array( 'username' => 'ablancodev', 'value' => '50' );
        // $loads[] = array( 'username' => 'raiz', 'value' => '10' );
        // $loads[] = array( 'username' => 'otro', 'value' => '25' );
        
        return $loads;
    }
}
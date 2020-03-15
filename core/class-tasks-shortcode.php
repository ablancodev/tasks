<?php
class Tasks_Shortcode {
    public static function init()  {
        add_shortcode('tasks_list', array( __CLASS__, 'tasks_list' ) );
    }

    public static function tasks_list() {
        $output = '';
        $tasks = get_posts( array( 'post_type' => 'task', 'numberposts' => -1 ) );
        if ( $tasks ) {
            $output .= '<div class="container">';
            $output .= '<div class="row task-row">';
            $output .= '<input type="text" id="taskSearchInput" placeholder="' . __( 'Search', 'tasks' ) . '"/>';
            $output .= '
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Asignada a</th>
                    <th scope="col">Proyecto</th>
                    <th scope="col">Título</th>
                    <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody id="tasksTable">';
            foreach ( $tasks as $task ) {
                $state = get_the_terms( $task, 'state' );
                if ( $state ) {
                    $state = $state[0]->term_id;
                } else {
                    $state = 0;
                }
                $project = get_the_terms( $task, 'project' );
                if ( $project ) {
                    $project_name = $project[0]->name;
                } else {
                    $project_name = '--';
                }
                $back_color = '';
                $term_meta = get_option( 'taxonomy_' . $state );
                if ( $term_meta ) {
                    $back_color = 'background-color:' . $term_meta['color'] . ';';
                }
                
                $post_user_id = get_post_meta( $task->ID, 'user', true );
                $output .= '
                <tr style="' . $back_color .'">
                  <th scope="row">#' . $task->ID . '</th>
                  <td>' . get_avatar( $post_user_id ) . '</td>
                  <td>' . $project_name . '</td>
                  <td><a href="' . get_the_permalink( $task->ID ) . '">' . get_the_title( $task->ID ) . '</a></td>
                  <td>' . strip_tags( get_the_term_list( $task->ID, 'state' ) ) . '</td>
                </tr>
                ';
                
                /*
                $output .= '<div class="col-sm-12">';
                $output .= '<div class="">';
                $output .= '<a href="#task_modal_' . $key . '" data-toggle="modal" data-target="#task_modal_' . $key . '">';
                $output .= get_the_title( $task->ID );
                $output .= '</a>';
                $output .= '</div>';
                $output .= '</div>';

                // Modal 
                $output .= '<div class="modal fade" id="task_modal_' . $key . '" tabindex="-1" role="dialog">';
                $output .= '<div class="modal-dialog modal-lg">';
                $output .= '<div class="modal-content">';
                $output .= '<div class="modal-header">';
                $output .= '<h5 class="modal-title">' . get_the_title( $task->ID ) . '</h5>';
                $output .= '</div>';
                $output .= '<div class="modal-body">';
                $output .= get_post_field('post_content', $task->ID );
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                */
            }
            //$output .= '</div>';
            $output .= '
              </tbody>
            </table>
            ';
        } else {
            $output .= '<h2>En breve podra ver aquí nuestra sección de tasks</h2>';
        }
        return $output;
    }
}
Tasks_Shortcode::init();

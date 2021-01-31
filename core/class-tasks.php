<?php
class Tasks {
    public static function getTasksByDay ( $currentDay, $month, $year ) {
        $args = array(
            'post_type'         => 'task',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'start_date',
                    'value'   => $year . '-' . $month . '-' . $currentDay,
                    'compare' => '<=',
                    'type'    => 'string'
                ),
                array(
                    'key'     => 'end_date',
                    'value'   => $year . '-' . $month . '-' . $currentDay,
                    'compare' => '>=',
                    'type'    => 'string'
                )
            ),
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $tasks = get_posts($args);
        return $tasks;
    }

    public static function getTasksByDayByResource ( $currentDay, $month, $year, $resource_id ) {
        $args = array(
            'post_type'         => 'task',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'start_date',
                    'value'   => $year . '-' . $month . '-' . $currentDay,
                    'compare' => '<=',
                    'type'    => 'string'
                ),
                array(
                    'key'     => 'end_date',
                    'value'   => $year . '-' . $month . '-' . $currentDay,
                    'compare' => '>=',
                    'type'    => 'string'
                ),
                array(
                    'key'     => 'resource',
                    'value'   => $resource_id
                )
            ),
            'orderby' => 'date',
            'order' => 'DESC'
        );
        $tasks = get_posts($args);
        return $tasks;
    }
    
}
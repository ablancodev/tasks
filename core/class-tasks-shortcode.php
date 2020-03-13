<?php
class Tasks_Shortcode {
    public static function init()  {
        add_shortcode('tasks_listado', array( __CLASS__, 'tasks_listado' ) );
    }

    public static function tasks_listado() {
        $output = '';
        $productos = get_posts( array( 'post_type' => 'producto', 'numberposts' => -1 ) );
        if ( $productos ) {
            $output .= '<div class="row producto-row">';
            foreach ( $productos as $key => $producto ) {
                if ( ( $key % 3 ) == 0 ) {
                    $output .= '</div>';
                    $output .= '<div class="row producto-row">';
                }
                $output .= '<div class="col-sm-4">';
                $output .= '<div class="imagen-producto-container">';
                $output .= get_the_post_thumbnail( $producto->ID, 'medium' );
                $output .= '</div>';
                $output .= '<span class="price">' . get_post_meta( $producto->ID, 'precio', true ) . '</span>';
                $output .= '<div class="">';
                $output .= '<a href="#producto_modal_' . $key . '" data-toggle="modal" data-target="#producto_modal_' . $key . '">';
                $output .= get_the_title( $producto->ID );
                $output .= '</a>';
                $output .= '</div>';
                $output .= '</div>';

                // Modal 
                $output .= '<div class="modal fade" id="producto_modal_' . $key . '" tabindex="-1" role="dialog">';
                $output .= '<div class="modal-dialog modal-lg">';
                $output .= '<div class="modal-content">';
                $output .= '<div class="modal-header">';
                $output .= '<h5 class="modal-title">' . get_the_title( $producto->ID ) . '</h5>';
                $output .= '</div>';
                $output .= '<div class="modal-body">';
                $output .= get_post_field('post_content', $producto->ID );
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
            }
            $output .= '</div>';
            $output .= '</div>';
        } else {
            $output .= '<h2>En breve podra ver aquí nuestra sección de productos</h2>';
        }
        return $output;
    }
}
Tasks_Shortcode::init();

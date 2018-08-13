
<?php
/*
Plugin Name: BadFoxer pdf-embedder

*/

function admin_page_scripts() {   
    //scripts registration
    wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/mano.js', array('jquery'), '1.0' );
    wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/jquery-3.3.1.min.js', array('jquery'), '1.0' );
}
add_action('admin_enqueue_scripts', 'admin_page_scripts');


function custom_admin_media_button() {
    echo '<a href="#" id="insert-my-media" class="button">Add files</a>';

}
add_action('media_buttons', 'custom_admin_media_button', 15);


//add_filter( 'default_content', 'my_editor_content' );

//function my_editor_content( $content ) {
   // $content = "[pdf-embederis url= 'labas rytas']";
  //  return $content;
//}


?>



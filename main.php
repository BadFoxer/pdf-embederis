
<?php
/*
Plugin Name: BadFoxer pdf-embedder

*/

function custom_style(){
	wp_enqueue_style('stilius', plugin_dir_url( __FILE__ ) . '/css/stilius.css' );
	
}

add_action('wp_enqueue_scripts', 'custom_style');


function admin_page_scripts() {   
    //scripts registration
    wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/mano.js', array('jquery'), '1.0' );
    wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/jquery-3.3.1.min.js', array('jquery'), '3.3.1' );

}

add_action('admin_enqueue_scripts', 'admin_page_scripts');



function custom_admin_media_button() {
    echo '<a href="#" id="insert-my-media" class="button">Add files</a>';

}
add_action('media_buttons', 'custom_admin_media_button', 15);


function get_shortcode_attributes($atts){

  //extract atribute from shorcode admin dashboard
  extract(shortcode_atts(array(
 'url' =>'Default',
 'lapas' => 'Default', 
),$atts));


 return "<div><button class=testas onclick=location.href='{$url}' type=button>
     Didinti</button>
     <iframe src={$url}#view=Fit&toolbar=0&statusbar=0&messages=0&navpanes=0&scrollbar=0  width=595 height=720   class={$lapas}></iframe></div>";

}

add_shortcode("pdf-embedder","get_shortcode_attributes");


function custom_tag_field( $form_field, $post ) {
    $form_field['tag'] = array(
        'label' => 'tag',
        'input' => 'text',
        'value' => get_post_meta( $post->ID, 'tag', true ),
        'helps' => 'lapo pozicija',
    );
 
 
    return $form_field;
}
 
add_filter( 'attachment_fields_to_edit', 'custom_tag_field', 10, 2 );


function be_attachment_field_credit_save( $post, $attachment ) {
    if( isset( $attachment['tag'] ) )
        update_post_meta( $post['ID'], 'tag', $attachment['tag'] );
 
    return $post;
}
 
add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2 );




?>



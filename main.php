<?php
/*
Plugin Name: BadFoxer pdf-embedder
*/
function custom_style(){
	wp_register_style('stilius', plugin_dir_url( __FILE__ ) . '/css/stilius.css' );
  wp_enqueue_style('stilius');
}


add_action('wp_enqueue_scripts', 'custom_style');


function admin_page_scripts() {   
    //scripts registration
    wp_register_script( 'custom_script', plugin_dir_url( __FILE__ ) . 'js/mano.js', array('jquery'), '1.0' );
    wp_enqueue_script('custom_script');
  

}

add_action('admin_enqueue_scripts', 'admin_page_scripts');



function custom_admin_media_button() {
    echo '<a href="#" id="custom" class="button">Add pdf file</a>';

}
add_action('media_buttons', 'custom_admin_media_button', 15);


function media_checkbox( $form_fields, $post ) {
    $lapas = (bool) get_post_meta($post->ID, '_lapas', true);
    $checked = ($lapas) ? 'checked' : '';

    $form_fields['lapas'] = array(
        'label' => 'horizontal',
        'input' => 'html',
        'html' => "<input type='checkbox' id='myCheck' {$checked} name='attachments[{$post->ID}][lapas]' id='attachments[{$post->ID}][lapas]'/>",
        'value' => $lapas,
    );
    return $form_fields;

}

add_filter( 'attachment_fields_to_edit', 'media_checkbox', null, 2 );

function save_media_checkbox_state($post, $attachment) {
    $lapas = ($attachment['lapas'] == 'on') ? '1' : '0';
    update_post_meta($post['ID'], '_lapas', $lapas);  
    return $post;  
}
add_filter( 'attachment_fields_to_save', 'save_media_checkbox_state', null, 2 );


function get_shortcode_attributes($atts){

  //extract atribute from shorcode admin dashboard
  extract(shortcode_atts(array(
 'url' =>'Default',
 'lapas' => 'Default', 
),$atts));

 return "<div><button class=didinti onclick=location.href='{$url}' type=button>
     Didinti</button><div>
     <iframe src={$url}#view=Fit&toolbar=0&statusbar=0&messages=0&navpanes=0&scrollbar=0  width=595 height=720   class={$lapas}></iframe></div></div>";

}

add_shortcode("pdf-embedder","get_shortcode_attributes");

function media_hacks_attachment_field_to_edit( $form_fields, $post ){

  // https://codex.wordpress.org/Function_Reference/wp_get_attachment_metadata
  $media_author = get_post_meta( $post->ID, 'media_author', true );
    
  $form_fields['media_author'] = array(
    'value' => $media_author ? $media_author : '',
    'label' => __( 'Author' )
  ); 
  return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'media_hacks_attachment_field_to_edit', 10, 2 );
?>
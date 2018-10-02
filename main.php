<?php
/*
Plugin Name: BadFoxer pdf-embedder
*/

function custom_style(){
  // styles registration
	wp_register_style('stilius', plugin_dir_url( __FILE__ ) . '/css/stilius.css' );
  wp_enqueue_style('stilius');
}

// call styles function
add_action('wp_enqueue_scripts', 'custom_style');


function admin_page_scripts() {   
    //scripts registration
    wp_register_script( 'custom_script', plugin_dir_url( __FILE__ ) . 'js/mano.js', array('jquery'), '1.0' );
    wp_enqueue_script('custom_script');
  

}

// call scritps function ps. in admin dashboard
add_action('admin_enqueue_scripts', 'admin_page_scripts');


// add custom button in post or pages next to add media
function custom_admin_media_button() {
    echo '<a href="#" id="custom" class="button">Add pdf file</a>';

}
// call function whitch creates custom button
add_action('media_buttons', 'custom_admin_media_button', 15);


//create check box
function media_checkbox( $form_fields, $post ) {
    $lapas = (bool) get_post_meta($post->ID, '_lapas', true);
    $checked = ($lapas) ? 'checked' : '';

    // generate fields
    $form_fields['lapas'] = array(
        'label' => 'horizontal',
        'input' => 'html',
        'html' => "<input type='checkbox' id='myCheck' {$checked} name='attachments[{$post->ID}][lapas]' id='attachments[{$post->ID}][lapas]'/>",
        'value' => $lapas,
    );
    // return generated fields
    return $form_fields;

}
// show check box ir media library
add_filter( 'attachment_fields_to_edit', 'media_checkbox', null, 2 );

//save check box state
function save_media_checkbox_state($post, $attachment) {
    $lapas = ($attachment['lapas'] == 'on') ? '1' : '0';
    update_post_meta($post['ID'], '_lapas', $lapas);  
    return $post;  
}

// show check box ir media library
add_filter( 'attachment_fields_to_save', 'save_media_checkbox_state', null, 2 );


// get attributes from shortcode
function get_shortcode_attributes($atts){

  //extract atribute from shorcode admin dashboard
  extract(shortcode_atts(array(
 'url' =>'Default',
 'lapas' => 'Default', 
),$atts));

// return content
 return "<div><button class=didinti onclick=location.href='{$url}' type=button>
     Didinti</button><div>
     <iframe src={$url}#view=Fit&toolbar=0&statusbar=0&messages=0&navpanes=0&scrollbar=0  width=595 height=720   class={$lapas}></iframe></div></div>";

}

// call function whitch get atributes from shortcode
add_shortcode("pdf-embedder","get_shortcode_attributes");

?>
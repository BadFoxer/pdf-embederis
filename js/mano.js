  jQuery(document).ready(function(){
    	// run openMediaWindow function
    jQuery('#custom').click(open_media_window);

function open_media_window() {


	//If the window object does not exist, then
    if (this.window === undefined) {
     
        this.window = wp.media({
        	       // title of wp media frame
                title: 'Add files',
              /*  library: {type: 'image'},*/
              // can upload more than one file change to true
                multiple: false,
                // button text in wp media frame
                button: {text: 'Insert'}
            });

        var self = this; // Needed to retrieve our variable in the anonymous function below

        // Bind an event handler to the "select" JavaScript event, or trigger that event on an element.
        this.window.on('select', function() {
            	// Get media attachment details from the frame state
                var attachment = self.window.state().get('selection').first().toJSON();
                //get url from attachment file
                var res =  get_url_extension(attachment.url);
                //get checkbox id 
                var checkBox = document.getElementById("myCheck");


                 function get_url_extension( url ) {
                  //trim url get only extension like: pdf,jpg,png and etc..
                return url.split(/\#|\?/)[0].split('.').pop().trim();
                 }
                 // check if its pdf document
                 if(res != 'pdf'){
              alert('Only pdf documents');
              }       
              else{
                //call checkBox function
                check();
              }
            function check(){
              // if checkbox is checked
            if (checkBox.checked == true){
       alert('test'); 
       // here goes magic create shortcode and post to the post editor 
        wp.media.editor.insert('[pdf-embedder url="' + attachment.url + '" lapas="gulscias"]'); 
         } else {
       alert('test2');
        // here goes magic create shortcode and post to the post editor 
       wp.media.editor.insert('[pdf-embedder url="' + attachment.url + '"]'); 
    }
}
            });
    }
     // open media window
    this.window.open();

    // dont close until the button is pressedd
    return false;
}

});

   

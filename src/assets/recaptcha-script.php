<?php 

class RecaptchaScript {

    public function __construct() {
          //add script to frontend
          add_action( 'wp_enqueue_scripts', array($this,'recaptchascript') );

          //add script to admin login page
          add_action( 'login_enqueue_scripts', array($this,'recaptchascript') );
  
          add_filter( 'script_loader_tag', array($this, 'make_script_async'), 10, 3 );
    }  

    function recaptchascript() {
        wp_register_script( 'reCaptcha', 'https://www.google.com/recaptcha/api.js', null, null, true );
        wp_enqueue_script('reCaptcha');
    }
    
    function make_script_async( $tag, $handle, $src ){
        if ( 'reCaptcha' != $handle ) {
            return $tag;
        }
        return str_replace( '<script', '<script async defer', $tag );
    }
   
}

new RecaptchaScript();
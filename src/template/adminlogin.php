<?php

class AdminLogin {

    public function __construct(){  
        $this->init();
    }

    function init() {
        
        $options = get_option( 'recaptchawp_showon' );

        //execute if adminlogin checked in settings
        if ( isset($options) && !empty($options) && in_array( 'adminlogin', $options )) { 
            add_action( 'login_form', array( $this, 'login_field' ) );
            add_action('wp_authenticate_user', array($this, 'captcha_login_check'), 10, 2);
        }

    }

    function login_field(){
        
        $sitekey = get_option( 'recaptchawp_sitekey' );
        echo '<p><div class="g-recaptcha" data-sitekey="'. $sitekey  .'"></div></p> <br>';

        wp_register_script( 'reCaptcha', 'https://www.google.com/recaptcha/api.js', null, null, true );
        wp_enqueue_script('reCaptcha');
    
        function make_script_async( $tag, $handle, $src ){
        if ( 'reCaptcha' != $handle ) {
            return $tag;
        }
            return str_replace( '<script', '<script async defer', $tag );
        }
        add_filter( 'script_loader_tag', 'make_script_async', 10, 3 );
    }

    function captcha_login_check($user, $password) {
        if (!empty($_POST['g-recaptcha-response'])) {
            $secret = get_option( 'recaptchawp_secretkey' );
            $captcha = $_POST['g-recaptcha-response'];
            $rsp = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $captcha);
            $valid = json_decode($rsp, true);
            if ($valid["success"] == true) {
                return $user;
            } else {
                return new WP_Error('Captcha Invalid', __('<center>Captcha Invalid! Please check the captcha!</center>'));
            }
        } else {
            return new WP_Error('Captcha Invalid', __('<center>Login failed! Please check the captcha!</center>'));
        }
    }
  
}

new AdminLogin();
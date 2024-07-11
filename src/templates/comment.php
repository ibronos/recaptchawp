<?php

class Comment {

    public function __construct(){  
        $this->init();
    }

    function init() {
        
        $options = get_option( 'recaptchawp_showon' );

        //execute if comment checked in settings
        if ( 
            isset($options) && 
            !empty($options) && 
            in_array( 'comment', $options )
            // !is_user_logged_in()
        ) { 
            add_filter('comment_form_defaults', array($this, 'comment_recaptcha_field') ); 
            add_action('pre_comment_on_post', array($this, 'verify_google_recaptcha') ); 
        }

    }


    function comment_recaptcha_field($submit_field) { 
        $sitekey = get_option( 'recaptchawp_sitekey' );
        $submit_field['submit_field'] = '<div class="g-recaptcha" data-sitekey="'.$sitekey.'"></div>'.$submit_field['submit_field']; 
        
        return $submit_field; 
    } 


    function is_valid_captcha_response($captcha) { 
        $captcha_postdata = http_build_query( 
            array( 
                'secret' => get_option( 'recaptchawp_secretkey' ), 
                'response' => $captcha, 
                'remoteip' => $_SERVER['REMOTE_ADDR'] 
            ) 
        ); 
        $captcha_opts = array( 
            'http' => array( 
                'method'  => 'POST', 
                'header'  => 'Content-type: application/x-www-form-urlencoded', 
                'content' => $captcha_postdata 
            ) 
        ); 
        $captcha_context  = stream_context_create($captcha_opts); 
        $captcha_response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify", false, $captcha_context), true); 
        if(!empty($captcha_response['success'])){ 
            return true; 
        }else{ 
            return false; 
        } 
    } 
     
    function verify_google_recaptcha() { 
        $recaptcha = $_POST['g-recaptcha-response']; 
        if(empty($recaptcha)){ 
            wp_die(__("<b>ERROR: </b><b>Please click the captcha checkbox.</b><p><a href='javascript:history.back()'>« Back</a></p>")); 
        }
        elseif(!$this->is_valid_captcha_response($recaptcha)){ 
            wp_die(__("<b>Spam detected!</b>")); 
        } 
    } 

}

new Comment();
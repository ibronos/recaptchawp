<?php

class RecaptchawpAbout {

    public function __construct(){  
        add_action( 'admin_menu', array($this, 'recaptchawp_about_page') );
    }

    function recaptchawp_about_page() {
        add_submenu_page(
            'recaptchawp', //parent
            'About',
            'About',
            'manage_options',
            'recaptchawp-about',
            array($this, 'recaptchawp_about_cb')
        );
    }

    function recaptchawp_about_cb() { 
        require plugin_dir_path( __FILE__ ) . 'views/about.php';
    }

}

new RecaptchawpAbout();





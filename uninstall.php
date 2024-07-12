<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

unregister_setting( 'recaptchawp', 'recaptchawp_sitekey' );
unregister_setting( 'recaptchawp', 'recaptchawp_secretkey' );
unregister_setting( 'recaptchawp', 'recaptchawp_showon' );

delete_option( 'recaptchawp_sitekey' );
delete_option( 'recaptchawp_secretkey' );
delete_option( 'recaptchawp_showon' );
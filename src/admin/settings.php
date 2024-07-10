<?php

class RecaptchawpSettings {

    public function __construct(){  
        add_action( 'admin_menu', array( $this, 'recaptchawp_options_page' ) );
        add_action( 'admin_init', array( $this, 'recaptchawp_settings_init' ) );
    }

    function recaptchawp_options_page() {
        add_menu_page(
            'RecaptchaWP',
            'RecaptchaWP',
            'manage_options',
            'recaptchawp',
            array( $this, 'recaptchawp_options_page_html' )
        );
    }

    function recaptchawp_settings_init() {

        add_settings_section (
            'recaptchawp_section_developers',
            '', 
            array($this, 'recaptchawp_section_callback'),
            'recaptchawp'
        );

       
        add_settings_field(
            'recaptchawp_sitekey', 
            'Site Key',
            array( $this, 'recaptchawp_sitekey_cb' ),
            'recaptchawp',
            'recaptchawp_section_developers',
            array(
                'label_for'         => 'recaptchawp_sitekey',
                'class'             => 'recaptchawp'
            )
        );

        add_settings_field(
            'recaptchawp_secretkey', 
            'Secret Key',
            array( $this, 'recaptchawp_secretkey_cb' ),
            'recaptchawp',
            'recaptchawp_section_developers',
            array(
                'label_for'         => 'recaptchawp_secretkey',
                'class'             => 'recaptchawp'
            )
        );

        register_setting( 'recaptchawp', 'recaptchawp_sitekey' );
        register_setting( 'recaptchawp', 'recaptchawp_secretkey' );
      
    }

    function recaptchawp_section_callback( $args ) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>">
            <?php esc_html_e( 'Add Google Recaptcha Site key and Secret key below.', 'recaptcha' ); ?>
        </p>
        <?php
    }

    function recaptchawp_sitekey_cb( $args ) {
        $options = get_option( 'recaptchawp_sitekey' );
        ?>
        <input type="text" 
        id="<?php echo esc_attr( $args['label_for'] ); ?>" 
        name="recaptchawp_sitekey" 
        value="<?php echo $options; ?>"
        />
        <?php
    }

    function recaptchawp_secretkey_cb( $args ) {
        $options = get_option( 'recaptchawp_secretkey' );
        ?>
        <input type="text" 
        id="<?php echo esc_attr( $args['label_for'] ); ?>" 
        name="recaptchawp_secretkey" 
        value="<?php echo $options; ?>"
        />
        
        <?php
    }


    function recaptchawp_options_page_html() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( isset( $_GET['settings-updated'] ) ) {
            add_settings_error( 'recaptchawp_messages', 'recaptcha_message', __( 'Settings Saved', 'recaptcha' ), 'updated' );
        }

        settings_errors( 'recaptchawp_messages' );

        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                    do_settings_sections( 'recaptchawp' );
                    settings_fields( 'recaptchawp' );
                    submit_button( 'Save Settings' );
                ?>
            </form>
        </div>
        <?php
    }

}


new RecaptchawpSettings();
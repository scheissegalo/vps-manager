<?php
/* enqueue scripts and style from parent theme */
    
add_action( 'wp_enqueue_scripts', 'zsyl_enqueue_assets' );

function zsyl_enqueue_assets() {
	wp_enqueue_style( 'child-style', get_stylesheet_uri() );
}

include('custom-shortcodes.php');

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(https://klabausterbeere.xyz/wp-content/uploads/2022/04/minilogo.png);
		height:65px;
		width:65px;
		background-size: 65px 65px;
		background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

add_filter( 'wp_mail_from', 'sender_email' );
function sender_email( $original_email_address ) {
return 'info@klabausterbeere.xyz';
}
add_filter( 'wp_mail_from_name', 'sender_name' );
function sender_name( $original_email_from ) {
return 'Klabausterbeere';
}

function collectiveray_load_js_script() {
 // if( is_page(ID) ) {
    wp_enqueue_script( 'js-file', get_stylesheet_directory_uri() . '/main.js');
    //or use the version below if you know exactly where the file is
    //wp_enqueue_script( 'js-file', get_template_directory_uri() . '/js/myscript.js');
 // }
}

add_action('wp_enqueue_scripts', 'collectiveray_load_js_script');


?>
<?php
// INCLUDES FILE PHP & JS
function flatsome_child_enqueue_scripts() {
	wp_enqueue_script( 'flatsome-child-custom-js', get_stylesheet_directory_uri() . '/js/main.js', array( 'jquery' ), '1.0', true );
}
foreach ( glob(__DIR__.'/includes/*.php') as $file ){
	include $file;
}
add_action( 'wp_enqueue_scripts', 'flatsome_child_enqueue_scripts', 999 );
// THAY ĐỔI NỘI DUNG
function my_custom_translations( $strings ) {
    $text = array(

    );
    $strings = str_ireplace( array_keys( $text ), $text, $strings );
    return $strings;
}
add_filter( 'gettext', 'my_custom_translations', 20 );

// 
function breabcrumb() {
	if( !is_front_page() ){
		if ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb( '<div id="breadcrumbs"><div class="container">','</div></div>' );
		} else {
			echo '<div id="breadcrumbs"><div class="container"><span><span><a href="https://hwood.vn/">Trang chủ</a></span> » <span class="breadcrumb_last" aria-current="page">Tin tức</span></span></div></div>';
		}
	}
}
add_action('flatsome_after_header','breabcrumb');
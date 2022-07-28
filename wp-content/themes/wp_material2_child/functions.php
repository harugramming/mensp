<?php

/****  親スタイルシート読み込み  ****/
function load_parent_css(){
	wp_enqueue_style( "parent_style", get_template_directory_uri()."/style.css", false );
}
add_action('wp_enqueue_scripts', 'load_parent_css');

?>
<?php
/*
Plugin Name: Server Config
Plugin URI: http://blog.gagan.pro/
Description: Shows the server's configuration in the dashboard
Author: gagan0123
Author URI: http://gagan.pro/
Version: 0.1
Text Domain: server-config
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

add_action('admin_menu', 'screen_config_register_submenu_page');

function screen_config_register_submenu_page() {
	add_submenu_page( 'tools.php', 'Server Config', 'Server Config', 'manage_options', 'server-config', 'screen_config_submenu_page_callback' ); 
}

function screen_config_submenu_page_callback() {
	if ( isset ( $_GET['tab'] ) ) {
		screen_config_admin_tabs($_GET['tab']);
	}
	else {
		screen_config_admin_tabs('general');
	}
}

function screen_config_admin_tabs($current = 'general') {
	$tabs = array( 'general' => 'General', 'php' => 'PHP', 'mysql' => 'MySQL', 'extensions' => 'Extensions', 'phpinfo' => 'PHPInfo' );
	echo '<div class="wrap">';
    echo '<div id="icon-tools" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=server-config&tab=$tab'>$name</a>";

    }
    echo '</h2>';
	switch($current){
		case 'general'	:
			screen_config_display_tab_general();
			break;
		case 'phpinfo'	: 
			screen_config_display_tab_phpinfo();
			break;
		case 'extensions' :
			screen_config_display_tab_extensions();
			break;
		case 'mysql'	:
			screen_config_display_tab_mysql();
			break;
		default:
			screen_config_display_tab_not_exist();
	}
	echo '</div>';
}

function screen_config_display_tab_phpinfo(){
	phpinfo();
}

function screen_config_display_tab_not_exist(){
	echo 'Tab you requested does not exist';
}

function screen_config_display_tab_extensions(){
	echo '<pre>';
	var_dump(get_loaded_extensions());
	echo '</pre>';
}

function screen_config_display_tab_general(){
	
}

function screen_config_display_tab_mysql(){
	global $wpdb;
	$res = $wpdb->get_results('SHOW VARIABLES LIKE "%version%";');
	echo '<pre>';
	var_dump($res);
	echo '</pre>';
}

function screen_config_utility_extension_descriptions(){
	return array(
		'apc'	=>	array(
			'Advanced PHP Cache',
			'Caching and optimizing PHP intermediate code'
			),
		'amqp'	=>	array(
			'Advanced Message Queue Protocol',
			'Open standard middleware layer for message routing and queuing'
			),
		'apd'	=>	array(
			'Advanced PHP Debugger',
			'Provide profiling and debugging capabilities for PHP code, as well as to provide the ability to print out a full stack backtrace'
		),
		'bbcode'	=>	array(
			'Bulletin Board Code',
			'Helps to parse BBCode text in order to convert it to HTML or another markup language'
		),
		'bcmath'	=>	array(
			'BCMath Arbitrary Precision Mathematics',
			'Supports numbers of any size and precision, represented as strings'
		),
		'bcompiler'	=> array(
			'PHP bytecode Compiler',
			'Encode some classes and/or functions or entire script in a proprietary PHP application'
		),
		'bz2'	=>	array(
			'BZip2',
			'Used to transparently read and write bzip2 (.bz2) compressed files'
		),
		'calendar'	=>	array(
			'Calendar',
			'Provides functions to simplify converting between different calendar formats'
		),
		'ctype'	=>	array(
			'Character type checking',
			'Provides functions to check whether a character or string falls into a certain character class according to the current locale'
		),
	);
}
?>
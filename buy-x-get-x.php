<?php
/*
 * Plugin Name:       Buy X Get X 
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the Buy X Get X offer with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Roshan
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

use BXG\App\Route;

 defined( 'ABSPATH' ) || exit ;

 defined( 'BXG_PLUGIN_FILE' ) || define( 'BXG_PLUGIN_FILE' , __FILE__ ) ;
 defined( 'BXG_PLUGIN_PATH' ) || define( 'BXG_PLUGIN_PATH' , plugin_dir_path( __FILE__ ) ) ;

 //autoload files
 if ( file_exists( BXG_PLUGIN_PATH . '/vendor/autoload.php' ) ) 
 {
    require BXG_PLUGIN_PATH . '/vendor/autoload.php' ;
 } 
 else 
 {
    wp_die( 'Autoload File Not Found ' );
 }

 if ( class_exists( 'BXG\App\Route' ) )
 {
   Route::bxgFunction() ;
 }
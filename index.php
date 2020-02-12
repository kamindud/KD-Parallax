<?php

/**
 * Plugin Name:       KD-parallax
 * Plugin URI:        https://github.com/kamindud/KD-Parallax
 * Description:       KD-Parallax creates beautiful Parallax effect on your website.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            Kamindu Dushmantha
 * Author URI:        https://www.upwork.com/o/profiles/users/~015e0f8986e381d86b/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

//  variables

// includes
include_once ('inc/admin_page.php');
include_once ('inc/metaboxes.php');
include_once ('inc/frontend.php');

// functions

// create post type
function kd_create_cpt(){
    $custom_posts = new adminPage();
    $custom_posts->kd_create_cpt();
}

// create metaboxes
function kd_create_metaboxes(){

    $createMetaboxes = new KDMetaboxes();
    $createMetaboxes->kd_create_metaboxes();
}

function kd_save_post_meta($post_id, $post){
    $createMetaboxes = new KDMetaboxes();
    $createMetaboxes->kd_save_post_meta($post_id, $post);
}

// enqueue scripts
function kd_enqueue_scripts(){
    
}

// enqueue admin scripts
function kd_enqueue_admin_scripts(){
    wp_enqueue_media();
    wp_enqueue_style( 'kd-admin-css', plugins_url( 'assets/css/kd-admin-css.css', __FILE__));
    wp_enqueue_script( 'kd-admin-js', plugins_url( '/assets/js/kd-parallax-admin.js', __FILE__ ) , array() , '' , true);
}

// create shortcode
function create_shortcode   ($atts){
    $post_id = $atts['id'];
    $front_end =  new FrontEnd();
    return $front_end->create_shortcode($post_id);
}

// shortcodes
add_shortcode( 'kd-parallax', 'create_shortcode');

// action events
add_action('init', 'kd_create_cpt');
add_action( 'add_meta_boxes', 'kd_create_metaboxes' );
add_action( 'save_post', 'kd_save_post_meta' , 10 , 2);
add_action( 'wp_enqueue_scripts', 'kd_enqueue_scripts' );
add_action( 'admin_init', 'kd_enqueue_admin_scripts' );
// add_action( 'admin_footer', 'media_selector_print_scripts' );


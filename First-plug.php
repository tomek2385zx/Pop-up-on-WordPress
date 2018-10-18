<?php
/**
*@package LeadsCatcher
*/
/*
Plugin Name: LeadsCatcher
Plugin URI: https://nanocoder.pl
Description: This plugin allow you to display pop-up window with form for clients.You can choose posts where pop-up will be shown.
Version: 1.0.0
Author: Tomasz Kowalski & Konrad Zimny (Nanocoder)
Text Domain: LeadsCatcher
*/

//Require functions needed for wp_mail()
require('inc/pluggable.php');

//Plugin path constant
define ( 'DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
defined('ABSPATH') or die("STOP IT");


class LeadsCatcher
{

  //Adding actions and filters
  function register(){
    add_action('wp_enqueue_scripts', array($this,'enqueue'));
    add_action('admin_menu',array($this, 'add_admin_pages'));
  }
  //Adding admin pages
  function add_admin_pages(){
    add_menu_page('LeadCatcher Plugin','LeadCatcher','manage_options','LeadCatcher_Plugin',array($this,'admin_index'),'dashicons-id-alt',100);
  }
  function admin_index(){
    require_once plugin_dir_path(__FILE__).'templates/admin.php';
  }
  function custom_post_type(){
    }

        function enqueue(){
          //enqueue our scripts
            //Is it page with good tag?
            global $wpdb;
            $myrows = $wpdb->get_results( "SELECT name FROM wp_leads" );
            //alltags = Array with values from leads table
            $alltags = array();
            foreach ( $myrows as $print )   {
              array_push($alltags, $print->name);
          }


            if(is_home())
            {
              //Popup cant be displayed on homepage!!
            }
            else{
                  if ( has_tag($alltags)){
                            //This  will show popup
                            require_once( DIR . '/inc/popup.php' ); // Database connection and EMail sending
                  } else {
                      // The current post DOES NOT have the tag from lead table;
                      // do something else
                  }
                }

          wp_enqueue_script('tags',plugins_url('/assets/js/tags.js',__FILE__));//OnClick Popup
        //  wp_enqueue_script('form',plugins_url('/assets/js/form.js',__FILE__));//OnClick Popup
          wp_enqueue_script('jQuery',plugins_url('/assets/js/jquery-3.3.1.min.js',__FILE__));//JQuery
          wp_enqueue_style('bootstrap',plugins_url('/assets/css/bootstrap/bootstrap.min.css',__FILE__));//Bootstrap
          wp_enqueue_style('mainpagestyle',plugins_url('/assets/css/css.css',__FILE__));//Our own CSS
        //  wp_enqueue_style('form',plugins_url('/assets/css/form.css',__FILE__));//Our own CSS


        }


}
//Initializing Plugin
  if(class_exists('LeadsCatcher')){
    $LeadsCatcher = new LeadsCatcher('FirstPlug initialized!');
    $LeadsCatcher->register();
  }



// activation
  require_once plugin_dir_path(__FILE__).'inc/Activation.php';
  register_activation_hook(__FILE__,array('LeadsCatcherActivate','activate'));

// deactivate
  require_once plugin_dir_path(__FILE__).'inc/Deactivation.php';
  register_deactivation_hook(__FILE__,array('LeadsCatcherDeactivate','deactivate'));

// uninstall
  require_once plugin_dir_path(__FILE__).'inc/uninstall.php';
  register_uninstall_hook(__FILE__,array('LeadsCatcherUninstall','uninstall'));

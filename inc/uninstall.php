<?php

/**
* Trigger this file on Plugin uninstall
*
*@package LeadsCatcher
*/
class LeadsCatcherUninstall
{
  public static function uninstall(){
      if(!defined('WP_UNINSTALL_PLUGIN')){
        die;
      }

      //Clear Database stored database
      $plug = get_posts(array('post_type' => 'Leady','numberposts' => -1));

      foreach($plugs as $data){
        wp_delete_post( $data->ID, true);
      }

      //Acess the database via SQL

      global $wpdb;
      $wpdb->query("DELETE FROM wp_posts WHERE post_type = 'Leady'");
      $wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
      $wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");
    }
}

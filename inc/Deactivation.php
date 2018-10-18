<?php
/**
*@package LeadsCatcher
*/
class LeadsCatcherDeactivate
{
  public static function deactivate(){
    flush_rewrite_rules();
  }
}

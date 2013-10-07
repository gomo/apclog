<?php
class Apclog
{
  public static function createAction($args)
  {
    $action = @$args[1];
    if(!$action){
      throw new Exception('Missing action name. Usage: php acplog action [arg [arg...]]');
    }

    unset($args[0]);
    unset($args[1]);

    $class = 'Action_'.$action;

    return new $class($action, array_merge(array(), $args));
  }
}
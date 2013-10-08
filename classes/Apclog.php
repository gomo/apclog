<?php
class Apclog
{
  public static function createAction($args)
  {
    foreach($args as $key => $arg)
    {
      if(strpos($arg, '-') === 0)
      {
        unset($args[$key]);
      }
    }

    $args = array_merge($args);

    $action = @$args[1];
    if(!$action){
      throw new Exception('Missing action name. Usage: php acplog action [arg [arg...]]');
    }

    unset($args[0]);
    unset($args[1]);

    $class = 'Action_'.$action;

    return new $class($action, array_merge($args));
  }
}
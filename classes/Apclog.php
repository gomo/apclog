<?php
class Apclog
{
  public static function createAction($args)
  {
    list($args, $options) = self::_parseOptions($args);
    $action = @$args[1];
    if(!$action){
      throw new Exception('Missing action name. Usage: php acplog action [arg [arg...]]');
    }

    unset($args[0]);
    unset($args[1]);

    $class = 'Action_'.$action;

    return new $class($action, array_merge($args), $options);
  }

  private static function _parseOptions($args)
  {
    $options = array();
    foreach($args as $key => $arg)
    {
      if(strpos($arg, '-') === 0)
      {
        $options = array_merge($options, str_split(substr($arg, 1)));
        unset($args[$key]);
      }
    }

    return array(array_merge($args), $options);
  }
}
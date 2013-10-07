<?php
abstract class Data
{
  protected function _execCmd()
  {
    $args = func_get_args();

    $format = $args[0];
    unset($args[0]);

    $cmd = vsprintf($format, $args);
    
    return shell_exec($cmd);
  }
}
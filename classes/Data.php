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

  protected function _getGrepCommands(array $greps)
  {
    $grep_cmds = array();
    foreach($greps as $grep)
    {
      $grep_cmds[] = sprintf("grep -E '%s'", $grep);
    }

    return implode(' | ', $grep_cmds);
  }
}
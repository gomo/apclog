<?php
class Data_IpReport extends Data
{
  public function get($log_path, $greps)
  {
    $grep_cmd = $this->_getGrepCommands($greps);
    $resp = $this->_execCmd("cat %s | %s ", $log_path, $grep_cmd);

    return $resp;
  }
}
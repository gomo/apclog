<?php
class Data_IpCount extends Data
{
  public function get($log_path, $greps, $min)
  {
    $grep_cmd = $this->_getGrepCommands($greps);
    $resp = $this->_execCmd("cat %s | %s | cut -d ' ' -f 1 | sort | uniq -c", $log_path, $grep_cmd);

    $result = array();
    foreach(explode(PHP_EOL, $resp) as $row)
    {
      @list($count, $ip) = explode(' ', trim($row));

      if(!$ip){
        continue;
      }

      if($count >= $min){
        $result[] = array('ip' => $ip, 'count' => $count);
      }
    }

    return $result;
  }
}
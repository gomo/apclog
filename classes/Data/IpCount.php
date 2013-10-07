<?php
class Data_IpCount extends Data
{
  public function get($log_path, $greps)
  {
    $grep_cmd = '';
    foreach($greps as $grep)
    {
      $grep_cmd .= sprintf("grep -E '%s' | ", $grep);
    }

    $resp = $this->_execCmd("cat %s | %s cut -d ' ' -f 1 | sort | uniq -c", $log_path, $grep_cmd);

    $result = array();
    foreach(explode(PHP_EOL, $resp) as $row)
    {
      @list($count, $ip) = explode(' ', trim($row));

      if(!$ip){
        continue;
      }

      if($count <= 2){
        continue;
      }

      $result[] = array('ip' => $ip, 'count' => $count);
    }

    return $result;
  }
}
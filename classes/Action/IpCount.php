<?php
class Action_IpCount extends Action
{
  protected $_usage_string = '/path/to/log.file grep-regex[ grep-regex...]';

  protected function _run()
  {
    $path = $this->_getParam(0);
    $greps = $this->_getParams(1);

    $grep_cmd = '';
    foreach($greps as $grep)
    {
      $grep_cmd .= sprintf("grep -E '%s' | ", $grep);
    }

    $resp = $this->_execCmd("cat %s | %s cut -d ' ' -f 1 | sort | uniq -c", $path, $grep_cmd);

    $data_name = 'Action_IpCount.ip_list';
    $exists = $this->_getSavedData($data_name, array());
    $new = array();
    $old = array();
    foreach(explode(PHP_EOL, $resp) as $row)
    {
      list($count, $ip) = explode(' ', trim($row));

      if(!$ip){
        continue;
      }

      if($count <= 2){
        continue;
      }

      if(!in_array($ip, $exists)){
        $exists[] = $ip;
        $new[] = sprintf('%s : %d回', $ip, $count);
      } else {
        $old[] = sprintf('%s : %d回', $ip, $count);
      }
    }

    $this->_saveData($data_name, $exists);

    var_dump($new, $old);
  }
}
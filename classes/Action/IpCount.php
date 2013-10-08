<?php
class Action_IpCount extends Action
{
  protected $_usage_string = '/path/to/log.file grep-regex[ grep-regex...]';

  protected $_option_string = 'm:n';

  protected function _run()
  {
    $path = $this->_getParam(0);
    $greps = $this->_getParams(1);

    $ip_counter = new Data_IpCount();

    $data_name = 'Action_IpCount.ip_list.'.sha1($path.implode(',', $greps));
    $exists = $this->_getSavedData($data_name, array());
    $new = array();
    $old = array();
    foreach($ip_counter->get($path, $greps, $this->_getOption('m', 1)) as $data)
    {
      if(!in_array($data['ip'], $exists)){
        $exists[] = $data['ip'];
        $new[] = sprintf("%d\t: %s", $data['count'], $data['ip']);
      } else {
        $old[] = sprintf("%d\t: %s", $data['count'], $data['ip']);
      }
    }

    if(!$this->_hasOption('n')){
      $this->_saveData($data_name, $exists);
    }

    $this->_echoStd(array(
      array('name' => 'Exists', 'values' => $old),
      array('name' => 'New', 'values' => $new),
    ));
  }
}
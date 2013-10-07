<?php
class Action_IpCount extends Action
{
  protected $_usage_string = '/path/to/log.file grep-regex[ grep-regex...]';

  protected function _run()
  {
    $path = $this->_getParam(0);
    $greps = $this->_getParams(1);

    $data = new Data_IpCount();

    $data_name = 'Action_IpCount.ip_list.'.sha1($path.implode(',', $greps));
    $exists = $this->_getSavedData($data_name, array());
    $new = array();
    $old = array();
    foreach($data->get($path, $greps) as $data)
    {
      if(!in_array($data['ip'], $exists)){
        $exists[] = $data['ip'];
        $new[] = sprintf("%d\t: %s", $data['count'], $data['ip']);
      } else {
        $old[] = sprintf("%d\t: %s", $data['count'], $data['ip']);
      }
    }

    $this->_saveData($data_name, $exists);

    $this->_echoStd(array(
      array('name' => 'Exists', 'values' => $old),
      array('name' => 'New', 'values' => $new),
    ));
  }
}
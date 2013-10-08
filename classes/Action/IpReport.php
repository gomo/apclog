<?php
class Action_IpReport extends Action
{
  protected function _run()
  {
    $path = $this->_getParam(0);
    $greps = $this->_getParams(1);

    $ip_counter = new Data_IpCount();
    $ip_report = new Data_IpReport();

    $result = array();
    foreach($ip_counter->get($path, $greps, 5) as $data)
    {
      $gr = $greps;
      $gr[] = $data['ip'];
      $result[] = array(
        'name' => sprintf('%s - %d', $data['ip'], $data['count']),
        'values' => array($ip_report->get($path, $gr)),
      );
    }

    $this->_echoStd($result);
  }
}
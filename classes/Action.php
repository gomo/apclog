<?php
abstract class Action
{
  private $_params;

  private $_action;

  protected $_usage_string = '';

  public function __construct($action, array $params){
    $this->_params = $params;
    $this->_action;
  }

  protected function _getParam($key, $default = null)
  {
    if($default === null && !isset($this->_params[$key])){
      throw new Exception('Missing '.$key.' param. Usage: php apclog '.$this->_usage_string);
    }

    if(!isset($this->_params[$key])){
      return $default;
    }

    return $this->_params[$key];
  }

  protected function _getParams($start)
  {
    $args = array();
    for ($i=$start; $i < count($this->_params); $i++) { 
      $args[] = $this->_params[$i];
    }

    return $args;
  }

  public function run(){
    $this->_run();
  }

  private function _getDataPath($key)
  {
    return 'data/'.$key.'.php';
  }

  protected function _saveData($name, $data)
  {
    $save = "<?php".PHP_EOL.'$cash_data = '.var_export($data, true).';';
    file_put_contents($this->_getDataPath($name), $save);
    chmod($this->_getDataPath($name), 0666);
  }

  protected function _getSavedData($key, $default = null)
  {
    @include $this->_getDataPath($key);
    if(!isset($cash_data))
    {
      return $default;
    }

    return $cash_data;
  }

  protected function _echoStd($data)
  {
    $result = '';
    foreach($data as $val)
    {
      $result .= $val['name'].PHP_EOL;
      $result .= implode(PHP_EOL, $val['values']);
      $result .= PHP_EOL;
      $result .= PHP_EOL;
    }

    echo $result;
  }

  abstract protected function _run();
}
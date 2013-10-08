<?php
abstract class Action
{
  private $_params;

  private $_options;

  private $_action;

  private $_base_path;

  protected $_usage_string = '';

  protected $_option_string = '';

  public function __construct($action, array $params){
    $this->_params = array_merge($params);
    $this->_options = getopt($this->_option_string);
    $this->_action = $action;
  }

  protected function _hasOption($key)
  {
    return isset($this->_options[$key]);
  }

  protected function _getOption($key, $default = null)
  {
    if($this->_hasOption($key)){
      return $this->_options[$key];
    } else {
      $default;
    }
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

  public function run($base_path){
    $this->_base_path = $base_path;
    $this->_run();
  }

  private function _getDataPath($key)
  {
    return $this->_base_path.'/data/'.$key.'.php';
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
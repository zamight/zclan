<?php

/**
 * Class settings
 */
class z
{

	public $setting_array = array();

	/**
	 * @var array
     */
	private $pluginList = array();

	public function __construct()
	{
		//$this->setting_array['db'] = new db(this);
		//$this->setting_array['user'] = new user(this);
	}

	/**
	 * @param $get
	 * @return bool
     */
	public function getInput($get)
	{
		if(isset($_GET[$get]))
		{
			return $_GET[$get];
		}
		else
		{
			if(!isset($_POST[$get]))
			{
				return FALSE;
			}
			return $_POST[$get];
		}
	}

    public function getInput2($get, &$name)
    {
        if(isset($_GET[$get]))
        {
            $name = $_GET[$get];
        }
        else
        {
            if(!isset($_POST[$get]))
            {
                $name = FALSE;
            }
            $name = $_POST[$get];
        }
    }

	/**
	 * @param $index
	 * @param null $params
     */
	public function runPlugin($index, $params = NULL)
	{
		if($this->pluginList[$index]) {
			//print_r($this->pluginList);
			foreach ($this->pluginList[$index] as $func_plugin) {
				if (function_exists($func_plugin)) {
					if ($params != NULL) {
						call_user_func_array($func_plugin, $params);
					} else {
						call_user_func($func_plugin);
					}
				}
			}
		}
	}

	/**
	 * @param $index
	 * @param $func_plugin
     */
	public function addPlugin($index, $func_plugin)
	{
		$this->pluginList[$index][] = $func_plugin;
	}

	public function __get($name)
	{
		if(array_key_exists($name, $this->setting_array)) {
			return $this->setting_array[$name];
		}

		return null;
	}

	public function __set($name, $value)
	{
		$this->setting_array[$name] = $value;
	}

}
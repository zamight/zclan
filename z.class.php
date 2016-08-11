<?php

/**
 * Class settings
 */
class settings
{

	/**
	 * @var array
     */
	private $pluginList = array();

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

}

$z = new settings();
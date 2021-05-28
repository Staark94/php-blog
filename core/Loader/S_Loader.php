<?php

declare(strict_types=1);
namespace Core\Loader;

class S_Loader {
    protected $_ob_level;
    protected $_view_paths		= array();
	protected $_library_paths	= array();
	protected $_model_paths		= array();
	protected $_helper_paths	= array();
	protected $_base_classes	= array();
	protected $_cached_vars		= array();
	protected $_classes			= array();
	protected $_loaded_files	= array();
	protected $_models			= array();
	protected $_helpers			= array();

    public function __construct()
	{
		$this->_ob_level  = ob_get_level();
		$this->_library_paths = array(APPPATH, BASEPATH);
		$this->_helper_paths = array(APPPATH, BASEPATH);
		$this->_model_paths = array(APPPATH);
		$this->_view_paths = array(APPPATH.'themes/' => TRUE);

		error_log("[debug] Loader Class Initialized");
	}


    public function initialize()
	{
		$this->_classes = array();
		$this->_loaded_files = array();
		$this->_models = array();
		$this->_base_classes = $this->is_loaded;

		$this->_autoloader();

		return $this;
	}

    public function is_loaded($class)
	{
		if (isset($this->_classes[$class]))
		{
			return $this->_classes[$class];
		}

		return FALSE;
	}

    public function model($model, $name = '', $db_conn = FALSE) {

    }
}
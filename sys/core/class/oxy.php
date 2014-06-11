<?php
/*-------------------------------------------------------------------
	
	Oxy Framework Copyright (c) 2014 athron (athron.poster@gmail.com)
  
	-------------------------------------------------------------------*/
	
	class Conf {
		public $Config;
		function __construct(){
			require iCONFIG.'site.php';
			foreach ($SiteConfig as $key => $value) {
				$this->Config[$key] = $value;
			}			
		}
	}

	class Oxy {
		static protected $Html;
		static protected $Cfg;
		static protected $vars = array();		
		
		static function Init(){
			self::$Cfg = new Conf;
		}
		
		static function Config($var) {
			return self::$Cfg->Config[$var];
		}
		
		static function Modules(){
		}
		
		static function Themes(){
		}
		
		static function Out(){
		}

	}
	Oxy::Init();
	
?>
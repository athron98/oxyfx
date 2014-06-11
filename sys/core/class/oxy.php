<?php
/*-------------------------------------------------------------------
	
	Oxy Framework Copyright (c) 2014 athron (athron.poster@gmail.com)
  
	-------------------------------------------------------------------*/
  function checkCanGzip() {
      global $HTTP_ACCEPT_ENCODING;
      
      if (headers_sent()) return 0;
      if (strpos($HTTP_ACCEPT_ENCODING, 'x-gzip') !== false) return "x-gzip";
      if (strpos($HTTP_ACCEPT_ENCODING,'gzip') !== false) return "gzip";
      return 0;
  }

  function gzDocOut() {
      if ($encoding = checkCanGzip()) {
        $contents = ob_get_contents();
        ob_end_clean();
        header("Content-Encoding: ".$encoding);
        print("\x1f\x8b\x08\x00\x00\x00\x00\x00");
        $size = strlen($contents);
        $contents = gzcompress($contents, 9);
        $contents = substr($contents, 0, $size);
        print($contents);
//        print(pack('V', crc32($contents)));
//        print(pack('V', $size));
        exit();
      }
      else {
        ob_end_flush();
        exit();
      }
      
  }

	class Conf {
		public $Config;
		function __construct(){			
			$this->LoadConfig( iCONFIG.'site.php');
			$this->LoadConfig( iCONFIG.'server.php');
		}
		
		function LoadConfig($path){
				require $path;
				foreach ($Config as $key => $value) {
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
			$html = file_get_contents(iTHEME.self::$Cfg->Config['Site/Themes'].'/html.tpl');
			$html = str_replace('[^c.title]',self::$Cfg->Config['Site/Title'],$html);
			ob_start();
			ob_implicit_flush(0);
			echo $html;
			gzDocOut();
		}

	}
	Oxy::Init();
	
?>
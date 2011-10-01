<?php

	namespace MultiByte;
	
	class MultiByte {
				
		public static $library = null;
		
		public static function factory ( $library = null ) {
			
			if ( $library == null ) {
				
				\Fuel\Core\Config::load('multibyte', 'multibyte');
            	
            	$config = \Fuel\Core\Config::get( 'multibyte.library' );
				
				if ( $config == null ) {
					$config = 'mbstring';
				}
				
				self::$library = $config;
				
			}
			else {
				self::$library = $library;
			}
			
			$class = '\MultiByte\Engine_' . self::$library;
			
			return new $class();
			
		}
		
	}

?>
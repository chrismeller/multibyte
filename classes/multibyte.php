<?php

	class MultiByte {
				
		public static $library = null;
		
		public static function factory ( $library = null ) {
			
			if ( $library == null ) {
				
				$config = Kohana::config( 'multibyte.library' );
			
				if ( $config == null ) {
					$config = 'mbstring';
				}
				
				self::$library = $config;
				
			}
			else {
				self::$library = $library;
			}
			
			$class = 'MultiByte_Engine_' . self::$library;
			
			return new $class();
			
		}
		
	}

?>
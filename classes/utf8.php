<?php

	namespace MultiByte;

	class UTF8 {
		
		protected static $instance;
		
		public static function instance ( ) {
			
			if ( self::$instance == null ) {
				self::$instance = MultiByte::factory();
			}
			
			return self::$instance;
			
		}
		
		public static function clean ( $string, $charset = null ) {
			
			if ( is_array( $string ) || is_object( $string ) ) {
				
				$result = array();
				foreach ( $string as $k => $v ) {
					$result[ self::clean( $k, $charset ) ] = self::clean( $v, $charset );
				}
				
				return $result;
				
			}
			
			return self::instance()->convert_encoding( $string, $charset );
			
		}
		
		public static function is_ascii ( $string ) {
			
			$converted = self::instance()->convert_encoding( $string, 'ASCII' );
			
			if ( $string === $converted ) {
				return true;
			}
			else {
				return false;
			}
			
		}
		
		public static function strlen ( $string ) {
			
			return self::instance()->strlen( $string );
			
		}
		
		public static function ucfirst ( $string ) {
			
			return self::instance()->ucfirst( $string );
			
		}
		
		public static function lcfirst ( $string ) {
			
			return self::instance()->lcfirst( $string );
			
		}
		
		public static function ucwords ( $string ) {
			
			return self::instance()->ucwords( $string );
			
		}
		
		public static function trim ( $string, $charlist = null ) {
			
			return self::instance()->trim( $string, $charlist );
			
		}
		
		public static function ltrim ( $string, $charlist = null ) {
			
			return self::instance()->ltrim( $string, $charlist );
			
		}
		
		public static function rtrim ( $string, $charlist = null ) {
			
			return self::instance()->rtrim( $string, $charlist );
			
		}
		
		public static function strtoupper ( $string ) {
			
			return self::instance()->strtoupper( $string );
			
		}
		
		public static function strtolower ( $string ) {
			
			return self::instance()->strtolower( $string );
			
		}
		
		public static function substr ( $string, $offset, $length = null ) {
			
			return self::instance()->substr( $string, $offset, $length );
			
		}
		
		public static function strrev ( $string ) {
			
			return self::instance()->strrev( $string );
			
		}
		
		public static function strpos ( $string, $search, $offset = 0 ) {
			
			return self::instance()->strpos( $string, $search, $offset );
			
		}
		
		public static function str_replace ( $search, $replace, $string, &$count = null ) {
			
			return self::instance()->str_replace( $search, $replace, $string, $count );
			
		}
		
		public static function str_ireplace ( $search, $replace, $string, &$count = null ) {
			
			return self::instance()->str_ireplace( $search, $replace, $string, $count );
			
		}
		
	}

?>
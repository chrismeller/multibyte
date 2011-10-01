<?php

	namespace MultiByte;
	
	abstract class Engine {
		
		protected function encoding ( $use_encoding = null ) {
			
			$encoding = Kohana::$charset;
			
			if ( $use_encoding != null ) {
				$encoding = $use_encoding;
			}
			
			return $encoding;
			
		}
		
		abstract public function detect_encoding ( $string );
		
		abstract public function convert_encoding ( $string, $use_encoding = null, $from_encoding = null );
		
		public function strlen ( $string ) {
			
			$length = strlen( $string );
			
			return $length;
			
		}
		
		public function lcfirst ( $string ) {
			
			// lcfirst only exists in php 5.3+
			if ( function_exists( 'lcfirst' ) ) {
				
				$return = lcfirst( $string );
				
			}
			else {
				
				// emulate it
				
				// get the first character
				$first = $this->substr( $string, 0, 1 );
				
				// lowercase it
				$first = $this->strtolower( $first );
				
				// get the rest of the string
				$last = $this->substr( $string, 1 );
				
				// put them back together
				$return = $first . $last;
				
			}
			
			return $return;
			
		}
		
		public function strpos ( $haystack, $needle, $offset = 0 ) {
			
			$pos = strpos( $haystack, $needle, $offset );
			
			return $pos;
			
		}
		
		public function stripos ( $haystack, $needle, $offset = 0 ) {
			
			$pos = stripos( $haystack, $needle, $offset );
			
			return $pos;
			
		}
		
	}

?>
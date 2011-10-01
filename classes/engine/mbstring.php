<?php

	namespace MultiByte;

	class Engine_MBstring extends Engine {
		
		public function detect_encoding ( $string ) {
			
			// get the original detection order
			$old_order = mb_detect_order();
			
			// make sure ISO-8859-1 is included, the default ('auto') is ASCII,JIS,UTF-8,EUC-JP,SJIS
			mb_detect_order( array( 'ASCII', 'JIS', 'UTF-8', 'ISO-8859-1', 'EUC-JP', 'SJIS' ) );
			
			// detect the encoding
			$encoding = mb_detect_encoding( $string );
			
			// set the old order back
			mb_detect_order( $old_order );
			
			return $encoding;
			
		}
		
		public function convert_encoding ( $string, $use_encoding = null, $from_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			if ( $from_encoding == null ) {
				$from_encoding = $this->detect_encoding( $string );
			}
			
			$string = mb_convert_encoding( $string, $encoding, $from_encoding );
			
			return $string;
			
		}
		
		public function strlen ( $string, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			$length = mb_strlen( $string, $encoding );
			
			return $length;
			
		}
		
		public function substr ( $string, $begin, $len = null, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			// if $len is actually null. 0 would count if we didn't ===
			if ( $len === null ) {
				$len = $this->strlen( $string, $encoding ) - $begin;
			}
			
			$substring = mb_substr( $string, $begin, $len, $encoding );
			
			return $substring;
			
		}
		
		public function strpos ( $haystack, $needle, $offset = 0, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			$return = mb_strpos( $haystack, $needle, $offset, $encoding );
			
			return $return;
			
		}
		
		public function stripos ( $haystack, $needle, $offset = 0, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			$return = mb_stripos( $haystack, $needle, $offset, $encoding );
			
			return $return;
			
		}
		
		public function strtolower ( $string, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			$return = mb_strtolower( $string, $encoding );
			
			return $return;
			
		}
		
		public function strtoupper ( $string, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			$return = mb_strtoupper( $string, $encoding );
			
			return $return;
			
		}
		
		/**
		 * Replace all occurrences of the search string with the replacement string.
		 * 
		 * @todo Allow an array to be passed to $subject (and then return an array).
		 * 
		 * @see http://php.net/str_replace
		 * @param mixed $search A string or an array of strings to search for.
		 * @param mixed $replace A string or an array of strings to replace search values with.
		 * @param string $subject The string to perform the search and replace on.
		 * @param int $count If passed, this value will hold the number of matched and replaced needles.
		 * @param string $use_encoding The encoding to be used. If null, the internal encoding will be used.
		 * @return string The subject with replaced values.
		 */
		public function str_replace ( $search, $replace, $subject, &$count = 0, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			// if search is an array and replace is not, we need to make replace an array and pad it to the same number of values as search
			if ( is_array( $search ) && !is_array( $replace ) ) {
				$replace = array_fill( 0, count( $search ), $replace );
			}
			
			// if search is an array and replace is as well, we need to make sure replace has the same number of values - pad it with empty strings
			if ( is_array( $search ) && is_array( $replace ) ) {
				$replace = array_pad( $replace, count( $search ), '' );
			}
			
			// if search is not an array, make it one
			if ( !is_array( $search ) ) {
				$search = array( $search );
			}
			
			// if replace is not an array, make it one
			if ( !is_array( $replace ) ) {
				$replace = array( $replace );
			}
						
			
			
			$search_count = count( $search );	// we modify $search, so we can't include it in the condition next
			for ( $i = 0; $i < $search_count; $i++ ) {
				
				// the values we'll match
				$s = array_shift( $search );
				$r = array_shift( $replace );
				
				// while the search still exists in the subject
				while ( $this->strpos( $subject, $s, 0, $encoding ) !== false ) {
					
					// find the position
					$pos = $this->strpos( $subject, $s, 0, $encoding );
					
					// pull out the part before the string
					$before = $this->substr( $subject, 0, $pos, $encoding );
					
					// and the part after
					$after = $this->substr( $subject, $pos + $this->strlen( $s, $encoding ), null, $encoding );
					
					// now we have the string in two parts without the string we're searching for
					// put it back together with the replacement!
					$subject = $before . $r . $after;
					
					// increment our count, a replacement was made
					$count++;
					
				}
				
			}
			
			return $subject;
			
		}
		
		/**
		 * Replace all occurrences of the search string with the replacement string.
		 * 
		 * @todo Allow an array to be passed to $subject (and then return an array).
		 * 
		 * @see http://php.net/str_ireplace
		 * @param mixed $search A string or an array of strings to search for.
		 * @param mixed $replace A string or an array of strings to replace search values with.
		 * @param string $subject The string to perform the search and replace on.
		 * @param int $count If passed, this value will hold the number of matched and replaced needles.
		 * @param string $use_encoding The encoding to be used. If null, the internal encoding will be used.
		 * @return string The subject with replaced values.
		 */
		public function str_ireplace ( $search, $replace, $subject, &$count = 0, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			// if search is an array and replace is not, we need to make replace an array and pad it to the same number of values as search
			if ( is_array( $search ) && !is_array( $replace ) ) {
				$replace = array_fill( 0, count( $search ), $replace );
			}
			
			// if search is an array and replace is as well, we need to make sure replace has the same number of values - pad it with empty strings
			if ( is_array( $search ) && is_array( $replace ) ) {
				$replace = array_pad( $replace, count( $search ), '' );
			}
			
			// if search is not an array, make it one
			if ( !is_array( $search ) ) {
				$search = array( $search );
			}
			
			// if replace is not an array, make it one
			if ( !is_array( $replace ) ) {
				$replace = array( $replace );
			}
						
			
			
			$search_count = count( $search );	// we modify $search, so we can't include it in the condition next
			for ( $i = 0; $i < $search_count; $i++ ) {
				
				// the values we'll match
				$s = array_shift( $search );
				$r = array_shift( $replace );
				
				// while the lowercase search still exists in the lowercase subject
				while ( $this->strpos( $this->strtolower( $subject, $encoding ), $this->strtolower( $s, $encoding ), 0, $encoding ) !== false ) {
					
					// find the position
					$pos = $this->strpos( $this->strtolower( $subject, $encoding ), $this->strtolower( $s, $encoding ), 0, $encoding );
					
					// pull out the part before the string
					$before = $this->substr( $subject, 0, $pos, $encoding );
					
					// and the part after
					$after = $this->substr( $subject, $pos + $this->strlen( $s, $encoding ), null, $encoding );
					
					// now we have the string in two parts without the string we're searching for
					// put it back together with the replacement!
					$subject = $before . $r . $after;
					
					// increment our count, a replacement was made
					$count++;
					
				}
				
			}
			
			return $subject;
			
		}
		
		/**
		 * Uppercase the first character of each word in a string.
		 * 
		 * From php.net/ucwords:
		 * 	The definition of a word is any string of characters that is immediately after a whitespace
		 * 	(These are: space, form-feed, newline, carriage return, horizontal tab, and vertical tab).
		 * 
		 * @see http://php.net/ucwords
		 * @param string $string The input string.
		 * @param string $use_encoding The encoding to be used. If null, the internal encoding will be used.
		 * @return string The modified string.
		 */
		public function ucwords ( $string, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			$delimiters = array(
				chr( 32 ),	// space
				chr( 12 ),	// form-feed
				chr( 10 ),	// newline
				chr( 13 ),	// carriage return
				chr( 9 ),	// horizontal tab
				chr( 11 ),	// vertical tab
			);
			
			// loop through the delimiters and explode the string by each one
			foreach ( $delimiters as $d ) {
				
				$pieces = explode( $d, $string );
				
				for ( $i = 0; $i < count( $pieces ); $i++ ) {
					
					// capitalize each word
					$pieces[ $i ] = $this->ucfirst( $pieces[ $i ], $encoding );
					
				}
				
				// put the string back together
				$string = implode( $d, $pieces );
				
			}
			
			return $string;
		}
		
		/**
		 * Makes a string's first character uppercase
		 * 
		 * @see http://php.net/ucfirst
		 * @param string $string The string to capitalize.
		 * @param string $use_encoding The encoding to be used. If null, the internal encoding will be used.
		 * @return string The capitalized string.
		 */
		public function ucfirst ( $string, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			// get the first character
			$first = $this->substr( $string, 0, 1, $encoding );
			
			// uppercase it
			$first = $this->strtoupper( $first, $encoding );
			
			// get the rest of the characters
			$last = $this->substr( $string, 1, null, $encoding );
			
			// put them back together
			$return = $first . $last;
			
			return $return;
			
		}
		
		/**
		 * Makes a string's first character lowercase
		 * 
		 * @see http://php.net/ucfirst
		 * @param string $string The string to lowercase.
		 * @param string $use_encoding The encoding to be used. If null, the internal encoding will be used.
		 * @return string The lowercased string.
		 */
		public function lcfirst ( $string, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			// get the first character
			$first = $this->substr( $string, 0, 1, $encoding );
			
			// lowercase it
			$first = $this->strtolower( $first, $encoding );
			
			// get the rest
			$last = $this->substr( $string, 1, null, $encoding );
			
			// put them back together
			$return = $first . $last;
			
			return $return;
			
		}
		
		public function trim ( $string, $charlist = null, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
						
			$string = $this->ltrim( $string, $charlist, $use_encoding );
			$string = $this->rtrim( $string, $charlist, $use_encoding );
			
			return $string;
			
		}
		
		public function ltrim ( $string, $charlist = null, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			// parse out the charlist into an array, expanding any ranges or returning the default set
			$charlist = $this->trim_parse_charlist( $charlist, $encoding );
			
			if ( $charlist === false ) {
				return $string;
			}
			
			// while the first character is in our array of characters to remove
			while ( in_array( $this->substr( $string, 0, 1, $encoding ), $charlist ) ) {
				
				// trim off the first character
				$string = $this->substr( $string, 1, null, $encoding );
				
			}
			
			return $string;
			
		}
		
		public function rtrim ( $string, $charlist = null, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			// parse out the charlist into an array, expanding any ranges or returning the default set
			$charlist = $this->trim_parse_charlist( $charlist, $encoding );
			
			if ( $charlist === false ) {
				return $string;
			}
			
			// while the last character is in our array of characters to remove
			while ( in_array( $this->substr( $string, -1, null, $encoding ), $charlist ) ) {
				
				// trim off the last character
				$string = $this->substr( $string, 0, -1, $encoding );
				
			}
			
			return $string;
			
		}
		
		private function trim_parse_charlist ( $charlist = null, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
						
			$default_charlist = array(
				chr( 32 ),		// space
				chr( 9 ),		// horizontal tab
				chr( 10 ),		// newline
				chr( 13 ),		// carriage return
				chr( 0 ),		// NUL-byte
				chr( 11 ),		// vertical tab
			);
			
			// if no charlist was sent in, just return the default array
			if ( $charlist == null ) {
				return $default_charlist;
			}
			
			// if there's a .. in it we need to do some parsing first
			if ( $this->strpos( $charlist, '..', 0, $encoding ) !== false ) {
				
				// the number of chars we replace - we don't really care
				$count = 0;
				
				while ( $this->strpos( $charlist, '..', 0, $encoding ) !== false ) {
					
					$pos = $this->strpos( $charlist, '..', 0, $encoding );
					
					// get the character before and the character after - after is +2 because it's a 2-char string we matched
					$from = $this->substr( $charlist, $pos - 1, 1, $encoding );
					$to = $this->substr( $charlist, $pos + 2, 1, $encoding );
					
					// if the range is reversed, throw an error
					if ( ord( $to ) < ord( $from ) ) {
						trigger_error( 'Invalid \'..\'-range, \'..\'-range needs to be incrementing', E_USER_WARNING );
						
						// return false to tell the parent function to bail
						return false;
					}
					
					// loop to get all the characters in between
					$gap = array();
					for ( $i = ord( $from ); $i <= ord( $to ); $i++ ) {
						$gap[] = chr( $i );
					}
					
					// stringify it
					$gap = implode( '', $gap );
					
					// the string we're replacing includes from and to and the ..
					$search = $from . '..' . $to;
										
					// the string we're replacing with is the gap - this includes the from and to
					
					$charlist = $this->str_replace( $search, $gap, $charlist, $count, $encoding );
					
				}
				
			}
			
			// parse the list into an array
			$chars = array();
			for ( $i = 0; $i < $this->strlen( $charlist, $encoding ); $i++ ) {
				
				// get the char
				$char = $this->substr( $charlist, $i, 1, $encoding );
				
				// add it to the stack
				$chars[] = $char;
				
			}
			
			// and return the stack of chars
			return $chars;
			
		}
		
		public function strrev ( $string, $use_encoding = null ) {
			
			$encoding = $this->encoding( $use_encoding );
			
			// split the chars out into an array
			$chars = array();
			for ( $i = 0; $i < $this->strlen( $string, $encoding ); $i++ ) {
				
				// get the char
				$char = $this->substr( $string, $i, 1, $encoding );
				
				// add it to the stack
				$chars[] = $char;
				
			}
			
			// reverse it
			$chars = array_reverse( $chars );
			
			// and implode it
			$string = implode( '', $chars );
			
			return $string;
			
		}
		
	}

?>
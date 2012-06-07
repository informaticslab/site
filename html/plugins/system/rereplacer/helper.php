<?php
/**
 * Plugin Helper File
 *
 * @package     ReReplacer
 * @version     2.11.0a
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* Plugin that replaces stuff
*/
class plgSystemReReplacerHelper
{
	function plgSystemReReplacerHelper( &$config )
	{
		// Load plugin parameters
		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'parameters.php';
		$this->parameters =& NNePparameters::getParameters();
		$this->params = $this->parameters->getParams( $config['params'], JPATH_PLUGINS.DS.$config['type'].DS.$config['name'].'.xml' );

		$this->params->protect_start = '<!-- START: RR_PROTECT -->';
		$this->params->protect_end = '<!-- END: RR_PROTECT -->';

		$this->params->counter = array();

		require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'assignments.php';
		$this->params->assignments = new NoNumberElementsAssignmentsHelper;
		$this->params->user =& JFactory::getUser();

		$this->article_items = 0;
	}

////////////////////////////////////////////////////////////////////
// ARTICLES
////////////////////////////////////////////////////////////////////

	function replaceInArticles ( &$article )
	{
		if ( !$this->article_items ) {
			$this->article_items = $this->getItems( 'articles' );
		}
		$items = $this->article_items;
		$items = $this->filterItems( $items, $article );

		foreach ( $items as $item ) {
			if ( isset( $article->text ) ) {
				$this->replace( $article->text, $item );
			}
			if ( isset( $article->description ) ) {
				$this->replace( $article->description, $item );
			}
			if ( isset( $article->title ) && $item->enable_in_title ) {
				$this->replace( $article->title, $item );
			}
			if ( isset( $article->author ) && $item->enable_in_author ) {
				if ( isset( $article->author->name ) ) {
					$this->replace( $article->author->name, $item );
				} else if ( is_string( $article->author ) ) {
					$this->replace( $article->author, $item );
				}
			}
		}
	}

////////////////////////////////////////////////////////////////////
// COMPONENTS
////////////////////////////////////////////////////////////////////

	function replaceInComponents()
	{
		$document	=& JFactory::getDocument();
		$docType = $document->getType();

		// FEED
		if ( $docType == 'feed' && isset( $document->items ) ) {
			for ( $i = 0; $i < count( $document->items ); $i++ ) {
				$this->replaceInArticles( $document->items[$i] );
			}
		}

		unset( $this->article_items );

		if ( isset( $document->_buffer ) ) {
			$this->tagArea( $document->_buffer, 'RR', 'component' );
		}

		// PDF
		if ( $docType == 'pdf' ) {
			if ( isset( $document->_header ) ) {
				$this->replaceInTheRest( $document->_header );
				$this->cleanLeftoverJunk( $document->_header );
			}
			if ( isset( $document->title ) ) {
				$this->replaceInTheRest( $document->title );
				$this->cleanLeftoverJunk( $document->title );
			}
			if ( isset( $document->_buffer ) ) {
				$this->replaceInTheRest( $document->_buffer );
				$this->cleanLeftoverJunk( $document->_buffer );
			}
		}
	}

////////////////////////////////////////////////////////////////////
// OTHER AREAS
////////////////////////////////////////////////////////////////////
	function replaceInOtherAreas()
	{
		$document	=& JFactory::getDocument();
		$docType = $document->getType();

		// not in pdf's
		if ( $docType == 'pdf' ) { return; }

		$html = JResponse::getBody();
		$this->replaceInTheRest( $html );

		$this->cleanLeftoverJunk( $html );

		JResponse::setBody( $html );
	}

	function replaceInTheRest( &$str )
	{
		if ( $str == '' ) { return; }

		$document	=& JFactory::getDocument();
		$docType = $document->getType();

		// COMPONENT
		$items = $this->getItems( 'component' );
		if ( !empty( $items ) ) {
			if ( $docType == 'feed' ) {
				$s = '#(<item[^>]*>)#s';
				$str = preg_replace( $s, '\1<!-- START: RR_COMPONENT -->', $str );
				$str = str_replace( '</item>', '<!-- END: RR_COMPONENT --></item>', $str );
			}
			if ( strpos( $str, '<!-- START: RR_COMPONENT -->' ) === false ) {
				$this->tagArea( $str, 'RR', 'component' );
			}
			$components = $this->getTagArea( $str, 'RR', 'component' );
			foreach( $components as $component ) {
				foreach ( $items as $item ) {
					$this->replace( $component['1'], $item );
				}
				$str = str_replace( $component['0'], $component['1'], $str );
			}
			unset( $components );
		}

		// BODY

		$items = $this->getItems( 'body' );
		if ( !empty( $items ) ) {
			if ( !( strpos( $str, '</body>' ) === false ) ) {
				$s = '#(<body[^>]*>)#s';
				$str = preg_replace( $s, '\1<!-- START: RR_BODY -->', $str );
				$str = str_replace( '</body>', '<!-- END: RR_BODY --></item>', $str );
			}
			if ( strpos( $str, '<!-- START: RR_BODY -->' ) === false ) {
				$s = '#(<item[^>]*>)#s';
				$str = preg_replace( $s, '\1<!-- START: RR_BODY -->', $str );
				$str = str_replace( '</item>', '<!-- END: RR_BODY --></body>', $str );
			}
			if ( strpos( $str, '<!-- START: RR_BODY -->' ) === false ) {
				$this->tagArea( $str, 'RR', 'body' );
			}
			$bodies =  $this->getTagArea( $str, 'RR', 'body' );
			foreach( $bodies as $body ) {
				foreach ( $items as $item ) {
					$this->replace( $body['1'], $item );
				}
				$str = str_replace( $body['0'], $body['1'], $str );
			}
			unset( $bodies );
		}

		// EVERYWHERE
		$items = $this->getItems( 'everywhere' );
		if ( !empty( $items ) ) {
			foreach ( $items as $item ) {
				$this->replace( $str, $item );
			}
		}
	}

	function tagArea( &$str, $ext = 'EXT', $area = '' )
	{
		if ( $area ) {
			if ( is_array( $str ) ) {
				foreach ( $str as $key => $val ) {
					$this->tagArea( $val, $ext, $area );
					$str[ $key ] = $val;
				}
			} else if ( $str ) {
				$str = '<!-- START: '.strtoupper( $ext ).'_'.strtoupper( $area ).' -->'.$str.'<!-- END: '.strtoupper( $ext ).'_'.strtoupper( $area ).' -->';
				if ( $area == 'article_text' ) {
					$str = preg_replace( '#(<hr class="system-pagebreak".*?/>)#si', '<!-- END: '.strtoupper( $ext ).'_'.strtoupper( $area ).' -->\1<!-- START: '.strtoupper( $ext ).'_'.strtoupper( $area ).' -->', $str );
				}
			}
		}
	}

	function getTagArea( &$str, $ext = 'EXT', $area = '' )
	{
		$matches = array();
		if ( $str && $area ) {
			$start = '<!-- START: '.strtoupper( $ext ).'_'.strtoupper( $area ).' -->';
			$end = '<!-- END: '.strtoupper( $ext ).'_'.strtoupper( $area ).' -->';
			$matches = explode( $start, $str );
			array_shift( $matches );
			foreach ( $matches as $i => $match ) {
				list( $text, $post ) = explode( $end, $match, 2 );
				$matches[$i] = array(
					$start.$text.$end,
					$text
				);
			}
		}
		return $matches;
	}

	function replace( &$str, &$item )
	{
		if ( is_array( $str ) ) {
			foreach ( $str as $key => $val ) {
				$str[$key] = $this->replaceReturn( $val, $item );
			}
		} else {
			$this->protectVariables( $str );
			if ( $item->regex ) {
				$this->replaceRegEx( $str, $item );
			} else {
				$this->replaceString( $str, $item );
			}
			$this->replaceVariables( $str );
		}
	}
	function replaceReturn( $str, &$item )
	{
		$this->replace( $str, $item );
		return $str;
	}

	function replaceRegEx( &$str, &$item )
	{
		$str = str_replace( chr( 194 ).chr( 160 ), ' ', $str );
		$str_array = $this->stringToProtectedArray( $str, $item );

		$search = $item->search;
		$this->cleanString( $search );
		$search = '#'.$search.'#';
		if ( $item->s_modifier ) { $search .= 's'; } // . (dot) also matches newlines
		if ( !$item->casesensitive ) { $search .= 'i'; } // case-insensitive pattern matching

		$replace = $item->replace;
		$this->cleanStringReplace( $replace, 1 );
		$this->replaceInArray( $str_array, $search, $replace, $item->thorough );

		$str = implode( '', $str_array );
	}

	function replaceString( &$str, &$item )
	{
		$str_array = $this->stringToProtectedArray( $str, $item );

		$search_array = explode( ',', $item->search );
		$replace_array = explode( ',', $item->replace );
		$replace_count = count( $replace_array );

		foreach ( $search_array as $key => $search ) {
			if ( $search != '' ) {
				$this->cleanString( $search );
				$search = preg_quote( $search, "#" );
				if ( $item->word_search ) {
					$search = '(?<![a-zA-Z])('.$search.')(?![a-zA-Z])';
				}

				$search = '#'.$search.'#';
				$search .= 's'; // . (dot) also matches newlines
				if ( !$item->casesensitive ) { $search .= 'i'; } // case-insensitive pattern matching

				$replace = ( $replace_count > $key ) ? $replace_array[$key] : $replace_array['0'];
				$this->cleanStringReplace( $replace );

				$this->replaceInArray( $str_array, $search, $replace, $item->thorough );
			}
		}

		$str = implode( '', $str_array );
	}

	function replaceInArray( &$array, $search, $replace, $thorough = 0 )
	{
		foreach ( $array as $key => $val ) {
			// only do something if string is not empty
			// or on uneven count = not yet protected
			if ( trim( $val ) != '' && !fmod( $key, 2 ) ) {
				$this->replacer( $array[$key], $search, $replace, $thorough );
			}
		}
	}

	function replacer( &$str, $search, $replace, $thorough = 0 )
	{
		if ( @preg_match( $search.'u', $str ) ) {
			$search .= 'u';
		}
		if ( preg_match( $search, $str ) ) {
			// Counter is used to make it possible to use \# in the replacement to refer to the incremental counter
			$counter_name = base64_encode( $search.$replace );
			if ( !isset( $this->params->counter[$counter_name] ) ) { $this->params->counter[$counter_name] = 0; }

			$offset = 0;
			$thorough_count = 1; // prevents the thorough search to repeat endlessly

			while ( preg_match( $search, $str, $matches, PREG_OFFSET_CAPTURE, $offset ) ) {
				$match = $matches['0'];
				// Replace \# with the incremental counter
				$replace_c = str_replace( array( '\#', '[[counter]]' ), ++$this->params->counter[$counter_name], $replace );

				if ( !$thorough || $thorough_count == 1 ) {
					$prev_str_length = strlen( $str );
					$match_length = strlen( $match['0'] );
					$match_offset = $match['1'];
				}

				$str_part1 = substr( $str, 0, $offset );
				$str_part2 = substr( $str, $offset );
				$str = $str_part1.preg_replace( $search, $replace_c, $str_part2, 1 );
				$thorough_count++;

				if ( !$thorough || $thorough_count >= 100 ) {
					$offset = $match_offset + $match_length + ( strlen( $str ) - $prev_str_length );
					$thorough_count = 1;
					$prev_str_length = strlen( $str );
				}
			}
		}
	}

	function protect( $str, $protect = 1 )
	{
		if ( !$protect ) {
			return $this->params->protect_end.$str.$this->params->protect_start;
		} else {
			return $this->params->protect_start.$str.$this->params->protect_end;
		}
	}

	function stringToProtectedArray( $str, &$item, $onlyform = 0 )
	{
		$str_array = array( $str );

		$option = JRequest::getCmd( 'option' );
		if (	JRequest::getCmd( 'task' ) == 'edit'
			||	JRequest::getCmd( 'layout' ) == 'form'
			||	JRequest::getCmd( 'layout' ) == 'write'
			||	$option == 'com_contentsubmit'
			||	$option == 'com_rereplacer'
		) {
			// Protect complete adminForm (to prevent ReReplacer messing stuff up when editing articles and such)
			$s = '(<form [^>]*(id|name)="adminForm".*?</form>)';
			// Protect search result
			$this->arrayProtectByRegex( $str_array, $s, '', 1 );
		}

		if ( $onlyform ) {
			return $str_array;
		}

		// Protect everything between the {noreplace} tags
		$s = '(\{noreplace\}.*?\{/noreplace\})';
		// Protect search result
		$this->arrayProtectByRegex( $str_array, $s, '', 1 );

		// Protect everything outside the between tags
		if ( $item->between_start && $item->between_end ) {
			$s = '(?<='.preg_quote( $item->between_start, "#" ).')(.*?)(?='.preg_quote( $item->between_end, "#" ).')';
			// Protect everything but search result
			$this->arrayProtectByRegex( $str_array, $s, '', 0 );
		}

		// Protect all tags or everyting but tags
		if ( $item->enable_tags == 0 || $item->enable_tags == 2 ) {
			$s = '(</?[a-zA-Z][^>]*>)';
			if ( $item->enable_tags == 0 ) {
				// no search permitted in tags, so all tags are protected
				// Protect search result
				$this->arrayProtectByRegex( $str_array, $s, '', 1 );
				return $str_array;
			} else {
				// search only permitted in tags, so everything outside the tags is protected
				// Protect everything but search result
				$this->arrayProtectByRegex( $str_array, $s, '', 0 );
			}
		}

		// removes unwanted whitespace from tag selection
		$item->tagselect = preg_replace( '#\s*(\[|\])\s*#', '\1', $item->tagselect );
		// removes unwanted params from tag selection
		// (if a asterisk is set, all other params for that tag name are redundant)
		$item->tagselect = preg_replace( '#\[[^\]]*?\*[^\]]*\]#', '[*]', $item->tagselect );

		// tag selection is not used (or tags selection permits all tags)
		if ( !$item->limit_tagselect || !(strpos( $item->tagselect, '*[*]' ) === false) ) {
			return $str_array;
		}

		// Convert tag selection to a nested array with trimmed tag names and params
		$tagselect = explode( ']', $item->tagselect );

		$search_tags = array();
		foreach ( $tagselect as $tag ) {
			if ( strlen( $tag ) ) {
				$tag_parts = explode( '[', $tag );
				$tag_name = trim( $tag_parts['0'] );
				$tag_params = array();
				if ( count( $tag_parts ) > 1 ) {
					$tag_params = $tag_parts['1'];
					// Trim and remove empty values
					$tag_params = array_diff( array_map( 'trim', explode( ',', $tag_params ) ), array( '' ) );
					if ( in_array( '*', $tag_params ) ) {
						// Make array empty if asterisk is found
						// (the whole tag should be allowed)
						$tag_params = array();
					}
				}
				$search_tags[$tag_name] = $tag_params;
			}
		}

		// Tag selection is empty
		if ( !count( $search_tags ) ) {
			return $str_array;
		}

		$this->arrayProtectByTags( $str_array, $search_tags );

		return $str_array;
	}

	function arrayProtectByRegex( &$array, $search = '', $replace = '', $protect = 1, $convert = 1 )
	{
		$search = '#'.$search.'#si';
		if ( !$replace ) {
			$replace = '\1';
		}

		$is_array = is_array( $array );
		if ( !$is_array ) {
			$array = array( $array );
		}

		foreach ( $array as $key => $val ) {
			// only do something if string is not empty
			// or on uneven count = not yet protected
			if ( trim( $val ) != '' && !fmod( $key, 2 ) ) {
				$s = $search;
				if ( @preg_match( $search.'u', $val ) ) {
					$s = $search.'u';
				}
				if ( preg_match( $s, $val ) ) {
					if ( $protect ) {
						$val = preg_replace( $s, $this->protect( $replace ), $val );
					} else {
						$val = $this->protect( preg_replace( $s, $this->protect( $replace, 0 ), $val ) );
					}
				}
				$this->cleanProtected( $val );
				$array[$key] = $val;
			}
		}

		if ( !$is_array ) {
			$array = $array['0'];
		}

		if ( $convert ) {
			$array = $this->arrayProtect( $array );
		}
	}

	function arrayProtectByTags( &$array, &$tags, $convert = 1 )
	{
		foreach ( $array as $key => $val ) {
			// only do something if string is not empty
			// or on uneven count = not yet protected
			if ( trim( $val ) != '' && !fmod( $key, 2 ) ) {

				// First: protect all tags
				$s = '(</?[a-zA-Z][^>]*>)';
				$this->arrayProtectByRegex( $val, $s, '', 1, 0 );

				foreach ( $tags as $tag_name => $tag_params ) {
					if ( $tag_name == '*' ) {
						$tag_name = '[a-zA-Z][^> ]*';
					}
					if ( count( $tag_params ) ) {
						// only unprotect the parameter values
						foreach ( $tag_params as $tag_param ) {
							$s = '(<'.$tag_name.' [^>]*'.$tag_param.'=")([^"]*)("[^>]*>)';
							$s = '#'.$s.'#si';
							if ( @preg_match( $s.'u', $val ) ) {
								$s .= 'u';
							}
							if ( preg_match( $s, $val ) ) {
								$replace = '\1'.$this->protect( '\2', 0 ).'\3';
								$val = preg_replace( $s, $replace, $val );
							}
							$this->cleanProtected( $val );
						}

					} else {
						// unprotect the whole tag
						$s = '(</?'.$tag_name.'( [^>]*)?>)';
						$this->arrayProtectByRegex( $val, $this->protect( $s, 0 ), '', 1, 0 );
					}
				}
				$array[$key] = $val;
			}
		}

		if ( $convert ) {
			$array = $this->arrayProtect( $array );
		}
	}

	function cleanProtect( &$str )
	{
		$str = str_replace( array( $this->params->protect_start, $this->params->protect_end ), '', $str );

	}
	function cleanLeftoverJunk( &$str )
	{
		$str = preg_replace( '#<\!-- (START|END): RR_[^>]* -->#', '', $str );
		$this->cleanProtect( $str );

		// Remove any leftover protection strings (shouldn't be necessary, but just in case)
		$this->cleanProtect( $str );

		// Remove any leftover protection tags
		if ( !( strpos( $str, '{noreplace}' ) === false ) ) {
			$item = null;
			$str_array = $this->stringToProtectedArray( $str, $item, 1 );
			$this->replaceInArray( $str_array, '#\{noreplace\}#', '' );
			$this->replaceInArray( $str_array, '#\{/noreplace\}#', '' );
			$str = implode( '', $str_array );
		}
	}

	function cleanProtected( &$str )
	{
		while ( !( strpos( $str, $this->params->protect_start.$this->params->protect_start ) === false ) ) {
			$str = str_replace( $this->params->protect_start.$this->params->protect_start, $this->params->protect_start, $str );
		}
		while ( !( strpos( $str, $this->params->protect_end.$this->params->protect_end ) === false ) ) {
			$str = str_replace( $this->params->protect_end.$this->params->protect_end, $this->params->protect_end, $str );
		}
		while ( !( strpos( $str, $this->params->protect_end.$this->params->protect_start ) === false ) ) {
			$str = str_replace( $this->params->protect_end.$this->params->protect_start, '', $str );
		}

	}

	function arrayProtect( $array )
	{
		$new_array = array();

		foreach ( $array as $key => $val ) {
			// only do something if string is not empty
			// and is uneven count = not yet protected
			// and has protect start string
			if ( fmod( $key, 2 ) ) {
				// string is already protected
				$item_array = $this->protectStringToArray( $val, 1 );
			} else {
				// string is not yet protected
				$item_array = $this->protectStringToArray( $val );
			}
			foreach ( $item_array as $item_array_item ) {
				$new_array[] = $item_array_item;
			}
		}
		return $new_array;
	}

	function protectStringToArray( $str, $protected = 0 )
	{
		if ( $protected ) {
			// If already protected, just clean string and place in an array
			$this->cleanProtect( $str );
			$array = array ( $str );
		} else {
			// Return an array with 1 or 3 items.
			// 1) first part to protector start (if found) (= unprotected)
			// 2) part between the first protector start and its matching end (= protected)
			// 3) Rest of the string (= unprotected)

			$array = array();
			// Devide sting on protector start
			$str_array = explode( $this->params->protect_start, $str );
			// Add first element to the string ( = even = unprotected)
			$this->cleanProtect( $str_array['0'] );
			$array[] = $str_array['0'];

			$count = count( $str_array );
			if ( $count > 1 ) {
				for ( $i = 1; $i < $count; $i++ ) {
					$substr = $str_array[$i];
					$protect_count = 1;

					// Add the next string if not enough protector ends are found
					while (
						substr_count( $substr, $this->params->protect_end ) < $protect_count &&
						$i < ( $count - 1 )
					) {
						$protect_count++;
						$substr .= $str_array[++$i];
					}

					// Devide sting on protector end
					$substr_array = explode( $this->params->protect_end, $substr );

					$protect_part = '';
					// Add as many parts to the string as there are protector starts
					for ( $protect_i = 0; $protect_i < $protect_count; $protect_i++ ) {
						$protect_part .= array_shift( $substr_array );
						if ( !count( $substr_array ) ) {
							break;
						}
					}

					// This part is protected (uneven)
					$this->cleanProtect( $protect_part );
					$array[] = $protect_part;

					// The rest of the string is unprotected (even)
					$unprotect_part = implode( '', $substr_array );
					$this->cleanProtect( $unprotect_part );
					$array[] = $unprotect_part;
				}
			}
		}
		return $array;
	}

	function cleanString( &$str )
	{
		$str = str_replace( array( '[:space:]', '\[\:space\:\]', '[[space]]', '\[\[space\]\]' ), ' ', $str );
		$str = str_replace( array( '[:comma:]', '\[\:comma\:\]', '[[comma]]', '\[\[comma\]\]' ), ',', $str );
		$str = str_replace( array( '[:newline:]', '\[\:newline\:\]', '[[newline]]', '\[\[newline\]\]' ), "\n", $str );
		$str = str_replace( '[:REGEX_ENTER:]', '\\n', $str );
	}
	function cleanStringReplace( &$str, $is_regex = 0 )
	{
		if ( !$is_regex ) {
			$str = str_replace( '\\', '\\\\', $str );
			$str = str_replace( '\\\\#', '\\#', $str );
			$str = str_replace( '$', '\\$', $str );
		}
		$this->cleanString( $str );
	}

	function protectVariables( &$str )
	{
		$str = str_replace( array( '[[random:', '[[user:', '[[date:' ), array( '[[xrandom:', '[[xuser:', '[[xdate:' ), $str );
	}

	function replaceVariables( &$str )
	{
		if ( !( strpos( $str, '[[random' ) === false ) ) {
			while ( preg_match( '#\[\[random\:([0-9]+)-([0-9]+)\]\]#', $str, $match ) ) {
				$search = '#'.preg_quote( $match['0'], "#" ).'#';
				$replace = rand( (int) $match['1'], (int) $match['2'] );
				$str = preg_replace( $search, $replace, $str, 1 );
			}
		}
		if ( !( strpos( $str, '[[user' ) === false ) ) {
			if ( $this->params->user->id ) {
				$str = str_replace( '[[user:id]]', $this->params->user->id, $str );
				$str = str_replace( '[[user:username]]', $this->params->user->username, $str );
				$str = str_replace( '[[user:name]]', $this->params->user->name, $str );
			} else {
				$str = str_replace( '[[user:id]]', '', $str );
				$str = str_replace( '[[user:username]]', '', $str );
				$str = str_replace( '[[user:name]]', '', $str );
			}
		}
		if ( !( strpos( $str, '[[date' ) === false ) ) {
			if ( preg_match_all( '#\[\[date\:([^\]]+)\]\]#', $str, $matches, PREG_SET_ORDER ) > 0 ) {
				foreach ( $matches as $match ) {
					$replace = JHTML::_( 'date', time(), $match['1'] );
					$str = str_replace( $match['0'], $replace, $str );
				}
			}
		}
		$str = str_replace( array( '[[xrandom:', '[[xuser:', '[[xdate:' ), array( '[[random:', '[[user:', '[[date:' ), $str );
	}

	function getItems( $area = 'articles' )
	{
		$db =& JFactory::getDBO();
		$query = "SELECT CONCAT( 'search=', `search`, '\nreplace=', `replace`, '\narea=', `area`, '\n', `params` ) FROM #__rereplacer"
			.' WHERE published = 1'
			.' AND area = '.$db->quote( $area )
			.' ORDER BY ordering, id'
			;
		$db->setQuery( $query );
		$rows = $db->loadResultArray();

		$items = array();

		if ( !is_array( $rows ) ) {
			return $items;
		}

		$xmlfile = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rereplacer'.DS.'item_params.xml';
		jimport( 'joomla.filesystem.file' );

		foreach ( $rows as $params ) {
			$params = $this->parameters->getParams( $params, $xmlfile );

			if ( !$params->use_xml || !$params->view_state == 2 ) {
				if ( strlen( $params->search ) < 3 ) {
					continue;
				}
			}

			foreach ( $params as $key => $val ) {
				$params->$key = html_entity_decoder( stripslashes( $val ) );
			}

			$item = 0;

			if ( $params->use_xml && $params->view_state == 2 ) {
				if ( $params->xml != '' ) {
					$file = str_replace( DS.DS, DS, JPATH_SITE.DS.str_replace( array( '\\', '/' ), DS, $params->xml ) );
					if ( JFile::exists( $file ) ) {
						$xml =& JFactory::getXMLParser('Simple');
						$xml->loadFile($file);
						if ( isset( $xml->document ) && isset( $xml->document->_children ) ) {
							$xml_items = $this->parameters->getObjectFromXML( $xml->document->_children );
							if ( isset( $xml_items->items ) && isset( $xml_items->items->item ) ) {
								if ( !is_array( $xml_items->items->item ) ) {
									$xml_items->items->item = array( $xml_items->items->item );
								}
								foreach( $xml_items->items->item as $item ) {
									if ( isset( $item->search ) && isset( $item->replace ) ) {
										$p = clone( $params );
										$p->search = $item->search;
										$p->replace = $item->replace;
										if ( isset( $item->params ) ) {
											foreach ( $item->params as $key => $val ) {
												$p->$key = $val;
											}
										}
										$item = $p;
									}
								}
							}
						}
					}
				}
			} else {
				$item = $params;
			}

			if ( $item ) {
				$items[] = $item;
			}
		}

		if ( $area != 'articles' ) {
			$items = $this->filterItems( $items );
		}

		return $items;
	}

	function filterItems( $items, $article = 0 )
	{
		$mainframe =& JFactory::getApplication();

		$document =& JFactory::getDocument();
		$docType = $document->getType();

		$newitems = array();
		foreach ( $items as $item ) {
			if (
				( $mainframe->isAdmin() && $item->enable_in_admin == 0 ) ||
				( $mainframe->isSite() && $item->enable_in_admin == 2 ) ||
				( $docType == 'feed' && $item->enable_in_feeds == 0 ) ||
				( $docType != 'feed' && $item->enable_in_feeds == 2 )
			) {
				continue;
			}

			$item = $this->itemPass( $item, $article );
			if ( $item ) {
				$newitems[] = $item;
			}
		}
		return $newitems;
	}

	function itemPass( $item, $article = 0 )
	{
		jimport( 'joomla.filesystem.file' );

		$params = array();
		if ( $item->assignto_menuitems ) {
			$params['MenuItem'] = null;
			$params['MenuItem']->assignment = $item->assignto_menuitems;
			$params['MenuItem']->selection = $item->assignto_menuitems_selection;
			$params['MenuItem']->params = null;
			$params['MenuItem']->params->inc_children = $item->assignto_menuitems_inc_children;
			$params['MenuItem']->params->inc_noItemid = $item->assignto_menuitems_inc_noitemid;
		}
		if ( $item->assignto_urls ) {
			$params['URL'] = null;
			$params['URL']->assignment = $item->assignto_urls;

			$config =& JFactory::getConfig();
			if ( $config->getValue('config.sef') == 1 ) {
				$params['URL']->selection = $item->assignto_urls_selection_sef;
			} else {
				$params['URL']->selection = $item->assignto_urls_selection;
			}
			$params['URL']->selection = str_replace( '\n', "\n", $params['URL']->selection );
			$params['URL']->selection = str_replace( '[:REGEX_ENTER:]', '\n', $params['URL']->selection );
			$params['URL']->selection = explode( "\n", $params['URL']->selection );
		}
		if ( $item->assignto_browsers ) {
			$params['Browsers'] = null;
			$params['Browsers']->assignment = $item->assignto_browsers;
			$params['Browsers']->selection = $item->assignto_browsers_selection;
		}
		if ( $item->assignto_date ) {
			$params['Date'] = null;
			$params['Date']->assignment = $item->assignto_date;
			$params['Date']->params = null;
			$params['Date']->params->publish_up = $item->assignto_date_publish_up;
			$params['Date']->params->publish_down = $item->assignto_date_publish_down;
		}
		if ( $item->assignto_usergrouplevels ) {
			$params['UserGroupLevels'] = null;
			$params['UserGroupLevels']->assignment = $item->assignto_usergrouplevels;
			$params['UserGroupLevels']->selection = $item->assignto_usergrouplevels_selection;
		}
		if ( $item->assignto_users ) {
			$params['Users'] = null;
			$params['Users']->assignment = $item->assignto_users;
			$params['Users']->selection = $item->assignto_users_selection;
		}
		if ( $item->assignto_components ) {
			$params['Components'] = null;
			$params['Components']->assignment = $item->assignto_components;
			$params['Components']->selection = $item->assignto_components_selection;
		}
		if ( $item->assignto_articles ) {
			$params['Articles'] = null;
			$params['Articles']->assignment = $item->assignto_articles;
			$params['Articles']->selection = $item->assignto_articles_selection;
		}
		if ( $item->assignto_secscats ) {
			$params['SecsCats'] = null;
			$params['SecsCats']->assignment = $item->assignto_secscats;
			$params['SecsCats']->selection = $item->assignto_secscats_selection;
			$params['SecsCats']->params = null;
			$incs = $item->assignto_secscats_inc;
			if ( !( strpos( $incs, '|' ) === false ) ) {
				$incs = explode( '|', $incs );
			} else {
				$incs = explode( ',', $incs );
			}
			$params['SecsCats']->params->inc_sections = in_array( 'inc_secs', $incs );
			$params['SecsCats']->params->inc_categories = in_array( 'inc_cats', $incs );
			$params['SecsCats']->params->inc_articles = in_array( 'inc_arts', $incs );
			$params['SecsCats']->params->inc_others = in_array( 'inc_others', $incs );
		}
		if ( $item->assignto_languages ) {
			$params['Languages'] = null;
			$params['Languages']->assignment = $item->assignto_languages;
			$params['Languages']->selection = $item->assignto_languages_selection;
		}
		if ( $item->assignto_templates ) {
			$params['Templates'] = null;
			$params['Templates']->assignment = $item->assignto_templates;
			$params['Templates']->selection = $item->assignto_templates_selection;
		}
		if ( $item->assignto_php ) {
			$params['PHP'] = null;
			$params['PHP']->assignment = $item->assignto_php;
			$params['PHP']->selection = $item->assignto_php_selection;
		}

		if ( $item->assignto_k2cats && JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'admin.k2.php' ) ) {
			$params['Categories_K2'] = null;
			$params['Categories_K2']->assignment = $item->assignto_k2cats;
			$params['Categories_K2']->selection = $item->assignto_k2cats_selection;
			$params['Categories_K2']->params = null;
			$params['Categories_K2']->params->inc_children = $item->assignto_k2cats_inc_children;
			$incs = $item->assignto_k2cats_inc;
			if ( !( strpos( $incs, '|' ) === false ) ) {
				$incs = explode( '|', $incs );
			} else {
				$incs = explode( ',', $incs );
			}
			$params['Categories_K2']->params->inc_categories = in_array( 'inc_cats', $incs );
			$params['Categories_K2']->params->inc_items = in_array( 'inc_items', $incs );
		}

		if ( $item->assignto_mrcats && JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_resource'.DS.'resource.php' ) ) {
			$params['Categories_MR'] = null;
			$params['Categories_MR']->assignment = $item->assignto_mrcats;
			$params['Categories_MR']->selection = $item->assignto_mrcats_selection;
			$params['Categories_MR']->params = null;
			$params['Categories_MR']->params->inc_children = $item->assignto_mrcats_inc_children;
			$incs = $item->assignto_mrcats_inc;
			if ( !( strpos( $incs, '|' ) === false ) ) {
				$incs = explode( '|', $incs );
			} else {
				$incs = explode( ',', $incs );
			}
			$params['Categories_MR']->params->inc_categories = in_array( 'inc_cats', $incs );
			$params['Categories_MR']->params->inc_items = in_array( 'inc_items', $incs );
		}

		if ( $item->assignto_zoocats && JFile::exists( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_zoo'.DS.'zoo.php' ) ) {
			$params['Categories_ZOO'] = null;
			$params['Categories_ZOO']->assignment = $item->assignto_zoocats;
			$params['Categories_ZOO']->selection = $item->assignto_zoocats_selection;
			$params['Categories_ZOO']->params = null;
			$params['Categories_ZOO']->params->inc_children = $item->assignto_zoocats_inc_children;
			$incs = $item->assignto_zoocats_inc;
			if ( !( strpos( $incs, '|' ) === false ) ) {
				$incs = explode( '|', $incs );
			} else {
				$incs = explode( ',', $incs );
			}
			$params['Categories_ZOO']->params->inc_categories = in_array( 'inc_cats', $incs );
			$params['Categories_ZOO']->params->inc_items = in_array( 'inc_items', $incs );
		}

		$pass = $this->params->assignments->passAll( $params, $item->match_method, $article );

		if ( !$pass && $item->other_doreplace ) {
			$item->replace = $item->other_replace;
			// replace \n with newline
			$item->replace = preg_replace( '#(?<!\\\)\\\n#', "\n", $item->other_replace );
			$pass = 1;
		}

		if ( $pass ) {
			return $item;
		} else {
			return 0;
		}
	}
}

if ( !function_exists( 'html_entity_decoder' ) ) {
	function html_entity_decoder( $given_html, $quote_style = ENT_QUOTES, $charset = 'UTF-8' )
	{
		if ( is_array( $given_html ) ) {
			foreach( $given_html as $i => $html ) {
				$given_html[$i] = html_entity_decoder( $html );
			}
			return $given_html;
		}
		if ( phpversion() < '5.0.0' ) {
			$trans_table = array_flip( get_html_translation_table( HTML_SPECIALCHARS, $quote_style ) );
			$trans_table['&#39;'] = "'";
			return ( strtr( $given_html, $trans_table ) );
		} else {
			return html_entity_decode( $given_html, $quote_style, $charset );
		}
	}
}

// PHP4 compatiblility for cloning objects
if ( phpversion() < '5.0.0' && !function_exists( 'clone' ) ) {
	eval('
		function clone( $object )
		{
			return $object;
		}
	');
}
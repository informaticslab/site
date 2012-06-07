<?php
/**
 * Element: Title
 * Displays a title with a bunch of extras, like: description, image, versioncheck
 *
 * @package     NoNumber! Elements
 * @version     2.0.0
 *
 * @author      Peter van Westen <peter@nonumber.nl>
 * @link        http://www.nonumber.nl
 * @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// Ensure this file is being included by a parent file
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Title Element
 *
 * Available extra parameters:
 * title			The title
 * description		The description
 * message_type		none, message, notice, error?
 * image			Image (and path) to show on the right
 * show_apply		Show an apply tick image on the right (only if the image is not set)
 * url				The main url
 * download_url		The url of the download location
 * help_url			The url of the help page
 * version_url		The url to the new version folder (default = [url]/versions/)
 * version_path		The path to version folder
 * version_file		The filename of the current version file
 */
class JElementTitle extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Title';

	function fetchTooltip( $label, $description, &$node, $control_name, $name )
	{
		$nostyle =		$node->attributes( 'nostyle' );
		$description =	$node->attributes( 'description' );
		if ( $nostyle && $label && $label[0] != '@' && $description ) {
			return JElement::fetchTooltip( $label, '', $node, $control_name, $name );
		}
		return;
	}

	function fetchElement( $name, $value, &$node, $control_name )
	{
		$start =		$node->attributes( 'start' );
		$end =			$node->attributes( 'end' );
		$blocktype =	$node->attributes( 'blocktype' );

		if ( $blocktype == 'spacer' ) {
			return;
		}

		if ( $end ) {
			$html = '';
			$random = rand( 100000, 999999 );
			$html .= '<div id="end-'.$random.'"></div><script type="text/javascript">NoNumberElementsHideTD( "end-'.$random.'" );</script>';
			$html .= '</td></tr></table>';
			if ( $blocktype == 'fieldset' ) {
				$html .= '</fieldset>';

			} else {
				$html .= '</div></div>';
			}
			return $html;
		}
		$description =	$node->attributes( 'description' );
		$nostyle =		$node->attributes( 'nostyle' );

		$title =		$node->attributes( 'label' );
		$lang_folder =	$node->attributes( 'language_folder' );
		$message_type =	$node->attributes( 'message_type' );
		$image =		$node->attributes( 'image' );
		$image_w =		$node->attributes( 'image_w' );
		$image_h =		$node->attributes( 'image_h' );
		$show_apply =	$node->attributes( 'show_apply' );
		$toggle =		$node->attributes( 'toggle' );
		$tooltip =		$node->attributes( 'tooltip' );

		// The main url
		$url =				$node->attributes( 'url' );
		$download =			$node->attributes( 'download_url' );
		$help =				$node->attributes( 'help_url' );
		$extension =		$node->attributes( 'extension' );
		$xml =				$node->attributes( 'xml' );
		$version =			$node->attributes( 'version' );
		$version_url =		$this->def( $node->attributes( 'version_url' ), $url.'/versions/' );
		$version_file =		$node->attributes( 'version_file' );

		if ( !$extension ) {
			$extension = str_replace( 'version_', '', $version_file );
		}

		$msg = '';

		if ( $description ) {
			$description = JText::_( $description );
		}

		if ( $lang_folder ) {
			// Include extra language file
			$lang = JFactory::getLanguage();
			$lang = str_replace( '_', '-', $lang->_lang );

			if ( strpos( $lang_folder, '/administrator' ) === 0 ) {
				$lang_folder = str_replace( '/', DS, str_replace( '/administrator', JPATH_ADMINISTRATOR, $lang_folder ) );
			} else {
				$lang_folder = JPATH_SITE.str_replace( '/', DS, $lang_folder );
			}

			$lang_file = $lang.'.inc.php';
			if ( !file_exists( $lang_folder.DS.$lang_file ) ) {
				$lang_file = 'en-GB.inc.php';
			}
			if ( file_exists( $lang_folder.DS.$lang_file ) ) {
				include $lang_folder.DS.$lang_file;
			}
		}

		if ( $nostyle && $description ) {
			return $description;
		}

		if ( $title ) {
			$title = JText::_( $title );
		}

		$user = JFactory::getUser();
		if( strlen( $version ) && strlen( $version_file ) && ( $user->usertype == 'Super Administrator' || $user->usertype == 'Administrator' ) ) {
			// Import library dependencies
			require_once JPATH_PLUGINS.DS.'system'.DS.'nonumberelements'.DS.'helpers'.DS.'versions.php';
			$versions = NNVersions::instance();

			$msg = $versions->getMessage( $extension, $xml, $version, 1 );
			if ( $version ) {
				if ( $title ) {
					$title .= ' v'.$version;
				} else {
					$title = JText::_( 'Version' ).' '.$version;
				}
			}
		} else if ( $xml ) {
			$xml = JApplicationHelper::parseXMLInstallFile( JPATH_SITE.DS.( str_replace( '/', DS, $xml ) ) );
			if ( $xml && isset( $xml['version'] ) ) {
				$version = $xml['version'];
			}
			if ( $version ) {
				if ( $title ) {
					$title .= ' v'.$version;
				} else {
					$title = JText::_( 'Version' ).' '.$version;
				}
			}
		}

		if ( $url ) {
			$url = '<a href="'.$url.'" target="_blank" title="'.$title.'">';
		}

		if ( $image ) {
			$image = str_replace( '/', "\n", str_replace( '\\', '/', $image ) );
			$image = explode( "\n", trim( $image ) );
			if ( $image['0'] == 'administrator' ) {
				$image['0'] = JURI::base(true);
			} else {
				$image['0'] = JURI::root(true).'/'.$image['0'];
			}
			$image = $url.'<img src="'.implode( '/', $image ).'" border="0" style="float:right;margin-left:10px" alt=""';
			if ( $image_w ) {
				$image .= ' width="'.$image_w.'"';
			}
			if ( $image_h ) {
				$image .= ' height="'.$image_h.'"';
			}
			$image .= ' />';
			if ( $url ) { $image .= '</a>'; }
		}

		if ( $url ) { $title = $url.$title.'</a>'; }
		
		if ( $help ) { $help = '<a href="'.$help.'" target="_blank" title="'.JText::_( 'NN_MORE_INFO' ).'">'.JText::_( 'NN_MORE_INFO' ).'...</a>'; }

		if ( $title ) { $title = html_entity_decoder( $title ); }
		if ( $description ) { $description = html_entity_decoder( $description ); }

		$html = '';
		if ( $image ) { $html .= $image; }
		if ( $show_apply ) {
			$apply_button = '<a href="#" onclick="submitbutton( \'apply\' );" title="'.JText::_( 'Apply' ).'"><img align="right" border="0" alt="'.JText::_( 'Apply' ).'" src="images/tick.png"/></a>';
			$html .= $apply_button;
		}

		if ( $toggle && $description ) {
			$el = 'document.getElementById( \''.$control_name.$name.'description\' )';
			$onclick =
				'if( this.innerHTML == \''.JText::_( JText::_( 'Show' ).' '.$title ).'\' ){'
					.$el.'.style.display = \'block\';'
					.'this.innerHTML = \''.JText::_( JText::_( 'Hide' ).' '.$title ).'\';'
				.'}else{'
					.$el.'.style.display = \'none\';'
					.'this.innerHTML = \''.JText::_( JText::_( 'Show' ).' '.$title ).'\';'
				.'}'
				.'this.blur();return false;'
				;
			$html .= '<div class="button2-left" style="margin:0px 0px 5px 0px;"><div class="blank"><a href="javascript://;" onclick="'.$onclick.'">'.JText::_( JText::_( 'Show' ).' '.$title ).'</a></div></div>'."\n";
			$html .= '<br clear="all" />';
			$html .= '<div id="'.$control_name.$name.'description" style="display:none;">';
		} else if ( $title ) {
			if ( $blocktype != 'fieldset' ) {
				$html .= '<h4 style="margin: 0px;">'.$title.'</h4>';
			}
		}
		if ( $description && !$tooltip ) { $html .= $description; }
		if ( $help ) { $html .= '<p>'.$help.'</p>'; }
		if ( $toggle && $description ) {
			$html .= '</div>';
		}
		if ( $message_type ) {
			$html = '<dl id="system-message"><dd class="'.$message_type.'"><ul><li>'.html_entity_decoder( $html ).'</li></ul></dd></dl>';
		} else {
			if ( $blocktype != 'fieldset' && !$nostyle ) {
				$html = '<div class="panel"><div style="padding: 2px 5px;">'.$html.'<div style="clear: both;"></div>';
			}
			if ( $start ) {
				if ( $blocktype == 'fieldset' ) {
					if ( $description && $tooltip ) {
						$title = '<span class="hasTip" title="'.htmlentities( $title.'::'.$description ).'">'.$title.'</span>';
					}
					$html = '<fieldset class="adminform"><legend>'.$title.'</legend>'.$html;
				}
				$html .= '<table width="100%" class="paramlist admintable" cellspacing="1">';
				$html .= '<tr><td colspan="2" class="paramlist_value">';
				$random = rand( 100000, 999999 );
				$html .= '<div id="end-'.$random.'"></div><script type="text/javascript">NoNumberElementsHideTD( "end-'.$random.'" );</script>';
			} else {
				$html .= '</div></div>';
			}
		}

		if ( $msg ) { $html = $msg.$html; }

		return $html;
	}

	function def( $val, $default )
	{
		return ( $val == '' ) ? $default : $val;
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
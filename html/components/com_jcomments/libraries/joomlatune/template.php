<?php
/**
 *
 * Template class
 *
 * @static
 * @version 1.0
 * @package JoomlaTune.Framework
 * @author Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2010 by Sergey M. Litvinov (http://www.joomlatune.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/

// define directory separator short constant
if (!defined( 'DS' )) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

/**
 * JoomlaTune base template class
 *
 * @abstract
 *
 */
class JoomlaTuneTemplate {

	/**
	* A hack to support __construct() on PHP 4
	* Hint: descendant classes have no PHP4 class_name() constructors,
	* so this constructor gets called first and calls the top-layer __construct()
	* which (if present) should call parent::__construct()
	*
	* @return JoomlaTuneTemplate
	*/
	function JoomlaTuneTemplate()
	{
		$args = func_get_args();
		call_user_func_array(array(&$this, '__construct'), $args);
	}

	/**
	* Class constructor
	*
	* @access protected
	*/
	function __construct()
	{
		$this->_vars = array();
	}

	/**
	* Render template into string
	*
	* @abstract Implement in child classes
	* @access public
	* @return string
	*/
	function render()
	{
	}

	/**
	* Sets global variables
	*
	* @access public
	* @param array $value array list of global variables
	* @return void
	*/
	function setGlobalVars( &$value )
	{
		$this->_globals =& $value;
	}

	/**
	* Fetches and returns a given variable.
	*
	* @access private
	* @param string $name Variable name
	* @param mixed $default Default value if the variable does not exist
	* @return mixed Requested variable
	*/
	function getVar( $name, $default = null )
	{
		if (isset($this->_vars[$name])) {
			// fetch variable from local variables list
			return $this->_vars[$name];
		} else if (isset($this->_globals[$name])) {
			// fetch variable from global variables list
			return $this->_globals[$name];
		} else {
			// return default value
			return $default;
		}
	}

	/**
	* Set a template variable, creating it if it doesn't exist
	*
	* @access public
	* @param string $name The name of the variable
	* @param mixed $value The value of the variable
	* @return void
 	*/
	function setVar( $name, $value )
	{
		$this->_vars[$name] = $value;
	}
}

/**
 *
 * JoomlaTune template renderer class
 *
 */
class JoomlaTuneTemplateRender {

	var $_root = null;
	var $_default = null;
	var $_uri = null;
	var $_globals = null;
	var $_templates = null;

	/**
	* A hack to support __construct() on PHP 4
	* Hint: descendant classes have no PHP4 class_name() constructors,
	* so this constructor gets called first and calls the top-layer __construct()
	* which (if present) should call parent::__construct()
	*
	* @return JoomlaTuneTemplateRender
	*/
	function JoomlaTuneTemplateRender()
	{
		$args = func_get_args();
		call_user_func_array(array(&$this, '__construct'), $args);
	}

	/**
	* Class constructor
	*
	* @access protected
	*/
	function __construct()
	{
		$this->_globals		= array();
		$this->_templates	= array();

		//set root template directory
		$this->setRoot(dirname(__FILE__). DS. 'tpl' );
	}

	/**
	* Returns a reference to the global JoomlaTuneTemplateRender object, only creating it
	* if it doesn't already exist.
	*
	* This method must be invoked as:
	* 		<pre>  $tmpl = &JoomlaTuneTemplateRender::getInstance();</pre>
	*
	* @static
	* @access public
	* @return JoomlaTuneTemplate A template object
	*/
	function &getInstance()
	{
		static $instance = null;

		if (!is_object( $instance )) {
			$instance = new JoomlaTuneTemplateRender();
		}
		return $instance;
	}

	/**
	* Sets root base for the template
	*
	* The parameter depends on the reader you are using.
	*
	* @access public
	* @param string $root root base of the templates
	* @return void
	*/
	function setRoot( $path )
	{
		$this->_root = $path ? $path : dirname(__FILE__).DS.'tpl';
	}

	/**
	* Gets name of root base for the templates
	*
	* @access public
	* @return string
	*/
	function getRoot()
	{
		return $this->_root;
	}


	/**
	* Sets default base for the template
	*
	* The parameter depends on the reader you are using.
	*
	* @access public
	* @param string $path default base of the templates
	* @return void
	*/
	function setDefaultRoot( $path )
	{
		$this->_default = $path ? $path : $this->getRoot();
	}

	/**
	* Gets name of default base for the templates
	*
	* @access public
	* @return string
	*/
	function getDefaultRoot()
	{
		return $this->_default;
	}

	/**
	* Sets base url for the template images and css
	*
	* The parameter depends on the reader you are using.
	*
	* @access public
	* @param string $uri The base url of the templates
	* @return void
	*/
	function setBaseURI( $uri )
	{
		$this->_uri = $uri;
	}

	/**
	* Gets name of root base for the templates
	*
	* @access public
	* @return string
	*/
	function getBaseURI()
	{
		return $this->_uri;
	}

	/**
	* Load template class
	*
	* @access public
	* @param string $template name of the template
	* @return boolean
	*/
	function load( $template ) {

		$templateFileName = $this->getRoot().DS.$template.'.php';

		if (!is_file($templateFileName)) {
			$templateFileName = $this->getDefaultRoot().DS.$template.'.php';
		}

		if (is_file($templateFileName)) {
			ob_start();
			include_once( $templateFileName );
			ob_end_clean();

			$templateClass = 'jtt_' . $template;

			if (!class_exists($templateClass)) {
				$this->riseError( 'Template class not found in: ' . $template );
				return false;
			}

			ob_start();
			$tmpl = new $templateClass;

			$isValidTemplate = false;
			if ((version_compare( phpversion(), '4.2.0' ) < 0)) {
				// PHP < 4.2.0 (function is_a not exists)
				$isValidTemplate = is_subclass_of($tmpl, 'JoomlaTuneTemplate');
			} else {
				// PHP > 4.2.0 (using is_a)
				$isValidTemplate = is_a( $tmpl, 'JoomlaTuneTemplate' );
			}
			ob_end_clean();

			if (!$isValidTemplate) {
			       unset( $tmpl );
			       $this->riseError( 'Incorrect template: ' . $template );
			       return false;
			}

			ob_start();
			$tmpl->setGlobalVars( $this->_globals );
			$this->_templates[$template] =& $tmpl;
			ob_end_clean();

			return true;
		}
		return false;
	}

	/**
	* Adds a global variable
	*
	* Global variables are valid in all templates of this object.
	*
	* @access public
	* @param string $name name of the global variable
	* @param mixed $value value of the variable
	* @return void
	* @see addVar()
	*/
	function addGlobalVar( $name, $value )
	{
		$this->_globals[strtolower( $name )] = ( string )$value;
	}

	/**
	* Add a variable to a template
	*
	* @access public
	* @param string $template name of the template
	* @param string $name name of the variable
	* @param mixed $value value of the variable
	* @return void
	* @see addGlobalVar()
	*/
	function addVar( $template, $name, $value )
	{
		$this->_templates[$template]->_vars[$name] = $value;
	}

	/**
	* Add a object variable to a template
	*
	* @access public
	* @param string $template name of the template
	* @param string $name name of the variable
	* @param mixed $value value of the variable
	* @return void
	* @see addVar(), addGlobalVar()
	*/
	function addObject( $template, $name, $value )
	{
		$this->_templates[$template]->_vars[$name] = $value;
	}

	/**
	* Fetches and returns a given variable from template.
	*
	* @access public
	* @param string $template name of the template
	* @param string $name name of the variable
	* @return mixed
	*/
	function getVar( $template, $name )
	{
		if (!$this->exists($template))
		{
			$this->riseError( 'Unknown template: ' . $template );
			return null;
		}

		ob_start();
		$result = $this->_templates[$template]->getVar($name);
		ob_end_clean();

		return $result;
	}

	/**
	* Renders template and return result as string
	*
	* @access public
	* @param string $template name of the template
	* @return string
	* @see displayTemplate()
	*/
	function renderTemplate( $template )
	{
		if (!$this->exists($template)) {
			$this->riseError( 'Unknown template: ' . $template );
			return null;
		}

		ob_start();
		$this->_templates[$template]->render();
		$result = ob_get_contents();
		ob_end_clean();

		return $result;
	}

	/**
	* Renders template and displays output
	*
	* @access public
	* @param string $template name of the template
	* @return void
	* @see renderTemplate()
	*/
	function displayTemplate( $template )
	{
		echo $this->renderTemplate($template);
	}

	/**
	* Frees a template
	*
	* All memory consumed by the template will be freed.
	*
	* @access public
	* @param string $template name of the template
	* @return void
	* @see freeAllTemplates()
	*/
	function freeTemplate( $template )
	{
		unset($this->_templates[$template]);
	}

	/**
	* Frees all templates
	*
	* All memory consumed by the templates will be freed.
	*
	* @access public
	* @return void
	* @see freeTemplate()
	*/
	function freeAllTemplates()
	{
		$this->_templates = array();
		$this->_globals	= array();
	}

	/**
	* Checks if template exists
	*
	* @access public
	* @param string $name name of the template
	* @return boolean true, if template exists (loaded), false otherwise
	* @see load()
	*/
	function exists( $name )
	{
		return isset($this->_templates[$name]);
	}

	/**
	* Displays error-message and die
	*
	* @access private
	* @param string $message error message
	* @param string $type type of error (die or warning)
	* @return void
	*/
	function riseError( $message, $type = 'die' )
	{
		switch($type)
		{
			case 'warning':
				echo( 'JoomlaTuneTemplateWarning: ' . $message );
				break;
			case 'die':
			default:
				die( 'JoomlaTuneTemplateError: ' . $message );
				break;
		}
	}
}
?>
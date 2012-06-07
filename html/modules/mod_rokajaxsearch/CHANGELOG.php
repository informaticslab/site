<?php
/**
 * RokAjaxSearch Module
 *
 * @package RocketTheme
 * @subpackage rokajaxsearch
 * @version   2.0 December 30, 2010
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
?>

1. Copyright and disclaimer
----------------


2. Changelog
------------
This is a non-exhaustive changelog for RokAjaxSearch, inclusive of any alpha, beta, release candidate and final versions.

Legend:

* -> Security Fix
# -> Bug Fix
+ -> Addition
^ -> Change
- -> Removed
! -> Note

----------- 2.0 Release [17-Aug-2010] -----------
17-Aug-2010 Djamil Legato
# Fixed search results issue in Moo1.2 version and in com_content pages

----------- 1.9 Release [30-Jun-2010] -----------
30-Jun-2010 Djamil Legato
+ Added support for MT 1.2

----------- 1.8 Release [19-Mar-2010] -----------
19-Mar-2010 Djamil Legato
+ Added support for exact match when using the 2 double quotes (ie, "RocketTheme Extensions")

----------- 1.7 Release [09-Mar-2010] -----------
09-Mar-2010 Djamil Legato
# Fixed "Category" url link for Google Web Results

----------- 1.6 Release [24-Jan-2010] -----------

22-Jan-2010 Djamil Legato
+ Limit in "View All Results" is now automatically set based on the com_search "search limit" option.
# Fixed results not showing in non RocketTheme templates.
# Fixed non latin languages issue.

----------- 1.5 Release [31-Dec-2009] -----------

31-Dec-2009 Djamil Legato
+ Support for unlimited surrounds in the com_search override

----------- 1.4 Release [30-Nov-2009] -----------

30-Nov-2009 Djamil Legato
+ RokAjaxSearch now detects on which way of the screen it is positioned and display the results according to the position (left/right)
# Modified the way the addStyleSheet and Script are output

----------- 1.3 Release [18-Nov-2009] -----------

18-Nov-2009 Brian Towles
# Added bug fix for PHP 5.3

----------- 1.2 Release [02-Oct-2009] -----------

02-Oct-2009 Djamil Legato
# RokAjaxSearch Results now follow the window resize and keep the correct position

----------- 1.1 Release [20-Aug-2009] -----------

20-Aug-2009 Djamil Legato
+ The module now loads IE6 and IE7 css if found in the theme folders
+ Updated themes with James' fixes below

19-Aug-2009 James Spencer
# CSS Fixes for IE6 and IE7

----------- 1.0 Release [16-Jun-2009] -----------

+ Google Blogs, Google Images, Google Videos 
+ Built-in Light, Dark, Blue styles

----------- 0.9 Release [29-May-2009] -----------

# Fixed position issues

----------- 0.8 Release [29-Apr-2009] -----------

+ Left/Right keys for Google Search
+ Class for Google Results
+ Check for Google API
^ Reverted transition
+ Overlay for Google Searches
^ Updated to use document functionality to add scripts and CSS
# Fixed issues with full base url...switched to JURI:Root(true)

----------- 0.7 Release [03-Apr-2009] -----------

# helper.php fix

----------- 0.6 Release [02-Apr-2009] -----------

# Various fixes

----------- 0.5 Release [04-Mar-2009] -----------

# Various fixes

----------- 0.4 Release [04-Mar-2009] -----------

# Various fixes

----------- 0.3 Release [16-Feb-2009] -----------

# Various fixes

----------- 0.2 Release [16-Feb-2009] -----------

# Various fixes

----------- 0.1 Release [31-Jan-2009] -----------

! Initial release. 

----------- Initial Changelog Creation -----------
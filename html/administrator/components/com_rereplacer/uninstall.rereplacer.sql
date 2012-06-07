--
-- Database query file
-- For uninstallation
--
-- @package     ReReplacer
-- @version     2.13.0
--
-- @author      Peter van Westen <peter@nonumber.nl>
-- @link        http://www.nonumber.nl
-- @copyright   Copyright (C) 2010 NoNumber! All Rights Reserved
-- @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
--

DELETE FROM `#__plugins` WHERE folder = 'system' AND element = 'rereplacer';
DELETE FROM `#__plugins` WHERE folder = 'content' AND element = 'rereplacer';

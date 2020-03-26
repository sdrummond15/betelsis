<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * @package		Joomla.Administrator
 * @subpackage	mod_quickicon
 * @since		1.6
 */
abstract class modQuickIconHelper
{
	/**
	 * Stack to hold buttons
	 *
	 * @since	1.6
	 */
	protected static $buttons = array();

	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @param	JRegistry	The module parameters.
	 *
	 * @return	array	An array of buttons
	 * @since	1.6
	 */
	public static function &getButtons($params)
	{
		$key = (string)$params;
                $user       = JFactory::getUser();
		if (!isset(self::$buttons[$key])) {
			$context = $params->get('context', 'mod_quickicon');
			if ($context == 'mod_quickicon')
			{
				// Load mod_quickicon language file in case this method is called before rendering the module
			JFactory::getLanguage()->load('mod_quickicon');
                        if (in_array(10, $user->groups)){
				self::$buttons[$key] = array(
					array(
						'link' => JRoute::_('index.php?option=com_administrations&view=orcservs'),
						'image' => 'header/orcaserv.png',
						'text' => JText::_('MOD_QUICKICON_ORC'),
						'access' => array('core.manage', 'com_administrations' )
					),
					array(
						'link' => JRoute::_('index.php?option=com_administrations&view=clients'),
						'image' => 'header/clients.png',
						'text' => JText::_('MOD_QUICKICON_CLIENTS'),
						'access' => array('core.manage', 'com_administrations')
					),
					array(
						'link' => JRoute::_('index.php?option=com_administrations&view=districts'),
						'image' => 'header/district.png',
						'text' => JText::_('MOD_QUICKICON_DISTRICTS'),
						'access' => array('core.manage', 'com_administrations')
					),
                                        array(
						'link' => JRoute::_('index.php?option=com_administrations&view=cities'),
						'image' => 'header/citie.png',
						'text' => JText::_('MOD_QUICKICON_CITIES'),
						'access' => array('core.manage', 'com_administrations')
					),
                                        array(
						'link' => JRoute::_('index.php?option=com_administrations&view=employees'),
						'image' => 'header/employee.png',
						'text' => JText::_('MOD_QUICKICON_EMPLOYEES'),
						'access' => array('core.manage', 'com_administrations')
					),
					array(
						'link' => JRoute::_('index.php?option=com_administrations&view=services'),
						'image' => 'header/service.png',
						'text' => JText::_('MOD_QUICKICON_SERVICES'),
						'access' => array('core.manage', 'com_administrations')
					),
                                        array(
						'link' => JRoute::_('index.php?option=com_administrations&view=vehicles'),
						'image' => 'header/vehicle.png',
						'text' => JText::_('MOD_QUICKICON_VEHICLES'),
						'access' => array('core.manage', 'com_administrations')
					),
                                        array(
						'link' => JRoute::_('index.php?option=com_users'),
						'image' => 'header/icon-48-user.png',
						'text' => JText::_('MOD_QUICKICON_USER_MANAGER'),
						'access' => array('core.manage', 'com_users')
					),
				);
                        }else{
                            self::$buttons[$key] = array(
					array(
						'link' => JRoute::_('index.php?option=com_administrations&view=orcservs'),
						'image' => 'header/orcaserv.png',
						'text' => JText::_('MOD_QUICKICON_ORC'),
						'access' => array('core.manage', 'com_administrations' )
					),
					array(
						'link' => JRoute::_('index.php?option=com_administrations&view=clients'),
						'image' => 'header/clients.png',
						'text' => JText::_('MOD_QUICKICON_CLIENTS'),
						'access' => array('core.manage', 'com_administrations')
					),
					array(
						'link' => JRoute::_('index.php?option=com_administrations&view=districts'),
						'image' => 'header/district.png',
						'text' => JText::_('MOD_QUICKICON_DISTRICTS'),
						'access' => array('core.manage', 'com_administrations')
					),
                                        array(
						'link' => JRoute::_('index.php?option=com_administrations&view=cities'),
						'image' => 'header/citie.png',
						'text' => JText::_('MOD_QUICKICON_CITIES'),
						'access' => array('core.manage', 'com_administrations')
					),
                                        array(
						'link' => JRoute::_('index.php?option=com_administrations&view=employees'),
						'image' => 'header/employee.png',
						'text' => JText::_('MOD_QUICKICON_EMPLOYEES'),
						'access' => array('core.manage', 'com_administrations')
					),
					array(
						'link' => JRoute::_('index.php?option=com_administrations&view=services'),
						'image' => 'header/service.png',
						'text' => JText::_('MOD_QUICKICON_SERVICES'),
						'access' => array('core.manage', 'com_administrations')
					),
                                        array(
						'link' => JRoute::_('index.php?option=com_administrations&view=vehicles'),
						'image' => 'header/vehicle.png',
						'text' => JText::_('MOD_QUICKICON_VEHICLES'),
						'access' => array('core.manage', 'com_administrations')
					),
                               
				);
                        }
			}
			else
			{
				self::$buttons[$key] = array();
			}

		}

		return self::$buttons[$key];
	}

	/**
	 * Get the alternate title for the module
	 *
	 * @param	JRegistry	The module parameters.
	 * @param	object		The module.
	 *
	 * @return	string	The alternate title for the module.
	 */
	public static function getTitle($params, $module)
	{
		$key = $params->get('context', 'mod_quickicon') . '_title';
		if (JFactory::getLanguage()->hasKey($key))
		{
			return JText::_($key);
		}
		else
		{
			return $module->title;
		}
	}
}

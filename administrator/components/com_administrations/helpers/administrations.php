<?php

/*
 * @package Administrations
 * @com_admininistrations
 * @copyright Copyright (C) Sdrummond, Inc. All rights reserved.
 * @license Sdrummond
 */

// no direct access
defined('_JEXEC') or die;

class AdministrationsHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */

        public static function addSubmenu($vName)
            {
            $user = JFactory::getUser();
                    
                    JSubMenuHelper::addEntry(
                            JText::_('COM_ADMINISTRATIONS_SUBMENU_CLIENTS'),
                            'index.php?option=com_administrations&view=clients',
                            $vName == 'clients'
                    );
                    JSubMenuHelper::addEntry(
                            JText::_('COM_ADMINISTRATIONS_SUBMENU_ORCSERV'),
                            'index.php?option=com_administrations&view=orcservs',
                            $vName == 'orcservs'
                    );
                    JSubMenuHelper::addEntry(
                            JText::_('COM_ADMINISTRATIONS_SUBMENU_FIDEL'),
                            'index.php?option=com_administrations&view=fidelidade',
                            $vName == 'fidelidade'
                    );
                    if (in_array(10, $user->groups)){
                    JSubMenuHelper::addEntry(
                            JText::_('COM_ADMINISTRATIONS_SUBMENU_DISTRICTS'),
                            'index.php?option=com_administrations&view=districts',
                            $vName == 'districts'
                    );
                    JSubMenuHelper::addEntry(
                            JText::_('COM_ADMINISTRATIONS_SUBMENU_CITIES'),
                            'index.php?option=com_administrations&view=cities',
                            $vName == 'cities'
                    );
                    JSubMenuHelper::addEntry(
                            JText::_('COM_ADMINISTRATIONS_SUBMENU_EMPLOYEES'),
                            'index.php?option=com_administrations&view=employees',
                            $vName == 'employees'
                    );
                    JSubMenuHelper::addEntry(
                            JText::_('COM_ADMINISTRATIONS_SUBMENU_VEHICLES'),
                            'index.php?option=com_administrations&view=vehicles',
                            $vName == 'vehicles'
                    );
                    JSubMenuHelper::addEntry(
                            JText::_('COM_ADMINISTRATIONS_SUBMENU_SERVICES'),
                            'index.php?option=com_administrations&view=services',
                            $vName == 'services'
                    );
                    JSubMenuHelper::addEntry(
                            JText::_('COM_ADMINISTRATIONS_SUBMENU_REPORTNOTE'),
                            'index.php?option=com_administrations&view=reportnote',
                            $vName == 'reportnote'
                    );
                   }
            }
        
        
        public static function getActions()
            {
                    $user	= JFactory::getUser();
                    $result	= new JObject; 
                    $assetName  = 'com_administrations';
                    
                    $actions = array(
                        'core.admin','core.manage','core.create','core.edit','core.edit.state','core.delete' 
                    );
                    
                    foreach ($actions as $action){
                        $result->set($action, $user->authorise($action, $assetName));
                    }
                    
                    return $result;
            }
            
            
            
        public static function getCidadeOptions()
            {
                    // Initialize variables.
                    $options = array();

                    $db		= JFactory::getDbo();
                    $query	= $db->getQuery(true);

                    $query->select('id As value, nome As text');
                    $query->from('#__cidade AS a');
                    $query->order('a.nome');

                    // Get the options.
                    $db->setQuery($query);

                    $options = $db->loadObjectList();

                    // Check for a database error.
                    if ($db->getErrorNum()) {
                            JError::raiseWarning(500, $db->getErrorMsg());
                    }

                    // Merge any additional options in the XML definition.
                    //$options = array_merge(parent::getOptions(), $options);

                    array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_ADMINISTRATIONS_NO_CIDADE')));

                    return $options;
            }
            
        public static function getBairroOptions()
            {
                    // Initialize variables.
                    $options = array();

                    $db		= JFactory::getDbo();
                    $query	= $db->getQuery(true);

                    $query->select('id As value, nome As text');
                    $query->from('#__bairro AS a');
                    $query->order('a.nome');

                    // Get the options.
                    $db->setQuery($query);

                    $options = $db->loadObjectList();

                    // Check for a database error.
                    if ($db->getErrorNum()) {
                            JError::raiseWarning(500, $db->getErrorMsg());
                    }

                    // Merge any additional options in the XML definition.
                    //$options = array_merge(parent::getOptions(), $options);

                    array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_ADMINISTRATIONS_NO_BAIRRO')));

                    return $options;
            }
 
            public static function getClienteOrcOptions()
            {
                    // Initialize variables.
                    $options = array();

                    $db		= JFactory::getDbo();
                    $query	= $db->getQuery(true);

                    $query->select('a.id As value, nome As text');
                    $query->from('#__clientes AS a, #__orc_serv AS b');
                    $query->where('b.id_cliente = a.id');
                    $query->where('a.published = 1');
                    $query->order('a.nome');
                    $query->group('a.id');

                    // Get the options.
                    $db->setQuery($query);

                    $options = $db->loadObjectList();

                    // Check for a database error.
                    if ($db->getErrorNum()) {
                            JError::raiseWarning(500, $db->getErrorMsg());
                    }
                    
                    array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_ADMINISTRATIONS_NO_CLIENTE')));

                    return $options;
            }

            public static function getClienteOptions()
            {
                    // Initialize variables.
                    $options = array();

                    $db		= JFactory::getDbo();
                    $query	= $db->getQuery(true);

                    $query->select('a.id As value, nome As text');
                    $query->from('#__clientes AS a');
                    $query->where('a.published = 1');
                    $query->order('a.nome');
                    $query->group('a.id');

                    // Get the options.
                    $db->setQuery($query);

                    $options = $db->loadObjectList();

                    // Check for a database error.
                    if ($db->getErrorNum()) {
                            JError::raiseWarning(500, $db->getErrorMsg());
                    }

                    array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_ADMINISTRATIONS_NO_CLIENTE')));

                    return $options;
            }

            public static function getFuncOptions()
            {
                    // Initialize variables.
                    $options = array();

                    $db		= JFactory::getDbo();
                    $query	= $db->getQuery(true);

                    $query->select('a.id As value, nome As text');
                    $query->from('#__func AS a, #__funcxorc as b');
                    $query->where('b.id_func = a.id');
                    $query->where('a.published = 1');
                    $query->order('a.nome');
                    $query->group('a.id');

                    // Get the options.
                    $db->setQuery($query);

                    $options = $db->loadObjectList();

                    // Check for a database error.
                    if ($db->getErrorNum()) {
                            JError::raiseWarning(500, $db->getErrorMsg());
                    }

                    array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_ADMINISTRATIONS_NO_FUNC')));

                    return $options;
            }


            
            
}
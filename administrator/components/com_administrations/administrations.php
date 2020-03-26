<?php

/*
 * @package Administrations
 * @com_admininistrations
 * @copyright Copyright (C) Sdrummond, Inc. All rights reserved.
 * @license Sdrummond
 */

// no direct access
defined('_JEXEC') or die;

//Access check
if(!JFactory::getUser()->authorise('core.manage', 'com_administrations')){
    return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

//include dependences
jimport('joomla.application.component.controller');

//Execute the task.
$controller = JController::getInstance('Administrations');
$controller -> execute(JRequest::getCmd('task'));
$controller ->redirect();
?>

<?php

/*
 * @package Administrations
 * @com_admininistrations
 * @copyright Copyright (C) Sdrummond, Inc. All rights reserved.
 * @license Sdrummond
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

class AdministrationsTableReportnote extends JTable
{
	/**
	 * Constructor
	 *
	 * @since	2.5
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__abbook', 'id', $_db);
	}

	
	public function bind($array, $ignore = '')
	{
		if (isset($array['params']) && is_array($array['params'])) 
                    {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
                        $array['params'] = (string) $registry;
			
		}

		return parent::bind($array, $ignore);
	}
	       
}

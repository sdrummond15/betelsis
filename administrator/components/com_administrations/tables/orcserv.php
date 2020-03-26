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

class AdministrationsTableOrcserv extends JTable
{
	/**
	 * Constructor
	 *
	 * @since	2.5
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__orc_serv', 'id', $_db);
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
        
        public function store($updateNulls = false)
	{
            $date = JFactory::getDate();
            $user = JFactory::getUser();
            
            if (empty($this->id))
            {
                $this-> modified = $date ->toMySQL();
                $this-> modified_by = $user -> get('id');
                $this-> created = $date ->toMySQL();
                $this-> created_by = $user -> get('id');
            }
            else
            {
                if(!intval($this -> created))
                {
                    $this -> created = $date -> toMySQL();
                }
                if(empty($this -> created_by))
                {
                    $this -> created_by = $user -> get('id');
                }
            }
            
            return parent::store($updateNulls);
        }
	       
}

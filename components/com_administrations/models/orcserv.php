<?php

/*
 * @package Administrations
 * @com_admininistrations
 * @copyright Copyright (C) Sdrummond, Inc. All rights reserved.
 * @license Sdrummond
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');


class AdministrationsModelOrcserv extends JModelAdmin
{
	
	public function getTable($type = 'Orcserv', $prefix = 'AdministrationsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_administrations.orcserv', 'orcserv', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_administrations.edit.orcserv.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
        
        
        
        
        public function getCidade() {
                if (empty( $this->_cidadelist )) {
                        $query = ' SELECT cid.id AS id, cid.title AS cidade FROM #__cidade AS cid ORDER BY cidade';
                }
                if (empty($this->_cidadelist)) {
                        $this->_db->setQuery( $query );
                        $this->_cidadelist = $this->_getList( $query );
                }

                return $this->_cidadelist;
        }
        
}

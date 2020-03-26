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


class AdministrationsModelClient extends JModelAdmin
{
	
	public function getTable($type = 'Client', $prefix = 'AdministrationsTable', $config = array())
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
		$form = $this->loadForm('com_administrations.client', 'client', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_administrations.edit.client.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}
        
        public function save($data)
        {
                if (JRequest::getVar('task') == 'save2copy') {
			list($title, $alias) = $this->generateNewTitle($data['alias'], $data['title']);
			$data['title']	= $title;
			$data['alias']	= $alias;
		}
                if (parent::save($data)) {
                        $this->storeresponsavel($this->getState('client.id'), $data['id_resp']);
                        return true;
                }
                //$cache = JFactory::getCache('com_abook');
                //$cache->clean();

                return false;
        }
        
        function storeresponsavel($id , $id_resp = 20)
        {
                $clientsresplist['id'] = 0;
                $clientsresplist['id_cliente'] = $id;
                
                $row1 =& $this->getTable('respcliente2');
                if (!$row1->delete($id)) {
                        $this->setError($this->_db->getErrorMsg());
                        return false;
                }
                
                foreach ($_POST['id_resp']as $resp) {
                        
               
                        $db = JFactory::getDbo();

                        // Create a new query object.
                        $query = $db->getQuery(true);

                        // Insert columns.
                        $columns = array('id', 'id_cliente', 'id_resp');

                        // Insert values.
                        $values = array($clientsresplist['id'], $clientsresplist['id_cliente'], $resp);
                        
                        // Prepare the insert query.
                        $query
                            ->insert($db->quoteName('#__resp_cliente'))
                            ->columns($db->quoteName($columns))
                            ->values(implode(',', $values));

                        // Set the query using our newly populated query object and execute it.
                        $db->setQuery($query);
                        $db->query();
                }
                
                
        }
        
        public function getResplist() {
                if (empty( $this->_resplist )) {
                        $query = ' SELECT * '
                        . ' FROM #__responsavel'
                        ;
                }
                if (empty($this->_resplist)) {
                        $this->_db->setQuery( $query );
                        $this->_resplist = $this->_getList( $query );
                }

                return $this->_resplist;
        }
        
        
        public function getResponsaveis()
            {
                $db = &JFactory::getDBO();
                $query = "SELECT r.id as id_resp , r.title as resp
                            FROM #__responsavel AS r ORDER BY r.title";
                $db->setQuery($query);
                $item = $db->loadObjectList();
                return $item; 
            }
            
        
}

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
                if (isset($data->desconto) && empty($data->desconto)) {
                        $data->desconto = number_format($data->desconto, 2, ',', '.');
                }
                return $data;
        }

        public function validate($form, $data, $group = null)
	{
		$data = $form->filter($data);
		return $data;
	}

        public function save($data)
        {
                $data['desconto'] = str_replace(',', '.', $data['desconto']);
                if (parent::save($data)) {
                        $this->storefuncionario($this->getState('orcserv.id'), $data['id_func']);
                        $this->storeveiculo($this->getState('orcserv.id'), $data['id_veic']);
                        return true;
                }
                return false;
        }
        
        function storefuncionario($id, $id_func = 20)
        {
                $orcsfunclist['id'] = 0;
                $orcsfunclist['id_func'] = $id;
                $row1 = &$this->getTable('funcorcamento2');
                if (!$row1->delete($id)) {
                        $this->setError($this->_db->getErrorMsg());
                        return false;
                }
                foreach ($_POST['id_func'] as $func) {
                        $db = JFactory::getDbo();
                        // Create a new query object.
                        $query = $db->getQuery(true);
                        // Insert columns.
                        $columns = array('id', 'id_orc_serv', 'id_func');
                        // Insert values.
                        $values = array($orcsfunclist['id'], $orcsfunclist['id_func'], $func);
                        // Prepare the insert query.
                        $query
                                ->insert($db->quoteName('#__funcxorc'))
                                ->columns($db->quoteName($columns))
                                ->values(implode(',', $values));
                        // Set the query using our newly populated query object and execute it.
                        $db->setQuery($query);
                        $db->query();
                }
        }

        public function getFunclist()
        {
                if (empty($this->_funclist)) {
                        $query = ' SELECT * '
                                . ' FROM #__func';
                }
                if (empty($this->_funclist)) {
                        $this->_db->setQuery($query);
                        $this->_funclist = $this->_getList($query);
                }
                return $this->_funclist;
        }

        public function getOrcsFunclist()
        {
                if (empty($this->_orcsfunclist)) {
                        //	$bookId       = (int) $this->form->getValue('id');
                        $query = ' SELECT * '
                                . ' FROM #__funcxorc AS tb1 JOIN #__func AS tb2 ON tb1.id_func = tb2.id'
                                . '  WHERE tb1.id_orc_serv = ' . (int) $this->getItem()->id;
                }
                if (empty($this->_orcsfunclist)) {
                        $this->_db->setQuery($query);
                        $this->_orcsfunclist = $this->_getList($query);
                }
                return $this->_orcsfunclist;
        }
        public function getFuncionarios()
        {
                $db = JFactory::getDBO();
                $query = "SELECT f.id as id_func , f.nome as func
                FROM #__func AS f ORDER BY f.nome";
                $db->setQuery($query);
                $item = $db->loadObjectList();
                return $item;
        }
        public function getFuncChecked()
        {
                $db = JFactory::getDBO();
                $query = "SELECT fo.id_func AS func, fo.id_orc_serv AS orc 
                FROM #__funcxorc AS fo 
                JOIN #__func AS f 
                ON fo.id_func = f.id WHERE fo.id_orc_serv = " . (int) $this->getItem()->id;
                $db->setQuery($query);
                $item = $db->loadObjectList();
                return $item;
        }
        function storeveiculo($id, $id_veiculo = 20)
        {
                $orcsveiclist['id'] = 0;
                $orcsveiclist['id_veiculo'] = $id;
                $row1 = &$this->getTable('veicorcamento2');
                if (!$row1->delete($id)) {
                        $this->setError($this->_db->getErrorMsg());
                        return false;
                }
                foreach ($_POST['id_veiculo'] as $veic) {
                        $db = JFactory::getDbo();
                        // Create a new query object.
                        $query = $db->getQuery(true);
                        // Insert columns.
                        $columns = array('id', 'id_orc_serv', 'id_veiculo');
                        // Insert values.
                        $values = array($orcsveiclist['id'], $orcsveiclist['id_veiculo'], $veic);
                        // Prepare the insert query.
                        $query
                                ->insert($db->quoteName('#__veicxorc'))
                                ->columns($db->quoteName($columns))
                                ->values(implode(',', $values));
                        // Set the query using our newly populated query object and execute it.
                        $db->setQuery($query);
                        $db->query();
                }
        }
        public function getVeiclist()
        {
                if (empty($this->_veiclist)) {
                        $query = ' SELECT * '
                                . ' FROM #__veiculo';
                }
                if (empty($this->_veiclist)) {
                        $this->_db->setQuery($query);
                        $this->_veiclist = $this->_getList($query);
                }
                return $this->_veiclist;
        }
        public function getOrcsVeiclist()
        {
                if (empty($this->_orcsveiclist)) {
                        //	$bookId       = (int) $this->form->getValue('id');
                        $query = ' SELECT * '
                                . ' FROM #__veicxorc AS tb1 JOIN #__veiculo AS tb2 ON tb1.id_veiculo = tb2.id'
                                . '  WHERE tb1.id_orc_serv = ' . (int) $this->getItem()->id;
                }
                if (empty($this->_orcsveiclist)) {
                        $this->_db->setQuery($query);
                        $this->_orcsveiclist = $this->_getList($query);
                }
                return $this->_orcsveiclist;
        }
        public function getVeiculos()
        {
                $db = JFactory::getDBO();
                $query = "SELECT v.id as id_veiculo , v.nome as veic, v.placa as placa
                FROM #__veiculo AS v ORDER BY v.nome";
                $db->setQuery($query);
                $item = $db->loadObjectList();
                return $item;
        }
        public function getVeicChecked()
        {
                $db = JFactory::getDBO();
                $query = "SELECT vo.id_veiculo AS veic, vo.id_orc_serv AS orc 
                FROM #__veicxorc AS vo 
                JOIN #__veiculo AS v
                ON vo.id_veiculo = v.id WHERE vo.id_orc_serv = " . (int) $this->getItem()->id;
                $db->setQuery($query);
                $item = $db->loadObjectList();
                return $item;
        }
}

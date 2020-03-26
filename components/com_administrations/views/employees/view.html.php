<?php

/*
 * @package Administrations
 * @com_admininistrations
 * @copyright Copyright (C) Sdrummond, Inc. All rights reserved.
 * @license Sdrummond
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of administration.
 * 
 * @package  administration
 * @subpackage com_adminstration
 * @since 2.5
 */

class AdministrationsViewEmployees extends JView
{
    protected $items;
    protected $paginaton;
    protected $state;
    
    /*
     * Method to display the view.
     * 
     * @param string $tpl  A template file to load. [optional]
     * 
     * @return mixed   A string if successful, otherwise a JError object.
     * 
     * @since 1.6
     */
   public function display($tpl = null) 
   {
       // Initialise variables
       $this->items       = $this->get('Items');
       $this->pagination  = $this->get('Pagination');
       $this->state       = $this->get('State');
       
       if(count($errors = $this->get('Erros')))
       {
           JError::raiseError(500, implode("\n", $errors));
       }
       
       $doc = JFactory::getDocument();
       $doc ->addStyleSheet(JURI::root().'administrator/components/com_administrations/assets/css/backend.css');
       
       $this->addToolbar();
		
		// Include the component HTML helpers.
		JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

		parent::display($tpl);
   }
   protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/administrations.php';

		JToolBarHelper::title(JText::_('COM_ADMINISTRATIONS_MANAGER_EMPLOYEES'), 'employee.png');
		
                JToolBarHelper::addNew('employee.add');
		
		JToolBarHelper::editList('employee.edit');
		
                if ($this->state->get('filter.state') != 2)
                {
                        JToolBarHelper::divider();
                        JToolBarHelper::publish('employees.publish', 'JTOOLBAR_PUBLISH', true);
                        JToolBarHelper::unpublish('employees.unpublish', 'JTOOLBAR_UNPUBLISH', true);
                }

                if ($this->state->get('filter.state') != -1)
                {
                        JToolBarHelper::divider();
                        if ($this->state->get('filter.state') != 2)
                        {
                                JToolBarHelper::archiveList('employees.archive');
                        }
                        elseif ($this->state->get('filter.state') == 2)
                        {
                                JToolBarHelper::unarchiveList('employees.publish');
                        }
                }
                
                JToolBarHelper::checkin('employees.checkin');

                if ($this->state->get('filter.state') == -2 )
		{
			JToolBarHelper::deleteList('', 'employees.delete', 'JTOOLBAR_EMPTY_TRASH');
			JToolBarHelper::divider();
		}
		
                JToolBarHelper::trash('employees.trash');
                JToolBarHelper::divider();

                JToolBarHelper::preferences('com_administrations');
                JToolBarHelper::divider();
		
		JToolBarHelper::help('employees', $com = true);
        }
}
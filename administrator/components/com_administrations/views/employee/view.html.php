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

class AdministrationsViewEmployee extends JView
{
    protected $form;
    protected $item;
    protected $state;
    protected $cidade;
    
    public function display($tpl = null) 
    {
        $this->form         = $this->get('Form');
        $this->item         = $this->get('Item');
        $this->state        = $this->get('State');
     
        if(count($erros = $this->get('Errors'))){
            JError::raiseError(500, implode("\n", $errors));
            return false;
        }
        
        $doc = JFactory::getDocument();
        $doc ->addStyleSheet(JURI::root().'administrator/components/com_administrations/assets/css/backend.css');
        
        $this->addToolbar();
        
        parent::display($tpl);
    }
    
    protected function addToolbar()
    {
        JRequest::setVar('hidemainmenu', true);
        
        $user       = JFactory::getUser();
        $userId     = $user->get('id');
        $isNew      = ($this->item->id == 0);
        $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
        
        JToolBarHelper::title($isNew ? JText::_('COM_ADMINISTRATIONS_EMPLOYEE_ADD') : JText::_('COM_ADMINISTRATIONS_EMPLOYEE_EDIT'), 'employee.png');
        
        
			JToolBarHelper::apply('employee.apply');
			JToolBarHelper::save('employee.save');
		
		

			JToolBarHelper::save2new('employee.save2new');
		
		
			JToolBarHelper::save2copy('employee.save2copy');
		

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('employee.cancel');
		} else {
			JToolBarHelper::cancel('employee.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_ADMINISTRATIONS_EMPLOYEES_EDIT');
	}
}
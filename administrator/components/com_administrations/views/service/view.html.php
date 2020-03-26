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

class AdministrationsViewService extends JView
{
    protected $form;
    protected $item;
    protected $state;
    
    
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
        
        
        JToolBarHelper::title($isNew ? JText::_('COM_ADMINISTRATIONS_SERVICE_ADD') : JText::_('COM_ADMINISTRATIONS_SERVICE_EDIT'), 'services.png');
        
        
			JToolBarHelper::apply('service.apply');
			JToolBarHelper::save('service.save');
		
		

			JToolBarHelper::save2new('service.save2new');
		
		
			JToolBarHelper::save2copy('service.save2copy');
		

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('service.cancel');
		} else {
			JToolBarHelper::cancel('service.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_ADMINISTRATIONS_SERVICES_EDIT');
	}
}
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

class AdministrationsViewClient extends JView
{
    protected $form;
    protected $item;
    protected $state;
    protected $respcliente;
    protected $responsaveis;
    protected $responsavel;
    protected $respchecked;
    
    public function display($tpl = null) 
    {
        $this->form         = $this->get('Form');
        $this->item         = $this->get('Item');
        $this->state        = $this->get('State');
        $this->respcliente  = $this->get('ClientsResplist');
        $this->responsavel  = $this->get('Resplist');
        $this->responsaveis = $this->get('Responsaveis');
        $this->respchecked  = $this->get('RespChecked');
        
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
        $checkedOut = 0;
        $canDo      = AdministrationsHelper::getActions($this->item);
        
        JToolBarHelper::title($isNew ? JText::_('COM_ADMINISTRATIONS_CLIENT_ADD') : JText::_('COM_ADMINISTRATIONS_CLIENT_EDIT'), 'client.png');
       
        if (!$checkedOut && $canDo->get('core.edit') > 0){
                JToolBarHelper::apply('client.apply');
                JToolBarHelper::save('client.save');
                
                if ($canDo->get('core.create')) {
                JToolBarHelper::save2new('client.save2new');
                }
        }
        if (!$isNew && $canDo->get('core.create')) {
                JToolBarHelper::save2copy('client.save2copy');
        }

		if (empty($this->item->id))  {
			JToolBarHelper::cancel('client.cancel');
		} else {
			JToolBarHelper::cancel('client.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		JToolBarHelper::help('JHELP_COMPONENTS_ADMINISTRATIONS_CLIENTS_EDIT');
	}
}
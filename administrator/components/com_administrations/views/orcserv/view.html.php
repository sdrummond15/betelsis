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

class AdministrationsViewOrcServ extends JView
{
    protected $form;
    protected $item;
    protected $state;
    protected $funcorcamento;
    protected $funcionario;
    protected $funcionarios;    
    protected $funcchecked;
    protected $veicorcamento;
    protected $veiculo;
    protected $veiculos;    
    protected $veicchecked;
    
    public function display($tpl = null) 
    {
        $this->form            = $this->get('Form');
        $this->item            = $this->get('Item');
        $this->state           = $this->get('State');
        $this->funcorcamento   = $this->get('OrcsFunclist');
        $this->funcionario     = $this->get('Funclist');
        $this->funcionarios    = $this->get('Funcionarios');
        $this->funcchecked     = $this->get('FuncChecked');
        $this->veicorcamento   = $this->get('OrcsVeiclist');
        $this->veiculo         = $this->get('Veiclist');
        $this->veiculos        = $this->get('Veiculos');
        $this->veicchecked     = $this->get('VeicChecked');
        
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
        
        JToolBarHelper::title($isNew ? JText::_('COM_ADMINISTRATIONS_ORCSERV_ADD') : JText::_('COM_ADMINISTRATIONS_ORCSERV_EDIT'), 'orcserv.png');
       if (in_array(10, $user->groups)){
        if (!$checkedOut && $canDo->get('core.edit') > 0){
                JToolBarHelper::apply('orcserv.apply');
                JToolBarHelper::save('orcserv.save');
                
                if ($canDo->get('core.create')) {
                JToolBarHelper::save2new('orcserv.save2new');
                }
        }
        if (!$isNew && $canDo->get('core.create')) {
                JToolBarHelper::save2copy('orcserv.save2copy');
        }
         }
		if (empty($this->item->id))  {
			JToolBarHelper::cancel('orcserv.cancel');
		} else {
			JToolBarHelper::cancel('orcserv.cancel', 'JTOOLBAR_CLOSE');
		}

      
	}
}
<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');
class AdministrationsViewFidelidade extends JView
{
        protected $form;
        protected $result;
         
	public function display($tpl = null){
        
            $this->form      = $this->get('Form');
            $this->result     = $this->get('Result');
            
		
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
		$user = JFactory::getUser();
		JHTML::_('behavior.tooltip');
                $document       = JFactory::getDocument();
                $document->addStyleSheet('components/com_administrations/assets/css/backend.css');
                JToolBarHelper::title(   JText::_( 'COM_ADMINISTRATIONS_FIDELIDADE' ), 'fidelidade' );
                JHTML::addIncludePath(JPATH_COMPONENT.DS.'helpers');

                if ($user->authorise('core.admin','com_administrations')){
                        JToolBarHelper::preferences('com_administrations');
                }
        }
}
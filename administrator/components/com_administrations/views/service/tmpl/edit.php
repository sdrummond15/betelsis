<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_administrations
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$canDo = AdministrationsHelper::getActions();
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'service.cancel' || document.formvalidator.isValid(document.id('service-form'))) {
			Joomla.submitform(task, document.getElementById('service-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_administrations&layout=edit&id='.(int) $this->item->id); ?>" method="post" id="service-form" name="adminForm" class="form-validate">
<div class="width-60 fltlft">
	<fieldset class="adminform">
		<legend><?php echo empty($this->item->id) ? JText::_('COM_ADMINISTRATIONS_NEW_SERVICE') : JText::sprintf('COM_ADMINISTRATIONS_EDIT_SERVICE', $this->item->id); ?></legend>
		<ul class="adminformlist">
                    <?php if ($this->item->id): ?>
                        <li>
                            <?php echo $this->form->getLabel('id'); ?>
                            <?php echo $this->form->getInput('id'); ?>
                        </li>
                    <?php endif ?>
                        
                        <li>
                            <?php echo $this->form->getLabel('nome'); ?>
                            <?php echo $this->form->getInput('nome'); ?>
                        </li>

                        <li>
                            <?php echo $this->form->getLabel('alias'); ?>
                            <?php echo $this->form->getInput('alias'); ?>
                        </li>
                        
                        <li><?php echo $this->form->getLabel('descricao'); ?>
                        <?php echo $this->form->getInput('descricao'); ?></li>
                        
                        <?php if ($canDo->get('core.edit.state')): ?>
                       <li>
                            <?php echo $this->form->getLabel('published'); ?>
                            <?php echo $this->form->getInput('published'); ?>
                       </li>
                       <?php endif; ?>
                        
		</ul>

	</fieldset>
</div>

<div class="width-40 fltrt">
	<?php echo JHtml::_('sliders.start', 'administration-client-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

        <?php echo JHtml::_('sliders.panel', JText::_('COM_ADMINISTRATIONS_GROUP_LABEL_PUBLISHING_DETAILS'), 'publishing-details'); ?>
		<fieldset class="panelform">
		<ul class="adminformlist">
			<?php foreach($this->form->getFieldset('publish') as $field): ?>
				<li><?php echo $field->label; ?>
					<?php echo $field->input; ?></li>
			<?php endforeach; ?>
			</ul>
		</fieldset>
    
	<?php echo JHtml::_('sliders.panel', JText::_('JGLOBAL_FIELDSET_METADATA_OPTIONS'), 'metadata'); ?>
		<fieldset class="panelform">
			<ul class="adminformlist">
				<?php foreach($this->form->getFieldset('metadata') as $field): ?>
					<li><?php echo $field->label; ?>
						<?php echo $field->input; ?></li>
				<?php endforeach; ?>
			</ul>
		</fieldset>

	<?php echo JHtml::_('sliders.end'); ?>
		
	

	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</div>

<div class="clr"></div>
</form>

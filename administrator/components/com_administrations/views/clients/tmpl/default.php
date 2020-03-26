<?php

/*
 * @package Administrations
 * @com_admininistrations
 * @copyright Copyright (C) Sdrummond, Inc. All rights reserved.
 * @license Sdrummond
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$params     = (isset($this->state->params)) ? $this->state->params : new JObject();

?>
<form action="<?php echo JRoute::_('index.php?option=com_administrations&view=clients'); ?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_ADMINISTRATIONS_SEARCH_IN_TITLE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">
                       
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>
		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
                                <th width="20%">
					<?php echo JHtml::_('grid.sort', 'COM_ADMINISTRATIONS_HEADING_CLIENT', 'a.nome', $listDirn, $listOrder); ?>
				</th>
                                 <th width="20%">
					<?php echo JHtml::_('grid.sort', 'COM_ADMINISTRATIONS_HEADING_ENDERECO', 'enderecoc', $listDirn, $listOrder); ?>
				</th>
                                <th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_ADMINISTRATIONS_HEADING_DISTRICT', 'a.id_bairro', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort',  'JSTATUS', 'a.published', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_ADMINISTRATIONS_HEADING_CREATED','a.created',$listDirn, $listOrder); ?>
				</th>
                                <th width="10%">
					<?php echo JHtml::_('grid.sort', 'COM_ADMINISTRATIONS_HEADING_CREATED_BY','a.created_by',$listDirn, $listOrder); ?>
				</th>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="8">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			
			$canCreate	= $user->authorise('core.create',	'com_administrations');
			$canEdit	= $user->authorise('core.edit',		'com_administrations');
			$canCheckin	= $user->authorise('core.manage',	'com_checkin') || $item->checked_out==$user->get('id') || $item->checked_out==0;
			$canChange	= $user->authorise('core.edit.state',	'com_administrations') && $canCheckin;
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
                                <td class="center">
                                    <a href="<?php echo JRoute::_('index.php?option=com_administrations&task=client.edit&id='.(int) $item->id); ?>">
					<?php echo $item->nome; ?></a>
				</td>
                                <td class="center">
					<?php echo $item->enderecoc;?>
				</td>
                                <td class="center">
					<?php echo $item->bairro;?>
				</td>
                                <td class="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'clients.', $canChange);?>
				</td>
                                <td class="center">
					<?php echo $item->created; ?>
				</td>
				<td class="center">
					<?php echo $item->author_name; ?>
				</td>
				
				<td class="center">
					<?php echo $item->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
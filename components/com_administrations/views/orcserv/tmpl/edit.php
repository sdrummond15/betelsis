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
<script src="../administrator/components/com_administrations/assets/js/jquery-1.10.2.min.js"></script>
<script type="text/javascript">
/* Máscaras TELEFONE */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,""); //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function id( el ){
    return document.getElementById( el );
}
/*TELEFONE 1*/
window.onload = function(){
    id('jform_fone').onkeyup = function(){
        mascara( this, mtel );
    }
    id('jform_fone_comercial').onkeyup = function(){
            mascara( this, mtel );
    }
    id('jform_celular').onkeyup = function(){
            mascara( this, mtel );
    }
    id('jform_celular2').onkeyup = function(){
            mascara( this, mtel );
    }
}
</script>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'orcserv.cancel' || document.formvalidator.isValid(document.id('orcserv-form'))) {
			Joomla.submitform(task, document.getElementById('orcserv-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<script>
window.onload=function(){
// fora do fiddle, voc� pode trocar a linha abaixo por "var produtoList = {"
produtoList = {
    'init': function()
    {
        this.divProdutoList = document.getElementById('divProdutoList');
        this.divProdutoBase = document.getElementById('divProdutoBase');
    },
    
    'insert': function()
    {
        var newDiv = this.divProdutoBase.cloneNode(true);
        newDiv.style.display = '';
        console.log('newDiv => ', newDiv);
        this.divProdutoList.appendChild(newDiv);
    },
    
    'remove': function(el)
    {
        el.parentNode.removeChild(el);
    }
};
produtoList.init();
}

</script>

<div id="divProdutoBase" style="display:none;">
    <label>Produto:</label><input type="text" name="produto[]" />
    <label>Valor:</label><input type="text" name="valor[]" />
    <input type="button" value="Remover" onclick="produtoList.remove(this.parentNode)" />
</div>

<form action="<?php echo JRoute::_('index.php?option=com_administrations&layout=edit&id='.(int) $this->item->id); ?>" method="post" id="orcserv-form" name="adminForm" class="form-validate">
<div class="width-60 fltlft">
	<fieldset class="adminform">
		<legend><?php echo empty($this->item->id) ? JText::_('COM_ADMINISTRATIONS_NEW_ORCSERV') : JText::sprintf('COM_ADMINISTRATIONS_EDIT_ORCSERV', $this->item->id); ?></legend>
		<ul class="adminformlist">
                    <?php if ($this->item->id): ?>
                        <li><?php echo $this->form->getLabel('id'); ?>
                        <?php echo $this->form->getInput('id'); ?></li>
                    <?php endif ?>
                        
                        <li><?php echo $this->form->getLabel('id_cliente'); ?>
                        <?php echo $this->form->getInput('id_cliente'); ?></li>
                        
                        <li><?php echo $this->form->getLabel('contato'); ?>
                        <?php echo $this->form->getInput('contato'); ?></li>

                        <li><?php echo $this->form->getLabel('fantasia'); ?>
                        <?php echo $this->form->getInput('fantasia'); ?></li>
                        
                        <li><?php echo $this->form->getLabel('cnpjcpf'); ?>
                        <?php echo $this->form->getInput('cnpjcpf'); ?></li>

                        <li><?php echo $this->form->getLabel('insc_est'); ?>
                        <?php echo $this->form->getInput('insc_est'); ?></li>

                        <li><?php echo $this->form->getLabel('insc_mun'); ?>
                        <?php echo $this->form->getInput('insc_mun'); ?></li>
                        
                        <li><?php echo $this->form->getLabel('endereco'); ?>
                        <?php echo $this->form->getInput('endereco'); ?></li>

                        <li><?php echo $this->form->getLabel('numero'); ?>
                        <?php echo $this->form->getInput('numero'); ?></li>

                        <li><?php echo $this->form->getLabel('complemento'); ?>
                        <?php echo $this->form->getInput('complemento'); ?></li>

                        <li><?php echo $this->form->getLabel('cep'); ?>
                        <?php echo $this->form->getInput('cep'); ?></li>

                        <li><?php echo $this->form->getLabel('id_bairro'); ?>
                        <?php echo $this->form->getInput('id_bairro'); ?></li>

                        <li><?php echo $this->form->getLabel('id_cidade'); ?>
                        <?php echo $this->form->getInput('id_cidade'); ?></li> 
                        
                        <li><?php echo $this->form->getLabel('fone'); ?>
                        <?php echo $this->form->getInput('fone'); ?></li>
                        
                        <li><?php echo $this->form->getLabel('fone_comercial'); ?>
                        <?php echo $this->form->getInput('fone_comercial'); ?></li>
                        
                        <li><?php echo $this->form->getLabel('celular'); ?>
                        <?php echo $this->form->getInput('celular'); ?></li>
                        
                        <li><?php echo $this->form->getLabel('celular2'); ?>
                        <?php echo $this->form->getInput('celular2'); ?></li>
                        
                        <li><?php echo $this->form->getLabel('email'); ?>
                        <?php echo $this->form->getInput('email'); ?></li>
                        
                        <li><?php echo $this->form->getLabel('email2'); ?>
                        <?php echo $this->form->getInput('email2'); ?></li>

                        <li><?php echo $this->form->getLabel('id_tipo'); ?>
                        <?php echo $this->form->getInput('id_tipo'); ?></li>

                         <li><?php echo $this->form->getLabel('tp_pag'); ?>
                        <?php echo $this->form->getInput('tp_pag'); ?></li>
                        
                       <li><?php echo $this->form->getLabel('observacao'); ?>
                        <?php echo $this->form->getInput('observacao'); ?></li>
                       
                       <?php if ($canDo->get('core.edit.state')): ?>
                       <li>
                            <?php echo $this->form->getLabel('published'); ?>
                            <?php echo $this->form->getInput('published'); ?>
                       </li>
                       <?php endif; ?>
                       
                       <div style="width: 100%; display: table;">
                       <h1>Servi�os</h1>
                        <div id="divProdutoList">
                        </div>
                        <input type="button" value="Adicionar Produto" onclick="produtoList.insert()" />
                        </div>
                        
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

<?php
/**
 * @package		Joomla.Administrator
 * @subpackage	com_administrations
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$canDo = AdministrationsHelper::getActions();
$user = JFactory::getUser();

$doc = JFactory::getDocument();
$doc->addStyleSheet('../administrator/components/com_administrations/assets/css/orcserv.css');
?>
<script src="../administrator/components/com_administrations/assets/js/jquery-1.10.2.min.js"></script>
<script type='text/javascript' src="../administrator/components/com_administrations/assets/js/jquery.maskcpfcnpj.js"></script>
<script type="text/javascript">
    /* Máscaras TELEFONE */
    function mascara(o, f) {
        v_obj = o
        v_fun = f
        setTimeout("execmascara()", 1)
    }
    function execmascara() {
        v_obj.value = v_fun(v_obj.value)
    }
    function mtel(v) {
        v = v.replace(/\D/g, ""); //Remove tudo o que não é dígito
        v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
        v = v.replace(/(\d)(\d{4})$/, "$1-$2"); //Coloca hífen entre o quarto e o quinto dígitos
        return v;
    }
    function id(el) {
        return document.getElementById(el);
    }
    /*TELEFONE 1*/
    window.onload = function () {
        id('jform_fone').onkeyup = function () {
            mascara(this, mtel);
        }
        id('jform_fone_comercial').onkeyup = function () {
            mascara(this, mtel);
        }
        id('jform_celular').onkeyup = function () {
            mascara(this, mtel);
        }
        id('jform_celular2').onkeyup = function () {
            mascara(this, mtel);
        }
    }
</script>

<script type="text/javascript">
    jQuery.noConflict();
    jQuery(function (cep) {
        jQuery("#jform_cep").mask("99.999-999");
    });
</script> 

<script type="text/javascript">
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '000.000.000-00' : '00.000.000/0000-00';
        alert('teste');
    };
    jQuery('#jform_cnpjcpf').mask(SPMaskBehavior, {
        onKeyPress: function (val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    });
    jQuery("#jform_horaini").mask("99:99");
    jQuery("#jform_horafim").mask("99:99");
</script>

<script type="text/javascript">
    Joomla.submitbutton = function (task)
    {
        if (task == 'orcserv.cancel' || document.formvalidator.isValid(document.id('orcserv-form'))) {
            Joomla.submitform(task, document.getElementById('orcserv-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
        }
    }
</script>

<script language="javascript">
    function Calcula() {
//var Parametro1=document.frm.EditValor.value;
        var Parametro1 = document.getElementById('qtd').value;
        var Parametro2 = document.getElementById('valor').value;
        Parametro2 = Parametro2.replace(',','.');
        var Soma = ((parseFloat(Parametro1)) * (parseFloat(Parametro2)));
        if ((Parametro1 == '' || Parametro1 == null) || (Parametro2 == '' || Parametro2 == null)) {
            document.getElementById('soma').value = '0';
        } else {
            document.getElementById('soma').value = Soma;
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_administrations&layout=edit&id=' . (int) $this->item->id); ?>" method="post" id="orcserv-form" name="adminForm" class="form-validate">
    <div class="width-100 fltlft">
        <fieldset class="adminform">
            <legend><?php echo empty($this->item->id) ? JText::_('COM_ADMINISTRATIONS_NEW_ORCSERV') : JText::sprintf('COM_ADMINISTRATIONS_EDIT_ORCSERV', $this->item->id); ?></legend>
            <ul class="adminformlist">
                <?php if ($this->item->id): ?>
                    <li>
                        <?php echo $this->form->getLabel('id'); ?>
                        <?php echo $this->form->getInput('id'); ?>
                    </li>
                <?php endif ?>

                <li>
                    <?php echo $this->form->getLabel('id_cliente'); ?>
                    <?php echo $this->form->getInput('id_cliente'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('contato'); ?>
                    <?php echo $this->form->getInput('contato'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('fantasia'); ?>
                    <?php echo $this->form->getInput('fantasia'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('cnpjcpf'); ?>
                    <?php echo $this->form->getInput('cnpjcpf'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('insc_est'); ?>
                    <?php echo $this->form->getInput('insc_est'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('insc_mun'); ?>
                    <?php echo $this->form->getInput('insc_mun'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('endereco'); ?>
                    <?php echo $this->form->getInput('endereco'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('numero'); ?>
                    <?php echo $this->form->getInput('numero'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('complemento'); ?>
                    <?php echo $this->form->getInput('complemento'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('cep'); ?>
                    <?php echo $this->form->getInput('cep'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('id_bairro'); ?>
                    <?php echo $this->form->getInput('id_bairro'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('id_cidade'); ?>
                    <?php echo $this->form->getInput('id_cidade'); ?>
                </li> 

                <li>
                    <?php echo $this->form->getLabel('fone'); ?>
                    <?php echo $this->form->getInput('fone'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('fone_comercial'); ?>
                    <?php echo $this->form->getInput('fone_comercial'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('celular'); ?>
                    <?php echo $this->form->getInput('celular'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('celular2'); ?>
                    <?php echo $this->form->getInput('celular2'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('email'); ?>
                    <?php echo $this->form->getInput('email'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('email2'); ?>
                    <?php echo $this->form->getInput('email2'); ?>
                </li>
                
                <?php if ($canDo->get('core.edit.state')): ?>
                    <li>
                        <?php echo $this->form->getLabel('published'); ?>
                        <?php echo $this->form->getInput('published'); ?>
                    </li>
                <?php endif; ?>
                    
                <li>
                    <?php echo $this->form->getLabel('dtini'); ?>
                    <?php echo $this->form->getInput('dtini'); ?>
                    <?php echo $this->form->getInput('horaini'); ?>
                </li>
                
                <li>
                    <?php echo $this->form->getLabel('dtfim'); ?>
                    <?php echo $this->form->getInput('dtfim'); ?>
                    <?php echo $this->form->getInput('horafim'); ?>
                </li>
                
                <li>
                    <?php echo $this->form->getLabel('tp_orcserv'); ?>
                    <?php echo $this->form->getInput('tp_orcserv'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('tp_pag'); ?>
                    <?php echo $this->form->getInput('tp_pag'); ?>
                </li>

                <li>
                    <?php echo $this->form->getLabel('dtvenc'); ?>
                    <?php echo $this->form->getInput('dtvenc'); ?>
                </li>
                
                <li>
                    <?php echo $this->form->getLabel('observacao'); ?>
                    <?php echo $this->form->getInput('observacao'); ?>
                </li>

                
                <div class="litot">
                    <li class="halfli">
                        <?php foreach ($this->form->getFieldset('funcionario') as $funcionarios): ?>
                            <label>Funcion&aacute;rios: 
                                <p class="desc_func">Selecione os funcion&aacute;rios segurando a tecla <br /><strong>CTRL + Clique mouse</strong></p>
                            </label>
                            <select name="id_func[]" multiple size="15" >
                                <?php
                                $selected = '';
                                foreach ($this->funcionarios as $funcionarios) {
                                    foreach ($this->funcchecked as $checked) {
                                        if ($checked->func == $funcionarios->id_func) {
                                            $selected = 'SELECTED';
                                        }
                                    }
                                    echo '<option name="id_func[]" value="' . $funcionarios->id_func . '"' . $selected . '>' . $funcionarios->func .'</option>';
                                    $selected = '';
                                }
                                ?>
                            </select>
                        <?php endforeach; ?>
                    </li>

                    <li class="halfli">
                        <?php foreach ($this->form->getFieldset('veiculo') as $veiculos): ?>
                        <label>Ve&iacute;culos: 
                                <p class="desc_veic">Selecione os Ve&iacute;culos utilizados segurando a tecla <br /><strong>CTRL + Clique mouse</strong></p>
                            </label>
                            <select name="id_veiculo[]" multiple size="15">
                                <?php
                                $selected = '';
                                foreach ($this->veiculos as $veiculos) {
                                    foreach ($this->veicchecked as $checked) {
                                        if ($checked->veic == $veiculos->id_veiculo) {
                                            $selected = 'SELECTED';
                                        }
                                    }
                                    echo '<option name="id_veiculo[]" value="' . $veiculos->id_veiculo . '"' . $selected . '>' . $veiculos->veic . ' ('.$veiculos->placa.')</option>';
                                    $selected = '';
                                }
                                ?>
                            </select>
                        <?php endforeach; ?>
                    </li>
                </div>

                <?php
                if (!empty($this->item->id)) {
                    $id_orc = $this->item->id;
                    ?>

                    <div class="servicostotal">
                        <h1>Servi&ccedil;os</h1>
                        <?php
                        $db = JFactory::getDbo();
                        $querybusca = $db->getQuery(true);
                        $querybusca = "SELECT sxo.id AS id, sxo.quantidade AS qtd, sxo.valor_unit AS valor, sxo.descricao AS descricao, sxo.garantia AS garantia, s.nome AS servico, sxo.valor_tot AS subtotal FROM #__servxorc AS sxo LEFT JOIN #__servicos AS s ON sxo.id_servico = s.id WHERE sxo.id_orc_serv = " . $id_orc;
                        $db->setQuery($querybusca);
                        $db->query();
                        $services = (array) $db->loadObjectList();

                        $valortotal = 0;
                      
                        echo '<table class="listaserv">';
                        echo '<tr>';
                        echo '<th>Quantidade</th>';
                        echo '<th>Servi&ccedil;o</th>';
                        echo '<th>Valor</th>';
                        echo '<th>Subtotal</th>';
                        echo '<th>Garantia(Dias)</th>';
                        echo '<th>Observa&ccedil;&atilde;o</th>';
                        echo '<th>Deletar</th>';
                        echo '</tr>';
                        foreach ($services as $services) {
                            if (empty($services->servico)) {
                                $servico = 'Outros Servi&ccedil;os';
                            } else {
                                $servico = $services->servico;
                            }
                            echo '<tr>';
                            echo '<td>' . $services->qtd . '</td>';
                            echo '<td>' . $servico . '</td>';
                            echo '<td>R$ ' . number_format($services->valor, 2, ',', '.') . '</td>';
                            echo '<td>R$ ' . number_format($services->subtotal, 2, ',', '.') . '</td>';
                            echo '<td>' . $services->garantia . '</td>';
                            echo '<td>' . $services->descricao . '</td>';
                            if(in_array(10, $user->groups)){
                            echo '<td class="tddeletaserv"><input type="button" id="delete' . $services->id . '" class="deletaserv" name="' . $services->id . '" value=""></td>';
                            } else{
                                echo '<td>&nbsp;</td>';
                            }
                            echo '</tr>';

                            $valortotal += $services->subtotal;
                        }
                        if ($this->item->desconto > 0){
                           echo '<tr><td class="totalservicos" colspan="3">Sub-Total:</td><td colspan="3">R$ ' . number_format($valortotal, 2, ',', '.') . '</td></tr>';
                           echo '<tr><td class="totalservicos" colspan="3">Desconto:</td><td colspan="3">R$ ' . number_format($this->item->desconto, 2, ',', '.') . '</td></tr>';
                           $valortotal -= $this->item->desconto;
                        }
                        echo '<tr><td class="totalservicos" colspan="3">Total:</td><td colspan="3">R$ ' . number_format($valortotal, 2, ',', '.') . '</td></tr>';
                        echo '</table>';

                        
                        ?>
                        <div id="results"></div>
                        <div id="divProdutoList">
                            <div class="inserts">
                                <input type="number" id="qtd" name="qtd" placeholder="Quantidade" onKeyUp="Calcula()" />
                                <?php
                                $db = JFactory::getDbo();
                                $query = $db->getQuery(true);
                                $query->select('*');
                                $query->from('#__servicos As s');

                                $db->setQuery($query);
                                $rows = (array) $db->loadObjectList();

                                echo '<select id="servico" name="servico" >';
                                echo '<option value="0">Outro Servi&ccedil;o</option>';
                                foreach ($rows as $servicos) {
                                    echo '<option value="' . $servicos->id . '">' . $servicos->nome . '</option>';
                                }
                                echo '</select>';
                                ?>
                                <input type="text" id="valor" name="valor" placeholder="Valor" onKeyUp="Calcula()"/>
                                <input type="text" id="soma" name="EditValorTotal" disabled placeholder="Total">
                                <input type="text" id="garantia" name="garantia" placeholder="Garantia(dias)">
                                <input type="text" id="desc" name="desc" placeholder="Descri&ccedil;&atilde;o"/>
                            </div>
                            <?php if(in_array(10, $user->groups)){?>
                                <div class="insertbutton">
                                    <input type="button" id="insertserv" value="Inserir">
                                </div>
                            <?php } ?>
                            <?php $this->item->desconto = number_format($this->item->desconto, 2, ',', '.'); ?>
                             <li>
                             <label>Desconto:
                            </label>
                            <?php echo $this->form->getInput('desconto'); ?>
                        </li>
                        <?php if(in_array(10, $user->groups)){ ?>
                         <div id="toolbar-apply">
                        <a href="#" onclick="Joomla.submitbutton('orcserv.apply')" class="btn-salvar">
                        Salvar
                        </a>
                        </div>
                        <?php } ?>
                        </div>
                    </div>
                <?php }$document = JFactory::getDocument();
                            $document->addScript('../administrator/components/com_administrations/assets/js/jquery-1.10.2.min.js');
                                           $document->addScript('../administrator/components/com_administrations/assets/js/jqueryinsertservice.js');
?>
            </ul>
            <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

        </fieldset>
    </div>

    <div class="clr"></div>
</form>
<?php
     if(in_array(10, $user->groups)){
        $id_orc = $this->item->id;
        if (!empty($id_orc)) { ?>
            <form action="<?php echo JRoute::_('index1.php?option=com_administrations&view=pdfreport&format=pdf'); ?>" method="post" name="pdfreport" id="pdfreport" class="form-validate">
                <input type="hidden" name="id" value="<?php echo $this->item->id; ?>">
                <input class="button" name="resultado" formtarget="_blank" type="submit" value="GERAR PEDIDO"/>
            </form>
<?php   }
    }
?>
<script>
    jQuery('#jform_desconto').attr("onkeyup","Calcula()");
</script>
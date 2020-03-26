<?php

/**

 * @package		Joomla.Administrator

 * @subpackage	com_administrations

 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.

 * @license		GNU General Public License version 2 or later; see LICENSE.txt

 */



// no direct access

defined('_JEXEC') or die('Restricted access');

$user   = JFactory::getUser();

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

JHtml::_('behavior.tooltip');

JHtml::_('behavior.formvalidation'); ?>

<form action="<?php echo JRoute::_('index.php?option=com_administrations&view=fidelidade'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

    <div class="width-60 fltlft" style="width: 100%;">

                <fieldset class="adminform" id="formmodify">

                	<legend><?php echo JText::_( 'COM_ADMINISTRATIONS_FIDELIDADE' ); ?></legend>

                        <ul class="adminformlist">

                            <li class="data">
                                <div>
                                    <?php echo $this->form->getLabel('dataini'); ?>

                                    <?php echo $this->form->getInput('dataini'); ?>
                                </div>
                                <div>
                                    <?php echo $this->form->getLabel('datafim'); ?>

                                    <?php echo $this->form->getInput('datafim'); ?>
                                </div>
                            </li> 
                            
			</ul>

                        <div class="report"></div>

                        <input class="button" name="resultado" type="submit" value="Consulta por Data Realizada"/>

                        

		</fieldset>

	</div>

	<?php echo JHTML::_( 'form.token' ); ?>

</form>

<div class="clr"></div>


<?php if(empty($this->result)){

     echo '<div class="noresult">A consulta não retornou nenhum resultado.</div>';

}else{
    ?>






<div class="resultado">
    <table width="100%" id="indextable">

        <thead>

        <tr>

            <th>

                N&ordm;

            </th>

            <th>
       
                Cliente               

            </th>

            <th>

                Tipo

            </th>

            <th>

                Data In&iacute;cio

            </th>
            
            <th>

                Data T&eacute;rmino

            </th>

            <th>

                Servi&ccedil;os

            </th>

            <th>

                Funcion&aacute;rios

            </th>

            <th>

                Valor

            </th>

        </tr>

        </thead>

        <tbody>
            
        <?php
        foreach ($this->result as $resultado){?>
            
            <tr>

                <td width="5%">
                    <?php echo str_pad($resultado->id, 6, "0", STR_PAD_LEFT);?>
                </td>

                <td width="40%">

                    <?php echo $resultado->cliente;?>

                </td>

                <td width="5%">

                    <?php if($resultado->tipnote == 0){

                                echo 'Or&ccedil;amento';

                            }else{

                                echo 'Pedido';

                            }?>

                </td>

                <td width="5%">

                    <?php if($resultado->dtini == '0000-00-00'){
                              echo 'Sem data';
                          }else{
                              $dataini = explode('-', $resultado->dtini);
                              $dataini = $dataini[2].'/'.$dataini[1].'/'.$dataini[0];
                              echo $dataini;
                          }
                    ?>

                </td>

                <td width="5%">

                    <?php if($resultado->dtfim == '0000-00-00'){
                              echo 'Sem data';
                          }else{
                              $dataini = explode('-', $resultado->dtfim);
                              $dataini = $dataini[2].'/'.$dataini[1].'/'.$dataini[0];
                              echo $dataini;
                          }?>

                </td>

                <td width="22%">

                    <?php 
                        if(!empty($resultado->id)){
                            $db = JFactory::getDBO();
                            $query = $db->getQuery(true);
                            $query->select('s.nome AS servico');
                            $query->from('#__servicos AS s');
                            $query->join('LEFT','#__servxorc AS sxo ON sxo.id_servico = s.id');
                            $query->where('sxo.id_orc_serv = '.$resultado->id);
                            $db->setQuery($query);
                            $servicos = $db->loadObjectList();
                            $cserv = 0;
                            foreach ($servicos as $countserv){
                                $cserv +=1;
                            }
                            $cserv1 = 1;
                            foreach ($servicos as $serv){
                                if($cserv1 < $cserv){
                                    echo $serv->servico.', ';
                                }else{
                                    echo $serv->servico;
                                }
                                $cserv1 ++;
                            }
                        }
                    ?>

                </td>

                <td width="10%">
                    
                    <?php 
                    if(!empty($resultado->id)){
                            $db = JFactory::getDBO();
                            $query = $db->getQuery(true);
                            $query->select('f.nome AS funcionario');
                            $query->from('#__func AS f');
                            $query->join('LEFT','#__funcxorc AS fxo ON fxo.id_func = f.id');
                            $query->where('fxo.id_orc_serv = '.$resultado->id);
                            $db->setQuery($query);
                            $funcionarios = $db->loadObjectList();
                            $cfunc = 0;
                            foreach ($funcionarios as $countfunc){
                                $cfunc +=1;
                            }
                            $cfunc1 = 1;
                            foreach ($funcionarios as $func){
                                if($cfunc1 < $cfunc){
                                    echo $func->funcionario.', ';
                                }else{
                                    echo $func->funcionario;
                                }
                                $cfunc1 ++;
                            }
                    }
                    ?>

                </td>
                <td width="8%">
                    <?php 
                    if(!empty($resultado->id)){
                            $db = JFactory::getDBO();
                            $query = $db->getQuery(true);
                            $query->select('sxo.valor_tot AS total');
                            $query->from('#__servxorc AS sxo');
                            $query->where('sxo.id_orc_serv = '.$resultado->id);
                            $db->setQuery($query);
                            $total = $db->loadObjectList();
                            $soma = 0;
                            foreach ($total as $total){
                                $soma += $total->total;
                            }
                            echo 'R$ '.number_format($soma, 2, ',', '.');
                    }
                    ?>
                </td>

            </tr>

        <?php }?>

        </tbody>
    </table>
    
</div>

<?php } ?>


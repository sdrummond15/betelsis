 <?php

define( '_JEXEC', 1 );

// defining the base path.
if (stristr( $_SERVER['SERVER_SOFTWARE'], 'win32' )) {
    define( 'JPATH_BASE', realpath(dirname(__FILE__).'\..\..\..' ));
	} else define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../..' ));
	define( 'DS', DIRECTORY_SEPARATOR );
	
	// including the main joomla files
	require_once ( JPATH_BASE.DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE.DS.'includes'.DS.'framework.php' );
	
	// Creating an app instance 
	$app = JFactory::getApplication('site');
	
	$app->initialise();
	jimport( 'joomla.user.user' );
	jimport( 'joomla.user.helper' );
	
        $id_orc = $_REQUEST['id'];
       
        
        $deletar = isset($_REQUEST['deletaid']);
        
        if(empty($deletar)){
            
            $qtd      = $_REQUEST['qtd'];
            $valor    = $_REQUEST['valor'];
            $valor    = str_replace(',', '.',$valor);
            $serv     = $_REQUEST['serv'];
            $desc     = $_REQUEST['desc'];
            $garantia = $_REQUEST['garantia'];
            $soma     = $_REQUEST['soma'];
            $db = JFactory::getDBO();
            $query = "INSERT INTO #__servxorc (id_orc_serv,quantidade,valor_unit,descricao,garantia, id_servico, valor_tot) VALUES ('".$id_orc."','".$qtd."','".$valor."','".$desc."','".$garantia."', '".$serv."','".$soma."')";
            $db->setQuery($query);
            $db->query();
        
        }else{
            $deletar = $_REQUEST['deletaid'];
            
            $db =JFactory::getDBO();   
            $query = "DELETE FROM #__servxorc WHERE id = ".$deletar;
            $db->setQuery($query);
            $db->execute();  
        }
        
        $querybusca = $db->getQuery(true);
        $querybusca = "SELECT sxo.id AS id, sxo.quantidade AS qtd, sxo.valor_unit AS valor, sxo.descricao AS descricao, sxo.garantia AS garantia, s.nome AS servico, sxo.valor_tot AS subtotal FROM #__servxorc AS sxo LEFT JOIN #__servicos AS s ON sxo.id_servico = s.id WHERE sxo.id_orc_serv =" .$id_orc;
	$db->setQuery($querybusca);
	$db->query();
        $services = (array) $db->loadObjectList();


        $querydesc = $db->getQuery(true);
        $querydesc = "SELECT desconto FROM #__orc_serv WHERE id =" .$id_orc;
	$db->setQuery($querydesc);
	$db->query();
        $descontos = (array) $db->loadObjectList();
        //print_r($descontos);
        
        //echo '<div>'.$querybusca.'</div>';
	
        $valortotal = 0;
        $desconto = 0;
        

        echo '<table class="listaserv1">';
            echo '<tr>';
                echo '<th>Quantidade</th>';
                echo '<th>Servi&ccedil;o</th>';
                echo '<th>Valor</th>';
                echo '<th>Subtotal</th>';
                echo '<th>Observa&ccedil;&atilde;o</th>';
                echo '<th>Garantia</th>';
                echo '<th>Deletar</th>';
            echo '</tr>';
            
        foreach ($services as $services){
            if(empty($services->servico)){
                $servico = 'Outros Servi&ccedil;os';
            }else{
                $servico = $services->servico;
            }
            if(!empty($services->valor)){
                $valor = str_replace('.', ',', $services->valor);
                $subtotal = str_replace('.', ',', $services->subtotal);
            }
            echo '<tr>';
                echo '<td>'.$services->qtd.'</td>';
                echo '<td>'.$servico.'</td>';
                echo '<td>R$ '.number_format($services->valor, 2, ',', '.').'</td>';
                echo '<td>R$ '.number_format($services->subtotal, 2, ',', '.').'</td>';
                echo '<td>'.$services->garantia .'</td>';
                echo '<td>'.$services->descricao .'</td>';
                echo '<td class="tddeletaserv"><input type="button" id="delete'.$services->id.'" class="deletaserv" name="'.$services->id.'" value=""></td>';  
            echo '</tr>';

            $valortotal += $services->subtotal;
            
        }
        $desconto = $descontos[0]->desconto;
        if($desconto > 0){
            echo '<tr><td class="totalservicos" colspan="3">Sub-Total:</td><td colspan="3">R$ '.number_format($valortotal, 2, ',', '.').'</td></tr>';
            echo '<tr><td class="totalservicos" colspan="3">Desconto:</td><td colspan="3">R$ '.number_format($desconto, 2, ',', '.') .'</td></tr>';
            $valortotal -= $desconto;
         }
            echo '<tr><td class="totalservicos" colspan="3">Total:</td><td colspan="3">R$ '.$valortotal.'</td></tr>';
       

        echo '</table>';

	?>

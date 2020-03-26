<?php
define('FPDF_FONTPATH', 'font/');
//require('html_table.php');
require('mc_table.php');

define( '_JEXEC', 1 );

// defining the base path.
if (stristr( $_SERVER['SERVER_SOFTWARE'], 'win32' )) {
    define( 'JPATH_BASE', realpath(dirname(__FILE__).'\..\..\..\..\..\..' ));
	} else define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../../../../..' ));
	define( 'DS', DIRECTORY_SEPARATOR );
	
	// including the main joomla files
	require_once ( JPATH_BASE.DS.'includes'.DS.'defines.php' );
	require_once ( JPATH_BASE.DS.'includes'.DS.'framework.php' );
	
	// Creating an app instance 
	$app = JFactory::getApplication('site');
	
	$app->initialise();
	jimport( 'joomla.user.user' );
	jimport( 'joomla.user.helper' );

        $cli            = '';

        $dat            = '';

        $tip            = '';
 
        $cliente         = $_POST["client"];
        $tipnote         = $_POST["tipnote"];
        $dataini         = $_POST["dataini"];
        $datafim         = $_POST["datafim"];
        $func            = $_POST["func"];
        
        if(!empty($client)){
            $cli = ' WHERE cl.id = '. $client;
        }
        if(!empty($tipnote)){
            if(empty($client)){
                $tip = ' WHERE ';
            }else{
                $tip = ' AND ';
            }
                
            if ($tipnote == 1) {
                $tipnote = 0;
            }elseif ($tipnote == 2){
                $tipnote = 1;
            }
           $tip = $tip. 'os.tp_orcserv = '. $tipnote;
        }
        if(!empty($func)){
            if((empty($client))&&(!empty($datefim))){
                $fun = ' WHERE ';
            }else{
                $fun = ' AND ';
            }
           $fun = $fun. 'fo.id_func = '. $func;
        }
            
        // Valida  da DATA
        //SE conter data inicial e final
        if((!empty($dateini))&&(!empty($datefim))){
            if((empty($client)) && (empty($tipnote))){
                $dat = ' WHERE ';
            }else{
                $dat = ' AND ';
            }
            $dat = $dat.'os.dtfim > "'.$dateini.'" AND os.dtfim < "'.$datefim.'"';
        }
        
        //SE conter somente data inicial
        if ((!empty($dateini)) && (empty($datefim))) {
            if ((empty($client)) && (empty($tipnote))) {
                $dat = ' WHERE ';
            }else{
                $dat = ' AND ';
            }
            $dat = $dat . 'os.dtfim > "' . $dateini . '"';
        }

        //SE conter somente data final
        if ((empty($dateini))&&(!empty($datefim))){
            if((empty($client)) && (empty($tipnote))){
                $dat = ' WHERE ';
            }else{
                $dat = ' AND ';
            }
            $dat = $dat.'os.dtfim < "'.$datefim.'"';
        }
        
        //EXECUTA O SELECT DE ACORDO COM OS CAMPOS PREENCHIDOS
        if((!empty($cli)) || (!empty($tip)) || (!empty($dat))){
            $db =JFactory::getDBO();
            $query = 'SELECT os.id AS id,
                    cl.nome AS cliente,
                    os.tp_orcserv AS tipnote,
                    os.dtini AS dtini,
                    os.dtfim AS dtfim 
                    FROM #__clientes AS cl 
                    LEFT JOIN #__orc_serv AS os ON cl.id = os.id_cliente
                    LEFT JOIN #__funcxorc AS fo ON os.id = fo.id_orc_serv'
                    . $cli . $dat . $tip. fun;
            $query->group('os.id');
            $db->setQuery($query);
            echo $query;
            $db->query();
            $itens = (array) $db->loadObjectList();
        }
        
//        $db =JFactory::getDBO(); 
//        $queryserv = $db->getQuery(true);
//        $queryserv->select('se.nome AS servico,
//                        so.quantidade AS qtd,
//                        so.valor_unit AS vunit,
//                        so.valor_tot As vtot, 
//                        so.descricao AS descricao');
//        $queryserv->from('#__servxorc AS so');
//        $queryserv->join('LEFT', '#__servicos AS se ON so.id_servico = se.id');
//        $queryserv->where('so.id_orc_serv = '. $idorcserv);
//	$db->setQuery($queryserv);
//	$db->query();
//        $servicos = (array) $db->loadObjectList();
//echo $queryserv;

        
//INICIA PDF
//$pdf = new PDF_MC_Table();
//$pdf->AddPage('L', 'A4');
//$pdf->SetMargins(10,10,10);
//$pdf->SetAutoPageBreak(1,10);
//
//
//$pdf->SetFont('Helvetica', 'B', 16);
//$pdf->Cell(278,8,'Relatório Notas',1,1,'C');
//$pdf->Cell(278,8,'',1,1,'C');
//
//$pdf->Ln(2);
//
//$pdf->SetWidths(array(13,70,18,18,18,61,60,20));
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Row(array('Nº','Cliente','Tipo','Data Início','Data Fim','Serviços','Funcionários','Valor'));
//$pdf->SetFont('Helvetica', '', 8);
//
//foreach ($itens as $itens){
//    $id = str_pad($itens->id, 6, "0", STR_PAD_LEFT);
//    $idref = $itens->id;
//    $cliente = $itens->cliente;
//    $tipo = $itens->tipnote;
//    $dtini = $itens->dtini;
//    $dtfim = $itens->dtfim;
//
//    if($tipo == 0){
//        $tipon = 'Orçamento';
//    }else{
//        $tipon = 'Pedido';
//    }
//
//    $tamnome = strlen($cliente);
//    $nomecortado = substr($cliente, 0, 40);
//
//    //QUERY RETORNA SERVICOS
//        $queryserv = $db->getQuery(true);
//        $queryserv->select('s.nome AS servico');
//        $queryserv->from('#__servicos AS s');
//        $queryserv->join('LEFT','#__servxorc AS sxo ON sxo.id_servico = s.id');
//        $queryserv->where('sxo.id_orc_serv = '.$idref);
//        $db->setQuery($queryserv);
//	$db->query();
//        $servicos = (array) $db->loadObjectList();
//        $servs = '';
//        $cserv = 0;
//        foreach ($servicos as $countserv){
//            $cserv +=1;
//        }
//        $cserv1 = 1;
//        foreach ($servicos as $servicos){
//            if($cserv1 < $cserv){
//                $serv = $servicos->servico.', ';
//            } else {
//                $serv = $servicos->servico;
//            }
//            $cserv1 ++;
//            $servs .= $serv;
//        }
//    //CONTA TAMANHO DA STRING DO SERVIÇO
//    $tamserv = strlen($servs);
//
//
//    //QUERY RETORNA FUNCIONARIOS
//        $queryfunc = $db->getQuery(true);
//        $queryfunc->select('f.nome AS funcionario');
//        $queryfunc->from('#__func AS f');
//        $queryfunc->join('LEFT','#__funcxorc AS fxo ON fxo.id_func = f.id');
//        $queryfunc->where('fxo.id_orc_serv = '.$idref);
//        $db->setQuery($queryfunc);
//	$db->query();
//        $funcionarios = (array) $db->loadObjectList();
//        $funcs = '';
//        $cfunc = 0;
//        foreach ($funcionarios as $countfunc){
//            $cfunc +=1;
//        }
//        $cfunc1 = 1;
//        foreach ($funcionarios as $funcionarios){
//            if($cfunc1 < $cfunc){
//                $func = $funcionarios->funcionario.', ';
//            } else {
//                $func = $funcionarios->funcionario;
//            }
//            $cfunc1 ++;
//            $funcs .= $func;
//        }
//    //CONTA TAMANHO DA STRING DO FUNCIONARIOS
//    $tamfunc = strlen($funcs);
//
//
//    $pdf->Row(array($id,$cliente,$tipon,$dtini,$dtfim,$servs,$funcs,$id));
//
//}
//
//ob_start ();
//
//$pdf->Output('relatorio_notas.pdf','I');
//
//
////INICIA PDF
//$pdf = new PDF_MC_Table();
//$pdf->AddPage('P', 'A4');
//$pdf->SetMargins(10,10,10);
//$pdf->SetAutoPageBreak(1,10);
//$pdf->SetFont('Arial','',10);
//
//
//$pdf->Image('http://localhost/betelsis/images/logo_betel.png',12,18,-200);
//$pdf->Cell(35,30,'',1);
//$pdf->SetFont('Helvetica', 'B', 20);
//$pdf->Cell(155,10,'DESENTUPIDORA BETEL LTDA.',1,1,'C');
//$pdf->Cell(35);
//$pdf->SetFontSize(8);
//$pdf->Multicell(155,5,'BOMBEIROS E ELETRICISTAS - ESGOTOS - RALOS - PIAS - TANQUES - REDES - COLUNAS DE PRÉDIOS',1,'C');
//$pdf->Cell(35);
//$pdf->SetFontSize(12);
//$pdf->Multicell(125,10,'Atendimento 24 HORAS - (31)3491-7382 / 0800-2837382',1,'C');
//$pdf->Ln(-10);
//$pdf->SetLeftMargin(170);
//$pdf->Multicell(30,15,'Nº '.$id,1,'C');
//$pdf->Ln(-5);
//$pdf->SetFontSize(7);
//$pdf->Cell(-125);
//$pdf->Multicell(125,5,'AV. SEBASTIÃO DE BRITO, 601 - DONA CLARA - BELO HORIZONTE - MG',1,'C');
//
//$pdf->Ln();
//$pdf->Cell(-160);
//$pdf->SetMargins(0,0,0);
//if($tipo == 0){
//    $pdf->SetFont('Helvetica', 'B', 16);
//    $pdf->Cell(190,8,'ORÇAMENTO',1,1,'C');
//}else{
//    $pdf->SetFont('Helvetica', 'B', 16);
//    $pdf->Cell(190,8,'SERVIÇO REALIZADO',1,1,'C');
//}
//
//$pdf->SetLeftMargin(10);
//$pdf->Ln(2);
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Cell(24,6,'Contratante:',0,0,'L');
//$pdf->SetFont('Helvetica', '', 10);
//$pdf->Cell(166,6,' '.$cliente,0,1,'L');
//
//if (!empty($numero)){
//    $numero = ', '.$numero;
//}
//
//$pdf->SetLeftMargin(10);
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Cell(20,6,'Endereço:',0,0,'L');
//$pdf->SetFont('Helvetica', '', 10);
//$pdf->Cell(170,6,' '.$endereco.$numero,0,1,'L');
//
//$pdf->SetLeftMargin(10);
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Cell(14,6,'Bairro:',0,0,'L');
//$pdf->SetFont('Helvetica', '', 10);
//$pdf->Cell(87,6,' '.$bairro,0,0,'L');
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Cell(12,6,'CEP:',0,0,'L');
//$pdf->SetFont('Helvetica', '', 10);
//$pdf->Cell(22,6,' '.$cep,0,0,'L');
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Cell(40,6,$cidade,0,0,'L');
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Cell(15,6,$estado,0,1,'L');
//
//$pdf->SetLeftMargin(10);
//$pdf->Cell(14,6,'Fone:',0,0,'L');
//$pdf->SetFont('Helvetica', '', 10);
//$pdf->Cell(42,6,' '.$fone,0,0,'L');
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Cell(30,6,'Fone Comercial:',0,0,'L');
//$pdf->SetFont('Helvetica', '', 10);
//$pdf->Cell(42,6,' '.$fone_comercial,0,0,'L');
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Cell(20,6,'Celular:',0,0,'L');
//$pdf->SetFont('Helvetica', '', 10);
//$pdf->Cell(42,6,' '.$celular,0,1,'L');
//
//$pdf->SetLeftMargin(10);
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Cell(24,6,'CPF / CNPJ:',0,0,'L');
//$pdf->SetFont('Helvetica', '', 10);
//$pdf->Cell(65,6,' '.$cnpjcpf,0,0,'L');
//$pdf->SetFont('Helvetica', 'B', 10);
//$pdf->Cell(36,6,'Inscrição Estadual:',0,0,'L');
//$pdf->SetFont('Helvetica', '', 10);
//$pdf->Cell(65,6,' '.$insc_est,0,1,'L');
//
//if(!empty($servicos)){
//    $pdf->Ln();
//    $pdf->SetLeftMargin(10);
//    $pdf->SetFont('Helvetica', 'B', 10);
//    $pdf->Cell(24,6,'Quantidade',1,0,'C');
//    $pdf->Cell(111,6,'Descrição dos Serviços',1,0,'C');
//    $pdf->Cell(30,6,'Valor Unitário',1,0,'C');
//    $pdf->Cell(25,6,'Subtotal',1,1,'C');
//    
//    foreach ($servicos as $servicos){
//        $servico = $servicos->servico;
//        $qtd = $servicos->qtd;
//        $valorunit = $servicos->vunit;
//        $vunit = str_replace('.', ',',$valorunit);
//        $valortot = $servicos->vtot;
//        $vtot = str_replace('.', ',',$valortot);
//        $desc = $servicos->descricao;
//        
//        $pdf->SetLeftMargin(10);
//        $pdf->SetFont('Helvetica', '', 10);
//        $pdf->Cell(24,6,$qtd,1,0,'C');
//        $pdf->Cell(111,6,$servico,1,0,'C');
//        $pdf->Cell(30,6,'R$ '.$vunit,1,0,'L');
//        $pdf->Cell(25,6,'R$ '.$vtot,1,1,'L');
//        $pdf->Multicell(190,6,$desc,1,'L');
//        
//        $somatotal += $vtot;
//        
//    }
//    $total = number_format($somatotal, 2, ',', '.');
//    $pdf->SetFont('Helvetica', 'B', 12);
//    $pdf->Cell(155,8,'TOTAL: ',1,0,'R');
//    $pdf->Cell(35,8,'R$ '.$total,1,1,'L');
//    
//}           
//ob_start ();
//
//if($tipo == 0){
//    $tip = 'orcamento';
//}else{
//    $tip = 'pedido';
//}
//
//$pdf->Output($tip.'_'.$id.'.pdf','I');
?>



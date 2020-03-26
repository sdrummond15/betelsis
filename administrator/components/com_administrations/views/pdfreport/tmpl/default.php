<?php
define('FPDF_FONTPATH', 'font/');
require('html_table.php');

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
	$app =& JFactory::getApplication('site');
	
	$app->initialise();
	jimport( 'joomla.user.user' );
	jimport( 'joomla.user.helper' );

        $idorcserv         = '';
 
        $idorcserv         = $_POST["id"];
        
        $db =JFactory::getDBO(); 
        $query = $db->getQuery(true);
        $query->select('os.id AS id,
                        cl.nome AS cliente,
                        cl.fantasia AS fantasia,
                        os.contato As contato, 
                        os.cnpjcpf AS cnpjcpf, 
                        os.insc_est AS insc_est, 
                        os.insc_mun AS insc_mun, 
                        os.endereco AS endereco, 
                        os.numero AS numero, 
                        os.complemento AS complemento, 
                        ba.nome AS bairro, 
                        ci.nome AS cidade,
                        ci.estado AS estado,
                        os.cep AS cep, 
                        os.fone AS fone, 
                        os.fone_comercial AS fone_comercial, 
                        os.celular AS celular, 
                        os.celular2 As celular2, 
                        os.email AS email,
                        os.email2 As email2,
                        os.desconto As desconto,
                        os.dtini As dtini,
                        os.tp_pag As tppag,
                        os.created As created,
                        os.tp_orcserv AS tipo');
        $query->from('#__orc_serv AS os');
        $query->join('LEFT', '#__clientes AS cl ON os.id_cliente = cl.id');
        $query->join('LEFT', '#__cidade AS ci ON os.id_cidade = ci.id');
        $query->join('LEFT', '#__bairro AS ba ON os.id_bairro = ba.id');
        $query->where('os.id = '. $idorcserv);
	$db->setQuery($query);
	$db->query();
        $clientes = (array) $db->loadObjectList();
        
        
        $db =JFactory::getDBO(); 
        $queryserv = $db->getQuery(true);
        $queryserv->select('se.nome AS servico,
                        so.quantidade AS qtd,
                        so.valor_unit AS vunit,
                        so.valor_tot As vtot,
                        so.garantia as garantia,
                        so.descricao AS descricao');
        $queryserv->from('#__servxorc AS so');
        $queryserv->join('LEFT', '#__servicos AS se ON so.id_servico = se.id');
        $queryserv->where('so.id_orc_serv = '. $idorcserv);
	$db->setQuery($queryserv);
	$db->query();
        $servicos = (array) $db->loadObjectList();
        //echo $queryserv;
        
        $db =JFactory::getDBO(); 
        $queryfunc = $db->getQuery(true);
        $queryfunc->select('f.nome AS funcionario');
        $queryfunc->from('#__funcxorc AS fo');
        $queryfunc->join('LEFT', '#__func AS f ON fo.id_func = f.id');
        $queryfunc->where('fo.id_orc_serv = '. $idorcserv);
	$db->setQuery($queryfunc);
	$db->query();
        $funcionarios = (array) $db->loadObjectList();
        //echo $queryfunc;
        
foreach ($clientes as $clientes){
    $id = str_pad($clientes->id, 6, "0", STR_PAD_LEFT);
    $fantasia = utf8_decode($clientes->fantasia);
    $cliente = utf8_decode($clientes->cliente);
    $contato = utf8_decode($clientes->contato);
    $cnpjcpf = $clientes->cnpjcpf;
    $insc_est = $clientes->insc_est;
    $insc_mun = $clientes->insc_mun;
    $endereco = utf8_decode($clientes->endereco);
    $numero = $clientes->numero;
    $complemento = utf8_decode($clientes->complemento);
    $bairro = utf8_decode($clientes->bairro);
    $cidade = utf8_decode($clientes->cidade);
    $estado = $clientes->estado;
    $cep = $clientes->cep;
    $fone = $clientes->fone;
    $fone_comercial = $clientes->fone_comercial;
    $celular = $clientes->celular;
    $celular2 = $clientes->celular2;
    $desconto = $clientes->desconto;
    $email = $clientes->email;
    $email2 = $clientes->email2;
    $dtini = $clientes->dtini;
    $formpag = $clientes->tppag;
    $created = $clientes->created;
    $tipo = $clientes->tipo;
}


    
//INICIA PDF
$pdf = new PDF_MC_Table();
$pdf->AddPage('P', 'A4');
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(1,10);
$pdf->SetFont('Arial','',10);


$pdf->Image('http://localhost/betelsis/images/logo_betel.png',12,18,-200);
$pdf->Cell(35,30,'',1);
$pdf->SetFont('Helvetica', 'B', 20);
$pdf->SetTextColor(7,1,180);
$pdf->Cell(155,10,'DESENTUPIDORA BETEL LTDA.',1,1,'C');
$pdf->Cell(35);
$pdf->SetFontSize(8);
$pdf->SetTextColor(0,0,0);
$pdf->Multicell(155,5,'BOMBEIROS E ELETRICISTAS - ESGOTOS - RALOS - PIAS - TANQUES - REDES - COLUNAS DE PRÉDIOS',1,'C');
$pdf->Cell(35);
$pdf->SetFontSize(12);
$pdf->SetTextColor(255,0,0);
$pdf->Multicell(125,10,'Atendimento 24 HORAS - (31)3491-7382 / 0800-2837382',1,'C');
$pdf->Ln(-10);
$pdf->SetLeftMargin(170);
$pdf->SetTextColor(0,0,0);
$pdf->Multicell(30,15,'Nº '.$id,1,'C');
$pdf->Ln(-5);
$pdf->SetFontSize(7);
$pdf->Cell(-125);
$pdf->Multicell(125,5,'AV. SEBASTIÃO DE BRITO, 601 - DONA CLARA - BELO HORIZONTE - MG',1,'C');

$pdf->Ln();
$pdf->Cell(-160);
$pdf->SetMargins(0,0,0);
if($tipo == 0){
    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->Cell(190,8,'ORÇAMENTO',1,1,'C');
}else{
    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->Cell(190,8,'SERVIÇO REALIZADO',1,1,'C');
}

$pdf->SetLeftMargin(10);
$pdf->Ln(2);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(24,6,'Contratante:',0,0,'L');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(166,6,' '.$cliente,0,1,'L');

if (!empty($numero)){
    $numero = ', '.$numero;
}

$pdf->SetLeftMargin(10);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(20,6,'Endereço:',0,0,'L');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(170,6,' '.$endereco.$numero,0,1,'L');

$pdf->SetLeftMargin(10);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(14,6,'Bairro:',0,0,'L');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(87,6,' '.$bairro,0,0,'L');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(12,6,'CEP:',0,0,'L');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(22,6,' '.$cep,0,0,'L');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(40,6,$cidade,0,0,'L');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(15,6,$estado,0,1,'L');

$pdf->SetLeftMargin(10);
$pdf->Cell(14,6,'Fone:',0,0,'L');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(42,6,' '.$fone,0,0,'L');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(30,6,'Fone Comercial:',0,0,'L');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(42,6,' '.$fone_comercial,0,0,'L');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(20,6,'Celular:',0,0,'L');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(42,6,' '.$celular,0,1,'L');

$pdf->SetLeftMargin(10);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(24,6,'CPF / CNPJ:',0,0,'L');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(65,6,' '.$cnpjcpf,0,0,'L');
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(36,6,'Inscrição Estadual:',0,0,'L');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(65,6,' '.$insc_est,0,1,'L');

if(!empty($servicos)){
    $pdf->Ln();
    $pdf->SetLeftMargin(10);
    $pdf->SetFont('Helvetica', 'B', 10);
    $pdf->Cell(20,6,'Quantidade',1,0,'C');
    $pdf->Cell(90,6,'Descrição dos Serviços',1,0,'C');
    $pdf->Cell(25,6,'Garantia',1,0,'C');
    $pdf->Cell(30,6,'Valor Unitário',1,0,'C');
    $pdf->Cell(25,6,'Subtotal',1,1,'C');
    
    foreach ($servicos as $servicos){
        $servico = utf8_decode($servicos->servico);
        $qtd = $servicos->qtd;
        $valorunit = $servicos->vunit;
        $vunit = number_format($valorunit, 2, ',', '.');
        $valortot = $servicos->vtot;
        $vtot1 = str_replace('.', ',',$valortot);
        $vtot = number_format($valortot, 2, ',', '.');
        $desc = utf8_decode($servicos->descricao);
        if($servicos->garantia == 0){
            $garantia = '';
        }else{
            $garantia = $servicos->garantia . ' dias';
        }
        $pdf->SetLeftMargin(10);
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(20,6,$qtd,1,0,'C');
        $pdf->Cell(90,6,$servico,1,0,'C');
        $pdf->Cell(25,6,$garantia,1,0,'L');
        $pdf->Cell(30,6,'R$ '.$vunit,1,0,'L');
        $pdf->Cell(25,6,'R$ '.$vtot,1,1,'L');
        if (!empty($desc)){
            $pdf->Multicell(190,6,$desc,1,'L');
        }
        $somatotal += $servicos->vtot;
    }
    if(!empty($desconto)){
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(155,8,'SUB-TOTAL: ',1,0,'R');
        $pdf->Cell(35,8,'R$ '.number_format($somatotal, 2, ',', '.'),1,1,'L');
        $somatotal -= $desconto;
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->Cell(155,8,'Desconto: ',1,0,'R');
        $pdf->Cell(35,8,'R$ '.number_format($desconto, 2, ',', '.'),1,1,'L');
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->Cell(155,8,'TOTAL: ',1,0,'R');
        $pdf->Cell(35,8,'R$ '.number_format($somatotal, 2, ',', '.'),1,1,'L');
    }else{
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->Cell(155,8,'TOTAL: ',1,0,'R');
    $pdf->Cell(35,8,'R$ '.number_format($somatotal, 2, ',', '.'),1,1,'L');
    }
    
}

$pdf->Ln();
$pdf->SetLeftMargin(10);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(60,8,'FORMA DE PAGAMENTO: ',0,0,'L');
$pdf->SetFont('Helvetica', '', 12);
$pdf->SetTextColor(158,0,0);
switch ($formpag) {
    case 0:
        $formpag = 'DINHEIRO';
        break;
    case 1:
        $formpag = 'CHEQUE';
        break;
    case 2:
        $formpag = 'CARTÃO DE CRÉDITO';
        break;
    case 3:
        $formpag = 'CARTÃO DE DÉBITO';
        break;
    case 4:
        $formpag = 'BOLETO BANCÁRIO';
        break;
}
$pdf->Cell(130,8,$formpag,0,1,'L');

$pdf->Ln();
$pdf->SetLeftMargin(10);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(14,8,'Data: ',0,0,'L');

$pdf->SetFont('Helvetica', '', 12);
$pdf->SetTextColor(158,0,0);
if($dtini != '0000-00-00'){
    $data = strtotime($dtini); 
    $dataserv = date('d/m/Y', $data);
    $pdf->Cell(90,8,$dataserv,0,0,'L');
}else{
    $data = strtotime($created); 
    $dataserv = date('d/m/Y', $data);
    $pdf->Cell(90,8,$dataserv,0,0,'L');
}
if($tipo == 0){
    $valprop = date('d/m/Y', strtotime("+30 days",$data));
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(56,8,'Validade Proposta: ',0,0,'R');
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->SetTextColor(158,0,0);
    $pdf->Cell(30,8,$valprop,0,0,'L');
}


if(!empty($funcionarios)){
    $pdf->Ln();
    $pdf->SetLeftMargin(10);
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(190,8,'Equipe',0,1,'C');
    
    $countfunc = 0;
    foreach ($funcionarios as $qtdfunc){        
        $countfunc ++;
    }
    
    $loopfunc = 1;
    foreach ($funcionarios as $funcionarios){
        $funcionario = utf8_decode($funcionarios->funcionario);
        
        if($loopfunc < $countfunc){
            $allfunc .= $funcionario.', ';
        }else{
            $allfunc .= $funcionario;
        }
        $loopfunc ++;
        
    }
    
    $pdf->SetLeftMargin(10);
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->SetTextColor(0,11,180);
    $pdf->Multicell(190,8,$allfunc,0,'C');
    
    
}    

$pdf->Ln(30);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(95,5,'____________________________________',0,0,'C');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(95,5,'____________________________________',0,1,'C');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(95,4,'Cliente',0,0,'C');
$pdf->SetFont('Helvetica', '', 10);
$pdf->Cell(95,4,'Técnico Responsável',0,1,'C');


ob_start ();

if($tipo == 0){
    $tip = 'orcamento';
}else{
    $tip = 'pedido';
}

$pdf->Output($tip.'_'.$id.'.pdf','I');
?>



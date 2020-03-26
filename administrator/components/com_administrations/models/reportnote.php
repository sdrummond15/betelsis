<?php



defined( '_JEXEC' ) or die( 'Restricted access' );



jimport('joomla.application.component.modeladmin');

jimport( 'joomla.filesystem.file' );



class AdministrationsModelReportnote extends JModelAdmin

{

    

    public function getTable($type = 'Reportnote', $prefix = 'AdministrationsTable', $config = array())

	{

		return JTable::getInstance($type, $prefix, $config);

	}

    

    protected $text_prefix = 'COM_ADMINISTRATIONS';

    

    public function getResult(){

        

        $cli            = '';

        $dati           = '';

        $datf           = '';

        $tip            = '';

        $fun            = '';

        

        $db             = JFactory::getDBO();
        $query	= $db->getQuery(true);

        $client         = JRequest::getVar("client");

        $func           = JRequest::getVar("func");
        
        $tipnote        = JRequest::getVar("tipnote");

        $dateini        = JRequest::getVar("dataini");
        
        $datefim        = JRequest::getVar("datafim");
        
        
        if((empty($client)) && (empty($tipnote)) && (empty($dateini)) && (empty($datefim)) && (empty($func))){

            echo '<div class="relnulo">Informe ao menos um dos valores para que o relatório seja gerado!</div>';

        }else{

            if(!empty($client)){
               $cli =  $query->where('cl.id = '. $client);
            }
                          
            
            if(!empty($tipnote)){
                
               if ($tipnote == 1) {
                    $tipnote = 0;
                }elseif ($tipnote == 2){
                    $tipnote = 1;
                }
                $tip = $query->where('os.tp_orcserv = '. $tipnote);
            }
             if (!empty($dateini)){
                 $dati = $query->where('os.dtini > "'.$dateini.'"');
             }
             
             if (!empty($datefim)){
                 $datf = $query->where('os.dtini < "'.$datefim.'"');
             }

            if(!empty($func)){
                $fun = $query->where('fo.id_func = '. $func);
            }


                $query->select('os.id AS id, cl.nome AS cliente, os.tp_orcserv AS tipnote, os.dtini AS dtini, os.dtfim AS dtfim');
                $query->from('#__clientes AS cl');
                $query->leftJoin('#__orc_serv AS os ON cl.id = os.id_cliente');
                $query->leftJoin('#__funcxorc AS fo ON os.id = fo.id_orc_serv');
                $cli . $dati . $datf . $tip. $fun;

                $query->group('os.id');
                $db->setQuery($query);
                
                $item = $db->loadObjectList();
                
                return $item;
                               


        }

    }

   

    

    public function getForm($data = array(), $loadData = true)

        {

                $form = $this->loadForm('com_administrations.reportnote', 'reportnote', array('control' => '', 'load_data' => $loadData));

                if (empty($form)) {

                        return false;

                }



                return $form;

        }



}



?>
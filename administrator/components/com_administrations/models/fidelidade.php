<?php

/*
 * @package Administrations
 * @com_admininistrations
 * @copyright Copyright (C) Sdrummond, Inc. All rights reserved.
 * @license Sdrummond
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Methods supporting a list of administration.
 * 
 * @package  administration
 * @subpackage com_adminstration
 * @since 2.5
 */

class AdministrationsModelFidelidade extends JModelAdmin
{

     public function getResult()
    {
        $dati           = '';
        $datf           = '';
        $venc           = '';
        $db             = JFactory::getDBO();
        $query	= $db->getQuery(true);
        $dateini        = JRequest::getVar("dataini");

        $datefim        = JRequest::getVar("datafim");


        if((empty($dateini)) && (empty($datefim))){

            echo '<div class="relnulo">Est&aacute; listado os servi&ccedil;os com as datas de vencimento pr&oacute;ximas com 5 dias a mais e 5 dias a menos!</div>';
            $data = date('Y-m-d');
            $venc_ini = date('Y-m-d', strtotime("-5 days",strtotime($data)));
            $venc_fim = date('Y-m-d', strtotime("+5 days",strtotime($data)));
            $dati = $query->where('os.dtvenc BETWEEN "'.$venc_ini.'" AND "'.$venc_fim.'"');

        }else{

             if (!empty($dateini)){
                 $dati = $query->where('os.dtini > "'.$dateini.'"');
             }

             if (!empty($datefim)){
                 $datf = $query->where('os.dtini < "'.$datefim.'"');
             }

        }
                $query->select('os.id AS id, cl.nome AS cliente, os.tp_orcserv AS tipnote, os.dtini AS dtini, os.dtfim AS dtfim');
                $query->from('#__clientes AS cl');
                $query->leftJoin('#__orc_serv AS os ON cl.id = os.id_cliente');
                $dati . $datf;


                $db->setQuery($query);

                $item = $db->loadObjectList();

                return $item;



       

    }





    public function getForm($data = array(), $loadData = true)

        {

                $form = $this->loadForm('com_administrations.fidelidade', 'fidelidade', array('control' => '', 'load_data' => $loadData));

                if (empty($form)) {

                        return false;

                }



                return $form;

        }







}
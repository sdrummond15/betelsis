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

        

        $id_cliente = $_REQUEST['idcliente'];

        $db = JFactory::getDBO();

        $query = $db->getQuery(true);

        $query->select('nome, 

                        contato, 

                        cnpjcpf, 

                        insc_est, 

                        insc_mun, 

                        endereco, 

                        numero, 

                        complemento, 

                        id_bairro, 

                        id_cidade, 

                        cep, 

                        fone, 

                        fone_comercial, 

                        celular, 

                        celular2, 

                        email,

                        email2,

                        published');

        $query->from('#__clientes');

        $query->where('id = '. $id_cliente);

	$db->setQuery($query);

	$db->query();

        $clientes = (array) $db->loadObjectList();

        echo json_encode($clientes);
	exit;
        

	

	?>


<?php
	session_start();
            require_once('Conf/my_general.inc.php');
            require_once ('Conf/my_locale.inc.php');

?>
<html>
	<head>
		<title></title>
		  <ink href="Static/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
                            <script src="Static/js/jquery-1.11.3.min.js"></script>
                            <script src="Static/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div id="wrap">
			<div id="header">
				<h1><?php echo _('Géstion des Stocks') ?></h1>
			</div>
			<div id="content">
				<div id="Menu">
					<h3><?php echo _('Menu'); ?></h3>
					<ul>
						<li><a href="?controller=Home"><?php echo _('Home'); ?></a></li>
						<li><a href="?controller=Products"><?php echo _('Products'); ?></a></li>
						<li><a href="?controller=Categories"><?php echo _('Categories'); ?></a></li>
                                                                            <li><a href="?controller=Stock"><?php echo _('Stock'); ?></a></li>
                                                                                <!--li><a href="?controller=Providers"><?php echo _('Fournisseurs'); ?></a></li-->
                                                                                
					</ul>
				</div>
				<div id="main">
					<?php
                                                                            $try = 3;
						
						while ($try > 0) {
                                                                                    try {
                                                                                        $dbh = new PDO("mysql:host=".DBH_HOST.";dbname=".DBH_NAME.";charset=utf8",DBH_USER,DBH_PASS);
                                                                                        
                                                                                        /*Traitement de la Requete*/ 
                                                                                        $controller = !empty($_GET['controller']) ? $_GET['controller'] : 'Home';
                                                                                        $action = !empty($_GET['action']) ? $_GET['action'] : 'index';
                                                                                        $id = !empty($_GET['id']) ? $_GET['id'] : null;

                                                                                        if (file_exists('Controllers/'.$controller.'Controller.php')) {
                                                                                            include 'Controllers/'.$controller.'Controller.php';
                                                                                            $class = $controller."Controller";
                                                                                            $objet = new $class();
                                                                                            $objet->$action($id);
                                                                                        }
                                                                                        break;
                                                                                    } catch (Exception $e){
                                                                                        $try--;
                                                                                        if ($try == 0) {
                                                                                            echo 'MySQL Connection Database Error: ' . $e->getMessage();
                                                                                        }
                                                                                    }
                                                                                }
					?>
				</div>
			</div>
			<div id="footer">
				© 2016, Lounis Rahmani. Tous droits réservés.
			</div>
		</div>
	</body>
</html>

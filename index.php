<?php
/** Démarrage de la mise en buffer */
// ob_start ();
define ('DIR_ROOT', realpath (dirname (__FILE__)).'/');
define ('DIR_MODELS', DIR_ROOT.'Models/');
define ('DIR_CONTROLLERS', DIR_ROOT.'Controllers/');


/** Définit le path du framework */
ini_set ('include_path', 
                 ini_get ('include_path').':'.DIR_ROOT.'ext:');

/** Chargement des élements principaux */
require_once('etc/my_general.inc.php');
require_once('etc/my_memcache.inc.php');
require_once('etc/my_locale.inc.php');

require 'LR/lib/functions/autoload.php';
require 'LR/lib/functions/location.php';

/** Place l'affichage des erreurs */
if (SITE_STATE & SITE_PROD)
    ini_set ('display_errors', 'Off');

if (!extension_loaded ('gettext'))
{
    function _ ($string) { return $string; }
}
?>
<html>
	<head>
		<title></title>
		  <ink href="static/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
                            <script src="static/js/jquery-1.11.3.min.js"></script>
                            <script src="static/js/bootstrap.min.js"></script>
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
                                                                                        $dbh = new PDO("mysql:host=".DBH_HOST.";dbname=".DBH_NAME,DBH_USER,DBH_PASS);
                                                                                        
                                                                                        /*Traitement de la Requete*/ 
                                                                                        if (file_exists(DIR_CONTROLLERS.'BaseController.php')) {
                                                                                            include DIR_CONTROLLERS.'BaseController.php';
                                                                                            $fc = new Controller (new URIRequest);
                                                                                            $fc->dispatch ();
                                                                                        }
                                                                                        break;
                                                                                    } catch (Exception $e){
                                                                                        $try--;
                                                                                        if ($try == 0) {
                                                                                            logging::error ('MySQL Connection Database Error: ' . $e->getMessage());
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

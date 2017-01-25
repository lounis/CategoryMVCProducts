<?php
/**
 * my_general.inc.php
 * 
 *
 *
 */

//--- 
define ('START_TIME', microtime ());

//--- DIR
if (!defined ('DIR_ROOT'))
    die ("DIR_ROOT, n'est pas définit");

//--- VERSION
define ('VERSION',  trim (file_get_contents (DIR_ROOT.'VERSION')));

//--- SITE
define ('SITE_PROD',    1);
define ('SITE_VALID',   2);
define ('SITE_DEV',     4);
define ('SITE_DEBUG',   8);


if (file_exists (DIR_ROOT.'.dev'))
    define ('SITE_STATE', SITE_DEV);
elseif (file_exists (DIR_ROOT.'.valid'))
    define ('SITE_STATE', SITE_VALID);
elseif (file_exists (DIR_ROOT.'.debug'))
    define ('SITE_STATE', SITE_DEBUG);
else
    define ('SITE_STATE', SITE_PROD);


//--- WWW
if (SITE_STATE & (SITE_DEV | SITE_DEBUG))
    define ('WWW_ROOT', @$_SERVER['HTTP_HOST'].dirname (@$_SERVER["PHP_SELF"]));
elseif (SITE_STATE & (SITE_VALID | SITE_PROD))
     define ('WWW_ROOT', @$_SERVER['HTTP_HOST']);

define ('WWW_HOST', @$_SERVER['HTTP_HOST'].'/');


// if (SITE_STATE & (SITE_DEV | SITE_DEBUG))
//     define ('URL_ROOT', preg_replace ("/^\/(~[^\/]+)(.*)/", "/$1", dirname ($_SERVER['SCRIPT_NAME'])));
// else
    define ('URL_ROOT', '');

if ((SITE_STATE & SITE_PROD) && preg_match('/^admin/', WWW_HOST) && !file_exists(DIR_ROOT.'.admin')) {
  @$msg = <<<EOT
REMOTE_ADDR: $_SERVER[REMOTE_ADDR]
HTTP_X_FORWARDED_FOR: $_SERVER[HTTP_X_FORWARDED_FOR]
HTTP_CLIENT_IP: $_SERVER[HTTP_CLIENT_IP]
HTTP_REFERER: $_SERVER[HTTP_REFERER]
SERVER_NAME: $_SERVER[SERVER_NAME]
SERVER_ADDR: $_SERVER[SERVER_ADDR]
REQUEST_URI: $_SERVER[REQUEST_URI]
EOT;
  mail ('lounis.rahmani@gmail.com', 'tentative d\'intrusion admin', $msg);
  die('');
}


//-- MASTER
define ('DBH_HOST', 'localhost');
define ('DBH_USER', 'root');
define ('DBH_PASS', 'lounis');
define ('DBH_NAME', 'product_stock');

 $LANGUAGE_CODE_TO_LCNAME = array(
      'en' => 'en_US.UTF8',
      'fr' => 'fr_FR.UTF8',
      'nl' => 'nl_NL.UTF8',
      'tr' => 'et_EE.UTF8',
      'de' => 'de_DE.UTF8',
      'ar' => 'ar_SA.UTF8',
);
 
$LANGUAGES = array(
      'fr' => 'Français',
      'en' => 'English',
      'ar' => 'العربية',
      'nl' => 'Nederlands',
      'tr' =>'Türkçe',
      'de' =>'Deutsch',
);


?>

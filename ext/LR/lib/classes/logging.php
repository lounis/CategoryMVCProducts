<?php
/**
 *
 * classes/logging.php
 */

/**
 * Log les données dans syslog
 *
 */

if (!defined ('SYSLOG_NAME'))
	define ('SYSLOG_NAME', 'noname');

class logging 
{
    protected static function log ($type, $msg)
    {
        openlog (SYSLOG_NAME, LOG_PERROR, LOG_USER);
        syslog (LOG_WARNING, $msg);
        closelog ();
    }

    public static function info ($msg, $e = null)
    {
        self::log (LOG_INFO, sprintf ("INFO %s", $msg));
    }

    public static function error ($msg, $e = null)
    {
        self::log (LOG_ERR, sprintf ("ERROR %s", $msg));
        if (!empty($e)) {
            self::sendmsg ('PHP FATAL ERROR',$e);
        }
    }

    public static function debug ($msg, $e = null)
    {
        if (SITE_STATE & (SITE_DEBUG | SITE_VALID)) {
            self::log (LOG_DEBUG, sprintf ("DEBUG %s", $msg));
        }
    }

    public static function notice ($msg, $e = null)
    {
        self::log (LOG_NOTICE, sprintf ("NOTICE %s", $msg));
    }

    public static function warning ($msg, $e = null)
    {
        self::log (LOG_WARNING, sprintf ("WARNING %s", $msg));
        if (!empty($e)) {
          self::sendmsg ('PHP WARNING', $e);
        }
    }
  
  private static function sendmsg ($level, $e)
  {
        $msg = $e->getMessage()."' in ".$e->getFile().":".$e->getLine()."\n\nStack trace:\n".$e->getTraceAsString();
        $backtrace = $e->getTraceAsString();
        $full_backtrace = base64_encode(gzcompress(var_export(debug_backtrace(), true)));
        $requestExport = var_export($_REQUEST, true);
        $aspid = 'undefined';
        $session = 'undefined';
        if (isset($_COOKIE['neteid'])) {
            $aspid = $_COOKIE['neteid'];
        }
        if (isset($_COOKIE['netesession'])) {
            $session = $_COOKIE['netesession'];
        }
    
    $server_vars = array();
    foreach (array('REMOTE_ADDR', 'HTTP_X_FORWARDED_FOR',
        'HTTP_CLIENT_IP', 'HTTP_REFERER', 'SERVER_NAME', 'SERVER_ADDR') as $e)
    {
          if (isset($_SERVER[$e])) {
            $server_vars[$e] = $_SERVER[$e];
          } else {
            $server_vars[$e] = 'undefined';
          }
    }
    $msg .= <<<EOT
\$_REQUEST:
$requestExport

REMOTE_ADDR: $server_vars[REMOTE_ADDR]
HTTP_X_FORWARDED_FOR: $server_vars[HTTP_X_FORWARDED_FOR]
HTTP_CLIENT_IP: $server_vars[HTTP_CLIENT_IP]
HTTP_REFERER: $server_vars[HTTP_REFERER]
SERVER_NAME: $server_vars[SERVER_NAME]
SERVER_ADDR: $server_vars[SERVER_ADDR]
aspid: $aspid
session: $session

Full stack trace (Content-Encoding: base64; Compression: gzip)
----------------------------------------------------
$full_backtrace
----------------------------------------------------
EOT;
    mail   ('lounis.rahmani@gmail.com', $level, $msg);
  }
}

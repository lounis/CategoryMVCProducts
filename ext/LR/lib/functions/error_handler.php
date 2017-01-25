<?php
/**
 * error_handler, ajout un meilleure debug des erreurs.
 *
 */

function process_error_backtrace ($errno, $errstr, $errfile, $errline) {
	switch ($errno)	{
	case E_USER_ERROR: 
		$type = 'error';	break;
		
	case E_USER_WARNING:
		$type = 'warning';	break;
		
	case E_USER_NOTICE:
		$type = 'notice';	break;
		
	default: $type = false;
	}

	if ($type != false) {
		logging::$type (sprintf ("--- Begin %s ---", `uname -n`));
		logging::$type (sprintf ("%s : %s:%s", $errstr, $errfile, $errline));
		foreach (array_reverse (debug_backtrace ()) as $item) {
			logging::$type (sprintf ("%s:%s %s()", 
															 (isset($item['file']) ? $item['file'] : '<unknown file>'),
															 (isset($item['line']) ? $item['line'] : '<unknown line>'),
															 $item['function']));
		}
		logging::$type ("--- End ---");
	}
	
	return true;
}

set_error_handler ("process_error_backtrace");

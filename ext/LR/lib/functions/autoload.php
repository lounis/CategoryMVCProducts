<?php
/**
 * lib/functions/autoload.php 
 *
 *
 */

spl_autoload_register ('autoloadLR');
spl_autoload_register ('autoload_Swift');

function autoloadLR ($class_name)
{
	$class = $class_name.'.php';

	/** répertoire classes principal */
	if (defined ('DIR_CLASSES') && 
			file_exists (DIR_CLASSES.$class))
		{
			require_once DIR_CLASSES.$class;
			return;
		}
	if (defined ('DIR_MODELS') && file_exists (DIR_MODELS.$class))
            {
                require_once DIR_MODELS.$class;
                return;
            }
	/** regarde dans les models */
	// if (file_exists (dirname (__FILE__).'/../models/'.$class))
	// 	return require_once dirname (__FILE__).'/../models/'.$class;
	
	/** regarde dans le framework */
	if (file_exists (dirname (__FILE__).'/../classes/'.$class))
		return require_once dirname (__FILE__).'/../classes/'.$class;

}

function autoload_Swift ($class)
  {  
    //Don't interfere with other autoloaders
    if (0 !== strpos($class, 'Swift'))
    {
      return false;
    }
    
    $swiftBase = '/../../share/swiftmailer';

    $path = dirname(__FILE__).$swiftBase.'/classes/'.str_replace('_', '/', $class).'.php';
     
    if (!file_exists($path))
    {
      return false;
    }

  require_once $path;
  
  //Load in dependency maps
  require_once dirname(__FILE__) . $swiftBase. '/dependency_maps/cache_deps.php';
  require_once dirname(__FILE__) . $swiftBase. '/dependency_maps/mime_deps.php';
  require_once dirname(__FILE__) . $swiftBase. '/dependency_maps/transport_deps.php';
  
  //Load in global library preferences
  require_once dirname(__FILE__) . $swiftBase. '/preferences.php';
  
  }


?>

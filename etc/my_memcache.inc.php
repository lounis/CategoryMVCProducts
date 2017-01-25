<?php
/**
 * my_memcache.inc.php
 * 
 *
 *
 */

// -- HOST
define ('MCHOST_00', 'memcache00');
define ('MCHOST_01', 'memcache01');
define ('MCHOST_02', 'memcache02');
define ('MCHOST_03', 'memcache00.hhqr9x.0001.euw1.cache.amazonaws.com');
define ('MCHOST_04', 'nethomo.hhqr9x.0001.euw1.cache.amazonaws.com');

// -- PORT
define ('MCPORT_11211', '11211');

// -- PREFIX
define ('MCPREFIX_CATALOG', 'catalog');

define ('MCPORT_03', '11212');

//-- Nombre de slave actifs
define ('MC_NUM_SLAVES', 1);

//-- Type de connection (Persistante ou non)
define ('MC_PERSISTENT', true);

// -- Servers
define ('MCH0', MCHOST_00);
define ('MCH0_PORT', MCPORT_11211);

define ('MCH1', MCHOST_01);
define ('MCH1_PORT', MCPORT_11211);

// -- Prefix (prefix-key)
define ('MC_PREFIX_KEY', MCPREFIX_CATALOG);

?>

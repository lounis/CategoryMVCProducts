<?php
/**
 * lib/functions/location.php 
 *
 *
 */

function set_location ($location)
{
	header ("Location: {$location}");
	exit;
}

function set_404_location ($e)
{
	header("HTTP/1.0 404 Not Found");
	echo str_replace ('{MESSAGE}', 
										$e->getMessage (), 
										file_get_contents (DIR_ROOT.'Views/404.html'));
}

function set_fatal_location ($e)
{
	header("HTTP/1.0 404 Not Found");
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header ("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header ("Cache-Control: post-check=0, pre-check=0", false);
	header ("Pragma: no-cache");
	echo str_replace ('{MESSAGE}', 
										$e->getMessage (), 
										file_get_contents (DIR_ROOT.'Views/fatal.html'));
}


function set_custom_location ($e, $file = 'maintenance')
{
	header("HTTP/1.0 500 Internal server error");
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header ("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header ("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header ("Cache-Control: post-check=0, pre-check=0", false);
	header ("Pragma: no-cache");
	
	if (file_exists($file = DIR_ROOT."Views/{$file}.html"))
	{
		echo str_replace ('{MESSAGE}', 
										$e->getMessage (), 
									file_get_contents ($file));
	}
	else
		echo "<b>500 Internal server error</b>, merci de contacter le webmaster";
}

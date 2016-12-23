#!/usr/bin/php
<?php

include_once("config.php");
include_once("main.php");

if ($argc == 2)
{
	if ( file_exists( $xml_file_path ) )
	{
		$xml = updateFileFolder($xml_file_path, $argv[1]);
		$xml->save($xml_file_path);
	}
}



?>
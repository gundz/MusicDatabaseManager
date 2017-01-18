<?php

include_once("config.php");
include_once("node_tools.php");
include_once("media_tools.php");
include_once("xml_tools.php");
include_once("dir_and_files_tools.php");

function updateDatabase( $dom , $path )
{
	checkXMLDirs( $dom );
	checkXMLFiles( $dom );
	checkDirs( $dom , $path );
}

if (is_dir( $path ) )
{
	if ( !file_exists( $xml_file_path ) )
	{
		$dom = generateFullXMLFromDir( $path );
		$dom->save( $xml_file_path );
	}

	$dom = new DOMDocument();
	$dom->load( $xml_file_path );
	updateDatabase( $dom , new DirectoryIterator($path) );
	$dom->save( $xml_file_path );
}
?>
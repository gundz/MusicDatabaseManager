<?php

include_once("config/config.php");
include_once("srcs/node_tools.php");
include_once("srcs/media_tools.php");
include_once("srcs/xml_tools.php");
include_once("srcs/dir_and_files_tools.php");

function updateDatabase( $dom , $path )
{
	checkXMLDirs( $dom );
	checkXMLFiles( $dom );
	checkDirs( $dom , $path );
}

if ( !file_exists( $xml_file_path ) )
{
	$dom = generateFullXMLFromDir( $path );
	$dom->save( $xml_file_path );
}

if ( is_dir( $path ) )
{
	$dom = new DOMDocument();
	$dom->load( $xml_file_path );
	updateDatabase( $dom , new DirectoryIterator( $path ) );
	$dom->save( $xml_file_path );
}

?>
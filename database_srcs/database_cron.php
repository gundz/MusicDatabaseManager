<?php

include_once("config/config.php");
include_once("srcs/node_tools.php");
include_once("srcs/media_tools.php");
include_once("srcs/xml_tools.php");
include_once("srcs/dir_and_files_tools.php");

function updateDatabase( $dom , $dir_path )
{
	checkXMLDirs( $dom );
	checkXMLFiles( $dom );
	checkDirs( $dom , new DirectoryIterator ($dir_path) );
}

if ( !file_exists( $xml_file_path ) )
{
	$dom = generateFullXMLFromDir( $dir_path );
	$dom->save( $xml_file_path );
}
else
{
	if ( is_dir( $dir_path ) )
	{
		if (DOMDocument::load( $xml_file_path ) == false)
		{
			$dom = new DOMDocument();
			$dom = generateFullXMLFromDir( $dir_path );
			$dom->save( $xml_file_path );
		}
		$dom = new DOMDocument();
		$dom->load( $xml_file_path );
		updateDatabase( $dom , $dir_path );
		$dom->save( $xml_file_path );
	}
}

?>
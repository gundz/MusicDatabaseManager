<?php

include_once("config.php");

function getMediaInfos( $path )
{
	global $inform_path;

	$path = escapeshellarg( $path );
	$ret = exec( "mediainfo --inform=file://" . $inform_path . " " . $path );
	$array = array_map('trim', explode(":", $ret));
	return ( $array );
}

function fillArrayWithFileNodes( DirectoryIterator $dir , $xml , $root = null)
{
	$data = array();

	$root = $xml->createElement( 'dir' );
	$root->setAttribute( 'path' , $dir->getPath() );

	foreach ( $dir as $node )
	{
		if ( $node->isDir() && !$node->isDot() )
		{
			$sub = fillArrayWithFileNodes( new DirectoryIterator( $node->getPathname() ) , $xml, $root );
			$root->appendChild($sub);
		}
		else if ( $node->isFile() )
		{
			$sub = $xml->createElement( 'file' );
			$sub->setAttribute( 'path' , $node->getPath() . "/" . $node->getFilename() );

			$media_array = getMediaInfos( $node->getPath() . "/" . $node->getFilename() );
			$sub->setAttribute( 'format', $media_array[0]);
			$sub->setAttribute( 'bitrate', $media_array[1]);
			$sub->setAttribute( 'bitrate_mode', $media_array[2]);

			$root->appendChild( $sub );
		}
	}
	return $root;
}

function generateXMLFromDir($path)
{
	$xml = new DOMDocument( '1.0' , 'utf-8' );

	$sub = fillArrayWithFileNodes( new DirectoryIterator( $path ), $xml);
	
	$xml->appendChild($sub);
	echo $xml->saveXML();
}

generateXMLFromDir("Test_Dir");

?>
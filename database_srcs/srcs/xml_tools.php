<?php

function find_node($dom , $path)
{
	if ( !isset( $path ) || $path == "")
		return ( null );

	$path = realpath( $path );

	$xpath = new DOMXPath( $dom );

	$query = '//dir[@path="' . $path . '"]';

	$entries = $xpath->query( $query );

	if ($entries == false)
		return ( null );

	if ( $entries->item( 0 ) == null)
	{
		$query = '//file[@path="' . $path . '"]';
		$entries = $xpath->query( $query );
	}
	return ( $entries->item( 0 ) );
}

function generateFullXMLFromDir( $path )
{
	$dom = new DOMDocument( '1.0', 'utf-8' );
	$root = $dom->createElement( 'root' );
	$dom->appendChild( $root );

	$tagsRoot = $dom->createElement( 'tags' );
	$root->appendChild( $tagsRoot );

	$dirsRoot = $dom->createElement( 'dirs' );
	$root->appendChild( $dirsRoot );

	$dirs = scanDirectory( $dom , $path );
	$dirsRoot->appendChild( $dirs );

	return ( $dom );
}

function checkXMLDirs( $dom )
{
	$dirs = $dom->getElementsByTagName( "dir" );
	$ToDelete = array();

	foreach ( $dirs as $dir )
	{
		if ( $dir->hasAttribute( "path" ) )
		{
			if (file_exists( $dir->getAttribute( "path" ) ) )
			{
				echo "DIR: \"" . $dir->getAttribute( "path" ) . "\" EXISTS" . PHP_EOL;
			}
			else
			{
				echo "DIR: \"" . $dir->getAttribute( "path" ) . "\" NOT EXISTS" . PHP_EOL;
				$ToDelete[] = $dir;
			}
		}
	}
	foreach ($ToDelete as $dir)
	{
		$dir->parentNode->removeChild( $dir );
	}
}

function checkXMLFiles( $dom )
{
	$files = $dom->getElementsByTagName( "file" );
	$ToDelete = array();

	foreach ( $files as $files )
	{
		if ( $files->hasAttribute( "path" ) )
		{
			if (file_exists( $files->getAttribute( "path" ) ) )
			{
				echo "FILE: \"" . $files->getAttribute( "path" ) . "\" EXISTS" . PHP_EOL;
			}
			else
			{
				echo "FILE: \"" . $files->getAttribute( "path" ) . "\" NOT EXISTS" . PHP_EOL;
				$ToDelete[] = $files;
			}
		}
	}
	foreach ($ToDelete as $files)
	{
		$files->parentNode->removeChild( $files );
	}
}

?>
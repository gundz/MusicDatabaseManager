<?php

function createFileNode( $dom , $file_path )
{
	$ret = getMediaInfos( $file_path );
	$array = array_map( 'trim' , explode( ":" , $ret ) );
	if ( count( $array ) != 3)
		return ( null );

	$node = $dom->createElement( 'file' );

	$node->setAttribute( 'path' , $file_path );
	$node->setAttribute( 'format' , $array[0] );
	$node->setAttribute( 'bitrate' , explode ( " " , $array[1] )[0] );
	$node->setAttribute( 'bitrate_mode' , $array[2] );

	return ( $node );
}

function createDirNode( $dom , $path )
{
	$dirNode = $dom->createElement( 'dir' );
	$dirNode->setAttribute( 'path' , $path );
	return ( $dirNode );
}

function fileNodeExists( $dom , $file_path )
{
	$files = $dom->getElementsByTagName( "file" );

	foreach ( $files as $file )
	{
		if ( $file->hasAttribute( "path" ) )
		{
			if ( $file->getAttribute( "path" ) == $file_path )
			{
				return ( true );
			}
		}
	}
	return ( false );
}

function dirNodeExists( $dom , $file_path )
{
	$dirs = $dom->getElementsByTagName( "dir" );

	foreach ( $dirs as $dir )
	{
		if ( $dir->hasAttribute( "path" ) )
		{
			if ( $dir->getAttribute( "path" ) == $file_path )
			{
				return ( true );
			}
		}
	}
	return ( false );
}

?>
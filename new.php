<?php

$inform_path = "inform.txt";

function getMediaInfos( $file_path )
{
	global $inform_path;

	$file_path = escapeshellarg( $file_path );
	$ret = exec( "mediainfo --inform=file://" . $inform_path . " " . $file_path );
	return ( $ret );
}

function calculateDirNodeAverageQuality( $folder_node )
{
	$files = $folder_node->getElementsByTagName( "file" );

	$total_bitrate = 0;
	$total_bitrate_modes = array();
	$total_formats = array();

	$nbrFiles = 0;
	foreach ( $files as $file )
	{
		if ( $file->hasAttribute( "bitrate" ) )
		{
			$bitrate = $file->getAttribute( "bitrate" );
			$total_bitrate += $bitrate;

			$nbrFiles++;
		}
		if ( $file->hasAttribute( "bitrate_mode" ) )
		{
			$total_bitrate_modes[] = $file->getAttribute( "bitrate_mode" );
		}
		if ( $file->hasAttribute( "format" ) )
		{
			$total_formats[] = $file->getAttribute( "format" );
		}
	}
	if ( $nbrFiles <= 0 )
		return ( false );

	$total_bitrate = floor( $total_bitrate / $nbrFiles );

	$folder_node->setAttribute( 'folder_bitrate' , $total_bitrate );
	$folder_node->setAttribute( 'folder_bitrate_format' , implode( ";" , array_unique( $total_formats ) ) );
	$folder_node->setAttribute( 'folder_bitrate_mode' , implode( ";" , array_unique( $total_bitrate_modes ) ) );

	return ( true );
}

function scanDirectory ( $dom , DirectoryIterator $dirIt )
{
	$nbrFiles = 0;
	$nbrDirs = 0;

	$dirNode = createDirNode( $dom , $dirIt->getPath() );
	foreach ( $dirIt as $dir )
	{
		if ( $dir->isDir() && !$dir->isDot() )
		{
			$subDir = scanDirectory( $dom , new DirectoryIterator( $dir->getPathName() ) );
			$dirNode->appendChild( $subDir );

			$nbrDirs++;
		}
		else if ( $dir->isFile() )
		{
			$fileNode = createFileNode( $dom , $dir->getPathName() );
			if ($fileNode === null)
				continue ;
			$dirNode->appendChild( $fileNode );

			$nbrFiles++;
		}
	}

	if ($nbrDirs == 0 && $nbrFiles > 0)
	{
		calculateDirNodeAverageQuality( $dirNode );
	}
	return ( $dirNode );
}

function generateXMLFromDir( $path )
{
	$dom = new DOMDocument( '1.0', 'utf-8' );
	$root = $dom->createElement( 'root' );
	$dom->appendChild( $root );

	$dirs = scanDirectory( $dom , new DirectoryIterator( $path ) );
	$root->appendChild( $dirs );

	return ( $dom );
}

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

function updateFileNode( $dom , $file_path )
{
	$files = $dom->getElementsByTagName( "file" );

	foreach ( $files as $file )
	{
		if ( $file->hasAttribute( "path" ) )
		{
			if ( $file->getAttribute( "path" ) == $file_path )
			{
				$new_node = createFileNode( $dom , $file_path );
				$file->parentNode->replaceChild( $new_node , $file );
				break ;
			}
		}
	}
	return ( $dom );
}

function deleteFileNode( $dom , $file_path )
{
	$files = $dom->getElementsByTagName( "file" );

	foreach ( $files as $file )
	{
		if ( $file->hasAttribute( "path" ) )
		{
			if ( $file->getAttribute( "path" ) == $file_path )
			{
				$file->parentNode->removeChild( $file );
				break ;
			}
		}
	}
	return ( $dom );
}

function createDirNode( $dom , $path )
{
	$dirNode = $dom->createElement( 'dir' );
	$dirNode->setAttribute( 'path' , $path );
	return ( $dirNode );
}

function updateDirNode( $dom , $dir_path )
{
	$dirs = $dom->getElementsByTagName( "dir" );

	if ( !is_dir( $dir_path ) )
		return ( deleteDirNode( $dom , $dir_path ) );

	foreach ( $dirs as $dir )
	{
		if ( $dir->hasAttribute( "path" ) )
		{
			if ( $dir->getAttribute( "path" ) == $dir_path )
			{
				$new_node = scanDirectory( $dom , new DirectoryIterator( 
					$dir_path ) );
				$dir->parentNode->replaceChild( $new_node , $dir );
				return ( $dom );
			}
		}
	}

	return ( $dom );
}

function deleteDirNode( $dom , $dir_path )
{
	$files = $dom->getElementsByTagName( "dir" );

	foreach ( $files as $file )
	{
		if ( $file->hasAttribute( "path" ) )
		{
			if ( $file->getAttribute( "path" ) == $dir_path )
			{
				$file->parentNode->removeChild( $file );
				break ;
			}
		}
	}
	return ( $dom );
}

if ( !file_exists("database.xml") )
{
	$dom = generateXMLFromDir( "Test_dir" );
	$dom->save( "database.xml" );
}

$dom = new DOMDocument();
$dom->load( "database.xml" );

$dom = updateDirNode( $dom , "Test_dir/" );

echo $dom->SaveXML();
$dom->save( "database.xml" );

?>
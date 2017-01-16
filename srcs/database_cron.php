<?php

include_once("config.php");

function getMediaInfos( $file_path )
{
	global $inform_path;

	$file_path = escapeshellarg( $file_path );
	$ret = exec( "mediainfo --inform=file://" . $inform_path . " " . $file_path );
	return ( $ret );
}

function scanDirectory ( $dom , DirectoryIterator $dirIt, $dirNode = null)
{
	if ($dirNode == null)
	{
		$dirNode = createDirNode( $dom , $dirIt->getPath() );
	}
	foreach ( $dirIt as $dir )
	{
		if ( $dir->isDir() && !$dir->isDot() )
		{
			if (dirNodeExists( $dom , $dir->getPathName() ) == false)
			{
				$subDir = scanDirectory( $dom , new DirectoryIterator( $dir->getPathName() ) );
				$dirNode->appendChild( $subDir );
			}
		}
		else if ( $dir->isFile() )
		{
			if (fileNodeExists( $dom , $dir->getPathName()) == false)
			{
				$fileNode = createFileNode( $dom , $dir->getPathName() );
				if ($fileNode === null)
					continue ;
				$dirNode->appendChild( $fileNode );			
			}

		}
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

function addDir( $dom , $dir_path , $root_path )
{
	$dirs = $dom->getElementsByTagName( "dir" );

	foreach ( $dirs as $dir )
	{
		if ( $dir->hasAttribute( "path" ) )
		{
			if ( $dir->getAttribute( "path" ) == $dir_path )
			{
				scanDirectory( $dom , new DirectoryIterator( $dir->getAttribute( "path" ) ) , $dir );
				return ;
			}
		}
	}
	if (dirname($dir_path) != $root_path)
		addDir($dom, dirname($dir_path), $root_path);
}

function addFile( $dom , $file_path )
{
	$dirs = $dom->getElementsByTagName( "dir" );

	foreach ( $dirs as $dir )
	{
		if ( $dir->hasAttribute( "path" ) )
		{
			if ( $dir->getAttribute( "path" ) == dirname($file_path) )
			{
				$fileNode = createFileNode( $dom , $file_path );
				if ($fileNode === null)
					continue ;
				$dir->appendChild( $fileNode );
				return ;
			}
		}
	}
}

function checkDirs( $dom , DirectoryIterator $dirIt , $dirRoot = null )
{
	if ($dirRoot == null)
	{
		$dirRoot = $dirIt->getPathName();
		echo $dirRoot . PHP_EOL;
	}
	foreach ( $dirIt as $dir )
	{
		if ( $dir->isDir() && !$dir->isDot() )
		{
			if (dirNodeExists( $dom , $dir->getPathName()) )
			{
				echo "DIR: \"" . $dir->getPathName() . "\" EXISTS IN DB" . PHP_EOL;
			}
			else
			{
				echo "DIR: \"" . $dir->getPathName() . "\" NOT EXISTS IN DB" . PHP_EOL;
				addDir( $dom , $dir->getPathName() , $dirRoot );
			}
			checkDirs( $dom , new DirectoryIterator( $dir->getPathName() ) , $dirRoot);
		}
		else if ( $dir->isFile() )
		{
			if (fileNodeExists( $dom , $dir->getPathName()) )
			{
				echo "FILE: \"" . $dir->getPathName() . "\" EXISTS IN DB" . PHP_EOL;
			}
			else
			{
				echo "FILE: \"" . $dir->getPathName() . "\" NOT EXISTS IN DB" . PHP_EOL;
				addFile($dom, $dir->getPathname());
			}
		}
	}
}

function updateDatabase( $dom , $path )
{
	checkXMLDirs( $dom );
	checkXMLFiles( $dom );
	checkDirs( $dom , $path );
}

if ( !file_exists( $xml_file_path ) )
{
	$dom = generateXMLFromDir( $path );
	$dom->save( $xml_file_path );
}

$dom = new DOMDocument();
$dom->load( $xml_file_path );
updateDatabase( $dom , new DirectoryIterator($path) );
$dom->save( $xml_file_path );

?>
<?php

include_once("config.php");

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

function scanDirectory ( $dom , DirectoryIterator $dirIt, $dirNode = null)
{
	if ($dirNode == null)
	{
		echo "ok" .$dirIt->getPath() . PHP_EOL;
		$dirNode = createDirNode( $dom , $dirIt->getPath() );
	}
	foreach ( $dirIt as $dir )
	{
		if ( $dir->isDir() && !$dir->isDot() )
		{
			if (dirNodeExists( $dom , $dir->getPathName() ) == false)
			{
				echo "ok2" .  $dir->getPathname() . PHP_EOL;
				$subDir = scanDirectory( $dom , new DirectoryIterator( $dir->getPathName() ) );
				echo "ok3" . PHP_EOL;
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

function addFile( $dom , $file_path )
{
	$node = createFileNode( $dom , $file_path );
	if ($node == null || fileNodeExists( $dom , $file_path ) )
		return ( false );

	$file_dir = dirname( $file_path );

	$dirs = $dom->getElementsByTagName( "dir" );

	foreach ( $dirs as $dir )
	{
		if ( $dir->hasAttribute( "path" ) )
		{
			if ( $dir->getAttribute( "path" ) == $file_dir )
			{
				$dir->appendChild( $node );
				break ;
			}
		}
	}
	return ( true );
}

function removeFile( $dom , $file_path )
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
}

function addDir( $dom , $dir_path )
{
	$node = scanDirectory( $dom , new DirectoryIterator( $dir_path ) );

	$dirs = $dom->getElementsByTagName( "dir" );

	foreach ( $dirs as $dir )
	{
		if ( $dir->hasAttribute( "path" ) )
		{
			if ( $dir->getAttribute( "path" ) == dirname($dir_path) )
			{
				$dir->appendChild( $node );
				break ;
			}
		}
	}
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

function addDir2( $dom , $dir_path , $root_path )
{
	$dirs = $dom->getElementsByTagName( "dir" );

	echo "root_path = " . $root_path . PHP_EOL;
	foreach ( $dirs as $dir )
	{
		if ( $dir->hasAttribute( "path" ) )
		{
			if ( $dir->getAttribute( "path" ) == $dir_path )
			{
				echo "found ! " . $dir->getAttribute( "path" ) . PHP_EOL;
				scanDirectory( $dom , new DirectoryIterator( $dir->getAttribute( "path" ) ) , $dir );
				return ;
			}
		}
	}
	if (dirname($dir_path) != $root_path)
		addDir2($dom, dirname($dir_path), $root_path);
}

function addFile2( $dom , $file_path )
{
	$dirs = $dom->getElementsByTagName( "dir" );

	foreach ( $dirs as $dir )
	{
		if ( $dir->hasAttribute( "path" ) )
		{
			if ( $dir->getAttribute( "path" ) == dirname($file_path) )
			{
				echo "found ! " . $dir->getAttribute( "path" ) . PHP_EOL;
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
				addDir2( $dom , $dir->getPathName() , $dirRoot );
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
				addFile2($dom, $dir->getPathname());
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

if ($argc == 1)
{
	$dom = new DOMDocument();
	$dom->load( $xml_file_path );
	updateDatabase( $dom , new DirectoryIterator($path) );
	$dom->save( $xml_file_path );
}

?>
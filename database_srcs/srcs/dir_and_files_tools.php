<?php

function check_file_extention( $filename )
{
	$allowed =  array('mp3','flac');
	$ext = strtolower( pathinfo( $filename , PATHINFO_EXTENSION ) );
	if( !in_array( $ext , $allowed ) )
		return ( false );
	return ( true );
}

function scanDirectory ( $dom , $path, $dirNode = null)
{
	$files = array_slice( scandir( $path) , 2);
	if ($dirNode == null)
	{
		$dirNode = createDirNode( $dom , $path );
	}
	foreach ( $files as $file )
	{
		$pathName = $path . DIRECTORY_SEPARATOR . $file;

		if ( is_dir( $pathName ) && ( $file != "." && $file != ".." ) )
		{
			if (dirNodeExists( $dom , $pathName ) == false)
			{
				$subDir = scanDirectory( $dom , $pathName );
				$dirNode->appendChild( $subDir );
			}
		}
		else if ( is_file( $pathName ) )
		{
			if ( check_file_extention( $pathName ) == false )
				continue ;
			if (fileNodeExists( $dom , $pathName ) == false)
			{
				$fileNode = createFileNode( $dom , $pathName );
				if ($fileNode === null)
					continue ;
				$dirNode->appendChild( $fileNode );
			}

		}
	}
	return ( $dirNode );
}

function addDir( $dom , $dir_path , $root_path )
{
	$node = find_node( $dom , dirname( $dir_path ) );
	if ( $node == null )
	{
		if ( dirname ( $dir_path ) != $root_path )
			addDir( $dom , dirname( $dir_path ) , $root_path );
		else
			return ;
	}
	scanDirectory( $dom , $node->getAttribute( "path" ) , $node );
}

function addFile( $dom , $file_path )
{
	$node = find_node( $dom , dirname( $file_path ) );
	if ( $node == null )
		return ;
	$fileNode = createFileNode( $dom , $file_path );
	if ($fileNode === null)
		return ;
	$node->appendChild( $fileNode );
}

function checkDirs( $dom , DirectoryIterator $dirIt , $dirRoot = null )
{
	if ($dirRoot == null)
	{
		$dirRoot = $dirIt->getPathName();
	}
	foreach ( $dirIt as $dir )
	{
		if ( $dir->isDir() && !$dir->isDot() )
		{
			if ( find_node($dom, $dir->getPathName()) != null )
			{
				echo "DIR: \"" . $dir->getPathName() . "\" EXISTS IN DB" . PHP_EOL;
			}
			else
			{
				echo "DIR: \"" . $dir->getPathName() . "\" NOT EXISTS IN DB" . PHP_EOL;
				addDir( $dom , $dir->getPathName() , $dirRoot );
			}
			checkDirs( $dom , new DirectoryIterator( $dir->getPathName() ) , $dirRoot );
		}
		else if ( $dir->isFile() )
		{
			if ( check_file_extention( $dir->getPathName() ) == false )
				continue ;
			if (find_node($dom, $dir->getPathName()) != null)
			{
				echo "FILE: \"" . $dir->getPathName() . "\" EXISTS IN DB" . PHP_EOL;
			}
			else
			{
				echo "FILE: \"" . $dir->getPathName() . "\" NOT EXISTS IN DB" . PHP_EOL;
				addFile( $dom, $dir->getPathName() );
			}
		}
	}
}

?>
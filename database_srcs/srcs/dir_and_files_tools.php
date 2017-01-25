<?php

function scanDirectory2 ( $dom , DirectoryIterator $dirIt, $dirNode = null)
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

function scanDirectory ( $dom , $path, $dirNode = null)
{
	$files = array_slice( scandir( $path) , 2);
	natcasesort( $files );

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
	$dirs = $dom->getElementsByTagName( "dir" );

	foreach ( $dirs as $dir )
	{
		if ( $dir->hasAttribute( "path" ) )
		{
			if ( $dir->getAttribute( "path" ) == $dir_path )
			{
				scanDirectory( $dom , $dir->getAttribute( "path" ) , $dir );
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
		//echo $dirRoot . PHP_EOL;
	}
	foreach ( $dirIt as $dir )
	{
		if ( $dir->isDir() && !$dir->isDot() )
		{
			if (dirNodeExists( $dom , $dir->getPathName()) )
			{
				//echo "DIR: \"" . $dir->getPathName() . "\" EXISTS IN DB" . PHP_EOL;
			}
			else
			{
				//echo "DIR: \"" . $dir->getPathName() . "\" NOT EXISTS IN DB" . PHP_EOL;
				addDir( $dom , $dir->getPathName() , $dirRoot );
			}
			checkDirs( $dom , new DirectoryIterator( $dir->getPathName() ) , $dirRoot );
		}
		else if ( $dir->isFile() )
		{
			if (fileNodeExists( $dom , $dir->getPathName() ) )
			{
				//echo "FILE: \"" . $dir->getPathName() . "\" EXISTS IN DB" . PHP_EOL;
			}
			else
			{
				//echo "FILE: \"" . $dir->getPathName() . "\" NOT EXISTS IN DB" . PHP_EOL;
				addFile( $dom, $dir->getPathname() );
			}
		}
	}
}

?>
<?php

include_once("config.php");

function getMediaInfos( $path )
{
	global $inform_path;

	$path = escapeshellarg( $path );
	$ret = exec( "mediainfo --inform=file://" . $inform_path . " " . $path );
	$array = array_map( 'trim' , explode( ":" , $ret ));
	return ( $array );
}

function TagNode( $node , $path )
{
	$media_array = getMediaInfos( $path );
	$node->setAttribute( 'format' , $media_array[0] );
	$node->setAttribute( 'bitrate' , $media_array[1] );
	$node->setAttribute( 'bitrate_mode' , $media_array[2] );
	return ( $node );
}

function calculateFolderNodeBitrate( $xml_folder_node )
{
	$tags = $xml_folder_node->getElementsByTagName( "file" );

	$total_bitrate = 0;
	$total_bitrate_mode = array();
	$total_format = array();

	$i = 0;
	foreach( $tags as $tag )
	{
		if ($tag->hasAttribute( "bitrate" ))
		{
			$bitrate = explode( " " , $tag->getAttribute( "bitrate" ))[0];
			$total_bitrate_mode[] = $tag->getAttribute( 'bitrate_mode' );
			$total_format[] = $tag->getAttribute( 'format' );

			$total_bitrate += $bitrate;
			$i++;
		}
	}
	$total_bitrate = floor( $total_bitrate / $i );

	$dir = $tags->item(0)->parentNode;
	
	$dir->setAttribute( 'folder_bitrate' , $total_bitrate );
	$dir->setAttribute( 'folder_bitrate_format' , implode( ";" , array_unique( $total_format ) ) );
	$dir->setAttribute( 'folder_bitrate_mode' , implode( ";" , array_unique( $total_bitrate_mode ) ) );
	
	return ( $xml_folder_node );
}

function fillArrayWithFileNodes( DirectoryIterator $dir , $xml , $root = null)
{
	$nbrSubDir = 0;

	$root = $xml->createElement( 'dir' );
	$root->setAttribute( 'path' , $dir->getPath() );

	foreach ( $dir as $node )
	{
		if ( $node->isDir() && !$node->isDot() )
		{
			$sub = fillArrayWithFileNodes( new DirectoryIterator( $node->getPathname() ) , $xml, $root );
			$root->appendChild($sub);

			$nbrSubDir++;
		}
		else if ( $node->isFile() )
		{
			$path = $node->getPath() . "/" . $node->getFilename();
			$sub = $xml->createElement( 'file' );
			$sub->setAttribute( 'path' , $path );

			$node = TagNode( $sub, $path );

			$root->appendChild( $sub );
		}
	}

	if ($nbrSubDir == 0)
	{
		calculateFolderNodeBitrate( $root );
	}
	return ( $root );
}

function generateXMLFromDir( $path )
{
	$xml = new DOMDocument( '1.0' , 'utf-8' );

	$sub = fillArrayWithFileNodes( new DirectoryIterator( $path ) , $xml );
	$xml->appendChild( $sub );

	return ( $xml );
}

function updateFileFolder($xml_file_path, $file_path = null)
{
	$dom = new DOMDocument();
	$dom->load( $xml_file_path );

	$tags = $dom->getElementsByTagName("dir");
	foreach( $tags as $tag )
	{
		if ($tag->hasAttribute( "path" ) )
		{
			if ($tag->getAttribute( "path" ) == dirname( $file_path ) )
			{
				$new = ( fillArrayWithFileNodes( new DirectoryIterator( $tag->parentNode->getAttribute( "path" ) ) , $dom, $tag->parentNode ) );
				$tag->parentNode->replaceChild( $new, $tag );
				break ;
			}
		}
	}
	return ( $dom );
}

if (!file_exists($xml_file_path))
{
	$xml = generateXMLFromDir($path);
	$xml->save($xml_file_path);	
}
else
{
	$xml = updateFileFolder($xml_file_path, "Test_Dir/test/supertest/live.mp3");
	$xml->save($xml_file_path);	
}

?>
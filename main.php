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

function calculateBitrate($xml_folder_node)
{
	$tags = $root->getElementsByTagName("file");

	$total_bitrate = 0;
	$i = 0;
	foreach($tags as $file)
	{
		if ($tag->hasAttribute("bitrate"))
		{
			$bitrate = explode(" ", $tag->getAttribute("bitrate"))[0];
			$total_bitrate += $bitrate;
			$i++;
		}
	}
	$total_bitrate = floor($total_bitrate / $i);

	$var = $tags->item(0)->parentNode;
	$var->setAttribute('folder_bitrate', $total_bitrate);
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
		$listePays = $root->getElementsByTagName("file");

		$total_bitrate = 0;
		$i = 0;
		foreach($listePays as $pays)
		{
			if ($pays->hasAttribute("bitrate"))
			{
				$bitrate = explode(" ", $pays->getAttribute("bitrate"))[0];
				$total_bitrate += $bitrate;
				$i++;
			}
		}
		$total_bitrate = floor($total_bitrate / $i);

		$var = $listePays->item(0)->parentNode;
		$var->setAttribute('folder_bitrate', $total_bitrate);
	}
	return ( $root );
}

function generateXMLFromDir( $path )
{
	$xml = new DOMDocument( '1.0' , 'utf-8' );

	$sub = fillArrayWithFileNodes( new DirectoryIterator( $path ) , $xml );
	$xml->appendChild( $sub );

	$xml = $xml->saveXML();
	echo $xml;
	return ( $xml );
}

function test($xml_file, $file_path = null)
{
	$dom = new DOMDocument();
	$dom->loadXML($xml_file);


	$listePays = $dom->getElementsByTagName("file");
	foreach($listePays as $pays)
	{
		echo $pays->nodeValue;
		if ($pays->hasAttribute("path"))
		{
			echo $pays->parentNode->getAttribute("path") . " - " . basename($pays->getAttribute("path"));
		}
		echo "\n";
	}
}

$xml = generateXMLFromDir($path);

// test($xml);

?>
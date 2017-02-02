<?php

include_once("config/config.php");

$dom = new DOMDocument();
$dom->load( $xml_file_path );

function find_node($dom , $path)
{
	$path = addslashes( $path );

	$xpath = new DOMXPath( $dom );

	$dir_query = "//dir[@path='" . $path. "']";
	$entries = $xpath->query($dir_query);

	if ($entries->item(0) == null)
	{
		$file_query = "//file[@path='" . $path. "']";
		$entries = $xpath->query( $file_query );
	}

	return ( $entries->item(0) );
}

$node = find_node($dom, $_POST["pk"]);

if ($_POST["name"] == "comment")
{
	$node = find_node($dom , $_POST["pk"]);
	$node->setAttribute( 'comment' , $_POST["value"] );
	$dom->save( $xml_file_path );
}

if ($_POST["name"] == "country")
{
	$node = find_node($dom , $_POST["pk"]);
	$node->setAttribute( 'country' , $_POST["value"] );
	$dom->save( $xml_file_path );
}

?>
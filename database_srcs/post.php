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

if ($_POST["name"] == "tag")
{
	$xpath = new DOMXPath( $dom );

	$tags_node = $xpath->query("//tags")->item(0);
	foreach ($_POST["value"] as $value)
	{
		$ret = $xpath->query("//tag[text()='" . $value . "']");
		if ($ret == false OR $ret->item(0) == null)
		{
			$tag = $dom->createElement("tag", $value);
			$tags_node->appendChild($tag);
		}
	}

	$node = find_node($dom, $_POST["pk"]);
	$tags = json_decode($node->getAttribute('tags'));
	if ($tags == null)
		$tags = array();
	else
		$tags = array($tags);
	foreach ($_POST["value"] as $value)
	{
		if (in_array($value, $tags) == false && $value != null)
			$tags[] = $value;
	}
	$node->setAttribute("tag", json_encode($tags));

	$dom->save( $xml_file_path );
}
?>
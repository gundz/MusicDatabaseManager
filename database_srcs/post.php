<?php

include_once("config/config.php");

$dom = new DOMDocument();
$dom->load( $xml_file_path );

$dirs = $dom->getElementsByTagName( "file" );

foreach ( $dirs as $dir )
{
	if ( $dir->hasAttribute( "path" ) )
	{
		if ($_POST["name"] == "comment")
		{
			if ( $_POST["pk"] == $dir->getAttribute( "path" ) )
			{
				$dir->setAttribute( 'comment' , $_POST["value"] );
				$dom->save( $xml_file_path );
				exit(http_response_code(200));
			}
		}
		if ($_POST["name"] == "country")
		{
			if ( $_POST["pk"] == $dir->getAttribute( "path" ) )
			{
				$dir->setAttribute( 'country' , $_POST["value"] );
				$dom->save( $xml_file_path );
				exit(http_response_code(200));
			}
		}
	}
}

exit(http_response_code(500));

?>
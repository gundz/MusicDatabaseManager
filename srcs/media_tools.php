<?php

function getMediaInfos( $file_path )
{
	global $inform_path;

	$file_path = escapeshellarg( $file_path );
	$ret = exec( "mediainfo --inform=file://" . $inform_path . " " . $file_path );
	return ( $ret );
}

?>
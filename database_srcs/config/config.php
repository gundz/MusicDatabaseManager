<?php

if (($ret = getenv("DIR_PATH")))
	$dir_path = $ret;
else
	$dir_path = "Test_Dir";

if (($ret = getenv("INFORM_PATH")))
	$inform_path = $ret;
else
	$inform_path = "srcs/inform.txt";

if (($ret = getenv("DATABASE_PATH")))
{
	$xml_file_path = $ret;
}
else
	$xml_file_path = "database.xml";

?>
function basename(str)
{
   var base = new String(str).substring(str.lastIndexOf('/') + 1);
    if(base.lastIndexOf(".") != -1)
        base = base.substring(0, base.lastIndexOf("."));
   return base;
}

function setDir(node)
{
	dir = {
		_type: "dir",
		_path: $(node).attr('path'),
		_content: []
	}
	return (dir);
}

function setFile(node)
{
	file = {
		_type: "file",
		_path: $(node).attr('path'),
		_format: $(node).attr('format'),
		_bitrate: $(node).attr('bitrate'),
		_bitrate_mode: $(node).attr('bitrate_mode'),
	}
	return (file);
}

function scanDir(dirNode)
{
	var dir = setDir(dirNode);

	$(dirNode).children().each(function(index)
	{
		if (this.nodeName == "dir")
		{
			dir._content[index] = scanDir($(this));
		}
		else if (this.nodeName == "file")
		{
			dir._content[index] = setFile($(this));
		}
	});
	return (dir);
}

function getFileDetails(file)
{
	var ret;
	if (file._format == "FLAC")
		ret = "(FLAC)";
	else if (file._format == "MPEG Audio")
		ret = "(MP3 " + file._bitrate + ' ' + file._bitrate_mode + ')';
	return (ret);
}

function showTree($dir, $id = null, $id_text = null, $root = null)
{
	if ($id == null)
		$id = 0;

	if ($id_text == null)
		$id_text = "item-0";
	else
		$id_text = $id_text + "-" + $id;

	if ($root == null)
		$root = $(".css-treeview").children();

	$root = $root.append('<li><input type="checkbox" id="' + $id_text + '"/><label for="' + $id_text + '">' +basename($dir._path)+ '</label><ul>');

	$root = $root.find("ul").last();

	$($dir._content).each(function(index)
	{
		if (this._type == "dir")
		{
			showTree(this, index, $id_text, $root);
		}
		else if (this._type == "file")
		{
			var fileDetails = getFileDetails(this);
			$root.append('<li><a href="' +this._path+ '">' +basename(this._path)+ ' ' + fileDetails + '  ' + '</a></li>');
		}
	});

	$root.append('</ul></li>');
}

var xml = '<?xml version="1.0" encoding="utf-8"?><root><dir path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir"><dir path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra"><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/11_Invidia - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="1" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/04_Schrödinger - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="1" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/09_Free Clarinet Screamin\' in My Brain - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="922" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/08_KR For Things to See - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="889" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/06_African Trip (feat. Lisa Gutkin) - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="994" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/12_Noise in Sepher, Pt. 2 (feat Taron Benson) - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="1" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/02_(E)Met - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="1" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/05_Cabbalistic Snare - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="1" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/07_Uruk (feat. David Krakauer &amp; Leib Glantz) - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="950" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/03_Lady Mydriasis (feat. Frederika) - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="1" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/10_Samâ - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="966" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2013 - Noise in Sepher - Anakronic Electro Orkestra/01_Noise in Sepher, Pt. 1 - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="944" bitrate_mode="VBR"/></dir><dir path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra"><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/04 - Krazziak - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="1" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/07 - Kalumnia - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="968" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/06 - Why Is It Funny (feat. David Krakauer) (Remix) - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="968" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/05 - Shadok - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="1" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/01 - Nign for Lisa Gutkin - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="1" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/02 - Zibn (Composer\'s Cut) - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="956" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/10 - Free Klarinet Screamin In My Head - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="889" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/09 - Vendetta - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="946" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/11 - Speak With Ghosts (Composer\'s Cut) - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="968" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/03 - Terk In America - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="930" bitrate_mode="VBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/2011 - Speak With Ghosts - Anakronic Electro Orkestra/08 - Deadman\'s Song - Anakronic Electro Orkestra.flac" format="FLAC" bitrate="899" bitrate_mode="VBR"/></dir><dir path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/Divers"><dir path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/Divers/Live"><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/Divers/Live/Anakronic-Electro-Orkestra-Live-Partie-1-.mp3" format="MPEG Audio" bitrate="128" bitrate_mode="CBR"/><file path="/home/gundz/Prog/MusicDatabaseManager/Test_Dir/Divers/Live/Anakronic-Electro-Orkestra-Live-Partie-2-.mp3" format="MPEG Audio" bitrate="128" bitrate_mode="CBR"/></dir></dir></dir></root>';

var xmlDoc = $.parseXML( xml );
var $xml = $(xmlDoc);
var $root = $xml.find("root");

$ret = scanDir($root.children());
console.log($ret);
showTree($ret);
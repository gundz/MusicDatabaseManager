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
	{
		$id = 0;
		checked = 'checked="checked"';
	}
	else
		checked = '';

	if ($id_text == null)
		$id_text = "item-0";
	else
		$id_text = $id_text + "-" + $id;

	if ($root == null)
		$root = $(".css-treeview").children();

	$root = $root.append('<li><input type="checkbox" ' +checked+ ' id="' + $id_text + '"/><label for="' + $id_text + '">' +basename($dir._path)+ '</label><ul>');
	
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

$.ajax({
	'type': "GET",
	'url': "database.xml",
	'dataType': "xml",
    success: function (xml)
    {
		var $xml = $(xml);
		var $root = $xml.find("root");

		$ret = scanDir($root.children());
		showTree($ret);
    }
});
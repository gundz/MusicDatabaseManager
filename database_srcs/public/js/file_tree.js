var isoCountries=[{id:"AF",text:"Afghanistan"},{id:"AX",text:"Aland Islands"},{id:"AL",text:"Albania"},{id:"DZ",text:"Algeria"},{id:"AS",text:"American Samoa"},{id:"AD",text:"Andorra"},{id:"AO",text:"Angola"},{id:"AI",text:"Anguilla"},{id:"AQ",text:"Antarctica"},{id:"AG",text:"Antigua And Barbuda"},{id:"AR",text:"Argentina"},{id:"AM",text:"Armenia"},{id:"AW",text:"Aruba"},{id:"AU",text:"Australia"},{id:"AT",text:"Austria"},{id:"AZ",text:"Azerbaijan"},{id:"BS",text:"Bahamas"},{id:"BH",text:"Bahrain"},{id:"BD",text:"Bangladesh"},{id:"BB",text:"Barbados"},{id:"BY",text:"Belarus"},{id:"BE",text:"Belgium"},{id:"BZ",text:"Belize"},{id:"BJ",text:"Benin"},{id:"BM",text:"Bermuda"},{id:"BT",text:"Bhutan"},{id:"BO",text:"Bolivia"},{id:"BA",text:"Bosnia And Herzegovina"},{id:"BW",text:"Botswana"},{id:"BV",text:"Bouvet Island"},{id:"BR",text:"Brazil"},{id:"IO",text:"British Indian Ocean Territory"},{id:"BN",text:"Brunei Darussalam"},{id:"BG",text:"Bulgaria"},{id:"BF",text:"Burkina Faso"},{id:"BI",text:"Burundi"},{id:"KH",text:"Cambodia"},{id:"CM",text:"Cameroon"},{id:"CA",text:"Canada"},{id:"CV",text:"Cape Verde"},{id:"KY",text:"Cayman Islands"},{id:"CF",text:"Central African Republic"},{id:"TD",text:"Chad"},{id:"CL",text:"Chile"},{id:"CN",text:"China"},{id:"CX",text:"Christmas Island"},{id:"CC",text:"Cocos (Keeling) Islands"},{id:"CO",text:"Colombia"},{id:"KM",text:"Comoros"},{id:"CG",text:"Congo"},{id:"CD",text:"Congo}, Democratic Republic"},{id:"CK",text:"Cook Islands"},{id:"CR",text:"Costa Rica"},{id:"CI",text:"Cote D'Ivoire"},{id:"HR",text:"Croatia"},{id:"CU",text:"Cuba"},{id:"CY",text:"Cyprus"},{id:"CZ",text:"Czech Republic"},{id:"DK",text:"Denmark"},{id:"DJ",text:"Djibouti"},{id:"DM",text:"Dominica"},{id:"DO",text:"Dominican Republic"},{id:"EC",text:"Ecuador"},{id:"EG",text:"Egypt"},{id:"SV",text:"El Salvador"},{id:"GQ",text:"Equatorial Guinea"},{id:"ER",text:"Eritrea"},{id:"EE",text:"Estonia"},{id:"ET",text:"Ethiopia"},{id:"FK",text:"Falkland Islands (Malvinas)"},{id:"FO",text:"Faroe Islands"},{id:"FJ",text:"Fiji"},{id:"FI",text:"Finland"},{id:"FR",text:"France"},{id:"GF",text:"French Guiana"},{id:"PF",text:"French Polynesia"},{id:"TF",text:"French Southern Territories"},{id:"GA",text:"Gabon"},{id:"GM",text:"Gambia"},{id:"GE",text:"Georgia"},{id:"DE",text:"Germany"},{id:"GH",text:"Ghana"},{id:"GI",text:"Gibraltar"},{id:"GR",text:"Greece"},{id:"GL",text:"Greenland"},{id:"GD",text:"Grenada"},{id:"GP",text:"Guadeloupe"},{id:"GU",text:"Guam"},{id:"GT",text:"Guatemala"},{id:"GG",text:"Guernsey"},{id:"GN",text:"Guinea"},{id:"GW",text:"Guinea-Bissau"},{id:"GY",text:"Guyana"},{id:"HT",text:"Haiti"},{id:"HM",text:"Heard Island & Mcdonald Islands"},{id:"VA",text:"Holy See (Vatican City State)"},{id:"HN",text:"Honduras"},{id:"HK",text:"Hong Kong"},{id:"HU",text:"Hungary"},{id:"IS",text:"Iceland"},{id:"IN",text:"India"},{id:"ID",text:"Indonesia"},{id:"IR",text:"Iran}, Islamic Republic Of"},{id:"IQ",text:"Iraq"},{id:"IE",text:"Ireland"},{id:"IM",text:"Isle Of Man"},{id:"IL",text:"Israel"},{id:"IT",text:"Italy"},{id:"JM",text:"Jamaica"},{id:"JP",text:"Japan"},{id:"JE",text:"Jersey"},{id:"JO",text:"Jordan"},{id:"KZ",text:"Kazakhstan"},{id:"KE",text:"Kenya"},{id:"KI",text:"Kiribati"},{id:"KR",text:"Korea"},{id:"KW",text:"Kuwait"},{id:"KG",text:"Kyrgyzstan"},{id:"LA",text:"Lao People's Democratic Republic"},{id:"LV",text:"Latvia"},{id:"LB",text:"Lebanon"},{id:"LS",text:"Lesotho"},{id:"LR",text:"Liberia"},{id:"LY",text:"Libyan Arab Jamahiriya"},{id:"LI",text:"Liechtenstein"},{id:"LT",text:"Lithuania"},{id:"LU",text:"Luxembourg"},{id:"MO",text:"Macao"},{id:"MK",text:"Macedonia"},{id:"MG",text:"Madagascar"},{id:"MW",text:"Malawi"},{id:"MY",text:"Malaysia"},{id:"MV",text:"Maldives"},{id:"ML",text:"Mali"},{id:"MT",text:"Malta"},{id:"MH",text:"Marshall Islands"},{id:"MQ",text:"Martinique"},{id:"MR",text:"Mauritania"},{id:"MU",text:"Mauritius"},{id:"YT",text:"Mayotte"},{id:"MX",text:"Mexico"},{id:"FM",text:"Micronesia}, Federated States Of"},{id:"MD",text:"Moldova"},{id:"MC",text:"Monaco"},{id:"MN",text:"Mongolia"},{id:"ME",text:"Montenegro"},{id:"MS",text:"Montserrat"},{id:"MA",text:"Morocco"},{id:"MZ",text:"Mozambique"},{id:"MM",text:"Myanmar"},{id:"NA",text:"Namibia"},{id:"NR",text:"Nauru"},{id:"NP",text:"Nepal"},{id:"NL",text:"Netherlands"},{id:"AN",text:"Netherlands Antilles"},{id:"NC",text:"New Caledonia"},{id:"NZ",text:"New Zealand"},{id:"NI",text:"Nicaragua"},{id:"NE",text:"Niger"},{id:"NG",text:"Nigeria"},{id:"NU",text:"Niue"},{id:"NF",text:"Norfolk Island"},{id:"MP",text:"Northern Mariana Islands"},{id:"NO",text:"Norway"},{id:"OM",text:"Oman"},{id:"PK",text:"Pakistan"},{id:"PW",text:"Palau"},{id:"PS",text:"Palestinian Territory}, Occupied"},{id:"PA",text:"Panama"},{id:"PG",text:"Papua New Guinea"},{id:"PY",text:"Paraguay"},{id:"PE",text:"Peru"},{id:"PH",text:"Philippines"},{id:"PN",text:"Pitcairn"},{id:"PL",text:"Poland"},{id:"PT",text:"Portugal"},{id:"PR",text:"Puerto Rico"},{id:"QA",text:"Qatar"},{id:"RE",text:"Reunion"},{id:"RO",text:"Romania"},{id:"RU",text:"Russian Federation"},{id:"RW",text:"Rwanda"},{id:"BL",text:"Saint Barthelemy"},{id:"SH",text:"Saint Helena"},{id:"KN",text:"Saint Kitts And Nevis"},{id:"LC",text:"Saint Lucia"},{id:"MF",text:"Saint Martin"},{id:"PM",text:"Saint Pierre And Miquelon"},{id:"VC",text:"Saint Vincent And Grenadines"},{id:"WS",text:"Samoa"},{id:"SM",text:"San Marino"},{id:"ST",text:"Sao Tome And Principe"},{id:"SA",text:"Saudi Arabia"},{id:"SN",text:"Senegal"},{id:"RS",text:"Serbia"},{id:"SC",text:"Seychelles"},{id:"SL",text:"Sierra Leone"},{id:"SG",text:"Singapore"},{id:"SK",text:"Slovakia"},{id:"SI",text:"Slovenia"},{id:"SB",text:"Solomon Islands"},{id:"SO",text:"Somalia"},{id:"ZA",text:"South Africa"},{id:"GS",text:"South Georgia And Sandwich Isl."},{id:"ES",text:"Spain"},{id:"LK",text:"Sri Lanka"},{id:"SD",text:"Sudan"},{id:"SR",text:"Suriname"},{id:"SJ",text:"Svalbard And Jan Mayen"},{id:"SZ",text:"Swaziland"},{id:"SE",text:"Sweden"},{id:"CH",text:"Switzerland"},{id:"SY",text:"Syrian Arab Republic"},{id:"TW",text:"Taiwan"},{id:"TJ",text:"Tajikistan"},{id:"TZ",text:"Tanzania"},{id:"TH",text:"Thailand"},{id:"TL",text:"Timor-Leste"},{id:"TG",text:"Togo"},{id:"TK",text:"Tokelau"},{id:"TO",text:"Tonga"},{id:"TT",text:"Trinidad And Tobago"},{id:"TN",text:"Tunisia"},{id:"TR",text:"Turkey"},{id:"TM",text:"Turkmenistan"},{id:"TC",text:"Turks And Caicos Islands"},{id:"TV",text:"Tuvalu"},{id:"UG",text:"Uganda"},{id:"UA",text:"Ukraine"},{id:"AE",text:"United Arab Emirates"},{id:"GB",text:"United Kingdom"},{id:"US",text:"United States"},{id:"UM",text:"United States Outlying Islands"},{id:"UY",text:"Uruguay"},{id:"UZ",text:"Uzbekistan"},{id:"VU",text:"Vanuatu"},{id:"VE",text:"Venezuela"},{id:"VN",text:"Viet Nam"},{id:"VG",text:"Virgin Islands}, British"},{id:"VI",text:"Virgin Islands}, U.S."},{id:"WF",text:"Wallis And Futuna"},{id:"EH",text:"Western Sahara"},{id:"YE",text:"Yemen"},{id:"ZM",text:"Zambia"},{id:"ZW",text:"Zimbabwe"}];

var database = (function(){
	var xml;

	$.ajax({
		type: "GET",
		url: "database.xml",
		dataType: "xml",
		cache: false,
		success : function(data)
		{
			xml = data;
			main();
		},
	});

	return {getXml : function()
	{
		if (xml)
			return xml;
		// else show some error that it isn't loaded yet;
	}};
})();

function basename(path)
{
	return path.replace( /\\/g, '/' ).replace( /.*\//, '' );
}

function setDir(node)
{
	dir = {
		_node: node,
		_type: "dir",
		_path: $(node).attr('path'),
		_format: $(node).attr('format'),
		_bitrate: $(node).attr('bitrate'),
		_bitrate_mode: $(node).attr('bitrate_mode'),
		_comment: $(node).attr('comment'),
		_country: $(node).attr('country'),
		_tags: $(node).attr('tag'),

		_content: []
	}
	return (dir);
}

function setFile(node)
{
	file = {
		_node: node,
		_type: "file",
		_path: $(node).attr('path'),
		_format: $(node).attr('format'),
		_bitrate: $(node).attr('bitrate'),
		_bitrate_mode: $(node).attr('bitrate_mode'),
		_comment: $(node).attr('comment'),
		_country: $(node).attr('country'),
		_tags: $(node).attr('tag'),
	}
	return (file);
}

function parseBitrate(file)
{
	var ret;
	if (file._format == "FLAC")
		ret = "(FLAC)";
	else if (file._format == "MPEG Audio")
		ret = "(MP3 " + file._bitrate + ' ' + file._bitrate_mode + ')';
	return (ret);
}

function parseJSONTags(tags)
{
	if (tags == null)
		return (null);

	ret_tags = "";
	$(tags).each(function(index, item){
		ret_tags += item;
		if (index != tags.length - 1)
			ret_tags += ", ";
	});
	return (ret_tags);
}

function escapeStr(str)
{
    if (str)
        return str.replace(/([ #;?%&,.+*~\':"!^$[\]()=>|\/@])/g,'\\$1');

    return str;
}

function getInfos(node)
{
	var path = node._path;

	var retText = "";
	retText += '<div class="infos">';

	//Bitrate
	var bitrate = parseBitrate(node);
	bitrate_text = "";
	if (typeof bitrate !== 'undefined')
		bitrate_text = '<div class="bitrate_info">' +bitrate+ '</div>';
	retText += bitrate_text;

	//Country
	var country = "";
	var country_flag = "";
	if (typeof node._country !== 'undefined')
	{
		country = 'data-value="' +node._country+ '"';
		country_flag = '<span value="' +node._country+ '" class="flag-icon flag-icon-'+ node._country.toLowerCase() +'"></span>';
	}
	if (node._type == "dir")
	{
		retText += '<div class="country_info"><a href="' +path+ '" ' +country+ ' id="country" data-type="select2">' +country_flag+ '</a></div>';
	}

	//Comment
	var comment = "";
	if (typeof node._comment !== 'undefined')
		var comment = node._comment;
	retText += '<div class="comment_info"><a href="' +path+ '" id="comment">' +comment+ '</a></div>';

	//Tag
	tags = [];
	if (node._type == "dir")
	{
		$(node._node).find("[path^='" + escapeStr(path)+ "'][tag]").each(function() {
			tags = $.merge($(JSON.parse($(this).attr("tag"))), tags);
		});
	}
	if (tags.length != 0 && node._tags != null)
	{
		tags = $.merge($(JSON.parse(node._tags)), tags);
	}
	else
	{
		if (node._tags != null)
			tags = JSON.parse(node._tags);
	}
	tags = parseJSONTags(tags);
	if (tags == null)
		tags = "";
	retText += '<div class="comment_info"><a href="' +path+ '" id="tag" data-type="select2">' +tags+ '</a></div>';


	retText += '</div>';
	return (retText);
}

function parseDir(dir, index, index_text = null)
{
	dir = setDir(dir);

	if (index_text == null)
		index_text = "item-" + index;
	else
		index_text = index_text + "-" + index;

	return ('<li><img src="public/img/icon_folder.png" /><input type="checkbox" data-path="' +dir._path+ '" id="' +index_text+ '"/><label for="' +index_text+ '">' +basename(dir._path)+ '</label>' +getInfos(dir)+ '<ul></ul></li>');
}

function parseFile(file)
{
	file = setFile(file);

	var ret;

	ret = '<li><img src="public/img/icon_music.png" />' +basename(file._path);
	ret += getInfos(file);
	ret += '</li>';
	return (ret);
}

function listDir(xml, root = null, index_text = null)
{
	if (root == null)
		root = $(".css-treeview").children();
	else
	{
		root = $(root).parent().find('ul');
	}

	$(xml).each(function(index)
	{
		if (this.nodeName == 'dir')
			root.append(parseDir(this, index, index_text));
		else if (this.nodeName == 'file')
			root.append(parseFile(this));
	});
	if ($(xml).length == 0)
		root.append("<li>empty</li>");
}

function setCountry()
{
	$('a#country').editable({
		display: function (value)
		{
			if (value)
			{
				$(this).html('<span class="flag-icon flag-icon-'+ value.toLowerCase() +'"></span>');
			}
		},
		emptytext: '<img src="public/img/blankflag.png" />',
		source: isoCountries,
		pk: function($this) {return $(this).attr('href'); },
		url: "/post.php",
		select2:
		{
			width: 200,
			placeholder: 'Select country',
			formatSelection: function (country) {
				if (!country.id) { return country.text; }
				var $country = $('<span class="flag-icon flag-icon-'+ country.id.toLowerCase() +'"></span>' + '<span class="flag-text">'+ country.text+"</span>");
				return $country;
			},
			formatResult: function (country) {
				if (!country.id) { return country.text; }
				var $country = $('<span class="flag-icon flag-icon-'+ country.id.toLowerCase() +'"></span>' + '<span class="flag-text">'+ country.text+"</span>");
				return $country;
			},
		}
	});
}

function setComments()
{
	$.fn.editable.defaults.mode = 'popup';

	$('a#comment').editable({
		type: "text",
		placement: "right",
		emptytext: '<img src="public/img/comment_icon.png" />',
		title: "Please enter comment",
		value: "",
		allowClear: true,
		pk: function($this) { return $(this).attr('href'); },
		url: '/post.php'
	});
}

function getTags()
{
	tags_root = $(database.getXml()).find('tags');
	var tags = [];

	$(tags_root.children().each(function(){
		tags.push($(this).text());
	}));
	return (tags);
}

function setTags()
{
	tags = getTags();
	$('a#tag').editable(
	{
		pk: function($this) {return $(this).attr('href'); },
		url: "/post.php",
		emptytext: "tags",
		select2:
		{
			width: 200,
			separator: [",", " "],
			tags: tags,
			placeholder: 'Enter tags',
		}
	});
}

function setInfoBox()
{
	setComments();
	setCountry();
	setTags();
}

function setLoadSubDir()
{
	$(".css-treeview").on('change', "input[id^='item']", function()
	{
		if ( this.checked && $(this).parent().find('li').length == 0)
		{
			listDir(
				$(database.getXml()).find('dir[path="' +$(this).data("path")+  '"]').children(),
				$(this),
				$(this).attr('id'));
			setInfoBox();
		}
	});
}

function main()
{
	root = $(database.getXml()).find('dirs');
	listDir(root.children());
	setInfoBox();
	setLoadSubDir();
}

$(window).on("load", function()
{
	$(".loading").fadeOut("slow");
});
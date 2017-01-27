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
		_comment: $(node).attr('comment'),
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
			var pathName = basename(this._path);
			var path = this._path;

			if (typeof this._comment === 'undefined')
				comment = "";
			else
				comment = this._comment;

			var text = '<li><a href="' +path+ '">' +pathName+ ' </a>' + fileDetails;
			text += '<a href="' +path+ '" id="comment">' +comment+ '</a>';
			text += '<a href="' +path+ '" id="country" data-type="select" data-title="Select country"></a>';
			text += '</li>';

			$root.append(text);
		}
	});

	$root.append('</ul></li>');
}

function setComments()
{
	$.fn.editable.defaults.mode = 'popup';

	$('a#comment').editable({
		type: "text",
		placement: "right",
		emptytext: "+",
		title: "titre",
		value: "",
		pk: function($this) { return $(this).attr('href'); }
		,url: '/post.php'
		,error: function(response, newValue) {
			if ( response.status === 404 )
			{
				return 'Truc de ouf ?';
			}
			else
			{
				return response.responseText;
			}
		}
		
	});
}

function setCountry()
{
	var countries = [];
	$.each({"BD": "Bangladesh", "BE": "Belgium", "BF": "Burkina Faso", "BG": "Bulgaria", "BA": "Bosnia and Herzegovina", "BB": "Barbados", "WF": "Wallis and Futuna", "BL": "Saint Bartelemey", "BM": "Bermuda", "BN": "Brunei Darussalam", "BO": "Bolivia", "BH": "Bahrain", "BI": "Burundi", "BJ": "Benin", "BT": "Bhutan", "JM": "Jamaica", "BV": "Bouvet Island", "BW": "Botswana", "WS": "Samoa", "BR": "Brazil", "BS": "Bahamas", "JE": "Jersey", "BY": "Belarus", "O1": "Other Country", "LV": "Latvia", "RW": "Rwanda", "RS": "Serbia", "TL": "Timor-Leste", "RE": "Reunion", "LU": "Luxembourg", "TJ": "Tajikistan", "RO": "Romania", "PG": "Papua New Guinea", "GW": "Guinea-Bissau", "GU": "Guam", "GT": "Guatemala", "GS": "South Georgia and the South Sandwich Islands", "GR": "Greece", "GQ": "Equatorial Guinea", "GP": "Guadeloupe", "JP": "Japan", "GY": "Guyana", "GG": "Guernsey", "GF": "French Guiana", "GE": "Georgia", "GD": "Grenada", "GB": "United Kingdom", "GA": "Gabon", "SV": "El Salvador", "GN": "Guinea", "GM": "Gambia", "GL": "Greenland", "GI": "Gibraltar", "GH": "Ghana", "OM": "Oman", "TN": "Tunisia", "JO": "Jordan", "HR": "Croatia", "HT": "Haiti", "HU": "Hungary", "HK": "Hong Kong", "HN": "Honduras", "HM": "Heard Island and McDonald Islands", "VE": "Venezuela", "PR": "Puerto Rico", "PS": "Palestinian Territory", "PW": "Palau", "PT": "Portugal", "SJ": "Svalbard and Jan Mayen", "PY": "Paraguay", "IQ": "Iraq", "PA": "Panama", "PF": "French Polynesia", "BZ": "Belize", "PE": "Peru", "PK": "Pakistan", "PH": "Philippines", "PN": "Pitcairn", "TM": "Turkmenistan", "PL": "Poland", "PM": "Saint Pierre and Miquelon", "ZM": "Zambia", "EH": "Western Sahara", "RU": "Russian Federation", "EE": "Estonia", "EG": "Egypt", "TK": "Tokelau", "ZA": "South Africa", "EC": "Ecuador", "IT": "Italy", "VN": "Vietnam", "SB": "Solomon Islands", "EU": "Europe", "ET": "Ethiopia", "SO": "Somalia", "ZW": "Zimbabwe", "SA": "Saudi Arabia", "ES": "Spain", "ER": "Eritrea", "ME": "Montenegro", "MD": "Moldova, Republic of", "MG": "Madagascar", "MF": "Saint Martin", "MA": "Morocco", "MC": "Monaco", "UZ": "Uzbekistan", "MM": "Myanmar", "ML": "Mali", "MO": "Macao", "MN": "Mongolia", "MH": "Marshall Islands", "MK": "Macedonia", "MU": "Mauritius", "MT": "Malta", "MW": "Malawi", "MV": "Maldives", "MQ": "Martinique", "MP": "Northern Mariana Islands", "MS": "Montserrat", "MR": "Mauritania", "IM": "Isle of Man", "UG": "Uganda", "TZ": "Tanzania, United Republic of", "MY": "Malaysia", "MX": "Mexico", "IL": "Israel", "FR": "France", "IO": "British Indian Ocean Territory", "FX": "France, Metropolitan", "SH": "Saint Helena", "FI": "Finland", "FJ": "Fiji", "FK": "Falkland Islands (Malvinas)", "FM": "Micronesia, Federated States of", "FO": "Faroe Islands", "NI": "Nicaragua", "NL": "Netherlands", "NO": "Norway", "NA": "Namibia", "VU": "Vanuatu", "NC": "New Caledonia", "NE": "Niger", "NF": "Norfolk Island", "NG": "Nigeria", "NZ": "New Zealand", "NP": "Nepal", "NR": "Nauru", "NU": "Niue", "CK": "Cook Islands", "CI": "Cote d'Ivoire", "CH": "Switzerland", "CO": "Colombia", "CN": "China", "CM": "Cameroon", "CL": "Chile", "CC": "Cocos (Keeling) Islands", "CA": "Canada", "CG": "Congo", "CF": "Central African Republic", "CD": "Congo, The Democratic Republic of the", "CZ": "Czech Republic", "CY": "Cyprus", "CX": "Christmas Island", "CR": "Costa Rica", "CV": "Cape Verde", "CU": "Cuba", "SZ": "Swaziland", "SY": "Syrian Arab Republic", "KG": "Kyrgyzstan", "KE": "Kenya", "SR": "Suriname", "KI": "Kiribati", "KH": "Cambodia", "KN": "Saint Kitts and Nevis", "KM": "Comoros", "ST": "Sao Tome and Principe", "SK": "Slovakia", "KR": "Korea, Republic of", "SI": "Slovenia", "KP": "Korea, Democratic People's Republic of", "KW": "Kuwait", "SN": "Senegal", "SM": "San Marino", "SL": "Sierra Leone", "SC": "Seychelles", "KZ": "Kazakhstan", "KY": "Cayman Islands", "SG": "Singapore", "SE": "Sweden", "SD": "Sudan", "DO": "Dominican Republic", "DM": "Dominica", "DJ": "Djibouti", "DK": "Denmark", "VG": "Virgin Islands, British", "DE": "Germany", "YE": "Yemen", "DZ": "Algeria", "US": "United States", "UY": "Uruguay", "YT": "Mayotte", "UM": "United States Minor Outlying Islands", "LB": "Lebanon", "LC": "Saint Lucia", "LA": "Lao People's Democratic Republic", "TV": "Tuvalu", "TW": "Taiwan", "TT": "Trinidad and Tobago", "TR": "Turkey", "LK": "Sri Lanka", "LI": "Liechtenstein", "A1": "Anonymous Proxy", "TO": "Tonga", "LT": "Lithuania", "A2": "Satellite Provider", "LR": "Liberia", "LS": "Lesotho", "TH": "Thailand", "TF": "French Southern Territories", "TG": "Togo", "TD": "Chad", "TC": "Turks and Caicos Islands", "LY": "Libyan Arab Jamahiriya", "VA": "Holy See (Vatican City State)", "VC": "Saint Vincent and the Grenadines", "AE": "United Arab Emirates", "AD": "Andorra", "AG": "Antigua and Barbuda", "AF": "Afghanistan", "AI": "Anguilla", "VI": "Virgin Islands, U.S.", "IS": "Iceland", "IR": "Iran, Islamic Republic of", "AM": "Armenia", "AL": "Albania", "AO": "Angola", "AN": "Netherlands Antilles", "AQ": "Antarctica", "AP": "Asia/Pacific Region", "AS": "American Samoa", "AR": "Argentina", "AU": "Australia", "AT": "Austria", "AW": "Aruba", "IN": "India", "AX": "Aland Islands", "AZ": "Azerbaijan", "IE": "Ireland", "ID": "Indonesia", "UA": "Ukraine", "QA": "Qatar", "MZ": "Mozambique"}, function(k, v) {
	    countries.push({id: k, text: v});
	}); 
	$('a#country').editable({
		url: "/post.php",
	    source: countries,
	    pk: function($this) { return $(this).attr('href'); },
	    select: {
	        width: 200,
	        placeholder: 'Select country',
	        allowClear: true
	    } 
	}); 
}

$(document).ready(function()
{
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

			setComments();
			setCountry();
		}
	});
});


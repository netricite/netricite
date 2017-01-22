<?php require_once("netricite/view/vViewInit.php"); ?> 
<?php $this->title = "Registration"?>

<!--  based on http://codepen.io/afirulaf/pen/djAen  -->

<article class="container">
    <h1>Bienvenue ! </h1>   
    <?php   
    /* FORM : REGISTRATION */
    $data['passwordConfirm']="";
	echo $this->formgen->formbegin(array("name"=>"formRegistration"), 
	    array("application"=>"login","class"=>"registration"), $data);
    	echo "<fieldset>";
    	echo "<legend>Vos coordonnées</legend>";
    	echo $this->formgen->input(array("field"=>"email", "placeholder"=>"votre email", "icon"=>"envelope", "col"=>"8", "errortext"=>"email address, format: name@example.com",
    	    "attr"=>array("required" => "required", "autofocus" => "autofocus" )));
    	echo $this->formgen->input(array("field"=>"pseudo", "placeholder"=>"Votre pseudo", "icon"=>"user", "col"=>"8", "errortext"=>"pseudo minimum 5 characters",
    	    "attr"=>array("required" => "required")));
    	echo $this->formgen->input(array("field"=>"pwd", "type"=>"password", "placeholder"=>"Votre mot de passe", "icon"=>"lock", "col"=>"8", "errortext"=>"password 6 to 20 characters, at least one numeric digit, one uppercase, one lowercase letter",
    	    "attr"=>array("required" => "required")));
    	echo $this->formgen->input(array("field"=>"passwordConfirm", "type"=>"password", "placeholder"=>"Confirmez votre mot de passe", "icon"=>"lock", "col"=>"8", "errortext"=>"confirmation must be identical to password",
    	    "attr"=>array("required" => "required")));
    	echo $this->formgen->input(array("field"=>"lastname", "placeholder"=>"Votre nom", "icon"=>"user", "col"=>"8", "errortext"=>"Alphabétique",
    	    "attr"=>array("required" => "required")));
    	echo $this->formgen->input(array("field"=>"firstname", "placeholder"=>"Votre prénom", "icon"=>"user", "col"=>"8", "errortext"=>"Alphabétique"));
    	echo $this->formgen->inputDate(array("field"=>"birthdate", "placeholder"=>"Votre date de naissance", "col"=>"8", "icon"=>"calendar", "errortext"=>"Date valide"));
    	echo $this->formgen->select(array("field"=>"language", "icon"=>"user", "option"=>array("none"=>"Sélectionner votre langue","FR"=>"Français","EN"=>"English")));
    	echo $this->formgen->radio(array("field"=>"gender", "icon"=>"user", "col"=>"8", "option"=>array("F"=>"Femme","M"=>"Homme")));
    	echo $this->formgen->select(array("field"=>"country", "icon"=>"globe", "col"=>"8", "option"=>array("none"=>"Sélectionner votre pays", 
	        "FR"=>"France",
        	"BE"=>"Belgium",
        	"CH"=>"Switzerland",
        	"AF"=>"Afghanistan",
        	"AX"=>"Âland Islands",
        	"AL"=>"Albania",
        	"DZ"=>"Algeria",
        	"AS"=>"American Samoa",
        	"AD"=>"Andorra",
        	"AO"=>"Angola",
        	"AI"=>"Anguilla",
        	"AQ"=>"Antarctica",
        	"AG"=>"Antigua and Barbuda",
        	"AR"=>"Argentina",
        	"AM"=>"Armenia",
        	"AW"=>"Aruba",
        	"AU"=>"Australia",
        	"AT"=>"Austria",
        	"AZ"=>"Azerbaijan",
        	"BS"=>"Bahamas",
        	"BH"=>"Bahrain",
        	"BD"=>"Bangladesh",
        	"BB"=>"Barbados",
        	"BY"=>"Belarus",
        	"BE"=>"Belgium",
        	"BZ"=>"Belize",
        	"BJ"=>"Benin",
        	"BM"=>"Bermuda",
        	"BT"=>"Bhutan",
        	"BO"=>"Bolivia, Plurinational State of",
        	"BQ"=>"Bonaire, Sint Eustatius and Saba",
        	"BA"=>"Bosnia and Herzegovina",
        	"BW"=>"Botswana",
        	"BV"=>"Bouvet Island",
        	"BR"=>"Brazil",
        	"IO"=>"British Indian Ocean Territory",
        	"BN"=>"Brunei Darussalam",
        	"BG"=>"Bulgaria",
        	"BF"=>"Burkina Faso",
        	"BI"=>"Burundi",
        	"KH"=>"Cambodia",
        	"CM"=>"Cameroon",
        	"CA"=>"Canada",
        	"CV"=>"Cape Verde",
        	"KY"=>"Cayman Islands",
        	"CF"=>"Central African Republic",
        	"TD"=>"Chad",
        	"CL"=>"Chile",
        	"CN"=>"China",
        	"CX"=>"Christmas Island",
        	"CC"=>"Cocos (Keeling) Islands",
        	"CO"=>"Colombia",
        	"KM"=>"Comoros",
        	"CG"=>"Congo",
        	"CD"=>"Congo, the Democratic Republic of the",
        	"CK"=>"Cook Islands",
        	"CR"=>"Costa Rica",
        	"CI"=>"Côte d'Ivoire",
        	"HR"=>"Croatia",
        	"CU"=>"Cuba",
        	"CW"=>"Cura�ao",
        	"CY"=>"Cyprus",
        	"CZ"=>"Czech Republic",
        	"DK"=>"Denmark",
        	"DJ"=>"Djibouti",
        	"DM"=>"Dominica",
        	"DO"=>"Dominican Republic",
        	"EC"=>"Ecuador",
        	"EG"=>"Egypt",
        	"SV"=>"El Salvador",
        	"GQ"=>"Equatorial Guinea",
        	"ER"=>"Eritrea",
        	"EE"=>"Estonia",
        	"ET"=>"Ethiopia",
        	"FK"=>"Falkland Islands (Malvinas)",
        	"FO"=>"Faroe Islands",
        	"FJ"=>"Fiji",
        	"FI"=>"Finland",
        	"FR"=>"France",
        	"GF"=>"French Guiana",
        	"PF"=>"French Polynesia",
        	"TF"=>"French Southern Territories",
        	"GA"=>"Gabon",
        	"GM"=>"Gambia",
        	"GE"=>"Georgia",
        	"DE"=>"Germany",
        	"GH"=>"Ghana",
        	"GI"=>"Gibraltar",
        	"GR"=>"Greece",
        	"GL"=>"Greenland",
        	"GD"=>"Grenada",
        	"GP"=>"Guadeloupe",
        	"GU"=>"Guam",
        	"GT"=>"Guatemala",
        	"GG"=>"Guernsey",
        	"GN"=>"Guinea",
        	"GW"=>"Guinea-Bissau",
        	"GY"=>"Guyana",
        	"HT"=>"Haiti",
        	"HM"=>"Heard Island and McDonald Islands",
        	"VA"=>"Holy See (Vatican City State)",
        	"HN"=>"Honduras",
        	"HK"=>"Hong Kong",
        	"HU"=>"Hungary",
        	"IS"=>"Iceland",
        	"IN"=>"India",
        	"ID"=>"Indonesia",
        	"IR"=>"Iran, Islamic Republic of",
        	"IQ"=>"Iraq",
        	"IE"=>"Ireland",
        	"IM"=>"Isle of Man",
        	"IL"=>"Israel",
        	"IT"=>"Italy",
        	"JM"=>"Jamaica",
        	"JP"=>"Japan",
        	"JE"=>"Jersey",
        	"JO"=>"Jordan",
        	"KZ"=>"Kazakhstan",
        	"KE"=>"Kenya",
        	"KI"=>"Kiribati",
        	"KP"=>"Korea, Democratic People's Republic of",
        	"KR"=>"Korea, Republic of",
        	"KW"=>"Kuwait",
        	"KG"=>"Kyrgyzstan",
        	"LA"=>"Lao People's Democratic Republic",
        	"LV"=>"Latvia",
        	"LB"=>"Lebanon",
        	"LS"=>"Lesotho",
        	"LR"=>"Liberia",
        	"LY"=>"Libya",
        	"LI"=>"Liechtenstein",
        	"LT"=>"Lithuania",
        	"LU"=>"Luxembourg",
        	"MO"=>"Macao",
        	"MK"=>"Macedonia, the former Yugoslav Republic of",
        	"MG"=>"Madagascar",
        	"MW"=>"Malawi",
        	"MY"=>"Malaysia",
        	"MV"=>"Maldives",
        	"ML"=>"Mali",
        	"MT"=>"Malta",
        	"MH"=>"Marshall Islands",
        	"MQ"=>"Martinique",
        	"MR"=>"Mauritania",
        	"MU"=>"Mauritius",
        	"YT"=>"Mayotte",
        	"MX"=>"Mexico",
        	"FM"=>"Micronesia, Federated States of",
        	"MD"=>"Moldova, Republic of",
        	"MC"=>"Monaco",
        	"MN"=>"Mongolia",
        	"ME"=>"Montenegro",
        	"MS"=>"Montserrat",
        	"MA"=>"Morocco",
        	"MZ"=>"Mozambique",
        	"MM"=>"Myanmar",
        	"NA"=>"Namibia",
        	"NR"=>"Nauru",
        	"NP"=>"Nepal",
        	"NL"=>"Netherlands",
        	"NC"=>"New Caledonia",
        	"NZ"=>"New Zealand",
        	"NI"=>"Nicaragua",
        	"NE"=>"Niger",
        	"NG"=>"Nigeria",
        	"NU"=>"Niue",
        	"NF"=>"Norfolk Island",
        	"MP"=>"Northern Mariana Islands",
        	"NO"=>"Norway",
        	"OM"=>"Oman",
        	"PK"=>"Pakistan",
        	"PW"=>"Palau",
        	"PS"=>"Palestinian Territory, Occupied",
        	"PA"=>"Panama",
        	"PG"=>"Papua New Guinea",
        	"PY"=>"Paraguay",
        	"PE"=>"Peru",
        	"PH"=>"Philippines",
        	"PN"=>"Pitcairn",
        	"PL"=>"Poland",
        	"PT"=>"Portugal",
        	"PR"=>"Puerto Rico",
        	"QA"=>"Qatar",
        	"RE"=>"Réunion",
        	"RO"=>"Romania",
        	"RU"=>"Russian Federation",
        	"RW"=>"Rwanda",
        	"BL"=>"Saint Barthélemy",
        	"SH"=>"Saint Helena, Ascension and Tristan da Cunha",
        	"KN"=>"Saint Kitts and Nevis",
        	"LC"=>"Saint Lucia",
        	"MF"=>"Saint Martin (French part)",
        	"PM"=>"Saint Pierre and Miquelon",
        	"VC"=>"Saint Vincent and the Grenadines",
        	"WS"=>"Samoa",
        	"SM"=>"San Marino",
        	"ST"=>"Sao Tome and Principe",
        	"SA"=>"Saudi Arabia",
        	"SN"=>"Senegal",
        	"RS"=>"Serbia",
        	"SC"=>"Seychelles",
        	"SL"=>"Sierra Leone",
        	"SG"=>"Singapore",
        	"SX"=>"Sint Maarten (Dutch part)",
        	"SK"=>"Slovakia",
        	"SI"=>"Slovenia",
        	"SB"=>"Solomon Islands",
        	"SO"=>"Somalia",
        	"ZA"=>"South Africa",
        	"GS"=>"South Georgia and the South Sandwich Islands",
        	"SS"=>"South Sudan",
        	"ES"=>"Spain",
        	"LK"=>"Sri Lanka",
        	"SD"=>"Sudan",
        	"SR"=>"Suriname",
        	"SJ"=>"Svalbard and Jan Mayen",
        	"SZ"=>"Swaziland",
        	"SE"=>"Sweden",
        	"CH"=>"Switzerland",
        	"SY"=>"Syrian Arab Republic",
        	"TW"=>"Taiwan, Province of China",
        	"TJ"=>"Tajikistan",
        	"TZ"=>"Tanzania, United Republic of",
        	"TH"=>"Thailand",
        	"TL"=>"Timor-Leste",
        	"TG"=>"Togo",
        	"TK"=>"Tokelau",
        	"TO"=>"Tonga",
        	"TT"=>"Trinidad and Tobago",
        	"TN"=>"Tunisia",
        	"TR"=>"Turkey",
        	"TM"=>"Turkmenistan",
        	"TC"=>"Turks and Caicos Islands",
        	"TV"=>"Tuvalu",
        	"UG"=>"Uganda",
        	"UA"=>"Ukraine",
        	"AE"=>"United Arab Emirates",
        	"GB"=>"United Kingdom",
        	"US"=>"United States",
        	"UM"=>"United States Minor Outlying Islands",
        	"UY"=>"Uruguay",
        	"UZ"=>"Uzbekistan",
        	"VU"=>"Vanuatu",
        	"VE"=>"Venezuela, Bolivarian Republic of",
        	"VN"=>"Viet Nam",
        	"VG"=>"Virgin Islands, British",
        	"VI"=>"Virgin Islands, U.S.",
        	"WF"=>"Wallis and Futuna",
        	"EH"=>"Western Sahara",
        	"YE"=>"Yemen",
        	"ZM"=>"Zambia",
        	"ZW"=>"Zimbabwe"
	       )));
	
    	echo $this->formgen->textarea(array("field"=>"address", "placeholder"=>"Votre adresse", "label"=>"Adresse", "type"=>"input-group", "col"=>"8"));
    	echo $this->formgen->rowend();
    	echo $this->formgen->rowbegin();
    	echo $this->formgen->input(array("field"=>"phone", "placeholder"=>"Votre téléphone", "icon"=>"phone", "col"=>"8", "errortext"=>"numérique"));
    	echo $this->formgen->input(array("field"=>"city", "placeholder"=>"Votre vile", "icon"=>"globe", "col"=>"8", "errortext"=>"Alphabétique"));
    	echo $this->formgen->input(array("field"=>"zipcode", "placeholder"=>"Votre code postal", "icon"=>"globe", "col"=>"8", "errortext"=>"numérique"));
	
    	echo $this->formgen->rowend();
    	echo $this->formgen->rowbegin();
    	
    	//recaptcha verification is located in the controler cRegistration.php
    	echo '<div class="g-recaptcha" data-sitekey="'.$GLOBALS["google.publickey.recaptcha"].'"></div>';
    	echo "<p>Once register, we'll send you a login link.</p>";
   		echo "<p>By clicking Register, you agree on our ";
   		?>
   		<a href="javascript:OpenPopup('public/popup/TermsAndConditions2016-03.html','terms','top=500,left=500, height=400,width=1000')">terms and conditions</a>.</p>
   		<?php
		echo "<hr>";
		echo $this->formgen->rowend();
		echo $this->formgen->rowbegin();

		echo $this->formgen->button(array("field"=>"save","col"=>"6","icon"=>"ok","text"=>"Enregistrer", "tooltip"=>"création et modification"));

		echo $this->formgen->hiddenNodata("action", "registration");
		//echo $this->formgen->hidden("date_created", "$date");
		echo $this->formgen->hidden("token", "");
		$dateExpiry = date('Y-m-d H:i:s',strtotime("+10 minutes"));
		echo $this->formgen->hidden("tokenexpiry", "$dateExpiry");
		echo $this->formgen->rowend();
		echo "<hr>";

    	echo "</fieldset>";
    	echo $this->formgen->formend();
    	echo $this->formgen->rowend();
	?>
    <?php if (isset($errorMessage)): ?>
      <p><?= htmlutf8($errorMessage) ?></p>
    <?php endif; ?>
</article>
<SCRIPT>
    function OpenPopup(page,name,option) {
       window.open(page,name,option);
    }
  </SCRIPT>

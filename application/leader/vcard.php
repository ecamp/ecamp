<?php
/*
 * Copyright (C) 2010 Urban Suppiger, Pirmin Mattmann
 *
 * This file is part of eCamp.
 *
 * eCamp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * eCamp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with eCamp.  If not, see <http://www.gnu.org/licenses/>.
 */

/***************************************************************************

PHP vCard class v2.0
(c) Kai Blankenhorn
www.bitfolge.de/en
kaib@bitfolge.de


This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

***************************************************************************/

function encode($string) {
	return escape(quoted_printable_encode($string));
}

function escape($string) {
	return str_replace(";","\;",$string);
}

if (!function_exists('quoted_printable_encode')) {
	// taken from PHP documentation comments
	function quoted_printable_encode($input, $line_max = 76) {
		$hex = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
		$lines = preg_split("/(?:\r\n|\r|\n)/", $input);
		$eol = "\r\n";
		$linebreak = "=0D=0A";
		$escape = "=";
		$output = "";

		for ($j=0;$j<count($lines);$j++) {
			$line = $lines[$j];
			$linlen = strlen($line);
			$newline = "";
			for($i = 0; $i < $linlen; $i++) {
				$c = substr($line, $i, 1);
				$dec = ord($c);
				if ( ($dec == 32) && ($i == ($linlen - 1)) ) { // convert space at eol only
					$c = "=20"; 
				} elseif ( ($dec == 61) || ($dec < 32 ) || ($dec > 126) ) { // always encode "\t", which is *not* required
					$h2 = floor($dec/16); $h1 = floor($dec%16); 
					$c = $escape.$hex["$h2"].$hex["$h1"]; 
				}
				if ( (strlen($newline) + strlen($c)) >= $line_max ) { // CRLF is not counted
					$output .= $newline.$escape.$eol; // soft line break; " =\r\n" is okay
					$newline = "    ";
				}
				$newline .= $c;
			} // end of for
			$output .= $newline;
			if ($j<count($lines)-1) $output .= $linebreak;
		}
		return trim($output);
	}
}

class vCard {
	var $properties;
	var $filename;
	
	function setPhoneNumber($number, $type="") {
	// type may be PREF | WORK | HOME | VOICE | FAX | MSG | CELL | PAGER | BBS | CAR | MODEM | ISDN | VIDEO or any senseful combination, e.g. "PREF;WORK;VOICE"
		$key = "TEL";
		if ($type!="") $key .= ";".$type;
		$key.= ";ENCODING=QUOTED-PRINTABLE";
		$this->properties[$key] = quoted_printable_encode($number);
	}
	
	// UNTESTED !!!
	function setPhoto($type, $photo) { // $type = "GIF" | "JPEG"
		$this->properties["PHOTO;TYPE=$type;ENCODING=BASE64"] = base64_encode($photo);
	}
	
	function setFormattedName($name) {
		$this->properties["FN"] = quoted_printable_encode($name);
	}
	
	function setName($family="", $first="", $additional="", $prefix="", $suffix="") {
		$this->properties["N"] = "$family;$first;$additional;$prefix;$suffix";
		$this->filename = "$first%20$family.vcf";
		if ($this->properties["FN"]=="") $this->setFormattedName(trim("$prefix $first $additional $family $suffix"));
	}
	
	function setBirthday($date) { // $date format is YYYY-MM-DD
		$this->properties["BDAY"] = $date;
	}
	
	function setAddress($postoffice="", $extended="", $street="", $city="", $region="", $zip="", $country="", $type="HOME;POSTAL") {
	// $type may be DOM | INTL | POSTAL | PARCEL | HOME | WORK or any combination of these: e.g. "WORK;PARCEL;POSTAL"
		$key = "ADR";
		if ($type!="") $key.= ";$type";
		$key.= ";ENCODING=QUOTED-PRINTABLE";
		$this->properties[$key] = encode($name).";".encode($extended).";".encode($street).";".encode($city).";".encode($region).";".encode($zip).";".encode($country);
		
		if ($this->properties["LABEL;$type;ENCODING=QUOTED-PRINTABLE"] == "") {
			//$this->setLabel($postoffice, $extended, $street, $city, $region, $zip, $country, $type);
		}
	}
	
	function setLabel($postoffice="", $extended="", $street="", $city="", $region="", $zip="", $country="", $type="HOME;POSTAL") {
		$label = "";
		if ($postoffice!="") $label.= "$postoffice\r\n";
		if ($extended!="") $label.= "$extended\r\n";
		if ($street!="") $label.= "$street\r\n";
		if ($zip!="") $label.= "$zip ";
		if ($city!="") $label.= "$city\r\n";
		if ($region!="") $label.= "$region\r\n";
		if ($country!="") $country.= "$country\r\n";
		
		$this->properties["LABEL;$type;ENCODING=QUOTED-PRINTABLE"] = quoted_printable_encode($label);
	}
	
	function setEmail($address) {
		$this->properties["EMAIL;INTERNET"] = $address;
	}
	
	function setNote($note) {
		$this->properties["NOTE;ENCODING=QUOTED-PRINTABLE"] = quoted_printable_encode($note);
	}
	
	function setURL($url, $type="") {
	// $type may be WORK | HOME
		$key = "URL";
		if ($type!="") $key.= ";$type";
		$this->properties[$key] = $url;
	}
	
	function getVCard() {
		$text = "BEGIN:VCARD\r\n";
		$text.= "VERSION:2.1\r\n";
		foreach($this->properties as $key => $value) {
			$text.= "$key:$value\r\n";
		}
		$text.= "REV:".date("Y-m-d")."T".date("H:i:s")."Z\r\n";
		$text.= "MAILER:PHP vCard class by Kai Blankenhorn\r\n";
		$text.= "END:VCARD\r\n";
		return $text;
	}
	
	function getFileName() {
		return $this->filename;
	}
}

//  USAGE EXAMPLE
/*
$v = new vCard();

$v->setPhoneNumber("+49 23 456789", "PREF;HOME;VOICE");
$v->setName("Mustermann", "Thomas", "", "Herr");
$v->setBirthday("1960-07-31");
$v->setAddress("", "", "Musterstrasse 20", "Musterstadt", "", "98765", "Deutschland");
$v->setEmail("thomas.mustermann@thomas-mustermann.de");
$v->setNote("You can take some notes here.\r\nMultiple lines are supported via \\r\\n.");
$v->setURL("http://www.thomas-mustermann.de", "WORK");

$output = $v->getVCard();
$filename = $v->getFileName();

Header("Content-Disposition: attachment; filename=$filename");
Header("Content-Length: ".strlen($output));
Header("Connection: close");
Header("Content-Type: text/x-vCard; name=$filename");

echo $output;
?>
*/
	$user_id = $_REQUEST['user_id'];
	$user_id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $user_id );

	$query = "	SELECT
					user.homenr,
					user.mobilnr,
					user.scoutname,
					user.firstname,
					user.surname,
					user.birthday,
					user.street,
					user.zipcode,
					user.city,
					user.mail
				FROM
					user,
					user as my_user,
					user_camp,
					user_camp as my_user_camp
				WHERE
					user.id = $user_id AND
					my_user.id = $_user->id AND
					my_user.id = my_user_camp.user_id AND
					user.id = user_camp.user_id AND
					user_camp.camp_id = my_user_camp.camp_id";
	
	$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
	if( mysqli_num_rows($result) < 1 )	{	die("no result");	}
	
	$user_data = mysqli_fetch_assoc($result);
	
	$birthday = new c_date();
	$birthday->setDay2000( $user_data['birthday'] );
	
	$v = new vCard();
	
	$v->setPhoneNumber($user_data['homenr'], "PREF;HOME;VOICE");
	$v->setPhoneNumber($user_data['mobilnr'], "PREF;CELL;VOICE");
	$v->setName($user_data['surname'], $user_data['firstname'], $user_data['scoutname'], "");
	$v->setBirthday( $birthday->getString("Y-m-d") );
	$v->setAddress("", "", $user_data['street'], $user_data['city'], "", $user_data['zipcode'], "");
	$v->setEmail($user_data['mail']);
	$v->setNote("Automatisch generiert auf Basis der Daten von eCamp");

	$output = $v->getVCard();
	$filename = $v->getFileName();
	
	Header("Content-Disposition: attachment; filename=$filename");
	Header("Content-Length: ".strlen($output));
	Header("Connection: close");
	Header("Content-Type: text/x-vCard; name=$filename");
	
	echo $output;

	die();

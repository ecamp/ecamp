<?php
/*
 * Copyright (C) 2018 by Caspar Brenneisen
 *
 * This file is part of ecamp.
 *
 * ecamp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ecamp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with eCamp.  If not, see <http://www.gnu.org/licenses/>.
 */

//Config
$GLOBALS['midata_user'] = "caspar.brenneisen@protonmail.ch";
$GLOBALS['midata_pass'] = "C482816c";
$urlBase = "https://db.scout.ch";
$groups2get = "2"; //Groupids

class midata{
	function login ($user, $password) {
		global $urlBase;

		//Get token
		//API Url
		$url = $urlBase . "/users/sign_in.json?person[email]=". $GLOBALS['midata_user'] ."&person[password]=". $GLOBALS['midata_pass'];

		//Initiate cURL.
		$ch = curl_init();

		//The JSON data.
		$jsonData = array(
			"person[email]" => $GLOBALS['midata_user'],
			"person[password]" => $GLOBALS['midata_pass']
		);

		//Encode the array into JSON.
		$jsonDataEncoded = json_encode($jsonData);

		//set cURL options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

		//Execute the request
		$result = curl_exec($ch);

		//Close cURL
		curl_close($ch);

		//Decode JSON response
		$decoded = json_decode($result, TRUE);
		$authToken = $decoded["people"][0]["authentication_token"];
		return $authToken;
	}

	function qry($qry) {
		global $urlBase;
		global $authToken;
		$authToken = $this->login($GLOBALS['midata_user'], $GLOBALS['midata_pass']);

		//API Url
		$url = $urlBase . "/groups" . $qry . ".json";

		//Initiate cURL.
		$ch = curl_init();

		//Set cURL options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-User-Email: ' . $GLOBALS['midata_user'], 'X-User-Token: '.$authToken, 'Accept: application/json'));

		//Execute the request
		$result = curl_exec($ch);

		//Close cURL
		curl_close($ch);

		//Decode JSON response
		$decoded = json_decode($result, TRUE);
		return $decoded;
	}

	function getGroups($groupIds) {
		$groupId = array();
		$groupId = explode(",", $groupIds);

		$group_array = array();

		//Get data
		$data = array();
		foreach ($groupId as $id) {
			$qry = "/".$id;
			$data = $this->qry($qry);
		}

		return $data;
	}
}

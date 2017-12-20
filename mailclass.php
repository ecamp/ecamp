<?php
	/**
	 * Created by PhpStorm.
	 * User: Chronos
	 * Date: 20.12.2017
	 * Time: 17:25
	 */

	include "./lib/functions/mail.php";

	print_r($GLOBALS['smtp-config']);

	ecamp_send_mail('caspar.brenneisen@protonmail.ch','Testing','Testing');
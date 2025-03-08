<?php
/**
* This file contains settings for instantmessage/telegram connection
*
*
* @package Config
*/

$this->fraudprotection_connection(
	array(
		"type" => "recaptcha",
		"recaptcha_site_key" => "###RECAPTCHA_SITE_KEY###",
		"recaptcha_secret_key" => "###RECAPTCHA_SECRET_KEY###",
		"acceptable_score" => "###ACCEPTABLE_SCORE###",
	)
);
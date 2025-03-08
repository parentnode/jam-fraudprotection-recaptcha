<?php

class JanitorRecaptcha extends Module {


	private $recaptcha_site_key;
	private $recaptcha_secret_key;
	private $acceptable_score;

	public $module_group_id;
	public $module_id;


	function __construct($_settings) {


		parent::__construct();


		# Set credentials
		$this->recaptcha_site_key = isset($_settings["recaptcha_site_key"]) ? $_settings["recaptcha_site_key"] : false;
		$this->recaptcha_secret_key = isset($_settings["recaptcha_secret_key"]) ? $_settings["recaptcha_secret_key"] : false;
		$this->acceptable_score = isset($_settings["acceptable_score"]) ? $_settings["acceptable_score"] : false;


		$this->module_group_id = "fraudprotection";
		$this->module_id = "recaptcha";


		// site key
		$this->addToModel("recaptcha_site_key", array(
			"type" => "string",
			"label" => "reCAPTCHA site key",
			"required" => true,
			"hint_message" => "Enter your reCAPTCHA site key.", 
			"error_message" => "reCAPTCHA site key must be filled out."
		));

		// secret key
		$this->addToModel("recaptcha_secret_key", array(
			"type" => "string",
			"label" => "reCAPTCHA secret key",
			"required" => true,
			"hint_message" => "Enter your reCAPTCHA secret key.", 
			"error_message" => "reCAPTCHA secret key must be filled out."
		));

		// acceptable score
		$this->addToModel("acceptable_score", array(
			"type" => "number",
			"label" => "Acceptable score",
			"required" => true,
			"hint_message" => "Enter an acceptable score for the evaluation. This is the value used to decide whether the user is valid or not. 0.5 is a good starting point.", 
			"error_message" => "An acceptable score must be entered."
		));

	}

	function getSiteKey($_options) {

		$key_only = false;

		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {

					case "key-only"                  : $key_only                  = $_value; break;

				}
			}
		}


		if($key_only) {
			return $this->recaptcha_site_key;
		}
		else {
			return '<meta name="recaptcha" content="'.$this->recaptcha_site_key.'" />';
		}


	}

	function getEvaluation($_options) {

		$token = false;

		if($_options !== false) {
			foreach($_options as $_option => $_value) {
				switch($_option) {

					case "token"                  : $token                  = $_value; break;

				}
			}
		}

		if($token) {

			$recaptcha_response = curl()->request("https://www.google.com/recaptcha/api/siteverify", [
				"method" => "post",
				"inputs" => [
					"response" => $token,
					"remoteip" => security()->getRequestIp(),
					"secret" => $this->recaptcha_secret_key,
				]
			]);
			debug([$recaptcha_response]);

			if($recaptcha_response && $recaptcha_response["http_code"] === 200) {

				$response = json_decode($recaptcha_response["body"]);
				if($response && $response["success"] && $response["score"] > $this->acceptable_score) {
					return ["status" => "valid", "response" => $response];
				}
				else {
					return ["status" => "invalid", "response" => $response];
				}

			}
			else {
				return ["status" => "error", "error" => "INVALID_RESPONSE"];
			}

		}
		else {
			return ["status" => "error", "error" => "MISSING_TOKEN"];
		}

	}

}

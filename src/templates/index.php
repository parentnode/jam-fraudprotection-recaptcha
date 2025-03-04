<?php

@include_once("classes/adapters/fraudprotection/recaptcha.class.php");
$module_class = new JanitorRecaptcha(false);

$connect_values = $module_class->getConnectValues("fraudprotection");

$recaptcha_site_key = isset($connect_values["recaptcha_site_key"]) ? $connect_values["recaptcha_site_key"] : "";
$recaptcha_secret_key = isset($connect_values["recaptcha_secret_key"]) ? $connect_values["recaptcha_secret_key"] : "";
$acceptable_score = isset($connect_values["acceptable_score"]) ? $connect_values["acceptable_score"] : "";

$module_type = isset($connect_values["type"]) ? $connect_values["type"] : "";

?>
<div class="scene module i:module recaptcha i:recaptcha">

	<h1>reCAPTCHA configuration</h1>
	<h2>Fraud protection</h2>
	<ul class="actions">
		<?= $HTML->link("Modules", "modules", array("class" => "button", "wrapper" => "li.modules")) ?>
	</ul>

	<? if($module_type && $module_type !== "recaptcha"): ?>
	<p class="warning">The system is currently configured for another Fraud protection module.</p>
	<? endif; ?>

	<p>
		Enter your reCAPTCHA site key and secret key to enable the module. 
		Keys can be issed in the reCAPTCHA Admin Console.
	</p>

	<?= $module_class->formStart("modules/updateSettings/fraudprotection/recaptcha", array("class" => "labelstyle:inject")) ?>
		<fieldset>
			<?= $module_class->input("recaptcha_site_key", array("value" => $recaptcha_site_key)) ?>
			<?= $module_class->input("recaptcha_secret_key", array("value" => $recaptcha_secret_key)) ?>
			<?= $module_class->input("acceptable_score", array("value" => $acceptable_score)) ?>
		</fieldset>

		<ul class="actions">
			<?= $module_class->submit("Save", array("wrapper" => "li.save", "class" => "primary")) ?>
			<?= $module_class->link("Cancel", "modules", array("class" => "button key:esc", "wrapper" => "li.cancel")) ?>
		</ul>

	<?= $module_class->formEnd() ?>

</div>
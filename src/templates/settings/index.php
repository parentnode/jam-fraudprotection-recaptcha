<?php
global $module_group_id;
global $module_id;

$module = module()->getModule($module_group_id, $module_id);

@include_once("classes/adapters/fraudprotection/recaptcha.class.php");
$module_class = new JanitorRecaptcha(false);

$connect_values = module()->getConnectValues("fraudprotection");


$recaptcha_site_key = isset($connect_values["recaptcha_site_key"]) ? $connect_values["recaptcha_site_key"] : "";
$recaptcha_secret_key = isset($connect_values["recaptcha_secret_key"]) ? $connect_values["recaptcha_secret_key"] : "";
$acceptable_score = isset($connect_values["acceptable_score"]) ? $connect_values["acceptable_score"] : "";

$module_type = isset($connect_values["type"]) ? $connect_values["type"] : "";

?>
<div class="scene module i:module fraudprotection-recaptcha i:fraudprotectionRecaptcha">
	<h1>reCAPTCHA configuration</h1>
	<h2>Fraud protection</h2>

	<?= HTML()->renderSnippet("snippets/modules/actions-back.php") ?>

	<h3>Module description</h3>
	<?= HTML()->renderSnippet("snippets/modules/panel-info.php", [
		"module" => $module,
	]) ?>
	<?= HTML()->renderSnippet("snippets/modules/panel-version.php", [
		"module" => $module,
	]) ?>


	<? if($module_type && $module_type !== "recaptcha"): ?>
	<p class="warning">The system is currently configured for another Fraud protection module.</p>
	<? endif; ?>


	<div class="configuration">
		<h2>Configuration</h2>
		<p>
			Enter your reCAPTCHA site key and secret key to enable the module. 
			Keys can be issued in the reCAPTCHA Admin Console, commonly found here: <a href="https://www.google.com/recaptcha/admin/create" target="_blank">https://www.google.com/recaptcha/admin/create</a>.
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

	<?= HTML()->renderSnippet("snippets/modules/panel-upgrade.php", [
		"module" => $module,
	]) ?>
	<?= $HTML->renderSnippet("snippets/modules/panel-uninstall.php",  [
		"module" => $module,
	]) ?>

</div>

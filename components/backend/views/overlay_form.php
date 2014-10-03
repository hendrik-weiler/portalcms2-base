<!DOCTYPE html>
<html>
<head>
	<title><?php print $title; ?></title>
	<?php
		print Asset::css('autocomplete.css');

		print \Helper\JsVarBase::render();
		print Asset::js('jquery-1.7.2.min.js');
		print Asset::js('jquery-ui.min.js');
		print Asset::js('jquery.ocupload-1.1.2.min.js');
		print Asset::js('jquery.base64.min.js');
		print Asset::js('tiny_mce/tiny_mce.js');
		print Asset::js('bootstrap.min.js');
		print Asset::js('storage.js');
		print Asset::js('tooltip.js');

		print $asset->from_component('bootstrap.min.css','backend');
		print $asset->from_component('bootstrap-responsive.min.css','backend');
		print $asset->from_component('overlay.sass','backend');
		print $asset->from_public('redmond/jquery-ui-1.8.19.custom.css');
		print $asset->from_component(Backend\Helper\Component::$name . '.sass');
	?>
</head>
<body>
	<div class="user">
		<div class="container">
			<div class="info">
				<img src="<?php print \Uri::create('uploads/avatars/' . $account->id . '/medium/' . $avatar->picture); ?>" />
				<h5><?php print $account->username; ?></h5>	
			</div>
			<div class="pcms2">
				<?php print $asset->from_component('logo-small.png','backend') ?>
			</div>
		</div>
	</div>
	<div class="component-box row">
		<div class="container">
			<?php print $to_html($component_navigation) ?>
			<div class="controls">
				<a href="<?php print \Uri::create('backend/landing/index') ?>">
					<img src="<?php print Uri::create('server/svg/backend/assets/img/close') ?>">
				</a>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="content">
			<?php print $component_content ?>
		</div>
	</div>
</body>
</html>
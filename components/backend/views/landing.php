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
	<div class="container">
		<div class="navigation row">
			<!-- <?php print Form::select('language',\Session::get('current_language',\db\Language::getLanguages())) ?> -->
			<ul>
			<?php foreach($components as $component): ?>
				<?php if(isset($component->nav_visible) && $component->nav_visible): ?>
				<li>
					<?php
					$icon_url = 'server/svg/' . $component->name . '/icon';

					if(!file_exists(DOCROOT . '../components/' . $component->name . '/icon.svg')) $icon_url = 'server/svg/backend/icon';
					?>
					<a href="<?php print \Uri::Create($component->name . '/' . $component->nav_url); ?>">
						<img src="<?php print Uri::create($icon_url) ?>">
						<?php print $component->label->default; ?>
						<?php if(\Uri::segment(1) == $component->name) print html_entity_decode($component_navigation); ?>
					</a>
				</li>
				<?php endif; ?>
			<?php endforeach; ?>
				<li>
					<a href="<?php print \Uri::create('settings/administration') ?>">
						<img src="<?php print Uri::create('server/svg/settings/icon') ?>">
						<?php print __('global.user_settings') ?>
					</a>
				</li>
				<li>
					<a id="logout" href="<?php print \Uri::create('logincenter/action/logout'); ?>">
						<img src="<?php print Uri::create('server/svg/logincenter/icon') ?>">
						<?php print __('global.logout') ?>
					</a>
				</li>
			</ul>
		</div>
	</div>
</body>
</html>
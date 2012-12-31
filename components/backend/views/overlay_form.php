<!DOCTYPE html>
<html>
<head>
	<title><?php print $title; ?></title>
	<?php
		print Asset::css('base.min.css');
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

		print $asset->from_component('overlay.sass','backend');
		print $asset->from_component('responsive.css','backend');
		print $asset->from_public('redmond/jquery-ui-1.8.19.custom.css');
		print $asset->from_component(Backend\Helper\Component::$name . '.sass');
	?>
</head>
<body>
	<div class="container">
		<div class="head yui3-u-1">
			<div class="yui3-g">
				<div class="yui3-u-5-24 account">
					<div class="avatar">
						<img class="thumbnail" src="<?php print \Uri::create('uploads/avatars/' . $account->id . '/medium/' . $avatar->picture); ?>" />
						<h2><?php print $account->username; ?></h2>	
					</div>
				</div>
				<div class="yui3-u-19-24 logo">
					<img src="<?php print \Uri::create('server/component/backend/logo.png') ?>">
				</div>
			</div>
		</div>
		<div class="yui3-g">
			<div class="navigation yui3-u-5-24">
				<!-- <?php print Form::select('language',\Session::get('current_language',\db\Language::getLanguages())) ?> -->
				<ul>
				<?php foreach($components as $component): ?>
					<?php if(isset($component->nav_visible) && $component->nav_visible): ?>
					<li>
						<a <?php \Uri::segment(1) == $component->name and print 'class="active"' ?> href="<?php print \Uri::Create($component->name . '/' . $component->nav_url); ?>"><?php print $component->label->default; ?></a>
						<?php if(\Uri::segment(1) == $component->name) print html_entity_decode($component_navigation); ?>
					</li>
					<?php endif; ?>
				<?php endforeach; ?>
					<li><a <?php \Uri::segment(1) == 'settings' and print 'class="active"' ?> href="<?php print \Uri::create('settings/administration') ?>"><?php print __('global.user_settings') ?></a></li>
					<li><a id="logout" href="<?php print \Uri::create('logincenter/action/logout'); ?>"><?php print __('global.logout') ?></a></li>
				</ul>
			</div>
			<div class="body yui3-u-19-24">
				<?php print $component_content; ?>
			</div>
		</div>
	</div>
</body>
</html>
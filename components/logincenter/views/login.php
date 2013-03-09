<!DOCTYPE html>
<html>
<head>
	<title><?php print $title; ?></title>
	<?php
		print Asset::js('jquery-1.7.2.min.js');
		print Asset::js('jquery-ui.min.js');
		print \Helper\JsVarBase::render();

		print $asset->from_component('bootstrap.min.css','backend');
		print $asset->from_component('bootstrap-responsive.min.css','backend');
		print $asset->from_component('logincenter.sass');
	?>
</head>
<body>
	<div class="logincenter">
		<div class="container">
			<div class="span5">
				<?php print Form::open(array('action'=>'logincenter/action/login_attempt','class'=>'logincenter')); ?>
				<label><?php print __('global.username'); ?></label>
				<input type="text" name="username" />
				<label><?php print __('global.password'); ?></label>
				<input type="password" name="password" />
				<?php print \Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()); ?>
				<div class="action">
					<input type="submit" class="btn btn-primary" value="<?php print __('global.login'); ?>">
				</div>
				<?php print Form::close(); ?>
			</div>
			<div class="span5">
				<?php if(\Input::get('msg_id') != ''): ?>

				<div class="error">
					<div class="error-title">
						<h3><?php print __('messages.' . \Input::get('msg_id') . '.title') ?></h3>
					</div>
					<div class="error-message">
						<?php print __('messages.' . \Input::get('msg_id') . '.message') ?>
					</div>
				</div>

				<?php endif; ?>
			</div>

			<img src="<?php print \Uri::create('server/component/backend/logo.png') ?>">

		</div>
	</div>
	
</body>
</html>
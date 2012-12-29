<!DOCTYPE html>
<html>
<head>
	<title><?php print $title; ?></title>
	<?php
		print Asset::css('base.min.css');
		print Asset::css('autocomplete.css');
		print Asset::js('jquery-1.7.2.min.js');
		print Asset::js('jquery-ui.min.js');
		print Asset::js('ajax_load.js');
		print \Helper\JsVarBase::render();
	?>
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/component/backend/overlay.sass'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/public/redmond/jquery-ui-1.8.19.custom.css'); ?>">
	<link rel="stylesheet" type="text/css" href="<?php print Uri::create('server/component/logincenter/logincenter.sass'); ?>">
	<script type="text/javascript" src="<?php print Uri::create('server/component/logincenter/logincenter.js'); ?>"></script>
</head>
<body>
	<div class="logincenter-container yui3-g">
		<div class="yui3-u-1-2 form">
			<?php print Form::open(array('action'=>'logincenter/action/login_attempt','class'=>'logincenter')); ?>
			<?php print Form::hidden('_redirect',\Logincenter\Helper::login_redirect_url()); ?>
			<?php print Form::hidden('_current',\Uri::create('logincenter')); ?>
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
		<div class="yui3-u-1-2 logo">
			<img src="<?php print \Uri::create('server/component/backend/logo.png') ?>">
		</div>
		<div class="yui3-u-1">
	        <?php 
		    	print Helper\AjaxLoader::render(
		    		'.logincenter',
		    		__('messages'),
			    	\Logincenter\Helper::login_redirect_url(),
			    	\Uri::create('logincenter/action/login_attempt')
		    	); 
		    ?>
		</div>
	</div>
</body>
</html>
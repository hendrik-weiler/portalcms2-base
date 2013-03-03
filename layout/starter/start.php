<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php print $asset->from_layout('layout.css') ?>
	<?php print $asset->from_component('logo.png','backend'); ?>
	<?php print $asset->from_component('overlay.sass','backend'); ?>
	<?php print $asset->from_public('redmond/jquery-ui-1.8.19.custom.css');?>
</head>
<body>
	<div class="container">
		
	</div>
</body>
</html>
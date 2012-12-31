<h1><?php print __('title') . $component ?></h1>

<h4><?php print __('description') ?></h4>
<p>
	<?php print $to_html($content['description']) ?>
</p>

<h4><?php print __('behaviours') ?></h4>
<div class="behaviour">
	<ul>
<?php foreach ($content['behaviour'] as $value): ?>

		<li>
			<?php print __('behaviour.' . $value) ?>
		</li>

<?php endforeach; ?>
	</ul>
</div>

<div>
<?php print $to_html($form_buttons) ?>
</div>
<?php print $to_html($pagination) ?>
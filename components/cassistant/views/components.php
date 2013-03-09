<div>
	<a class="btn" href="<?php print \Uri::create('cassistant/administration/components/new_component') ?>"><?php print __('new_component') ?></a>
</div>
<br>
<div class="row chead">
	<div class="span2"><?php print __('th.name') ?></div>
	<div class="span2"><?php print __('th.id') ?></div>
	<div class="span2"><?php print __('th.version') ?></div>
	<div class="span2"><?php print __('th.status') ?></div>
	<div class="span2"><?php print __('th.install') ?></div>
</div>

<?php foreach($component_categories as $category): ?>
<div class="row seperate-line">
	<?php print $category ?>
</div>

<?php foreach($all_modules as $module): ?>
<?php if($module->category == $category): ?>
<div class="row crow">
	<div class="span2"><?php print $module->name; ?></div>
	<div class="span2"><?php print $module->id; ?></div>
	<div class="span2"><?php print $module->version; ?></div>
	<div class="span2"><?php print $module->status ? __('active') : __('inactive'); ?></div>
	<div class="span2">
		<?php 
		if($module->install)
		{
			print \Html::anchor('cassistant_install/administration/install?component=' . $module->name . '&return=' . \Uri::current() . '&page=1',__('form.install_component'),array('class'=>'btn'));
			print \Html::anchor('cassistant_install/administration/uninstall?component=' . $module->name . '&return=' . \Uri::current(),__('form.uninstall_component'),array('class'=>'btn'));
		} 
		?>
	</div>
</div>
<?php endif; ?>
<?php endforeach; ?>

<?php endforeach; ?>
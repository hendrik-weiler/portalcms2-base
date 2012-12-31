<?php
$form->input->create('test','test');
$create_form_buttons();
?>
<div>
<?php print $to_html($form()) ?>
</div>
<?php print $to_html($pagination) ?>
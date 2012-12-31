<?php
$form->input->create('test2','test2');
$create_form_buttons();
?>
<div>
<?php print $to_html($form()) ?>
</div>
<?php print $to_html($pagination) ?>
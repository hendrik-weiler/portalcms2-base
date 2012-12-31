<?php

return array(

	'title' => 'Installation assistant for: ',
	'description' => 'Description of installation:',
	'behaviours' => 'Effect of this installation:',
	'behaviour' => array(
		'modify_database' => 'This installation will modify the database',
		'add_database' => 'This installation will add to the dabase',
		'no_interaction' => 'This installation needs no user interaction.',
		'have_interaction' => 'This installation needs to be configured.',
		'load_external' => 'This installation will atempt to download from external sources.',
	),

	'start' => 'Start',
	'next' => 'Next',
	'back' => 'Back to component assistant',

	'finished' => 'The installation was complete.',

	'uninstall' => array(
		'title' => 'Uninstall component: ',
		'title_finish' => 'Successfully uninstalled.',
	),

);
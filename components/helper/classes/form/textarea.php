<?php
/*
 * Portal Content Management System Version 2
 * Copyright (C) 2013  Hendrik Weiler
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author     Hendrik Weiler
 * @license    http://www.gnu.org/licenses/gpl.html
 * @copyright  2013 Hendrik Weiler
 */
namespace Helper\Form;

class Textarea extends \Form
{

	private $script = '<script type="text/javascript">
$(function() {
	tinyMCE.init({
		// General options
		mode : "specific_textareas",
		editor_selector : "%selector%",

		theme_advanced_toolbar_location : "top",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,forecolor,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,outdent,indent,blockquote,separator,undo,redo,image,bullist,numlist,table,link,code",
		plugins : "emotions,safari,inlinepopups",
		theme_advanced_buttons1_add : "emotions",
	});
});
</script>
';

	public function create($name, $value='', $width='100%', $height='300px', $class='')
	{
		Wrapper::$current_form[] = static::textarea($name,$value,array('style'=>'width:' . $width . ';height:' . $height . ';', 'class'=>$class));
	}

	public function create_editor($name, $value='', $width='100%', $height='300px', $class='')
	{
		Wrapper::$current_form[] = static::textarea($name,$value,array('style'=>'width:' . $width . ';height:' . $height . ';', 'class'=> 'editor_' . $name . ' ' . $class));
		Wrapper::$current_form[] = str_replace(array(
			'%selector%'
		), array(
			'editor_' . $name
		), $this->script);
	}
}
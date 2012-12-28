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

class Radiobutton extends \Form
{
	private $template = '<div class="radio-list%class%">

		%buttons%

	</div>';

	private $radio_template = '<label class="radio">
	  %radio%
	  %label%
	</label>';

	private function make_radio($label, $value, $checked, $name)
	{
		return str_replace(array(
			'%label%', '%radio%'
		), array(
			$label,
			static::radio($name , $label, $checked),
		), $this->radio_template);
	}

	public function create($buttons, $name, $class='')
	{
		$form_content = array();
		for($i = 0; $i < count($buttons); $i++)
		{
			!isset($buttons[$i][0]) and $buttons[$i][0] = 'undefined';
			!isset($buttons[$i][1]) and $buttons[$i][1] = 'undefined';
			!isset($buttons[$i][2]) and $buttons[$i][2] = false;
			$form_content[] = $this->make_radio(trim($buttons[$i][0]), trim($buttons[$i][1]), $buttons[$i][2], $name);
		}

		Wrapper::$current_form[] = str_replace(array(
			'%buttons%', '%class%'
		), array(
			implode(' ',($form_content)),
			$class
		), $this->template);

	}
}
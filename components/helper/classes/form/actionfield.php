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

class Actionfield extends \Form
{
	private $template = '<div class="form-actions%class%">

		%buttons%

	</div>';

	public function create($buttons, $class='')
	{
		$form_content = array();
		for($i = 0; $i < count($buttons); $i++)
			$form_content[] = array_pop(Wrapper::$current_form);

		Wrapper::$current_form[] = str_replace(array(
			'%buttons%', '%class%'
		), array(
			implode(' ',array_reverse($form_content)),
			$class
		), $this->template);
	}
}
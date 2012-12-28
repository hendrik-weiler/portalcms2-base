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

class Input extends \Form
{
	private $template = '<div class="control-group">

		%label%
		<div class="controls">
			%input%
		</div>

	</div>';

	public function create($label, $name, $value='', $class='')
	{
		Wrapper::$current_form[] = str_replace(array(
			'%label%', '%input%'
		), array(
			static::label($label, $name,array('class'=>'control-label ' . $class)),
			static::input($name,$value,array('class'=>$class))
		), $this->template);
	}
}
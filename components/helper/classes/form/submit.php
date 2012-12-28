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

class Submit extends \Form
{
	public function create($label, $name, $type='', $class='')
	{

		$options = explode(',',$type);

		$visual_types = array();

		foreach ($options as $option) 
		{
			# ---- size
			if(preg_match('#large#', $option))
				$visual_types[] = 'btn-large';

			if(preg_match('#small#', $option))
				$visual_types[] = 'btn-small';

			if(preg_match('#mini#', $option))
				$visual_types[] = 'btn-mini';


			# --- block
			if(preg_match('#block#', $option))
				$visual_types[] = 'btn-block';


			# --- disabled
			if(preg_match('#disable|disabled#', $option))
				$visual_types[] = 'btn-disabled';

			# --- styles
			if(preg_match('#primary#', $option))
				$visual_types[] = 'btn-primary';

			if(preg_match('#info#', $option))
				$visual_types[] = 'btn-info';

			if(preg_match('#success#', $option))
				$visual_types[] = 'btn-success';

			if(preg_match('#warning#', $option))
				$visual_types[] = 'btn-warning';

			if(preg_match('#danger#', $option))
				$visual_types[] = 'btn-danger';

			if(preg_match('#inverse#', $option))
				$visual_types[] = 'btn-inverse';

			if(preg_match('#link#', $option))
				$visual_types[] = 'btn-link';
		}		

		Wrapper::$current_form[] = static::submit($name,$label,array('class'=>'btn ' . implode(' ',$visual_types) . $class));
	}
}
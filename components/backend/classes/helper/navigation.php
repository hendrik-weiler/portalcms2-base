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
namespace Backend\Helper;

class Navigation
{
	protected static $data;

	protected static $tpl_wrapper = '<div class="@component_navigation subnav clearfix"><ul>@content</ul></div>';

	protected static $tpl_li = '<li><a @active href="@url">@label</a></li>';

	protected static function _build_navigation()
	{
		$base_url = \Backend\Helper\Component::$base_url;
		$current_index = \Backend\Helper\Component::$url_segment[2];
		$tpl_li = array();
		foreach (static::$data as $point) 
		{
			$url_point = str_replace(' ','_',strtolower($point));
			$active = '';
			$current_index == $url_point and $active = 'class="sub_active"';
			$tpl_li[] = str_replace(
				array('@url','@label','@active'),
				array($base_url . '/' . $url_point,$point,$active), 
				static::$tpl_li
			);	
		}

		return str_replace(
			array('@component','@content'), 
			array('',implode('',$tpl_li)), 
			static::$tpl_wrapper
		);
	}

	public static function render(Array $data)
	{
		static::$data = array_unique($data);
		return static::_build_navigation();
	}
}
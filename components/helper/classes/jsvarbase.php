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
namespace Helper;

class JsVarBase
{
	protected static $_html = '
	<script type="text/javascript">
		var _url = "[url]";
		var _current_url = "[current_url]";
		var _segments = [[segments]];
		var _components = [[components]];
	</script>';

	protected static function _parse_html()
	{
		$segments = array();
		$components = array();

		$url = \Uri::create('/');
		$html = static::$_html;

		foreach(\Uri::segments() as $segment)
			array_push($segments,'"' . $segment . '"');

		foreach(\Config::get('always_load.modules') as $module)
			array_push($components,'"' . $module . '"');

		$html = str_replace(
		array(
			'[url]','[current_url]','[segments]','[components]'
			), 
		array(
			$url,\Uri::current(),implode(',',$segments),implode(',',$components)
		), $html);

		return $html;
	}

	public static function render()
	{
		return static::_parse_html();
	}
}
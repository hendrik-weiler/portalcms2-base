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

class Component
{
	public static $base_url;

	public static $url_segment;

	public static $name;

	public static $current_index;

	public static $options = array();

	public static $navigation = array();

	protected static function _get_name()
	{
		static::$name = static::$url_segment[0];
	}

	protected static function _get_navigation()
	{
		\Lang::load(static::$name . '::navigation');
		static::$navigation = __('component_navigation');
	}

	protected static function _get_options()
	{
		$content = \File::read(DOCROOT . '../components/' . static::$name . '/options.json',true);
		static::$options = \Format::forge($content,'json')->to_array();
	}

	protected static function _get_url()
	{

		static::$url_segment = \Uri::segments();

		if(!isset(static::$url_segment[1])) return;

		static::$base_url = \Uri::create(implode('/',array(static::$url_segment[0],static::$url_segment[1])));

		if(\Uri::segment(3) == '')
			static::$url_segment[] = 'index';

		static::$url_segment[2] = str_replace(' ','_',strtolower(static::$url_segment[2]));

		static::$current_index = static::$url_segment[2];
	}

	public static function analyze()
	{
		static::_get_url();
		static::_get_name();
		static::_get_options();
		static::_get_navigation();
	}
}
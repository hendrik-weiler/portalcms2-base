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
namespace db;

class Option extends \Orm\Model
{

	protected static $_table_name = 'options';

	protected static $_properties = array('id', 'key', 'value');

	public static function getKey($key)
	{
		$option = self::find('first',array(
		  'where' => array('key'=>$key),
		));

		if(empty($option))
		{
		  $option = new \stdClass;
		  $option->key = $key;
		  $option->value = 'undefined';
		}

		return $option;
	}

	public static function getKeyNew($key, $default)
	{
		$result = static::getKey($key);

		if($result->value == 'undefined')
		{
			$new_row = new Option();
			$new_row->key = $key;
			$new_row->value = $default;
			$new_row->save();
			$result = $new_row;
		}

		return $result;
	}
}
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
namespace db\component;

class Storage extends \Orm\Model
{

	protected static $_table_name = 'component_storage';

	protected static $_properties = array('id', 'account_id','component', 'label', 'value');

	public static function getKey($key)
	{
		$search = array();

		$key = explode('.',$key);

		$search['where']['label'] = $key[0];

		if(count($key) == 2)
		{
			$search['where']['component'] = $key[0];
			$search['where']['label'] = $key[1];
		}	

		$search['account_id'] = \db\Accounts::getCol(\Session::get('current_session'),'id');

		$option = static::find('first',$search);

		if(empty($option))
		{
		  $option = new \stdClass;
		  $option->label = $key;
		  $option->value = 'undefined';
		}

		return $option;
	}
}
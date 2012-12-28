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
namespace Cstorage;

class Storage
{
	public static $current_component;

	public function set($label, $value)
	{
		
		$component = static::$current_component;

		$full_label = $label;
		$label = explode('.', $label);

		if(count($label) == 2)
		{
			$component = $label[0];
			$label 	   = $label[1];
		}	
		else
		{
			$label = $label[0];
		}

		if(\db\component\Storage::getKey($full_label)->value == 'undefined')
		{
			$storage = new \db\component\Storage();
			$storage->component = $component;
			$storage->account_id = \db\Accounts::getCol(\Session::get('current_session'),'id');
			$storage->label = $label;
			$storage->value = $value;
			$storage->save();
		}
		else
		{
			$storage = \db\component\Storage::getKey($full_label);
			$storage->value = $value;
			$storage->save();
		}

		return true;
	}

	public function get($label, $as_object = false)
	{
		if($as_object)
			$return = \db\component\Storage::getKey($label);
		else
			$return = \db\component\Storage::getKey($label)->value;

		return $return;
	}

	public function remove($label)
	{
		$storage = $this->get($label,true);

		if($storage->value != 'undefined')
			$storage->delete();

		return $storage->value != 'undefined';
	}
}
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

class Controller_Storage extends \ComponentController
{
	private function _get_label()
	{
		$key = \Input::post('key');
		$component = \Input::post('component');

		$key = explode('.',$key);
		if(count($key) == 2)
		{
			$component = $key[0];
			$key = $key[1];
		}
		else
		{
			$key = $key[0];
		}

		return $component . '.' . $key;
	}

	public function action_set()
	{
		$label = $this->_get_label();
		$this->response->body = $this->storage->set($label, \Input::post('value'));
	}

	public function action_get()
	{
		$label = $this->_get_label();
		$this->response->body = $this->storage->get($label);
	}

	public function action_remove()
	{
		$label = $this->_get_label();
		$this->response->body = $this->storage->remove($label);
	}

	public function after($response)
	{
		return $this->response;
	}
}
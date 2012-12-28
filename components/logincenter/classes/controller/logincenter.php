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
namespace Logincenter;

class Controller_Logincenter extends \Controller
{

	protected $data;

	public function before()
	{

		$this->data = new \stdClass;
		\Lang::load('login');
		\Lang::load('messages');

		$this->data->title = 'Logincenter';
	}

	public function action_index()
	{
		$saved_logins = \Session::get('saved_logins');
		$this->data->accounts = empty($saved_logins) ? array() : $saved_logins;
	}

	public function after($response)
	{
		return \Response::forge(
			\View::forge('login',$this->data)
		);
	}
}
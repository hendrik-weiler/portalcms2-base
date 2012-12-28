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
namespace Backend;

class Overlay
{

	public static function init(&$data)
	{
		\Backend\Overlay::set_language();
		\Backend\Overlay::set_account($data);
		\Backend\Overlay::set_components($data); 
		\Backend\Overlay::set_content_view($data);
	}

	public static function set_language()
	{
		\Lang::load('backend::overlay');
	}

	public static function set_account(&$data)
	{
		$session = \Session::get('current_session');
		$data->account = \db\Accounts::getCol($session,'all');
		$data->avatar = \db\AccountsAvatars::getAvatarByAccountId($data->account->id);
	}

	public static function set_components(&$data)
	{
		$data->components = array();
		$components = \Config::get('always_load.modules');

		foreach ($components as $component) 
		{
			$filepath = APPPATH . '../../components/' . $component . '/options.json';
			if(file_exists($filepath))
			{
				$component_data = json_decode(\File::read($filepath,true));
				$component_data->name = $component;
				$data->components[] = $component_data;
			}	
		}
	}

	public static function set_content_view(&$data)
	{
		$function = \Uri::segment(3);
		$data->view = empty($function) ? 'index' : $function;
	}
}
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

class Helper
{
	public static function login_redirect_url()
	{
		$components = \File::read_dir(DOCROOT . '../components',1);

		$modules = \Config::get('always_load.modules');

		$start_module = \Config::get('portalcms2.login.start_module');

		if($start_module != 'auto')
		{
			return \Uri::create($start_module . '/administration');
		}

		foreach ($components as $dir => $s) 
		{
			$dir = str_replace(array('\\','/'), '', $dir);

			if(is_dir(DOCROOT . '../components/' . $dir) && in_array(strtolower($dir), $modules))
			{
				if(file_exists(DOCROOT . '../components/' . $dir . '/options.json'))
				{
					return \Uri::create($dir . '/administration');
				}
			}
		}
		return false;
	}
}
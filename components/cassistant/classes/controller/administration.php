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
namespace cassistant;

class Controller_Administration extends \BackendController
{
	public function action_index()
	{
		$this->data->all_modules = array_keys(\File::read_dir(DOCROOT . '../components',1));
		$this->data->active_modules = \Config::get('always_load.modules');

		$active_modules = $this->data->active_modules;

		$this->data->component_categories = array();

		$component_categories =& $this->data->component_categories;

		$this->data->all_modules = array_map(function($item) use ($active_modules, &$component_categories) {
			$row = new \stdClass;
			$row->name = str_replace(array('/','\\'), '', $item);
			$row->status = in_array($row->name, $active_modules);
			$components = json_decode(file_get_contents(DOCROOT . '../components/' . $row->name . '/component.json'));
			$row->version = $components->version;
			$row->id = $components->id;
			$row->category = $components->category;
			$row->install = false;
			if(file_exists(DOCROOT . '../components/' . $row->name . '/installer.json')) $row->install = true;
			$component_categories[] = $row->category;
			return $row;
		}, $this->data->all_modules);

		$this->data->component_categories  = array_unique($component_categories);
		sort($this->data->component_categories);
	}

	public function action_new_component()
	{
		$this->template('new_component');
	}
}
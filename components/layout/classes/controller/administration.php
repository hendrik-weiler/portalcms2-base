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
namespace Layout;

class Controller_Administration extends \BackendController
{

	public function get_layout_list()
	{
		$list = array();

		$layout_path = $this->path->layouts;

		@array_walk(\File::read_dir($layout_path,1), function($key, $value) use (&$list, $layout_path) {

			$config = \Format::forge(\File::read($layout_path . '/' . $value . 'config.json',true), 'json')->to_array();

			$layout = new \stdClass;
			$layout->index = count($list);
			$layout->label = $config['label'];
			$layout->description = $config['description'];
			$layout->folder_name = str_replace('/', '', $value);
			$list[] = $layout;
		});

		return $list;
	}

	public function action_index()
	{
		$this->data->layouts = $this->get_layout_list();
	}

	public function action_save()
	{
		$layout = $this->option->get('selected_layout');
		$layout->value = \Input::post('folder');
		$layout->save();

		\Response::redirect('layout/administration/Selection');
	}
}
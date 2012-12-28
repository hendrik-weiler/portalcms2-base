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
namespace Cupdateradmin;

class Controller_Administration extends \BackendController
{
	public function action_index()
	{
		$this->data->infos = \db\Component\Info::find('all',array(
			'order_by' => array('creation_date'=>'DESC')
		));
	}

	public function action_add()
	{
		$this->data->author = '';
		$this->data->version = '';
		$this->data->category = '';
		$this->data->name = '';
		$this->data->pictures = array();
		$this->data->description = '';
		$this->data->preview_index = 0;
		$this->data->action_url = 'cupdateradmin/action/add/save';
	}

	public function action_edit()
	{
		$this->template('add');

		$id = $this->param('id');

		$component = \db\Component\Info::find($id);

		$this->data->author = $component->author;
		$this->data->version = $component->version;
		$this->data->category = $component->category;
		$this->data->name = $component->name;
		$this->data->preview_index = $component->preview_index;

		$pictures = json_decode($component->pictures);
		$pictures = is_array($pictures) ? $pictures : array();
		$this->data->pictures = array_map(function($str) use ($component) {
			return \Uri::create('repository/' . $component->id . '/thumb_' . $str);
		}, $pictures);
		$this->data->description = $component->description;
		$this->data->package = $component->package;
		$this->data->action_url = 'cupdateradmin/action/edit/' . $id . '/save';
	}
}
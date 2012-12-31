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
class BackendController extends \AuthController
{
	protected $data;

	protected $component;

	protected $account;

	protected $no_render = false;

	private $_template = false;

	protected function template($name)
	{
		$this->_template = $name;
	}

	public function before()
	{
		parent::before();
		\Lang::load('global');
		$this->data = new \stdClass;
		\Backend\Overlay::init($this->data);
		\Backend\Helper\Component::analyze();
		$this->component = new \stdClass;
		$this->component->base_url = \Backend\Helper\Component::$base_url;
		$this->component->url_segment = \Backend\Helper\Component::$url_segment;
		$this->component->current_index = \Backend\Helper\Component::$current_index;
		$this->component->options = \Backend\Helper\Component::$options;
		$this->component->navigation = \Backend\Helper\Component::$navigation;
		$this->component->name = \Backend\Helper\Component::$name;

		$this->info = \Backend\Helper\Account::info();
		$this->data->account = $this->info->account;
		$this->data->group = $this->info->group;
		$this->data->avatar = $this->info->avatar;

		$this->data->title = ucfirst($this->component->name) . ' - ' . ucfirst($this->component->current_index);

		\Lang::load($this->component->name . '::default');

		if(!$this->component->options['has_index']
		 && $this->component->current_index == 'index')
		{
			return \Response::redirect($this->component->base_url . '/' . $this->component->navigation[0]);
		}	

		$this->data->option = $this->option;	

		$this->data->form = new \Helper\Form\Wrapper();

		$this->data->asset = new \Helper\Asset();

		$this->data->to_html = function($html) {
			return html_entity_decode($html);
		};
	}

	public function no_render()
	{
		$this->no_render = true;
	}

	public function after($response)
	{
		if($this->no_render) return $this->response;

		parent::after($response);

		$this->data->component_navigation = \Backend\Helper\Navigation::render(__('component_navigation'));

		if(is_array($this->component->options['type']) 
			&& $this->component->options['type'][$this->component->current_index] == 'dragdropgrid')
		{
			$view = 'backend::overlay_dragdropgrid';
		}
			
		if(is_array($this->component->options['type']) 
			&& $this->component->options['type'][$this->component->current_index] == 'dragdrop')
		{
			$view = 'backend::overlay_dragdrop';
		}
			
		if(is_array($this->component->options['type']) 
			&& $this->component->options['type'][$this->component->current_index] == 'form'
			|| $this->component->options['type'] == 'form')
		{
			$this->data->component_content = \View::forge(\Backend\Helper\Component::$current_index,$this->data);
			$view = 'backend::overlay_form';
		}

		if($this->_template != false)
		{
			$this->data->component_content = \View::forge($this->_template,$this->data);
		}
			
		return \Response::forge(\View::forge($view,$this->data));
	}
}
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
namespace cassistant_install;

class Controller_Administration extends \BackendController
{

	public function before()
	{
		parent::before();
		
		$this->data->component = \Input::get('component');
		$this->data->return_url = \Input::get('return');

		$content = \File::read($this->path->components . '/' . $this->data->component . '/installer.json', true);
		$this->data->content = \Format::forge($content, 'json')->to_array();
		$this->data->pages = $this->data->content['interaction_views'];
	}

	public function action_uninstall()
	{
		$this->data->component = \Input::get('component');

		$url = \Uri::current() . '?component=' . $this->data->component . '&return=' . \Input::get('return') . '&is_finished=true';
		$button_text = 'start';
		if(\Input::get('is_finished') == 'true')
		{
			$button_text = 'back';
			$url = \Input::get('return');
			call_user_func_array('\\' . ucfirst($this->data->component) . '\\Install' . '::uninstall', array());
			$this->template('uninstall_finish');
		}

		$this->data->form->create($url);

		$this->data->form->submit->create(__($button_text), $button_text);

		$this->data->form_buttons = $this->data->form->render();
	}

	public function action_index()
	{
		$this->data->current_page = \Input::get('page') == '' ? 1 : \Input::get('page');

		$button_text = 'start';

		$url = \Uri::current() . '?component=' . \Input::get('component') . '&return=' . \Input::get('return') . '&page=' . ($this->data->current_page + 1);

		if(count($this->data->pages) >= 2 && \Input::get('page') >= 2 && \Input::get('page') != (count($this->data->pages) + 2) ) $button_text = 'next';
		if(\Input::get('page') == (count($this->data->pages) + 2)) { $button_text = 'back'; $url = \Input::get('return'); }

		$this->data->form->create($url);

		$this->data->form->submit->create(__($button_text), $button_text);

		$this->data->form_buttons = $this->data->form->render();

		if(count($this->data->pages) >= 2 && \Input::get('page') >= 2 && \Input::get('page') != (count($this->data->pages) + 2) )
		{
			$this->template( ($this->data->component) . '::installer/' . $this->data->pages[\Input::get('page') - 2] );
			$this->data->form->create($url);
			$form = $this->data->form;
			$this->data->create_form_buttons = function() use (&$form, $button_text) {
				$form->submit->create(__($button_text), $button_text);
			};
			if($this->data->current_page >= 3)
			{
				call_user_func_array('\\' . ucfirst($this->data->component) . '\\Install' . '::' . $this->data->pages[\Input::get('page') - 3], array());
			}


		}
		else if(\Input::get('page') == (count($this->data->pages) + 2))
		{
			if(count($this->data->pages) >= 2)
			{
				call_user_func_array('\\' . ucfirst($this->data->component) . '\\Install' . '::' . $this->data->pages[\Input::get('page') - 3], array());
			}

			call_user_func_array('\\' . ucfirst($this->data->component) . '\\Install' . '::install', array());
			$this->template('finish');
		}

		$this->data->pagination = '<div class="pagination">Page: ' . $this->data->current_page . ' / ' . (count($this->data->content['interaction_views']) + 2) . '</div>';
	}
}
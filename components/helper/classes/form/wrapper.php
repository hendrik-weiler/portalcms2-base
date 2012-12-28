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
namespace Helper\Form;

class Wrapper extends \Form
{
	public static $current_form = array();

	public $input;

	public $textarea;

	public $checkbox;

	public $radiobutton;

	public $actionfield;

	public $select;

	public $submit;

	public function __construct()
	{
		$this->input = new Input();

		$this->textarea = new Textarea();

		$this->checkbox = new Checkbox();

		$this->actionfield = new Actionfield();

		$this->submit = new Submit();

		$this->radiobutton = new Radiobutton();

		$this->select = new Select();
	}

	public function create($url, $type='horizontal', $class='', $returns_back = false)
	{
		static::$current_form = array();
		switch($type)
		{
			case 'horizontal':
				$type = 'form-horizontal';
			break;

			case 'vertical':
				$type = 'form-vertical';
			break;
		}

		if($returns_back) \Uri::create($url) . '?return=' . \Uri::current(); 

		static::$current_form[] = static::open(array('action'=>$url,'class'=>$type . $class,'enctype'=>'multipart/form-data'));
	}

	public function add_html($html)
	{
		static::$current_form[]  = $html;
	}

	public function __invoke()
	{
		return implode('',static::$current_form) . static::close();
	}
}
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
namespace Frontend;

class Initializer extends \ComponentController
{

	public static $component_output = array();

	public static $base_layout = 'start.php';

	public function __construct()
	{
		parent::before();
	}

	private function get_frontend_components()
	{
		$components = \File::read_dir(DOCROOT . '../components/',1);

		$list = array();

		foreach($components as $component => $is_file)
		{
			$component = str_replace(DS,'',$component);
			$content = \File::read(DOCROOT . '../components/' . $component . '/component.json',true);
			$options = \Format::forge($content,'json')->to_array();
			if(isset($options['frontend_display']) && $options['frontend_display'] == true)
				$list[] = $component;
		}

		return $list;
	}

	public function render()
	{
		$component_list = $this->get_frontend_components();

		foreach ($component_list as $component) 
		{
			$component_name = $component;

			$component = '\\' . ucfirst($component) . '\\Frontend';
			$component = new $component();

			$reflector = new \ReflectionClass(new $component());
			if($reflector->hasProperty('base_layout'))
				static::$base_layout = $component->base_layout;

			static::$component_output[$component_name] = $component->get_output();
		}

		$selected_layout = $this->option->get('selected_layout');
		if($selected_layout->value == 'undefined')
		{
			print 'Option "selected_layout" is missing.';
			exit;
		}

		static::$component_output['asset'] = new \Helper\Asset();
		static::$component_output['asset']->is_not_a_component = true;

		return \View::forge($this->path->layouts . '/' . $selected_layout->value . '/' . static::$base_layout, static::$component_output);
	}

}
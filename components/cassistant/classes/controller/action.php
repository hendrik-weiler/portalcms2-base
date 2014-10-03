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

class Controller_Action extends \AuthController
{
	public function before()
	{
		\Lang::load('messages');
	}

	public function action_create_component()
	{
		$name = \Input::post('name');
		$options = \Input::post('options');
		$visible = \Input::post('visible');
		$id = \Input::post('id');
		$has_index = \Input::post('has_index');
		$version = \Input::post('version');
		$category = \Input::post('category');
		$author = \Input::post('author');
		$frontend_display = \Input::post('frontend_display');
		$entry_label = \Input::post('entry_label[]');
		
		$component_path = DOCROOT.'../component';
		File::create_dir($component_path, $name);
		File::create_dir($component_path.'/'. $name,'assets');
		File::create_dir($component_path.'/'. $name,'classes');
		File::create_dir($component_path.'/'. $name,'config');
		File::create_dir($component_path.'/'. $name,'lang');
		File::create_dir($component_path.'/'. $name,'tooltip');
		File::create_dir($component_path.'/'. $name,'views');

		$component = '
{
	"version" : '.$frontend_display.',
	"category" : "'.$category.'",
	"id" : "'.$id.'",
	"author" : "'.$author.'",
	"replace-component" : "none",
	"loaded" : true,
	"frontend_display" : '.($frontend_display=='1'?true:false).'
}
		';
		
		File::create($component_path.'/'. $name, 'component.json', $component);
		File::create($component_path.'/'. $name, 'installer.json', 'Contents for file.');

$options = '
{
	"label" : {
		"default" : "Component assistant",
		"de" : "Komponenten Assistent",
		"en" : "Component assistant"
	},
	"nav_url" : "administration",
	"nav_visible" : true,
	"type" :  "form",
	"has_index" : '.($has_index=='1'?true:false).'
}
';
		File::create($component_path.'/'. $name, 'options.json', 'Contents for file.');
		exit;

		\Response::redirect('cassistant/administration/components');
	}
}
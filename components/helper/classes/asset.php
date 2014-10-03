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

namespace Helper;

class Asset extends \Backend\Helper\Component
{

	public $is_not_a_component = false;

	public function from_component($file, $component = '')
	{
		if($this->is_not_a_component && empty($component)) throw new \Exception('You have to set the second parameter in frontend.');

		if(!$this->is_not_a_component) static::analyze();

		if($component == '') $component = static::$name;

		return $this->generate_asset_string($component, $file);
	}

	public function from_layout($path, $layout = '')
	{
		if(empty($layout))
		{
			$layout = \db\option::getKey('selected_layout')->value;
		}
		return $this->generate_asset_string('', $path, false, $layout);
	}

	public function from_public($path)
	{
		return $this->generate_asset_string('', $path, true);
	}

	public function generate_asset_string($current_component, $file, $is_public = false, $is_layout = false)
	{

		$filename = explode('.',$file);
		$extension = $filename[count($filename) - 1];

		$timestamp = time();

		$html = '<strong>Asset:</strong> ' . $file . ' couldnt be found.';

		$link = 'server/component/' . $current_component;
		$is_public and $link = 'server/public';
		if($is_layout != false)
		{
			$link = 'server/layout/' . $is_layout;
		}

		switch ($extension) 
		{
			case 'css':
			case 'sass':
				$html = '<link rel="stylesheet" type="text/css" href="' . \Uri::create($link. '/' . $file) . '?' . $timestamp . '" />';
				break;
			
			case 'js':
				$html = '<script type="text/javascript" href="' . \Uri::create($link . '/' . $file) . '?' . $timestamp . '"></script>';
				break;

			case 'jpg':
			case 'jpeg':
			case 'png':
			case 'gif':
				if(is_array($filename)) {
					$filename = implode('.', $filename);
				}
				$html = '<img alt="' . str_replace('.' . $extension, '', $filename) . '" src="' . \Uri::create($link . '/' . $file) . '">';
				break;
		}

		return $html;
	}
}
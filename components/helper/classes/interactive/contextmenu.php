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
namespace Helper\Interactive;

class Contextmenu extends \Form
{

	private static $instances = array();

	private $_id = 0;

	private $_template = '<div class="contextmenu %unique_instance_name%"><ul>%content%</ul></div>';

	private $_template_script = '<script type="text/javascript">%script%</script>';

	private $_entries = array();

	private function _child_search( &$entries ,$path, $index)
	{
		$splitted_path = explode('.',$path);

		foreach ($entries as $entry)
		{
			if($entry->name == $splitted_path[$index])
			{
				if($index == (count($splitted_path) - 1))
				{
					return $entry;
				}
				return $this->_child_search( $entry->children , $path,$index+1);
			}

		}

	}

	private function _loop_through( &$entries, &$data ,$callback, $wrap_start = '', $wrap_end='')
	{
		
		foreach ($entries as $entry) 
		{
			$data[] = $callback($entry, $data, $entries);
			if(!empty($entry->children)) $data[] = $wrap_start;			
			$this->_loop_through($entry->children, $data, $callback, $wrap_start, $wrap_end);
			if(!empty($entry->children)) $data[] = $wrap_end;
		}
	}

	public function __construct()
	{
		$this->_id = count(static::$instances);
		static::$instances[] = $this;
	}

	public function each($callback, $wrap_start='', $wrap_end='')
	{
		$data = array();

		$this->_loop_through($this->_entries, $data, $callback, $wrap_start, $wrap_end);

		return $data;
	}

	public function add_entry($name, $label, $callbackname)
	{

		$entry = new \stdClass;
		$entry->name = $name;
		$entry->label = $label;
		$entry->callbackname = $callbackname;
		$entry->children = array();

		$this->_entries[] = $entry;
	}

	public function add_child_to($path, $name, $label, $callbackname)
	{
		$entry_result = $this->_child_search( $this->_entries,$path, 0);

		$entry = new \stdClass;
		$entry->name = $name;
		$entry->label = $label;
		$entry->callbackname = $callbackname;
		$entry->children = array();

		$entry_result->children[] = $entry;
	}

	public function render($element)
	{
		$entries = $this->each(function($entry, $data, $entries) {
			return '<li><a onclick="javascript:' . $entry->callbackname . '();">' . $entry->label . '</a>';
		},'<ul>','</li></ul>');

		$html = str_replace(array('%content%','%unique_instance_name%'),array(implode('', $entries),'cmenu_' . $this->_id), $this->_template);
		$script = str_replace('%script%', 'var cmenu_' . $this->_id . ' = new pcms2.interactive.contextmenu("' . $element . '", ".cmenu_' . $this->_id . '");', $this->_template_script);

		return $html . $script;
	}
}
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
namespace Helper\Interactive\Content;

class Browser extends \Form
{

	private static $instances = array();

	private $_id = 0;

	private $_template = '<div class="contentbrowser %unique_instance_name%">%form%</div>';

	private $_template_script = '<script type="text/javascript">%script%</script>';

	private $_entries = array();

	public function __construct()
	{
		$this->_id = count(static::$instances);
		static::$instances[] = $this;
	}

	public function render($processing_url)
	{

		$form = \Form::open($processing_url);
		$form .= \Form::input('content_browser_input','');
		$form .= \Form::close();

		$html = str_replace(array('%form%','%unique_instance_name%'),array($form,'content_browser_' . $this->_id), $this->_template);
		$script = str_replace('%script%', 'var cmenu_' . $this->_id . ' = new pcms2.interactive.content.browser(".content_browser_' . $this->_id . '");', $this->_template_script);

		return $html . $script;
	}
}
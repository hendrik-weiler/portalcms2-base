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

class AjaxLoaderProgress
{

	protected static $_instances = 0;

	protected static function _build_html()
	{
		return '
		<div class="ui-widget">
			<div id="ajax_load_progressbar_' . static::$_instances . '"></div>
		</div>
		';
	}

	protected static function _build_js($selector,$redirect,$path,$params,$onstepcallback,$steps)
	{
		$params = preg_replace('/\n|\r\n|\r/','',$params);
		$js = '';
		$js .= '
		<script type="text/javascript">
			$("#ajax_load_progressbar_' . static::$_instances . '").hide().find("i").hide();
			$("' . $selector . '").submit(function(e) {
				e.preventDefault();
				$.ajax_load_progressbar_selector = "#ajax_load_progressbar_' . static::$_instances . '";
				$.ajax_load_progressbar_steps = ' . $steps . '
				$.ajax_load_progressbar_progress_step = 100/' . $steps . ';
				$.ajax_load_progressbar_progress = 0;
				$.ajax_load_progressbar_data = ' . $params . ';
				$.ajax_load_progressbar_data_counter = 0;

				if($.ajax_load_progressbar_data.length == 0) return;

				$($.ajax_load_progressbar_selector).show().progressbar({value:0});
				function ajax_load_progressbar_call_' . static::$_instances . '(path,data)
				{
					$.ajax({
					  type: "POST",
					  url: "' . $path . '",
					  dataType: "json",
					  data: { ajax_data : data },
					  success: function(result) {
							$.ajax_load_progressbar_progress+=$.ajax_load_progressbar_progress_step;
							$( $.ajax_load_progressbar_selector ).progressbar({
								value: $.ajax_load_progressbar_progress
							});
							' . $onstepcallback . '(result,data);
							++$.ajax_load_progressbar_data_counter;
							if($.ajax_load_progressbar_data_counter >= $.ajax_load_progressbar_data.length)
							{
								$($.ajax_load_progressbar_selector).delay(1000).fadeOut(1000,function() {
									$(this).progressbar({value:0});';
									if($redirect != false)
										$js .= 'window.location.href = "' . $redirect . '";';
									$js .= '
								});
							}
							else
							{
								ajax_load_progressbar_call_' . static::$_instances . '(path,$.ajax_load_progressbar_data[$.ajax_load_progressbar_data_counter]);
							}
						}
					});
				}
				ajax_load_progressbar_call_' . static::$_instances . '("' . $path . '",$.ajax_load_progressbar_data[0]);
			});
		</script>
		';

		return $js;
	}

	public static function get_input()
	{
		return AjaxLoader::get_input();
	}

	public static function get_response($input, $response)
	{
		if($input['ajax_call'])
		{
			return \Response::forge($response);	
		}
		else
		{
			!isset($input['_redirect']) and $input['_redirect'] = '';
			if($input['error_code'] == 0)
				return \Response::redirect($input['_redirect']);
			else
				return \Response::redirect($input['_current'] . '?message=' . $input['error_code']);
		}
	}

	public static function to_r(Array $response_array)
	{
		return AjaxLoader::to_r($response_array);
	}

	public static function response($status,$title='',$message='')
	{
		return AjaxLoader::response($status,$title,$message);
	}

	public static function render($selector,$messages,$redirect,$path,$params,$onstepcallback,$steps)
	{
		++static::$_instances;
		$html = '';

		if(isset($_GET['message']))
			$html .=  AjaxLoader::_build_no_ajax_error($messages[$_GET['message']]);

		$html .= static::_build_html();
		$html .= static::_build_js($selector,$redirect,$path,$params,$onstepcallback,$steps);

		return $html;
	}
}
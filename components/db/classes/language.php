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
namespace db;

class Language extends \Orm\Model
{

	protected static $_table_name = 'languages';

	protected static $_properties = array('id', 'label', 'prefix', 'sort');

	public static function getLanguages()
	{
		$result = array();

		foreach(self::find('all') as $lang)
			$result[$lang->prefix] = $lang->label;

		return $result;
	}

  public static function getLanguagesDatabaseUpdate()
  {
    $result = array();

    foreach(self::find('all') as $lang)
      $result[] = $lang->prefix;

    return $result;
  }

  public static function prefixToId($prefix)
  {
    $search = self::find('first',array(
      'where' => array('prefix'=>$prefix)
    ));

    if(!empty($search))
      return $search->id;

    return false;
  }

  public static function idToPrefix($id)
  {
    $search = self::find($id);

    if(!empty($search))
      return $search->prefix;

    return false;
  }
}
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
namespace Install;

class Controller_Install extends \Controller
{

	protected $data;

	public function before()
	{
		if(file_exists(DOCROOT . '../DISABLE_INSTALL_TOOL'))
		{
			print 'Install tool is disabled.';
			exit;
		}

		$this->data = new \stdClass;
		$this->data->step = (\Uri::segment(2) == '') ? 1 : \Uri::segment(2);
		\Lang::load('layout');
		\Lang::load('messages');

		$this->data->title = 'PortalCMS 2 - Installation ' . $this->data->step . '/4';
	}

	public function action_index()
	{
		\Response::redirect('install/1');
	}

	public function action_step1()
	{
		if(file_exists(DOCROOT . '../components/install/step1.bak'))
			$config = \File::read(DOCROOT . '../components/install/step1.bak',true);
		else
			$config = '{"dev_user":"","dev_pass":"","prod_user":"","prod_pass":"","db":""}';

		$conf = json_decode($config,true);

		$this->data->dev_user = $conf['dev_user'];
		$this->data->dev_pass = $conf['dev_pass'];
		$this->data->prod_user = $conf['prod_user'];
		$this->data->prod_pass = $conf['prod_pass'];
		$this->data->db = $conf['db'];
	}

	public function action_step2()
	{
		$option = \DB::query('SHOW TABLES LIKE "options"')->execute();

		$dir = \File::read_dir(DOCROOT . '../components/install/classes/migration',1);
		
		if(!$option)
		{
			$dbu = new \db\Option();
			$dbu->key = 'database_updates';
			$dbu->value = array();

			$updates = array();
			foreach ($dir as $value) 
			{
				$class = '\\Install\\Migration\\' . str_replace('.php', '', $value);
				$migration = new $class();
				$migration->update(array('dummy','en'));
				$info = $migration->get_info();
				$dbu->value[] = $info['version'];
			}
			$last_version = $dbu->value[count($dbu->value)-1];

			$dbu->value = json_encode($dbu->value);
			$dbu->save();

			$language = new \db\Language();
			$language->prefix = 'en';
			$language->label = 'English';
			$language->sort = 0;
			$language->save();

			$version = new \db\Option();
			$version->key = 'database_version';
			$version->value = $last_version;
			$version->save();

			$account = new \db\AccountsGroup();
			$account->label = 'Admin';
			$account->permissions = json_encode(array());
			$account->save();

			\db\NavGroup::setLangPrefix('en');
			$navgroup = new \db\NavGroup();
			$navgroup->title = 'Main';
			$navgroup->save();
		}	

		$this->data->current_version = \db\Option::getKey('database_version')->value;
		$this->data->finished_updates = json_decode(\db\Option::getKey('database_updates')->value);

		$updates = array();
		foreach ($dir as $value) 
		{
			$class = '\\Install\\Migration\\' . str_replace('.php', '', $value);
			$migration = new $class();
			$updates[] = $migration->get_info();
		}
		$this->data->updates = $updates;
		$this->data->latest_version = $updates[count($updates)-1]['version'];
	}

	public function action_step3()
	{
		$accounts = \db\Accounts::find('all',array(
			'where' => array('group'=>\db\AccountsGroup::getGroupByLabel('Admin')->id)
		));
		$account_final = array();
		foreach ($accounts as $key => $account) 
		{
			$avatar = \db\AccountsAvatars::find('first',array(
				'where' => array('account_id'=>$account->id)
			));
			$account_final[$key]['account'] = $account;
			$account_final[$key]['avatar'] = $avatar;
		}


		$this->data->accounts = $account_final;
	}

	public function action_step4()
	{
		$accounts = \db\Accounts::find('all',array(
			'where' => array('group'=>1)
		));

		$this->data->can_be_disabled = count($accounts) != 0;
	}

	public function after($response)
	{
		return \Response::forge(\View::forge('layout',$this->data));
	}
}
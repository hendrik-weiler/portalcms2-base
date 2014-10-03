<?php

namespace Base;

class Install extends \DBUtil
{

	private function _createCMSDataByLang($lang)
	{
		\DBUtil::create_table($lang . '_site', array(
            'id' => array('type' => 'int', 'constraint' => 10,'auto_increment' => true),
            'navigation_id' => array('type' => 'int', 'constraint' => 10, 'null' => true),
            'group_id' => array('type' => 'int', 'constraint' => 10,'null' => true),
            'label' => array('type' => 'varchar', 'constraint' => 60, 'null' => true),
            'url_title' => array('type' => 'varchar', 'constraint' => 80, 'null' => true),
            'site_title' => array('type' => 'varchar', 'constraint' => 120, 'null' => true),
            'keywords' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
            'description' => array('type' => 'text', 'null' => true),
            'redirect' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
            'sort' => array('type' => 'int', 'constraint' => 10, 'null' => true),
            'changed' => array('type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP')),
        ), array('id'));

		\DBUtil::create_table($lang . '_news', array(
            'id' => array('type' => 'int', 'constraint' => 10,'auto_increment' => true),
            'title' => array('type' => 'varchar', 'constraint' => 80, 'null' => true),
            'picture' => array('type' => 'text', 'null' => true),
            'text' => array('type' => 'text', 'null' => true),
            'attachment' => array('type' => 'text', 'null' => true),
            'creation_date' => array('type' => 'timestamp','default' => \DB::expr('CURRENT_TIMESTAMP'), 'null' => true),
        ), array('id'));

            \DBUtil::create_table($lang . '_navigation_group', array(
            'id' => array('type' => 'int', 'constraint' => 10,'auto_increment' => true),
            'title' => array('type' => 'varchar', 'constraint' => 80, 'null' => true),
        ), array('id'));

		\DBUtil::create_table($lang . '_navigation', array(
            'id' => array('type' => 'int', 'constraint' => 10,'auto_increment' => true),
            'group_id' => array('type' => 'int', 'constraint' => 10,'null' => true),
            'label' => array('type' => 'varchar', 'constraint' => 80, 'null' => true),
            'url_title' => array('type' => 'varchar', 'constraint' => 100, 'null' => true),
            'parent' => array('type' => 'int', 'constraint' => 11, 'null' => true),
            'sort' => array('type' => 'int', 'constraint' => 11, 'null' => true),
        ), array('id'));

	  \DBUtil::create_table($lang . '_content', array(
            'id' => array('type' => 'int', 'constraint' => 10,'auto_increment' => true),
            'group_id' => array('type' => 'int', 'constraint' => 10,'null' => true),
            'site_id' => array('type' => 'int', 'constraint' => 10, 'null' => true),
            'type' => array('type' => 'int', 'constraint' => 11, 'null' => true),
            'label' => array('type' => 'varchar', 'constraint' => 60, 'null' => true),
            'text' => array('type' => 'text', 'null' => true),
            'text2' => array('type' => 'text', 'null' => true),
            'text3' => array('type' => 'text', 'null' => true),
            'parameter' => array('type' => 'text', 'null' => true),
            'wmode' => array('type' => 'text', 'null' => true),
            'flash_file' => array('type' => 'text', 'null' => true),
            'pictures' => array('type' => 'text', 'null' => true),
            'dimensions' => array('type' => 'text', 'null' => true),
            'form' => array('type' => 'text', 'null' => true),
            'refer_content_id' => array('type' => 'text', 'null' => true),
            'sort' => array('type' => 'int', 'constraint' => 11, 'null' => true),
        ), array('id'));

	}

	public function language_selection()
	{
		
	}

	public static function install()
	{





	}

	private function _deleteCMSDataByLang($lang)
	{
		\DBUtil::drop_table($lang . '_site');
		\DBUtil::drop_table($lang . '_content');
		\DBUtil::drop_table($lang . '_news');
		\DBUtil::drop_table($lang . '_navigation');
            \DBUtil::drop_table($lang . '_navigation_group');
	}

	public static function uninstall()
	{

	}
}
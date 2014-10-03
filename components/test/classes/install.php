<?php

namespace Test;

class Install extends \DBUtil
{
	public function __construct() {}

	public static function test()
	{
		var_dump('Do something @test',$_POST);
	}

	public static function test2()
	{
		var_dump('Do something @test2',$_POST);
	}

	public static function install()
	{
		var_dump('install handler');
	}

	public static function uninstall()
	{
		var_dump('uninstall handler');
	}
}
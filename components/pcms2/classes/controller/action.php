<?php

namespace Pcms2;

class Controller_Action extends \AuthController
{
	public function before()
	{
		\Lang::load('messages');
	}


	public function action_index()
	{

	}
}
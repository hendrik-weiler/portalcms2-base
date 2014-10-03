<?php

namespace Pcms2;

class Controller_Administration extends \BackendController
{
	public function action_index()
	{
		$context = new \Helper\Interactive\Contextmenu();
		$context->add_entry('new','Neu','neu_clickhandler');
		$context->add_child_to('new','navpoint','Navigationspunkt','navipunkt_clickhandler');
		$context->add_child_to('new','content','Inhalt','inhalt_clickhandler');
		$context->add_child_to('new.content','slideshow','Slideshow','inhalt_clickhandler');
		$context->add_entry('properties','Eigenschaften','property_clickhandler');

		

		$this->data->content_ctxm = $context->render('.content');


		$browser = new \Helper\Interactive\Content\Browser();

		$this->data->content_browser = $browser->render(\Uri::current());
	}
}
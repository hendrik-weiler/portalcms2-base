<?php

class module_injection
{
	public static function generate($predefined = array())
	{
		foreach(scandir(DOCROOT . '../components') as $folder)
		{
			if(!in_array($folder, array('.','..','base','.ds_store','.DS_STORE'))
				&& !in_array($folder, $predefined)
				&& is_dir(DOCROOT . '../components/' . $folder))
			{
				$predefined[] = $folder;
			}
		}

		return $predefined;
	}
}
<?php

use Illuminate\Support\Arr; 

function ___($path = null, $replace = [], $locale = null)
{
    // Default behavior
    if (is_null($path)) return $path;
	if(!strrpos($path, '.')) {
		return  $path;
	}

    $properties = explode(".", $path);
	$currentLocale = app()->getLocale();	
	$translated_string = substr($path, strrpos($path, '.') + 1);

	if(is_dir(lang_path($currentLocale))) {
		if (is_file(lang_path($currentLocale.'\\'.$properties[0].'.json'))) {
			$contents = json_decode(file_get_contents(lang_path($currentLocale.'\\'.$properties[0].'.json')), true);
			$translated_string = Arr::get($contents, $properties[1], $properties[1]);
		}
	}

	return $translated_string;
}
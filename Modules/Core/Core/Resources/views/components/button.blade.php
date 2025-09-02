@props([
	'default'		=> true,
	'ghost'			=> false,
	'primary'		=> false,
	'secondary'		=> false,
	'destructive'	=> false,
	'text'			=> false,
	'link'			=> false,

	'submit'		=> false,

	'xs'			=> false,
	'sm'			=> false,
	'md'			=> false,
	'lg'			=> false,

	'id'			=> null
])

@php

	$style = $ghost ? 'ghost' : 
			($primary ? 'primary' : 
			($secondary ? 'secondary' : 
			($destructive ? 'destructive' :
			($text ? 'text' :
			($link ? 'link' :
			'default')))));

	$size = $xs ? 'xs' :
			($sm ? 'sm' :
			($md ? 'md' :
			($lg ? 'lg': null)));

	$type = $submit ? 'submit' : 'button';

	$btn_id = $id ?: ('btn-'.\Illuminate\Support\Str::random(8));

@endphp

<button

	{{
		$attributes
		->class([
			"uk-btn uk-btn-{$style}",
			$size ? "uk-btn-{$size}" : "",
		])->merge([
			'type'		=> $type,
			'id'		=> $id
		])
	}}>

{{$slot}}

</button>

</div>
@props([
	'default'		=> true,
	'ghost'			=> false,
	'primary'		=> false,
	'secondary'		=> false,
	'destructive'	=> false,
	'text'			=> false,
	'link'			=> false,

	'xs'			=> false,
	'sm'			=> false,
	'md'			=> false,
	'lg'			=> false,

	'back'			=> false,

	'href'          => '#',
    'target'        => null,
    'rel'           => null,
    'download'      => null,
    'hreflang'      => null,
    'type'          => null,
    'referrerpolicy'=> null,

	'icon'          	=> null,
    'icon_position'  	=> 'left', 
    'icon_size'      	=> 'size-4',

	'id'            => null,
    'title'         => null,
    'role'          => null,
    'tabindex'      => null,
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

	$anchor_id = $id ?: ('btn-'.\Illuminate\Support\Str::random(8));

	$icon_spacing = $icon_position === 'left' ? 'mr-2' : 'ml-2';

	$href = $back ? url()->previous() : $href;
	$icon = $back ? 'arrow-left-from-line' : $icon;

	$merge_attributes = array_filter([
        'id'            => $anchor_id,
        'href'          => $href,
        'target'        => $target,
        'rel'           => $rel,
        'download'      => $download,
        'hreflang'      => $hreflang,
        'type'          => $type,
        'referrerpolicy'=> $referrerpolicy,
        'title'         => $title,
        'role'          => $role,
        'tabindex'      => $tabindex,
    ], function($value) {
        return $value !== null;
    });

@endphp

<a
	{{
		$attributes
		->class([
			"uk-btn uk-btn-{$style}",
			$size ? "uk-btn-{$size}" : "",
		])->merge($merge_attributes);
	}}
>	
	@if($icon && $icon_position === 'left')
		<span class="{{ $icon_spacing }} {{ $icon_size }}"> 
			<uk-icon icon="{{ $icon }}"></uk-icon>
		</span>
	@endif

	@if ($slot->isNotEmpty())
		{{ $slot }}
	@else
		Back
	@endif
    
    @if($icon && $icon_position === 'right')
        <span class="{{ $icon_spacing }} {{ $icon_size }}"> 
            <uk-icon icon="{{ $icon }}"></uk-icon>
        </span>
    @endif

</a>
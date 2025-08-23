@props([
	'placeholder' 	=> null,
    'label'       	=> null,
	'type' 			=> 'password',
	'name'			=> 'password',
	'recover'		=> false,
	'remember'		=> false,
])

@php

	$label_text = $label ?? \Illuminate\Support\Str::headline($name);

	$input_id = "form-input-{$name}";

	$required = ($attributes->get(':100') || $attributes->get(':101') || $attributes->get(':110') || $attributes->get(':111')) ? true : false;
    $readonly = ($attributes->get(':010') || $attributes->get(':011') || $attributes->get(':110') || $attributes->get(':111')) ? true : false;
    $hidden   = ($attributes->get(':001') || $attributes->get(':011') || $attributes->get(':101') || $attributes->get(':111')) ? true : false;

    $controlKeys = collect([':001',':010',':011',':100',':101',':110',':111'])
	->filter(fn ($k) => $attributes->has($k))
	->all();

    $attrys = $attributes->except($controlKeys)->merge([
        'required' => $required ? true : null,
        'readonly' => $readonly ? true : null,
        'hidden'   => $hidden   ? true : null,
    ]);

@endphp

<div class="uk-form-element grid gap-y-1">

	@isset($label_text)
		<label
			class="uk-form-label uk-form-label-custom @if($required) uk-form-label-required @endif"
			for="{{ $input_id }}"
		>
			{{ $label_text }}
		</label>
	@endisset

	<div class="uk-inline flex">



		<a class="uk-form-icon uk-form-icon-flip" href="#">
			<uk-icon icon="link"></uk-icon>
		</a>

		<input {{
			$attrys
				->class([
					'uk-input',
					'uk-form-destructive' => $errors->has($name),
				])
				->merge([
					'type'             	=> $type,
					'id'               	=> $input_id,
					'name'             	=> $name,
					'placeholder'      	=> $placeholder,
					'aria-describedby' 	=> "{$name}-help-block",
					'aria-label'		=> "Clickable icon",
					'autocomplete' 		=> "off"
				], escape: false)
			}}
		/>
		
	</div>
	
	<x-core::errors :name="$name"/>

</div>

@if($remember || $recover)
<div class="flex justify-between mt-4">

	@if($remember)
	<label for="remember">
		<input name="remember" type="hidden" value="0" />
		<input
			class="uk-checkbox mr-1"
			id="remember"
			name="remember"
			type="checkbox"
			value="1"
		/>
		Remember me
	</label>
	@endif

	@if($recover)		
	<a class="uk-link" href="{{$recover}}"> Can't login? </a>
	@endif

</div>
@endif

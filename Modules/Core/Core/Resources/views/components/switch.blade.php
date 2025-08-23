@props([
    'label'			=> null,
    'name',
])

@aware(['model' => null])

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

$value = old($name, data_get($model, $name) ?? '');

@endphp

<div class="uk-form-element">

	<div class="flex items-center space-x-4">

		<input

			{{
				$attrys
					->class([
						'uk-toggle-switch uk-toggle-switch-primary',
						'uk-form-destructive' => $errors->has($name),
					])
					->merge([
						'type'             	=> 'checkbox',
						'id'               	=> $input_id,
						'name'             	=> $name,
						'aria-describedby' 	=> "{$name}-help-block",
						'autocomplete' 		=> "off"
					])
			}}

			@checked($value)
			
		/>

		@isset($label_text)
			<label class="uk-form-label mb-0 ms-8 
				@if($required) uk-form-label-required @endif" 
				for="{{ $input_id }}"
			>
				{{ $label_text }}
			</label>
		@endisset

	</div>

	<x-core::errors :name="$name"/>

</div>
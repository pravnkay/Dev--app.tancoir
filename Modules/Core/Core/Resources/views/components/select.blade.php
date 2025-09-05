@props([
    'options'				=> [],
    'enum'					=> [],
	'set'					=> null,

    'placeholder' 			=> null,
    'empty_placeholder' 	=> null,
    'label'					=> null,
    'name',
])

@aware(['model' => null])

@php

	$label_text = $label ?? \Illuminate\Support\Str::headline($name);

	$input_id = "form-select-{$name}";

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

	$options = $options ? $options : $enum;

	if($model) {
		$stored = data_get($model, $name) ;
    	$set = old($name, $stored ?? '');
	} else {
		$set = old($name, null);
	}

	if(!$options) $placeholder = $empty_placeholder

@endphp

<div class="uk-form-element mt-4">

    @isset($label_text)
        <label
            class="uk-form-label uk-form-label-custom @if($required) uk-form-label-required @endif"
            for="{{$input_id}}"
        >
            {{ $label_text }}
        </label>
    @endisset

	<div class="uk-form-controls">

		<uk-select @if ($set) value = {{$set}} @endif
			{{
				$attrys
					->class([
						'uk-form-destructive' => $errors->has($name),
					])
					->merge([
						'name'             	=> $name,
						'aria-describedby' 	=> "{$name}-help-block",
						'placeholder'		=> $placeholder
					])
			}}
			cls-custom="button: uk-input-fake justify-between w-full; dropdown: w-full"
			icon
			@if($readonly) disabled @endif
			
		>
			<select id="{{$input_id}}" hidden>
				@foreach ($options as $key => $value)
					<option value="{{$key}}">{{$value}}</option>
				@endforeach
			</select>
		</uk-select>

	</div>

    <x-core::errors :name="$name"/>

</div>

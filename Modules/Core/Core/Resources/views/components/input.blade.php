@props([
    'text'			=> false,
    'email'			=> false,
    'number'		=> false,
	'help'			=> null,
    'placeholder'	=> null,
    'label'			=> null,
	'blank'			=> null,
    'name',
])

@aware(['model' => null])

@php

	$label_text = $label ?? \Illuminate\Support\Str::headline($name);

	$input_id = "form-input-{$name}";
	$type = $email ? 'email' : ($number ? 'number' : 'text');

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

    // Value resolution
    $value = old($name, data_get($model, $name) ?? '');
	
@endphp

<div class="uk-form-element mt-4">

    @isset($label_text)
        <label
            class="uk-form-label uk-form-label-custom @if($required) uk-form-label-required @endif"
            for="{{ $input_id }}"
        >
            {{ $label_text }}
        </label>
    @endisset
	
	<div class="uk-form-controls">
		<input
			{{
				$attrys
					->class([
						'uk-input',
						'uk-form-blank' => $blank,
						'uk-form-destructive' => $errors->has($name),
					])
					->merge([
						'type'             	=> $type,
						'id'               	=> $input_id,
						'name'             	=> $name,
						'placeholder'      	=> $placeholder,
						'value'            	=> $value,
						'aria-describedby' 	=> "{$name}-help-block",
						'autocomplete' 		=> "off"
					], escape: false)
			}}
		/>
	</div>

	
	@if($help)
	<div class="uk-form-help text-muted-foreground">
		{{$help}}
	</div>
	@endif

    <x-core::errors :name="$name"/>

</div>

@props([
    'post'   => true,
    'put'    => false,
    'delete' => false,
    'id'     => null,
	'horizontal' => null,
    'action',
])

@php
    use Illuminate\Support\Str;

    // Stable form id
    $form_id = $id ?: ('form-'.Str::random(8));

    // Decide intended HTTP verb (explicit priority: DELETE > PUT > POST)
    $intended = $delete ? 'DELETE' : ($put ? 'PUT' : 'POST');

    // HTML <form> supports only GET|POST; spoof others via @method
    $form_method = in_array($intended, ['GET', 'POST'], true) ? $intended : 'POST';

	$layout = $horizontal ? 'horizontal' : 'stacked';
@endphp

<form 
	{{
		$attributes
			->class([
				"uk-form-{$layout}",
			])
			->merge([
				'action'            => $action,
				'id'               	=> $form_id,
				'method'            => $form_method,
				'autocomplete' 		=> 'off'
			])
	}}
>
	@csrf

    @if ($intended !== $form_method)
        @method($intended)
    @endif

    {{$slot}}
</form>
@extends('core::layouts.registry.index')

@section('main-content')

	<div class="space-y-4 mb-4">
		<div class="flex justify-between">
			<div class="self-center">
				{{ Breadcrumbs::render('ramp.apply.create', $event) }}
			</div>
			<div class="self-end"> 
				{{--  --}}
			</div>
		</div>		
		<div class="border-border border-t"></div>
	</div>

	<div class="row">
		<div class="col w-full">
			<h3 class="text-lg font-medium">{{$event['name']}} | {{$event['title']}}</h3>
			<p class="text-muted-foreground text-sm">{{__('You can apply to the event using the form below.')}}</p>
			<div class="border-border border-t my-3"></div>
			<p class="uk-paragraph">Form text can be created using <code class="uk-codespan">.uk-form-help</code> and should be explicitly associated with the form control it relates to using the <code class="uk-codespan">aria-describedby</code> attribute. This will ensure that assistive technologies—such as screen readers—will announce this form text when the user focuses or enters the control.</p>
		</div>
	</div>
	

@endsection

@push('page-scripts')
	
@endpush
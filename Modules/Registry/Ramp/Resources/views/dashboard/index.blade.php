@extends('core::layouts.main.index')

@section('main-content')

<div class="uk-container uk-container-lg">

	<div class="space-y-4 mb-4">
		<div class="space-y-1">

			<p class="uk-text-lead mt-2">
				{{__('$MODULE$')}}
			</p>
			<h3 class="uk-h3">
				{{__('Dashboard')}}
			</h3>
		
		</div>
		<div class="border-border border-t"></div>
	</div>

</div>

@endsection

@push('page-scripts')
	
@endpush
@extends('core::layouts.backend.index')

@section('main-content')

<div class="uk-container uk-container-lg">

	<div class="space-y-4 mb-4">
		<div class="space-y-1">

			<p class="uk-text-lead mt-2">
				{{__('Moderation')}}
			</p>
			<h3 class="uk-h3">
				{{__('Profiles')}}
			</h3>
		
		</div>
		<div class="border-border border-t"></div>
	</div>

	<div class="row">
		<div class="col w-full">
			<h4 class="uk-h4 mb-6">List of submitted profiles</h4>
			{!! $dataTable->table([], true) !!}
		</div>
	</div>

</div>

@endsection

@push('page-scripts')

{!! $dataTable->scripts() !!}

@endpush
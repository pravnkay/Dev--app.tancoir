@extends('core::layouts.registry.index')

@section('main-content')

	<div class="space-y-4 mb-4">
		<div class="flex justify-between">
			<div class="self-center">
				{{ Breadcrumbs::render('profile') }}
			</div>
			<div class="self-end"> 
				<a type="button" href="{{route('app.profile.create')}}" class="uk-btn uk-btn-primary self-end">New Profile</a>					
			</div>
		</div>		
		<div class="border-border border-t"></div>
	</div>

	<div class="row">
		<div class="col w-full">
			<h4 class="uk-h4 mb-6">List of your profiles</h4>
			{!! $dataTable->table([], true) !!}
		</div>
	</div>
	

@endsection

@push('page-scripts')

{!! $dataTable->scripts() !!}
	
@endpush
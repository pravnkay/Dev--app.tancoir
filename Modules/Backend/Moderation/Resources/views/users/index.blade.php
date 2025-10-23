@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.moderation.users'))

@section('main-content')

	<div class="row">
		<div class="col w-full">
			<h4 class="uk-h4 mb-6">List of users</h4>
			{!! $dataTable->table([], true) !!}
		</div>
	</div>

@endsection

@push('page-scripts')

{!! $dataTable->scripts() !!}

@endpush
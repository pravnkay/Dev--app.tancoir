@extends('core::layouts.backend.index')

@section('main-content')

<div class="uk-container uk-container-lg">

	<div class="row">
		<div class="col w-full">	
			<div class="row">
				<div class="col w-6/12 content-end">
					{{ Breadcrumbs::render('backend.moderation.profile')}}
				</div>
				<div class="col w-6/12 flex items-end justify-end">
					{{--  --}}
				</div>
			</div>
		</div>
		<div class="col w-full border-border border-t my-6"></div>
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
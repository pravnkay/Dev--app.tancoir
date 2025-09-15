@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.rampmanagement.enterprises'))

@section('action-button')
	{{-- <a type="button" href="{{route('backend.rampmanagement.enterprises.create')}}" class="uk-btn uk-btn-primary self-end">{{__('New Enterprise')}}</a> --}}
@endsection

@section('main-content')

	<div class="row">
		<div class="col w-full">
			{!! $dataTable->table([], true) !!}
		</div>
	</div>

	<form id="bulk-delete-form" method="POST" action="{{route('backend.bulk.destroy') }}">
		@csrf
		@method('DELETE')
		<input type="text" name="model" value="{{$model}}" hidden>
	</form>

@endsection

@push('page-scripts')

{!! $dataTable->scripts() !!}
	
@endpush
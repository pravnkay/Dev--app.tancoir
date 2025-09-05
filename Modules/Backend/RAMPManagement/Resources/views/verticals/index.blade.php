@extends('core::layouts.backend.index')

@section('main-content')

<div class="uk-container uk-container-lg">

	<div class="row">
		<div class="col w-full">	
			<div class="row">
				<div class="col w-6/12 content-end">
					{{ Breadcrumbs::render('backend.rampmanagement.verticals')}}				
				</div>
				<div class="col w-6/12 flex items-end justify-end">
					<a type="button" href="{{route('backend.rampmanagement.verticals.create')}}" class="uk-btn uk-btn-primary self-end">{{__('New Vertical')}}</a>
				</div>
			</div>
		</div>
		<div class="col w-full border-border border-t my-6"></div>
	</div>

	<div class="row">
		<div class="col w-full">
			{!! $dataTable->table([], true) !!}
		</div>
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
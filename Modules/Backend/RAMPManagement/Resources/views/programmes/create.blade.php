@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.rampmanagement.programmes.create'))	

@section('action-button')
	<button type="submit" form="create-programme-form" class="uk-btn uk-btn-primary">{{__('Save Programme')}}</button>
@endsection

@section('main-content')

<div class="row">
	<div class="col w-full">
		<x-core::form action="{{route('backend.rampmanagement.programmes.store')}}" id="create-programme-form"> 

			<fieldset class="uk-fieldset space-y-4">
				<div class="row">
					<div class="col w-full xl:w-6/12 mb-4">
						<x-core::input name="name" :100/>
					</div>
					<div class="col w-full xl:w-6/12 mb-4">
						<x-core::select name="scheme" :enum="$schemes" :100> </x-core::select>
					</div>
				</div>
				<div class="row">
					<div class="col w-full">
						<x-core::select name="vertical_id" label="Programme vertical" :options="$verticals" :100> </x-core::select>
					</div>
				</div>
			</fieldset>

		</x-core::form>
	</div>
</div>

@endsection

@push('page-scripts')

@endpush
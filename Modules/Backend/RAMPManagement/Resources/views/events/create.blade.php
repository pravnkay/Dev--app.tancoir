@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.rampmanagement.events.create'))	

@section('action-button')
	<button type="submit" form="create-event-form" class="uk-btn uk-btn-primary">{{__('Save Event')}}</button>
@endsection

@section('main-content')

<div class="row">
	<div class="col w-full">
		<x-core::form id="create-event-form" action="{{route('backend.rampmanagement.events.store')}}"> 

			<fieldset class="uk-fieldset space-y-4">

				<div class="row">
					<div class="col w-full xl:w-8/12 mb-4">
						<x-core::input name="title" :100/>
					</div>
					<div class="col w-full xl:w-4/12 mb-4">
						<div class="uk-form-element mt-4">
							<span class="uk-form-label uk-form-label-custom">Date</span>
							<uk-input-date name="date" jumpable cls-custom="uk-input-fake" required></uk-input-date>
						</div>
					</div>
				</div>				

				<div class="row">					
					<div class="col w-full xl:w-4/12 mb-4">
						<x-core::input number name="days" :100/>
					</div>
					<div class="col w-full xl:w-4/12 mb-4">
						<x-core::input number name="cost" :100/>
					</div>
					<div class="col w-full xl:w-4/12 mb-4">
						<x-core::input number name="participant_count" :100/>
					</div>								
					<div class="col w-full">
						<x-core::select name="programme_id" label="Programme" empty_placeholder="Verticals missing. No valid programmes." :options="$programmes" :100> </x-core::select>
					</div>				
				</div>

			</fieldset>

		</x-core::form>
	</div>
</div>

@endsection

@push('page-scripts')

@endpush
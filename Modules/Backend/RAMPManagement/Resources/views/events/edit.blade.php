@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.rampmanagement.events.edit', $event))	

@section('action-button')
	<button type="submit" form="edit-event-form" class="uk-btn uk-btn-primary">{{__('Update Event')}}</button>
@endsection

@section('main-content')

	<div class="row">
		<div class="col w-full">

			<x-core::form put id="edit-event-form" action="{{route('backend.rampmanagement.events.update', ['event' => $event['id']])}}" :model="$event"> 


				<fieldset class="uk-fieldset space-y-4">

					<div class="row">
						<div class="col w-full xl:w-8/12 mb-4">
							<x-core::input name="title" :100/>
						</div>
						<div class="col w-full xl:w-4/12 mb-4">
							<div class="uk-form-element mt-4">
								<span class="uk-form-label uk-form-label-custom">Date</span>
								<uk-input-date name="date" jumpable cls-custom="uk-input-fake" value="{{$event['date'] ? $event['date']->format('Y-m-d') : ''}}" required></uk-input-date>
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
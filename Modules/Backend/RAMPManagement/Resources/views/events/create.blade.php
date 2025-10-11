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
					<div class="col w-full xl:w-1/2 mb-4">
						<x-core::select name="programme_id" label="Programme" empty_placeholder="Verticals missing. No valid programmes." :options="$programmes" :100> </x-core::select>
					</div>
					<div class="col w-full xl:w-1/2 mb-4">

							<div class="uk-form-element mt-4">
								<label class="uk-form-label uk-form-label-custom uk-form-label-required" for="registration_status_selector">
									Registration status
								</label>

								<div class="uk-form-controls">
									<select name="is_registration_open" id="registration_status_selector" class="uk-select" required>
										<option hidden disabled value="" @selected(old('is_registration_open') === null)>-- Pick one --</option>
										<option value="1" @selected(old('is_registration_open') == 1)>Open</option>
										<option value="0" @selected(old('is_registration_open') == 0)>Closed</option>
									</select>
								</div>
							</div>
							
						</div>			
				</div>

			</fieldset>

		</x-core::form>
	</div>
</div>

@endsection

@push('page-scripts')

@endpush
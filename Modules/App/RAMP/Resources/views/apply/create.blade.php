@extends('core::layouts.app.index')

@section('main-content')

<div class="row">
	<div class="col w-full">

	<x-core::form action="{{route('app.ramp.apply.store', ['event' => $event['id']])}}"> 
	<div class="row">

		<div class="col w-full">	
			<div class="row">
				<div class="col w-6/12 content-end">
					{{ Breadcrumbs::render('app.ramp.apply.create', $event) }}
				</div>
				<div class="col w-6/12 flex items-end justify-end">
					{{--  --}}
				</div>
			</div>
			<div class="col w-full border-border border-t my-6"></div>
		</div>

		<div class="col w-full">
			<h3 class="text-lg font-medium">{{$event['name']}} | {{$event['title']}}</h3>
			<p class="text-muted-foreground text-sm">{{__('You can apply to the event using the form below.')}}</p>
			<div class="border-border border-t my-3"></div>
		</div>

		<div class="col w-full">
			<fieldset class="uk-fieldset space-y-4">
				<div class="row">

					<div class="col w-full mb-4">
						<div class="uk-form-element mt-4">

							<label class="uk-form-label uk-form-label-custom uk-form-label-required" for="profile_picker">
								{{__('Profile')}}
							</label>

							<div class="uk-form-controls">

								<uk-select 
									name="profile_id"
									id="profile_picker"
									cls-custom="button: uk-input-fake justify-between w-full; dropdown: w-full" icon
								>
									<select hidden id="profile_picker_select">
										@foreach ($active_profiles as $key => $value)
											<option value="{{$key}}">{{$value}}</option>
										@endforeach
									</select>
								</uk-select>

							</div>

							@error('profile_id')
								<div class="uk-anmt-shake uk-form-help mt-2 text-destructive">
									{{ $message }}
								</div>
							@enderror

							<div class="uk-form-help text-muted-foreground mt-3">
								Not seeing the desired UDYAM Profile ? Make sure one exists and approved.
							</div>
							<div class="uk-form-help">
								<a href="{{route('app.profile.index')}}">See all Profiles</a> &emsp; | &emsp; <a href="{{route('app.profile.create')}}">Create a new profile</a>
							</div>

						</div>						
						<div class="border-border border-t my-3"></div>
					</div>

					<div class="col w-full mb-4">
						<div class="uk-form-element mt-4">

							<label class="uk-form-label uk-form-label-custom uk-form-label-required" for="profile_picker">
								{{__('Participant')}}
							</label>

							<div class="uk-form-controls">

								<uk-select 
									name="participant_id"
									id="participant_picker"
									cls-custom="button: uk-input-fake justify-between w-full; dropdown: w-full" icon reactive
								>
									<select hidden id="participant_picker_select">
										@foreach ($participants_grouped as $profile_id => $participants)
											@foreach ($participants as $participant)
												<option disabled data-profile-id="{{$profile_id}}" value="{{$participant['id']}}">{{$participant['name']}}</option>
											@endforeach
										@endforeach
									</select>
								</uk-select>

							</div>

							@error('participant_id')
								<div class="uk-anmt-shake uk-form-help mt-2 text-destructive">
									{{ $message }}
								</div>
							@enderror

							<div class="uk-form-help text-muted-foreground mt-3">
								Not seeing the desired Participant ? Make sure one exists under the selected profile.
							</div>
							<div class="uk-form-help">
								<a href="{{route('app.participant.index')}}">See all participants</a> &emsp; | &emsp; <a href="{{route('app.participant.create')}}">Create a new participant</a>
							</div>

						</div>						
						<div class="border-border border-t my-3"></div>
					</div>

					

				</div>				
			</fieldset>
		</div>
	
	</div>
	</x-core::form>

	</div>
</div>
	

@endsection

@push('page-scripts')

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const profile_picker = document.getElementById('profile_picker')
		const participant_picker = document.getElementById('participant_picker')
		
		// Listen for the Franken UI specific event
		profile_picker.addEventListener('uk-select:input', function(event) {

			selected_profile_id = event.detail.value;

			const participant_picker_select = document.getElementById('participant_picker_select');

			if (participant_picker_select) {

				const non_disabled_options = participant_picker_select.querySelectorAll('option:not([disabled])');

				non_disabled_options.forEach(option => {
					option.disabled = true;
				});
				
				const matched_options = participant_picker_select.querySelectorAll(`option[data-profile-id="${selected_profile_id}"]`);

				matched_options.forEach(option => {
					option.disabled = false;
				});

			} else {

				console.warn(`Select element with ID participant_picker_select not found.`);

			}
		})
	})
</script>
	
@endpush
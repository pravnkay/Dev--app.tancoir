@extends('core::layouts.app.index')

@section('main-content')

<div class="row">
	<div class="col w-full">

	<x-core::form action="{{route('app.ramp.registration.store')}}"> 

		<div class="row">

			<div class="col w-full">	
				<div class="row">
					<div class="col w-6/12 content-end">
						{{ Breadcrumbs::render('app.ramp.registration.create') }}
					</div>
					<div class="col w-6/12 flex items-end justify-end">
						<x-core::anchor back /> 
						<x-core::button primary submit class="ms-4 self-end">Create RAMP Registration</x-core::button>
					</div>
				</div>
				<div class="col w-full border-border border-t mt-6"></div>
			</div>

			<div class="col w-full">
				<fieldset class="uk-fieldset space-y-4">
					<div class="row">

						<div class="col w-full mb-4">
							<div class="uk-form-element mt-8">
								<label class="uk-form-label uk-form-label-custom uk-form-label-required" for="event_selector">
									Select a open event
								</label>

								<div class="uk-form-controls">
									<select name="event_id" id="event_selector" class="uk-select" required>
										<option hidden disabled value=""  @selected(old('event_id') === null)> -- Pick one open event -- </option>
										@foreach ($registration_open_event_list as $event)
											<option value="{{$event['id']}}" @selected(old('event_id'))>{{$event['name']}}</option>									
										@endforeach								
									</select>
								</div>
							</div>
						</div>

						<div class="col w-full mb-4">
							<div class="uk-form-element mt-8">
								<label class="uk-form-label uk-form-label-custom uk-form-label-required" for="profile_selector">
									Select a profile
								</label>

								<div class="uk-form-controls">
									<select name="profile_id" id="profile_selector" placeholder="..." class="uk-select @error('profile_id') uk-form-destructive @enderror" label="Select a profile" aria-label="Select a profile" required>
										<option hidden disabled selected value=""> -- Pick one -- </option>
										@foreach ($approved_profile_list as $profile)
											<option value="{{$profile['id']}}">{{$profile['name']}}</option>									
										@endforeach								
									</select>
								</div>

								<x-core::errors name="profile_id"/>
							</div>
						</div>

						<div class="col w-full mb-4">
							<div class="uk-form-element mt-8">
								<label class="uk-form-label uk-form-label-custom uk-form-label-required" for="event_selector">
									Select a participant
								</label>

								<div class="uk-form-controls">
									<select name="participant_id" id="participant_selector" class="uk-select" label="Select a participant" aria-label="Select a profile" required disabled>
										<option hidden disabled selected value=""> -- Pick one after selecting a profile above -- </option>
										@foreach ($participant_list as $participant)
											<option data-profile-id="{{$participant['profile_id']}}" value="{{$participant['id']}}">{{$participant['name']}}</option>									
										@endforeach								
									</select>
								</div>
							</div>
						</div>
						
						{{-- <div class="col w-full xl:w-6/12 mb-4">
							<x-core::input name="name" :100/>
						</div>
						<div class="col w-full xl:w-6/12 mb-4">
							<x-core::select name="gender" :enum="$genders" :100> </x-core::select>
						</div>
						<div class="col w-full mb-4">
							<x-core::input number name="age" :100 />
						</div>
						<div class="col w-full mb-4">
							<x-core::select name="designation" :enum="$designations" :100> </x-core::select>
						</div>
						<div class="col w-full xl:w-1/2 mb-4">
							<x-core::select name="religion" :enum="$religions" :100> </x-core::select>
						</div>
						<div class="col w-full xl:w-1/2 mb-4">
							<x-core::select name="community" :enum="$communities" :100> </x-core::select>
						</div>
						<div class="col w-full mb-4">
							<x-core::input name="whatsapp" :100 />
						</div> --}}
					</div>				
				</fieldset>
			</div>
		
		</div>

	</x-core::form>

	</div>
</div>
	

@endsection

@push('page-scripts')
<script type="text/hyperscript">
	on load from #profile_selector
		call filterParticipants()
	end

	on change from #profile_selector
		call filterParticipants()
	end

	def filterParticipants()
		set profile_selector to #profile_selector
		set participant_selector to #participant_selector
		set selected_profile_id to profile_selector.value
		set first_visible to null
		set participant_options to participant_selector.options
		set placeholder_option to participant_selector.querySelector("option[value='']")

		set participant_selector.value to ''

		if selected_profile_id is ''
			set participant_selector.disabled to true
		else
			set participant_selector.disabled to false
		end

		for participant_option in participant_options
			if participant_option is placeholder_option
				continue
			end

			if participant_option.dataset.profileId is selected_profile_id
				set participant_option.hidden to false
				set participant_option.disabled to false
				if first_visible is null
					set first_visible to participant_option.value
				end			
			else
				set participant_option.hidden to true
				set participant_option.disabled to true
			end
		end
	end
</script>
@endpush



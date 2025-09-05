@extends('core::layouts.backend.index')

@section('main-content')

<div class="uk-container uk-container-lg">

	<div class="row">

		<div class="col w-full">		
			<x-core::form action="{{route('backend.moderation.profile.update', ['profile' => $profile['id']])}}" :model="$profile">
				<div class="row">
					<div class="col w-full">
						<div class="flex justify-between items-center">
							{{ Breadcrumbs::render('backend.moderation.profile.edit', $profile)}}
							<x-core::anchor back />
						</div>
						<div class="border-border border-t my-4"></div>
					</div>			
					<div class="col w-full">
						<fieldset class="uk-fieldset">
							<div class="uk-form-element mt-4">
								<label class="uk-form-label uk-form-label-custom" for="review_remarks">
									Comment
								</label>
								<div class="uk-form-controls">
									<textarea id="review_remarks" name="review_remarks" class="uk-textarea" rows="5" cols="100"></textarea>
								</div>
							</div>				
							<div class="row md:space-0">
								<div class="col w-full md:w-1/2">
									<x-core::select name="status" :enum="$statuses" :100> </x-core::select>
								</div>
								<div class="col w-full md:w-1/2 content-end">
									<x-core::button submit primary>Update Profile</x-core::button>
								</div>
							</div>
						</fieldset>
					</div>
					<div class="border-border border-t my-4"></div>
				</div>
			</x-core::form>
		</div>

		<div class="col-w-full">
			<x-core::form horizontal action="javascript:;" :model="$profile->profile_data" >
				<div class="row my-6">
					<div class="col w-full">
						<x-core::input blank name="name" label="Profile Name" :010 value="{{$profile['name']}}" />
						<div class="row ">
							<div class="col w-full">
								<x-core::input blank name="udyam" label="UDYAM" :010 />
							</div>
							<div class="col w-full">
								<x-core::input blank name="{{$profile->type}}_name" :010 />
							</div>
							<div class="col w-full md:w-1/2">
								<x-core::input blank name="{{$profile->type}}_place" :010 />
							</div>
							<div class="col w-full md:w-1/2">
								<x-core::input blank name="{{$profile->type}}_district" value="{{ucwords($profile->profile_data->{$profile->type->value . '_district'})}}" :010 />
							</div>
							<div class="col w-full md:w-1/2">
								<x-core::input blank name="contact_person_name" :010 />
							</div>
							<div class="col w-full md:w-1/2">
								<x-core::input blank name="contact_email" :010 />
							</div>
							<div class="col w-full md:w-1/2">
								<x-core::input blank name="contact_phone" :010 />
							</div>
							<div class="col w-full md:w-1/2">
								<x-core::input blank name="contact_whatsapp" :010 />
							</div>
						</div>
					</div>	
				</div>
			</x-core::form>
		</div>

	</div>
</div>

@endsection

@push('page-scripts')
	
@endpush
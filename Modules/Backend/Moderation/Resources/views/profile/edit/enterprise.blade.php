@extends('core::layouts.backend.index')

@section('main-content')

<div>
	
	<x-core::form action="{{route('backend.moderation.profile.update', ['profile_type' => $profile_type, 'profile_id' => $profile['id']])}}" :model="$profile">

	<div class="space-y-4 mb-4">
		<div class="flex justify-between items-center">
			{{ Breadcrumbs::render('profile.show', $profile_type, $profile->id)}}
			<div> 
				<x-core::anchor back />
			</div>
		</div>
		<div class="border-border border-t"></div>
	</div>

	<div class="row my-6">
		<div class="col w-full">

			<div class="uk-form-element mt-4">
				<label class="uk-form-label uk-form-label-custom" for="review_remarks">
					Comment
				</label>
				<div class="uk-form-controls">
					<textarea id="review_remarks" name="review_remarks" class="uk-textarea" rows="5" cols="100"></textarea>
				</div>
			</div>
			
			<div class="row space-y-4 md:space-0">
				<div class="col w-full md:w-1/2">
					<x-core::select name="status" :enum="$statuses" :100> </x-core::select>
				</div>
				<div class="col w-full md:w-1/2 content-end">
					<x-core::button submit primary>Update Profile</x-core::button>
				</div>
			</div>

		</div>
	</div>

	<div class="border-border border-t my-4"></div>

	</x-core::form>

	<x-core::form horizontal action="javascript:;" :model="$profile" >
	<div class="row my-6">

		<div class="col w-full">
			<x-core::input blank name="name" label="Profile Name" :010 />
			<div class="row ">
				<div class="col w-full">
					<x-core::input blank name="udyam" label="UDYAM" :010 />
				</div>
				<div class="col w-full">
					<x-core::input blank name="enterprise_name" :010 />
				</div>
				<div class="col w-full md:w-1/2">
					<x-core::input blank name="enterprise_place" :010 />
				</div>
				<div class="col w-full md:w-1/2">
					<x-core::input blank name="enterprise_district" value="{{ucwords($profile->enterprise_district)}}" :010 />
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

@endsection

@push('page-scripts')
	
@endpush
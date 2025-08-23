@extends('core::layouts.registry.index')

@section('main-content')

<x-core::form horizontal action="javascript:;" :model="$profile">
	
<div>

	<div class="space-y-4 mb-4">
		<div class="flex justify-between items-center">
			{{ Breadcrumbs::render('profile.show', $profile_type, $profile->id)}}
			<div> 
				<x-core::back />
				<x-core::anchor primary href="{{route('app.profile.edit', ['profile_id' => $profile['id'], 'profile_type' => $profile_type])}}" icon="pen"> Edit Profile </x-core::anchor>
			</div>
		</div>
		<div class="border-border border-t"></div>
	</div>

	<div class="row my-6">

		<div class="col w-full">
			<x-core::input blank name="name" label="Profile Name" :010 />
			<div class="row ">
				<div class="col w-full">
					<x-core::input blank name="udyam" label="UDYAM" :010 />
				</div>
				<div class="col w-full">
					<x-core::input blank name="society_name" :010 />
				</div>
				<div class="col w-full md:w-1/2">
					<x-core::input blank name="society_place" :010 />
				</div>
				<div class="col w-full md:w-1/2">
					<x-core::input blank name="society_district" value="{{ucwords($profile->society_district)}}" :010 />
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

</div>
	
</x-core::form>


@endsection

@push('page-scripts')
	
@endpush
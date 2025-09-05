@extends('profile::profile.show')

@section('page-content')

<x-core::form horizontal action="javascript:;" :model="$profile->profile_data">
	<div class="row my-6">
		<div class="col w-full">
			<x-core::input blank name="name" label="Profile Name" :010 value="{{$profile->name}}"/>
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
					<x-core::input blank name="society_district" value="{{ucwords($profile_data->society_district)}}" :010 />
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

@endsection

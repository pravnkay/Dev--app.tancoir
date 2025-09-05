@extends('core::layouts.app.index')

@section('main-content')

<x-core::form put action="{{route('app.profile.update', ['profile' => $profile['id']])}}" :model="$profile->profile_data">
	
<div>

	<div class="space-y-4 mb-4">
		<div class="flex justify-between">
			<div class="self-center">
				{{ Breadcrumbs::render('app.profile.edit', $profile)}}
			</div>
			<div class="self-end"> 
				<x-core::anchor back /> 
				<x-core::button primary submit class="self-end">Update Enterprise Profile</x-core::button>
			</div>
		</div>		
		<div class="border-border border-t"></div>
	</div>

	<div class="row my-6">

		<div class="col w-full">
			<x-core::input name="name" label="Profile Name" :110 value="{{$profile['name']}}"/>
			<div class="row ">
				<div class="col w-full">
					<x-core::input name="udyam" label="UDYAM" :100 />
				</div>
				<div class="col w-full">
					<x-core::input name="enterprise_name" :100 />
				</div>
				<div class="col w-full md:w-1/2">
					<x-core::input name="enterprise_place" :100 />
				</div>
				<div class="col w-full md:w-1/2">
					<x-core::select name="enterprise_district" :enum="$districts" :100> </x-core::select>
				</div>
				<div class="col w-full md:w-1/2">
					<x-core::input name="contact_person_name" :100 />
				</div>
				<div class="col w-full md:w-1/2">
					<x-core::input name="contact_email" :100 />
				</div>
				<div class="col w-full md:w-1/2">
					<x-core::input name="contact_phone" :100 />
				</div>
				<div class="col w-full md:w-1/2">
					<x-core::input name="contact_whatsapp" :100 />
				</div>
			</div>

		</div>	
		
	</div>

</div>
	
</x-core::form>


@endsection

@push('page-scripts')
	
@endpush
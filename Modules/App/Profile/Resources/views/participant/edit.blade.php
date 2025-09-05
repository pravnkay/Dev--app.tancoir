@extends('core::layouts.app.index')

@section('main-content')

<div class="row">
	<div class="col w-full">

	<x-core::form put action="{{route('app.participant.update', ['participant' => $participant['id']])}}" :model="$participant"> 

		<div class="row">

			<div class="col w-full">	
				<div class="row">
					<div class="col w-6/12 content-end">
						{{ Breadcrumbs::render('app.participant.edit', $participant) }}
					</div>
					<div class="col w-6/12 flex items-end justify-end">
						<x-core::anchor back /> 
						<x-core::button primary submit class="self-end">Update Participant</x-core::button>
					</div>
				</div>
				<div class="col w-full border-border border-t mt-6"></div>
			</div>

			<div class="col w-full">
				<fieldset class="uk-fieldset space-y-4">
					<div class="row">

						<div class="col w-full mb-4">
							<x-core::select name="profile_id" label="For profile" :options="$active_profiles" :100> </x-core::select>
							<div class="border-border border-t mt-6"></div>
						</div>
						
						<div class="col w-full xl:w-6/12 mb-4">
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
	
@endpush
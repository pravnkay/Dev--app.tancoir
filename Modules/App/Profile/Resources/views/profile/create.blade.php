@extends('core::layouts.app.index')

@section('main-content')

<x-core::form action="{{route('app.profile.store')}}">

	<div class="space-y-4 mb-4">
		<div class="flex justify-between">
			<div class="self-center">
				{{ Breadcrumbs::render('app.profile.create') }}
			</div>
			<div class="self-end"> 
				<a href="{{url()->previous()}}" class="uk-btn uk-btn-default"> 
					<span class="mr-2 size-4"> 
						<uk-icon icon="arrow-left-from-line"></uk-icon>
					</span>
					Back
				</a>				
			</div>
		</div>		
		<div class="border-border border-t"></div>
	</div>

	<div class="row">
		<div class="col w-1/2">

			<h3 class="uk-h4">Create a new profile</h3>
			<div class="border-border border-t my-4"></div>

			<x-core::input name="name" label="Profile Name" :100 />
			<x-core::select name="type" label="Profile Type" :enum="$profile_types" :100> </x-core::select>
			<x-core::button primary submit class="mt-6">Proceed to edit the profile</x-core::button>
		</div>		
	</div>
	
</x-core::form>

@endsection

@push('page-scripts')
	
@endpush
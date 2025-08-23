@extends('core::layouts.registry.index')

@section('main-content')

	<div class="space-y-4 mb-4">
		{{ Breadcrumbs::render('home') }}
		<div class="border-border border-t"></div>
	</div>

	<div class="row">

		@if (!$profiles)
		
			<div class="col w-full mb-4">				
				<p class="uk-paragraph"><strong>You dont have a profile registered.</strong></p>
				<a type="button" href="{{route('app.profile.create')}}" class="uk-btn uk-btn-primary self-end">
					<span class="mr-2 size-4"> 
						<uk-icon icon="plus"></uk-icon>
					</span>
					Create a New Profile				
				</a>
				<div class="border-border border-t my-6"></div>			
			</div>

		@else
		
		@if($user->activeProfile)

			<div class="col w-full mb-4">

				<h5 class="uk-h5 mb-6">Your active profile's mini-profile view.</h5>

				<div class="uk-card max-w-sm">
					<div class="uk-card-header">
						<div class="w-full px-0 flex justify-between items-center">
							<h3 class="uk-card-title">{{$user->activeProfile?->name}}</h3>
							{{-- Logo will come here --}}
							<a href="{{route('app.profile.edit', [
								'profile_type'	=> $user->active_profile_type_string, 
								'profile_id' 	=> $user->active_profile_id
							])}}" class="uk-link uk-btn-sm">
								<uk-icon icon="square-pen"></uk-icon>
							</a>
						</div>
						<div class="w-full px-0 flex justify-between">
							<p class="mt-2 text-muted-foreground">
								Location, District.
							</p>
						</div>
					</div>
					<div class="uk-card-body">
						<p class="mt-4">
							Lorem ipsum <a href="#">dolor</a> sit amet, consectetur adipiscing elit, sed
							do eiusmod tempor incididunt ut labore et dolore magna aliqua.
						</p>
					</div>
					<div class="uk-card-footer ">
						<div class="border-border border-t my-4"></div>
						<div class="w-full">
							Last Updated: <code class="uk-codespan">v2.0.0-internal.45</code>
						</div>
					</div>					
				</div>

				<div class="border-border border-t my-6"></div>			
					
			</div>

		@else

		<div class="col w-full mb-4">				
			<p class="uk-paragraph"><strong>You have profile(s) registered. None of them is active.</strong></p>
			<a type="button" href="{{route('app.profile.index')}}" class="uk-btn uk-btn-primary mt-2 self-end">
				<span class="mr-2 size-4"> 
					<uk-icon icon="eye"></uk-icon>
				</span>
				View them				
			</a>
			<div class="border-border border-t my-6"></div>			
		</div>

		@endif

		@endif

	</div>

@endsection

@push('page-scripts')
	
@endpush
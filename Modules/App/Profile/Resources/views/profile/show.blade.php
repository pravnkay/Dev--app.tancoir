@extends('core::layouts.app.index')

@section('main-content')

	
	<div>

		<div class="space-y-4 mb-4">
			<div class="flex justify-between items-center">
				{{ Breadcrumbs::render('app.profile.show', $profile)}}
				<div> 
					<x-core::anchor back />
					<x-core::anchor primary href="{{route('app.profile.edit', ['profile' => $profile['id']])}}" icon="pen"> Edit Profile </x-core::anchor>
				</div>
			</div>
			<div class="border-border border-t"></div>
		</div>

		<div class="space-y-4 mb-4">

			<div class="uk-alert" data-uk-alert>
				<div class="uk-alert-title">Notice</div>
				@if ($profile->status->value === 'draft')
					<p>Your profile will be <strong>auto-submitted for approval</strong> once all required information is updated. <br> Use the <code class="uk-codespan">Edit Profile</code> button above to update the details.</p>
				@elseif ($profile->status->value === 'submitted')
					<p>Your profile has been submitted for review. <br> Once approved, you can activate your profile.</p>
				@elseif ($profile->status->value === 'returned')
					<p>You profile has been returned with comments. <br> Please, correct them by editing your profile.</p><br><br>
					<p class="text-destructive">{{$profile->review_remarks}}</p>
				@else
					<p>You profile is approved. You can now, activate this profile from main table.</p>
				@endif
			</div>

			<div class="flex justify-between items-center">
				<p class="uk-paragraph">Your profile status: <code class="uk-codespan">{{$profile->status->label()}}</code></p>
			</div>
			<div class="border-border border-t"></div>
		</div>

		@yield('page-content')

	</div>
	

@endsection

@push('page-scripts')
	
@endpush
@extends('auth::layouts.master')

@section('content')

<div class="mb-10 flex justify-center">
	<a href="#">
		<img src="https://pages.franken-ui.dev/logoipsum-284.svg" alt="Acme Inc." data-uk-svg/>
	</a>
</div>

<div class="fr-widget border-border bg-background text-foreground md:border md:p-10">

	<div class="flex flex-col space-y-1.5 mb-4">
		<h1 class="uk-h4">Sign in to your account</h1>
		<p class="text-muted-foreground">
			Enter your credentials below to login to your account.
		</p>
	</div>

	<div class="row">
		<div class="col w-full">
			<form action="{{route('login')}}" method="post">
				@csrf
				<div class="row">
					<div class="col w-full md:w-1/2 mb-4 md:mb-0">
						<uk-select id="user_picker" cls-custom="button: uk-input-fake justify-between w-full; dropdown: w-full" icon>
							<select hidden>
								@foreach ($users as $user)
									<option data-password="{{$user['password']}}" value="{{$user['email']}}">{{$user['email']}}</option>
								@endforeach
							</select>
						</uk-select>
					</div>
					<div class="col w-full md:w-1/2 mb-4 md:mb-0">
						<input id="user_email" name="email" value="" autocomplete="false" hidden>
						<input name="password" value="userpass" hidden>
						<button class="uk-btn uk-btn-default" submit>Login as User</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<x-core::form post action="{{route('login')}}" class="mt-6 space-y-6">
		<x-core::input email name="email" label="E-Mail" :100/>
		<x-core::password remember recover="{{route('password.request')}}" :100/>
		<x-core::button primary submit class="block w-full"> Login </x-core::button>
	</x-core::form>

	<div class="mt-6 text-center">
		Don't have an account? <a class="uk-link" href="{{route('register')}}">Register</a>
	</div>

</div>


@endsection

@push('page-scripts')

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const user_picker = document.getElementById('user_picker')
		const user_email = document.getElementById('user_email')
		
		// Listen for the Franken UI specific event
		user_picker.addEventListener('uk-select:input', function(event) {
			// Update the email input field
			user_email.value = event.detail.value;
			console.log('Email updated to:', event.detail.value);
		})
	})
</script>

@endpush

@extends('auth::layouts.master')

@section('content')

<div class="mb-10 flex justify-center">
	<a href="#">
		<img src="https://pages.franken-ui.dev/logoipsum-284.svg" alt="Acme Inc." data-uk-svg/>
	</a>
</div>

<div class="fr-widget border-border bg-background text-foreground md:border md:p-10">

	<div class="flex flex-col space-y-1.5">
		<h1 class="uk-h4">Welcome!</h1>
		<p class="text-muted-foreground">Please enter your UDYAM No., e-mmail and desired password to begin the registration process. This is a one time process.</p>
		<p class="text-muted-foreground pt-3">Kindly help us serve you better!</p>
	</div>

	<x-core::form action="{{route('register')}}" class="mt-6 space-y-6">

		<x-core::input name="name" :100/>
		<x-core::input name="email" email :100/>
		<x-core::password :100 autocomplete="new-password" />
		<x-core::password name="password_confirmation" label="Confirm Password" :100 />
		<x-core::button primary submit class="block w-full"> Register </x-core::button> 

	</x-core::form>

	<div class="mt-6 text-center">
		Already have an account? <a class="uk-link" href="{{route('login')}}">Log In</a>.
	</div>

</div>

@endsection
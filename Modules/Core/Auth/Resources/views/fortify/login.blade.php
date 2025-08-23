@extends('auth::layouts.master')

@section('content')

<div class="mb-10 flex justify-center">
	<a href="#">
		<img src="https://pages.franken-ui.dev/logoipsum-284.svg" alt="Acme Inc." data-uk-svg/>
	</a>
</div>

<div class="fr-widget border-border bg-background text-foreground md:border md:p-10">

	<div class="flex flex-col space-y-1.5">
		<h1 class="uk-h4">Sign in to your account</h1>
		<p class="text-muted-foreground">
			Enter your credentials below to login to your account.
		</p>
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

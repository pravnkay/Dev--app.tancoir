@extends('auth::layouts.master')

@section('content')

<div class="mb-10 flex justify-center">
	<a href="#">
		<img src="https://pages.franken-ui.dev/logoipsum-284.svg" alt="Acme Inc." data-uk-svg/>
	</a>
</div>

<div class="fr-widget border-border bg-background text-foreground md:border md:p-10">

	<div class="flex flex-col space-y-1.5 text-center">
		<h1 class="uk-h4">Sign in to your account</h1>
		<p class="text-muted-foreground">
			Use the below link to navigate to the login page.
		</p>
	</div>

	<div class="mt-6 text-center">
		<a class="uk-link" href="{{route('login')}}">Login</a>
	</div>
	<div class="mt-6 text-center">
		Don't have an account? <a class="uk-link" href="{{route('register')}}">Register</a>
	</div>

</div>


@endsection

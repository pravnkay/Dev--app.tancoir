@extends('auth::layouts.master')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-md-5 col-xl-4 my-5">

		<h1 class="mb-0 font-weight-bold text-center">
			Password reset
		</h1>

		<p class="mb-4 text-center text-muted">
			Enter your email to recieve a password reset link.
		</p>

		@if(session('status'))
			<div class="alert alert-success" role="alert">
				{{ session('status') }}
			</div>
		@endif

		<x-core::form post route="{{route('password.email')}}">
			<x-core::input email floating :100 name="email" label="E Mail Address" />
			<x-core::button submit class="w-100 mb-4"> Send Password Reset Link </x-core::button>
		</x-core::form>

		<!-- Text -->
		<p class="mb-0 font-size-sm text-center text-muted">
			Remember your password? <a href="{{ route('login') }}">{{ __('Sign in') }}</a>.
		</p>

	</div>
</div>

@endsection
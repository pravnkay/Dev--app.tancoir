@extends('auth::layouts.master')

@section('content')

<div class="row justify-content-center">	
    <div class="col-12 col-md-5 col-xl-4 my-5">

		<h1 class="mb-0 font-weight-bold text-center">
			Enter New Password
		</h1>

		<p class="mb-4 text-center text-muted">
			Use the form below to reset your password.
		</p>

		<x-core::form post route="{{route('password.update')}}">

			<x-core::input name="token" value="{{ $request->route('token') }}" :111 />
			<x-core::input email floating name="email" label="E Mail Address" value="{{ $request->email }}" :110 />
			<x-core::password label="New Password" autocomplete="new-password" :100 />
			<x-core::password name="password_confirmation" label="Confirm New Password" :100 />
			<x-core::button submit class="w-100 mb-4"> Reset Password </x-core::button>

		</x-core::form>

	</div>
</div>

@endsection
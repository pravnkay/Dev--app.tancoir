@extends('auth::layouts.master')

@section('content')

<div class="mb-10 flex justify-center">
	<a href="#">
		<img src="https://pages.franken-ui.dev/logoipsum-284.svg" alt="Acme Inc." data-uk-svg/>
	</a>
</div>

<div class="fr-widget border-border bg-background text-foreground md:border md:p-10 text-center">

	<div class="row">
		<div class="col w-full space-y-1.5">
			<h1 class="uk-h3 mb-3">Welcome {{auth()->user()->name}}!</h1>
			<p class="text-muted-foreground">
				Your account has been created successfully
			</p>
			<p>	You need to verify your email before proceeding !</p>
			<p>	Please click on the link we've sent to your email.</p>
		</div>

		<div class="col w-full space-y-1.5 mt-6">
			<p class="text-muted-foreground">Haven't got the email yet ?</p>
			<p class="text-muted-foreground">Please make sure to check the spam.</p>
		</div>

		<div class="col w-full space-y-3 mt-6">
			<p>
				You can click the below button 
				<span class="timer_text">in </span> 

				<span class="timer timer_text" 
					script="init set timer to 3 then 
							repeat until timer is 0
								set innerText of .timer to timer 
								wait 1s
								decrement timer by 1
							end
							send enable to the next <button/>
							hide .timer_text
					">
				</span> 

				<span class="timer_text">seconds</span> 
				<br> to resend the verification link.
			</p>
		</div>

		<div class="col w-full space-y-3 mt-6">

			<x-core::form action="{{route('verification.send')}}">
				<x-core::button id="submit-button" submit disabled script="on enable remove @disabled on me">
					Resend verification link <br> 
				</x-core::button>
			</x-core::form>

		</div>

		<div class="col w-full space-y-3 mt-6">

			<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="uk-link">Logout</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf
			</form>

		</div>

	</div>

</div>

@endsection

<!DOCTYPE html>
<html lang="en" class="">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="The description of the website">

	<link rel="stylesheet" href="{{asset('assets/css/theme/franken.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/theme/utilities.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/custom/custom.css')}}">

	<script src={{asset("assets/libs/jquery/jquery_v3.7.1.js")}}></script>

	<script src={{asset("assets/libs/hyperscript/hyperscript_v0.9.14.min.js")}}></script>
	

	<script src={{asset("assets/js/theme/core.iife.js")}} type = "module"></script>
	<script src={{asset("assets/js/theme/icon.iife.js")}} type = "module"></script>

	<script>
		const htmlElement = document.documentElement;
	  
		const __FRANKEN__ = JSON.parse(localStorage.getItem("__FRANKEN__") || "{}");
	  
		if (
		  __FRANKEN__.mode === "dark" ||
		  (!__FRANKEN__.mode &&
			window.matchMedia("(prefers-color-scheme: light)").matches)
		) {
		  htmlElement.classList.add("dark");
		} else {
		  htmlElement.classList.remove("dark");
		}
	  
		htmlElement.classList.add(__FRANKEN__.theme || "uk-theme-stone");
		htmlElement.classList.add(__FRANKEN__.radii || "uk-radii-md");
		htmlElement.classList.add(__FRANKEN__.shadows || "uk-shadows-sm");
		htmlElement.classList.add(__FRANKEN__.font || "uk-font-sm");
		htmlElement.classList.add(__FRANKEN__.chart || "uk-chart-default");
	</script>

	<title>Laravel</title>

</head>
<body class="bg-muted font-geist-sans text-foreground antialiased">

	<div class="md:bg-muted flex min-h-svh items-center justify-center p-4 md:p-20">
        <div class="w-full max-w-xl">

			@yield('content')

		</div>			
	</div>

	@if (session('notification.message'))
	<script>
		 window.addEventListener('DOMContentLoaded', () => {			
      		if (typeof UIkit !== 'undefined') {
				UIkit.notification({
					message: {!! json_encode(session('notification.message')) !!},
					@if (session('notification.options'))
					{!! collect(session('notification.options'))->map(function($value, $key) {
						return "$key: " . (is_numeric($value) ? $value : json_encode($value));
					})->implode(",\n") !!}
					@endif
				});
			}
    	});
  	</script>
	@endif		

	@stack('page-scripts')

</body>
</html>

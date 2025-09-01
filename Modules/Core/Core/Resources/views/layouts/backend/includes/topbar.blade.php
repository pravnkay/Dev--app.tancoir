<div class="hidden xl:flex flex h-14 items-center justify-between gap-8 px-4 sm:px-6 ">
	<div class="flex grow justify-start items-center gap-2">

		@foreach ($routes as $route)

			<a type="button" class="uk-btn  {{active([$route['active']], 'uk-btn-primary', 'uk-btn-ghost')}}" href="{{route($route['route'])}}">
				<uk-icon icon="{{$route['icon']}}"></uk-icon>
				{{$route['label']}}
			</a>

		@endforeach

	</div>
</div>
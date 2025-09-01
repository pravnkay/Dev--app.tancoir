<aside class="hidden xl:flex flex-col w-52 overflow-y-auto border-r border-border px-0 py-4">

	@foreach ($routes as $route)
		<div class="grow {{active([$route['active']], 'flex', 'hidden')}}">
			<ul class="uk-nav uk-nav-default grow">

				@foreach ($route['links'] as $link)

					<li class="{{active([$link['active']], 'uk-active', '')}}">
						<a class="px-6 py-2" href="{{route($link['route'])}}">
							<uk-icon class="pe-3" icon="{{$link['icon']}}"></uk-icon>
							{{$link['label']}}
						</a>
					</li>

					@isset($link['hr'])	<li class="uk-nav-divider my-2"></li> @endisset

				@endforeach	

			</ul>
		</div>
	@endforeach

</aside>
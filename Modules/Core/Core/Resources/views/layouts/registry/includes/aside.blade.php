<aside class="px-0 py-4">

	<ul data-uk-nav="multiple: true">

		@foreach ($routes as $route)

			@if ($route['links'])

				<li class="pb-2 uk-parent {{active([$route['active']], 'uk-open', '')}}">

					<a class="pb-3 {{active([$route['active']], 'font-semibold', '')}}" href="#" id="uk-nav-{{$loop->index}}" role="button" aria-controls="uk-nav-{{$loop->iteration}}" aria-expanded="{{active([$route['active']], 'true', 'false')}}" aria-disabled="{{active([$route['active']], 'true', 'false')}}">
						<uk-icon class="pe-3" icon="{{$route['icon']}}"></uk-icon>
						{{$route['label']}}
						<span data-uk-nav-parent-icon></span>
					</a>

					<ul class="uk-nav-sub ms-4 pb-3" hidden="" id="uk-nav-{{$loop->iteration}}" role="region" aria-labelledby="uk-nav-{{$loop->index}}">

						@foreach ($route['links'] as $link)

							<li class="{{active([$link['active']], 'uk-active font-semibold', '')}}" role="presentation"> 
								<a href="{{route($link['route'])}}" class="flex items-center justify-between">
									<span class="ps-3 nav-link-title"> {{$link['label']}} </span>
								</a>
							</li>

						@endforeach
						
					</ul> 
				</li>

			@else

				<li class="pb-2 {{active([$route['active']], 'uk-active', '')}}" role="presentation">
					<a class="flex items-center justify-between" href="{{route($route['route'])}}">
						<uk-icon class="pe-3" icon="{{$route['icon']}}"></uk-icon>
						<span class="flex-1">
							{{$route['label']}}
						</span>
					</a>
				</li>
				
			@endif

		@endforeach

		</ul>

</aside>
<div class="uk-offcanvas" data-uk-offcanvas="overlay: true" id="menu" style="--uk-offcanvas-bar-width: 320px; --uk-offcanvas-bar-width-i: -320px;" tabindex="-1">
	<div class="uk-offcanvas-bar p-4" role="dialog" aria-modal="true" style="">
		
		<div class="mb-4 flex justify-center">
			<button class="uk-btn uk-btn-secondary uk-btn-xs uk-offcanvas-close">
				<uk-icon icon="arrow-left">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=""><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
				</uk-icon>
				<span class="ml-2">Close</span>
			</button>
		</div>

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

	</div>
</div>
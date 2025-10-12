<!DOCTYPE html>
<html lang="en" class="">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="The description of the website">

	<link rel="stylesheet" href="{{asset('assets/css/theme/franken.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/theme/utilities.css')}}">
	
	<link rel="stylesheet" href="{{asset('assets/css/custom/custom.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/custom/tables.css')}}">

	<script src={{asset("assets/libs/jquery/jquery_v3.7.1.js")}}></script>

	<script src={{asset("assets/libs/hyperscript/hyperscript_v0.9.14.min.js")}}></script>

	<script src={{asset("assets/libs/datatables/2.3.2/js/dataTables.js")}}></script>
	<script src={{asset("assets/libs/datatables/2.3.2/js/dataTables.dataTables.js")}}></script>
	<script src={{asset("assets/libs/datatables/buttons/3.2.4/js/dataTables.buttons.js")}}></script>
	<script src={{asset("assets/libs/datatables/buttons/3.2.4/js/buttons.dataTables.js")}}></script>
	<script src={{asset("assets/libs/datatables/responsive/3.0.5/js/dataTables.responsive.js")}}></script>
	<script src={{asset("assets/libs/datatables/responsive/3.0.5/js/responsive.dataTables.js")}}></script>
	<script src={{asset("assets/libs/datatables/select/3.0.1/js/dataTables.select.js")}}></script>
	<script src={{asset("assets/libs/datatables/select/3.0.1/js/select.dataTables.js")}}></script>

	<script src={{asset("vendor/datatables/buttons.server-side.js")}}></script>

	<script src={{asset("assets/js/theme/core.iife.js")}} type = "module"></script>
	<script src={{asset("assets/js/theme/icon.iife.js")}} type = "module"></script>

	<script>
		const htmlElement = document.documentElement;
	  
		const __FRANKEN__ = JSON.parse(localStorage.getItem("__FRANKEN__") || "{}");
	  
		if (__FRANKEN__.mode === "dark" || (!__FRANKEN__.mode && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
		  htmlElement.classList.add("dark");
		} else {
		  htmlElement.classList.remove("dark");
		}
	  
		htmlElement.classList.add(__FRANKEN__.theme || "uk-theme-neutral");
		htmlElement.classList.add(__FRANKEN__.radii || "uk-radii-none");
		htmlElement.classList.add(__FRANKEN__.shadows || "uk-shadows-sm");
		htmlElement.classList.add(__FRANKEN__.font || "uk-font-sm");
		htmlElement.classList.add(__FRANKEN__.chart || "uk-chart-default");

	</script>

	<title>Laravel</title>

</head>
<body class="bg-background text-foreground font-geist-sans antialiased h-screen overflow-hidden">

	@php
		$routes = [

			"Home" => [
				'label'		=> 'Home',
				'active'	=> 'app.index',
				'route'		=> 'app.index',
				'icon'		=> 'home',
				'links'		=> [
					
				]
			],

			"Profile" => [
				'label'		=> 'Profiles',
				'active'	=> 'app.profile.*',
				'route'		=> 'app.profile.index',
				'icon'		=> 'user-round-pen',
				'links'		=> [
					
				]
			],

			"Participant" => [
				'label'		=> 'Participants',
				'active'	=> 'app.participant.*',
				'route'		=> 'app.participant.index',
				'icon'		=> 'users',
				'links'		=> [
					
				]
			],

			"RAMP Mgmt." => [
				'label'		=> 'RAMP',
				'active'	=> 'app.ramp.registration.*',
				'route'		=> 'app.ramp.registration.index',
				'icon'		=> 'command',
				'links'		=> [

				]
			],

		];
	@endphp

	<div class="uk-container border-border border-b fixed w-full inset-x-0 top-0 z-10 px-0 ">
		<div class="flex justify-center bg-background text-foreground">
			@include('core::layouts.app.includes.header')
		</div>
	</div>

	<main class="flex absolute bottom-0 inset-x-0 top-14 xl:top-14 border-border border-t">

		<div class="uk-container px-0 w-full flex flex-row">

		<section class="hidden xl:block w-52 overflow-y-auto border-r border-border p-4">
			@include('core::layouts.app.includes.aside')
		</section>

		<section class="flex-1 overflow-y-auto p-4">
			@yield('main-content')
		</section>

		</div>
		
	</main>

	@include('core::layouts.app.includes.offcanvas')	

	<div id="delete-confirm-modal" uk-modal>
		<div class="uk-modal-dialog uk-modal-body">
		  	<h2 class="uk-modal-title" id="modal-title">Are you sure?</h2>
			<p class="mb-4" id="modal-text">This action cannot be reversed.</p>
			<div class="uk-text-right">
				<button class="uk-btn uk-btn-ghost uk-modal-close" type="button" id="modal-cancel-btn">Cancel</button>
				<button class="uk-btn uk-btn-destructive" type="button" id="modal-confirm-btn">Yes, Delete!</button>
			</div>
		</div>
	</div>
	
	<script>
		$.extend (DataTable.ext.classes, {
			empty: {
				row: 'dt-empty text-center'
			},
			length: {
				container: 'dt-length grid grid-cols-2 gap-3 items-center',
				select: 'uk-select uk-form-sm'
			},
			paging: {
				active: 'uk-active',
				button: 'uk-btn uk-btn-default uk-btn-sm',
				container: 'dt-paging',
				disabled: 'uk-disabled',
				nav: 'flex'
			},
			container: 'dt-container uk-overflow-auto',
			table: 'uk-table uk-table-xs uk-table-divider dataTable',
			thead: {
				cell: 'font-semibold',
				row: 'bg-secondary'
			},
			tbody: {
				cell: 'content-center',
				row: ''
			},

			
		})
	</script>

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

	<script>
		document.addEventListener('DOMContentLoaded', function () {

			window.currentForm = null;
			
			document.body.addEventListener('click', function (e) {
				const button = e.target.closest('.delete-item-button');
			
				if (!button) return; // clicked element isn't a delete button
				e.preventDefault();
			
				window.currentForm = button.closest('form');
			
				// Load data attributes
				const title = button.dataset.title || 'Are you sure?';
				const text = button.dataset.text || 'This action cannot be reversed!';
				const confirmText = button.dataset.confirm_button || 'Yes, Delete!';
				const cancelText = button.dataset.cancel_button || 'Cancel';
			
				// Fill modal content
				document.getElementById('modal-title').innerText = title;
				document.getElementById('modal-text').innerText = text;
				document.getElementById('modal-confirm-btn').innerText = confirmText;
				document.getElementById('modal-cancel-btn').innerText = cancelText;
			
				// Show modal
				UIkit.modal('#delete-confirm-modal').show();
			});

			window.open_bulk_delete_confirm = function (dt, formSelector = '#bulk-delete-form') {

				const form = document.querySelector(formSelector);
				if (!form) return;

				// count checked on CURRENT page
				const count = $(dt.rows({ page: 'current' }).nodes())
				.find("input[name='ids[]']:checked").length;

				if (!count) {
					if (window.UIkit?.notification) {
						UIkit.notification({ message: '<uk-icon icon=\"triangle-alert\" class=\"content-center mr-2\"></uk-icon> Select at least one row.'});
					} else {
						alert('Select at least one row.');
					}
					return;
				}

				window.currentForm = form;

				// customize modal content for bulk
				document.getElementById('modal-title').innerText = `Delete ${count} record(s)?`;
				document.getElementById('modal-text').innerText  = 'This action cannot be reversed.';
				document.getElementById('modal-confirm-btn').innerText = 'Yes, Delete!';
				document.getElementById('modal-cancel-btn').innerText  = 'Cancel';

				UIkit.modal('#delete-confirm-modal').show();
			};
			
			// Modal confirm button: submit the form
			document.getElementById('modal-confirm-btn').addEventListener('click', function () {
				if (currentForm) {
					window.currentForm.requestSubmit();
					window.currentForm = null;
				}
			});

		});
	</script>		

	@stack('page-scripts')

</body>
</html>

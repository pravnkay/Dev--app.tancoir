<?php

namespace Modules\Backend\RAMPManagement\DataTables;

use Illuminate\Support\Str;
use Modules\Backend\RAMPManagement\Entities\Registration;
use Yajra\DataTables\Services\DataTable;

class RegistrationsDatatable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

			->addColumn('selector', function ($registration) {
                return '<input form="bulk-delete-form" type="checkbox" class="row-select uk-checkbox" name="ids[]" value="'.$registration->id.'">';
            })

			->addColumn('user', function ($registration) {
                return $registration->user->name;
            })

			->addColumn('event', function ($registration) {
                return $registration->event->name;
            })

			->addColumn('profile', function ($registration) {
                return $registration->profile->name;
            })

			->addColumn('participant', function ($registration) {
                return $registration->participant->name;
            })

			// ->addColumn('enterprise_name', function ($registration) {
            //     return Str::of($registration->registration_data['நிறுவனத்தின் பெயர் / Company Name'])->replace('.', ' ')->upper()->squish()->toString();
            // })

			// ->addColumn('place', function ($registration) {
            //     return Str::of($registration->registration_data['ஊர் / Place'])->replace('.', ' ')->squish()->title()->toString();
            // })

			// ->addColumn('district', function ($registration) {
            //     return Str::of($registration->registration_data['மாவட்டம் / District'])->before('/')->lower()->replaceMatches('/[^a-z]+/u', ' ')->squish()->replace(' ', '_')->title()->toString();
            // })

			// ->addColumn('eligible', function ($registration) {

			// 	$text = $registration->is_eligible_to_participate ? "" : "text-destructive";
            //     $icon = $registration->is_eligible_to_participate ? "check-check" : "x";

			// 	return '<uk-icon class="flex justify-center '.$text.'" icon="'.$icon.'"></uk-icon>';

            // })

			->addColumn('approved', function ($registration) {

				$text = $registration->is_approved_to_participate ? "" : "text-destructive";
                $icon = $registration->is_approved_to_participate ? "check-check" : "x";

				return 
				'<form action="'.route('backend.rampmanagement.registrations.toggle_approved_to_participate', ['registration' => $registration->id]).'" method="POST" class="d-inline">
					'.csrf_field().'
					<button type="submit">
						<uk-icon class="flex justify-center '.$text.'" icon="'.$icon.'"></uk-icon>
					</button>
				</form>';

            })

			->addColumn('action', function ($registration) {
				return view('core::components.datatable.action_column')->with([
					'delete' 	=> route('backend.rampmanagement.registrations.destroy', 	["registration" 	=> $registration->id]),
				])->render();	
			})

			->rawColumns(['selector', 'action', 'eligible', 'approved']);
    }

    public function query()
    {
		$filtered_event = $this->filtered_event;
		$registration = Registration::with(['user', 'event', 'profile', 'participant']);

		if ($filtered_event) {
			$registration->where('event_id', $filtered_event->id);
		}

		return $this->applyScopes($registration);
    }

    public function html()
    {
		$table_id  = 'registrations-table';
		$importer_route = $this->filtered_event ? route('backend.rampmanagement.registrations.upload', ['filtered_event' => $this->filtered_event->id]) : 'javascript:;';

        return $this->builder()
                    ->columns($this->getColumns())
					->responsive(true)
					->autoWidth(false)
					->stateSave(true)
					
					->setTableId($table_id)
					
					->orderBy(1, 'desc')
					
					->parameters([          
						'searchDelay' => 1000,
						'pageLength' => 10,
						'initComplete' => "						
						
						function (master, json) {

							var tableId  = '#{$table_id}';

							this.api().columns().every(function (index) {

								var r = $('tfoot tr');
								$('thead').append(r);

								var column = this;
								var colDef = master['aoColumns'][index];

								var input = document.createElement(\"input\")
								input.className = 'uk-input uk-form-sm'

								if(colDef.searchable){

									$(input).appendTo($(column.footer()).empty())
									.on('click', function (e) {
										e.stopPropagation()
									})
									.on('change', function () {
										column.search($(this).val(), false, false, true).draw();
									});

								}
								
							});

							$(document).on('change', '#select-all', function () {
								var on = this.checked;
								$(tableId + ' tbody input[name=\"ids[]\"]').each(function () {
									this.checked = on;
									$(this).closest('tr').toggleClass('selected', on);
								});
							});
					  
							$(document).on('change', tableId + ' tbody input[name=\"ids[]\"]', function () {
								$(this).closest('tr').toggleClass('selected', this.checked);
								if (!this.checked) $('#select-all').prop('checked', false);
							});

						}",

						'drawCallback' => "function (master) {
							
						}",

						'buttons' => [
							'dom' => [
								'button' => [
									'className' => ''
								],
							],
							'buttons' => [								
								[
									'text' => 'Import',
									'className'=>'uk-btn uk-btn-default',
									'action' => "function (e, dt, node, config) {
										window.location.href = '{$importer_route}';
									}",
								],
								[
									'text'      => 'Bulk Delete',
									'className' => 'uk-btn uk-btn-default',
									'action' => 'function (e, dt, node, config, cb) {
										e.stopPropagation();
      									window.open_bulk_delete_confirm(dt, "#bulk-delete-form");
									}'
								],
								[
									'extend'=>'reset',
									'className'=>'uk-btn uk-btn-default'
								],
							],
						],
					])

					->language([
						config('app.locale') === "ta" ? json_decode(file_get_contents(module_path('Core', 'Resources/lang/datatables/'.config('app.locale').'.json')), TRUE) : [],
						'paginate' => [
							'next' => '<uk-icon icon="chevron-right"></uk-icon>',
							'previous' => '<uk-icon icon="chevron-left"></uk-icon>',
							'first' => '<uk-icon icon="chevrons-left"></uk-icon>',
							'last' => '<uk-icon icon="chevrons-right"></uk-icon>'
						]
					])

					->layout([
						'topStart' => [
							'rowClass' => 'grid lg:grid-cols-2 gap-4 mb-8 items-center',
							'className' => 'justify-self-center mb-4 lg:mb-0 lg:justify-self-start font-light',
							'features' => [
								'info'
							]
						],
						'topEnd' => [
							'rowClass' => '',
							'className' => 'justify-self-center lg:justify-self-end',
							'features' => [
								'buttons'
							]
						],
						'bottomStart' => [
							'rowClass' => 'grid lg:grid-cols-2 gap-4 mt-8 items-center',
							'className' => 'justify-self-center mb-4 lg:mb-0 lg:justify-self-start',
							'features' => [
								'pageLength' => [
									'menu' => [5, 10, 20, -1],
								]
							]
						],
						'bottomEnd' => [
							'className' => 'justify-self-center lg:justify-self-end',
							'features' => [
								'paging'
							]
						],
					]);
    }

    protected function getColumns()
    {
		return [
			[
				'title'          => '<input id="select-all" class="uk-checkbox" type="checkbox"/>',
				'data'           => 'selector',
				'orderable'      => false,
				'searchable'     => false,
				'exportable'     => false,
				'printable'      => true,
				'width'          => '10px',
			],
			[
				"title"					=> __('UA'),
				"data"					=> "updated_at",
				"visible"				=> false,
				"orderable"				=> true,
			],
            [
				"title"					=> __('S.No'),
				"data"					=> "DT_RowIndex",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
				"width"					=> "25"
			],
			[
				"title"					=> __('User'),
				"data"					=> "user",
				"responsivePriority"	=> "1",
				"orderable"				=> true,
				"searchable"			=> true,
			],
			[
				"title"					=> __('Event'),
				"data"					=> "event",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
			],
			[
				"title"					=> __('Profile'),
				"data"					=> "profile",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
			],
			[
				"title"					=> __('Participant'),
				"data"					=> "participant",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
			],
            [
				"title"					=> __('Participation Approved?'),
				"data"					=> "approved",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
				"width"					=> "100",
			],
			[
				"title"					=> __('Action'),
				"data"					=> "action",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
				"exportable"			=> false,
				"printable"				=> false,
				"width"					=> "100",
				"class"					=> "flex gap-x-1",
			],
        ];
    }
}

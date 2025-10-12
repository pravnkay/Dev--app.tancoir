<?php

namespace Modules\Backend\RAMPManagement\DataTables;

use Illuminate\Support\Str;
use Modules\Backend\RAMPManagement\Entities\Participation;
use Yajra\DataTables\Services\DataTable;

class ParticipationsDatatable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

			->addColumn('selector', function ($participation) {
                return '<input form="bulk-delete-form" type="checkbox" class="row-select uk-checkbox" name="ids[]" value="'.$participation->id.'">';
            })

			->addColumn('user', function ($participation) {
                return $participation->registration->user->name;
            })

			->filterColumn('user', function ($query, $keyword) {
				$query->whereHas('registration.user', function ($userQuery) use ($keyword) {
					$userQuery->where('name', 'like', "%{$keyword}%");
				});
			})

			->addColumn('event', function ($participation) {
                return $participation->registration->event->name;
            })

			->addColumn('profile', function ($participation) {
                return $participation->registration->profile->name;
            })

			->addColumn('participant', function ($participation) {
                return $participation->registration->participant->name;
            })

			->addColumn('action', function ($participation) {
				return '<uk-icon class="flex justify-center my-2" icon="info" data-uk-tooltip="Edit/Delete through registrations"></uk-icon>';	
			})

			->rawColumns(['selector', 'action', 'eligible', 'approved']);
    }

    public function query()
    {
		$filtered_event = $this->filtered_event;
		$participation = Participation::with(['registration', 'registration.event']);

		if ($filtered_event) {
			$participation->whereHas('registration', function ($query) use ($filtered_event) {
				$query->where('event_id', $filtered_event->id);
			})->get();
		}

		return $this->applyScopes($participation);
    }

    public function html()
    {
		$table_id  = 'participations-table';

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
				"title"					=> __('Action'),
				"data"					=> "action",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
				"exportable"			=> false,
				"printable"				=> false,
				"width"					=> "100",
				"className"				=> "text-center",
			],
        ];
    }
}

<?php

namespace Modules\Backend\RAMPManagement\DataTables;

use Modules\Backend\RAMPManagement\Entities\EventRegistration;
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

			->addColumn('event', function ($registration) {
                return $registration->event->name;
            })

			->addColumn('action', function ($registration) {
				return view('core::components.datatable.action_column')->with([
					// 'edit' 		=> route('backend.rampmanagement.registrations.edit', 		["registration"	=> $registration->id]),
					// 'delete' 	=> route('backend.rampmanagement.registrations.destroy', 	["registration" 	=> $registration->id]),
				])->render();
	
			})

			->rawColumns(['selector', 'action']);
    }

    public function query()
    {
		$registration = EventRegistration::select();
		return $this->applyScopes($registration);
    }

    public function html()
    {
		$table_id  = 'registrations-table';
		$importer_route = route('backend.bulk.import.create', ['model' => 'registrations']);

        return $this->builder()
                    ->columns($this->getColumns())
					->responsive(true)
					->autoWidth(false)
					->stateSave(true)
					
					->setTableId($table_id)
					
					->orderBy(1, 'asc')
					
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
				"title"					=> __('Event'),
				"data"					=> "event",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
			],
			[
				"title"					=> __('Ent. Name'),
				"data"					=> "registration_data.நிறுவனத்தின் பெயர் / Company Name",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
			],
            [
				"title"					=> __('UDYAM'),
				"data"					=> "registration_data.உதயம் எண் / UDYAM No. (Format: UDYAM-TN-00-0000000)",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
			],
            [
				"title"					=> __('Place'),
				"data"					=> "registration_data.ஊர் / Place",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
			],
            [
				"title"					=> __('District'),
				"data"					=> "registration_data.மாவட்டம் / District",
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
				"class"					=> "flex gap-x-1",
			],
        ];
    }
}

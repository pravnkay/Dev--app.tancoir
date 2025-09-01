<?php

namespace Modules\Backend\RAMPManagement\DataTables;

use Modules\Backend\RAMPManagement\Entities\Vertical;
use Yajra\DataTables\Services\DataTable;

class VerticalsDatatable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

			->addColumn('selector', function ($vertical) {
                return '<input form="bulk-delete-form" type="checkbox" class="row-select uk-checkbox" name="ids[]" value="'.$vertical->id.'">';
            })

			->addColumn('action', function ($vertical) {
				return view('core::components.datatable.action_column')->with([
					'edit' => route('backend.rampmanagement.verticals.edit', ["vertical" => $vertical->id]),
					'delete' => route('backend.rampmanagement.verticals.destroy', ["vertical" => $vertical->id]),
				])->render();
	
			})

			->rawColumns(['selector','action']);
    }

    public function query()
    {
		$vertical = Vertical::select();
		return $this->applyScopes($vertical);
    }

    public function html()
    {
		$table_id  = 'verticals-table';
		$importer_route = route('backend.bulk.import.create', ['model' =>'verticals']);

        return $this->builder()
                    ->columns($this->getColumns())
					->responsive(true)
					->autoWidth(false)
					->stateSave(true)
					
					->setTableId($table_id)
					
					->orderBy(2, 'asc')
					
					->parameters([          
						'searchDelay' => 1000,
						'initComplete' => "						
						
						function (enterprise, json) {

							var tableId  = '#{$table_id}';

							this.api().columns().every(function (index) {

								var r = $('tfoot tr');
								$('thead').append(r);

								var column = this;
								var colDef = enterprise['aoColumns'][index];

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

						'drawCallback' => "function (enterprise) {
							
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
							'className' => 'mb-4 lg:mb-0 justify-self-start font-light',
							'features' => [
								'info'
							]
						],
						'topEnd' => [
							'rowClass' => '',
							'className' => 'justify-self-end',
							'features' => [
								'buttons'
							]
						],
						'bottomStart' => [
							'rowClass' => 'grid lg:grid-cols-2 gap-4 mt-8 items-center',
							'className' => 'justify-self-center mb-4 lg:mb-0 lg:justify-self-start',
							'features' => [
								'pageLength' => [
									'menu' => [5, 10, 25],
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
				"title"					=> __('S.No'),
				"data"					=> "DT_RowIndex",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
				"width"					=> "25"
			],
			[
				"title"					=> __('Name'),
				"data"					=> "name",
				"responsivePriority"	=> "1",
				"orderable"				=> true,
				"searchable"			=> true,
			],
			[
				"title"					=> __('Allocated Funds'),
				"data"					=> "allocated_funds",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
			],
			[
				"title"					=> __('Utilised Funds'),
				"data"					=> "utilised_funds",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> false,
			],
			[
				"title"					=> __('Remaining Funds'),
				"data"					=> "remaining_funds",
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

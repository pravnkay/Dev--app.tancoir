<?php

namespace Modules\Backend\RAMPManagement\DataTables;

use Modules\Backend\RAMPManagement\Entities\Programme;
use Modules\Backend\RAMPManagement\Entities\Vertical;
use Modules\Core\Core\Enums\ProgrammeSchemeEnum;
use Yajra\DataTables\Services\DataTable;

class ProgrammesDatatable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

			->addColumn('selector', function ($programme) {
                return '<input form="bulk-delete-form" type="checkbox" class="row-select uk-checkbox" name="ids[]" value="'.$programme->id.'">';
            })

			->addColumn('scheme', function ($programme) {
                return $programme->scheme->label();
            })

			->filterColumn('scheme', fn($query, $keyword) => $query->where('scheme', '=', "$keyword"))

			->addColumn('action', function ($programme) {
				return view('core::components.datatable.action_column')->with([
					'edit'		=> route('backend.rampmanagement.programmes.edit', 		["programme"	=> $programme->id]),
					'delete'	=> route('backend.rampmanagement.programmes.destroy', 	["programme"	=> $programme->id]),
				])->render();	
			})

			->rawColumns(['selector','action']);
    }

    public function query()
    {
		$programme = Programme::select()->with([
			'vertical'
		]);
		return $this->applyScopes($programme);
    }

    public function html()
    {
		$table_id  = 'programmes-table';
		$importer_route = route('backend.bulk.import.create', ['model' =>'programmes']);

		$schemes = ProgrammeSchemeEnum::asArray();
		$schemes_selector = view('core::components.datatable.select_filter', ['options' => $schemes])->render();

		$verticals = Vertical::query()->orderBy('name')->pluck('name', 'id')->all();
		$verticals_selector = view('core::components.datatable.select_filter', ['options' => $verticals])->render();
		
        return $this->builder()
                    ->columns($this->getColumns())
					->responsive(true)
					->autoWidth(false)
					->stateSave(true)
					
					->setTableId($table_id)
					
					->orderBy(3, 'asc')
					
					->parameters([          
						'searchDelay' => 1000,
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
										column.search($(this).val()).draw();
									});

									if(colDef.data === 'scheme') {

										var select = `".$schemes_selector."`

										$(select).appendTo($(column.footer()).empty())
										.on('change', function () {
											column.search($(this).val()).draw()
										})

									}

									if(colDef.data === 'vertical.name') {

										var select = `".$verticals_selector."`

										$(select).appendTo($(column.footer()).empty())
										.on('change', function () {
											column.search($(this).val()).draw()
										})

									}

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
									'menu' => [1, 2, 5, 10, 25, 50],
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
				"title"					=> __('Scheme'),
				"data"					=> "scheme",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> true,
			],
			[
				"title"					=> __('Vertical'),
				"data"					=> "vertical.name",
				"responsivePriority"	=> "1",
				"orderable"				=> false,
				"searchable"			=> true,
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

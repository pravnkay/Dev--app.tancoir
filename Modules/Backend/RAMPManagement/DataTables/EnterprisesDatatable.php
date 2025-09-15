<?php

namespace Modules\Backend\RAMPManagement\DataTables;

use Modules\Backend\RAMPManagement\Entities\Enterprise;
use Modules\Core\Core\Enums\DistrictEnum;
use Yajra\DataTables\Services\DataTable;

class EnterprisesDatatable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

			->addColumn('selector', function ($enterprise) {
                return '<input form="bulk-delete-form" type="checkbox" class="row-select uk-checkbox" name="ids[]" value="'.$enterprise->id.'">';
            })	

			->addColumn('district', function ($msme) {
                return $msme->district->label();
            })

			->filterColumn('district', fn($query, $keyword) => $query->where('district', '=', "$keyword"))
			
			->addColumn('is_valid', function ($enterprise) {
                $text = $enterprise->is_a_valid_enterprise ? "" : "text-destructive";				
                $icon = $enterprise->is_a_valid_enterprise ? "check-check" : "x";
				return 
				'<form action="'.route('backend.rampmanagement.enterprises.toggle_valid_status', ['enterprise' => $enterprise->id]).'" method="POST" class="d-inline">
					'.csrf_field().'
					<button type="submit">
						<uk-icon class="flex justify-center '.$text.'" icon="'.$icon.'"></uk-icon>
					</button>
				</form>';
            })

			->filterColumn('is_valid', function ($query, $keyword) {
				$keyword = $keyword == 'Valid' ? 1 : 0;
				return  $query->where('is_a_valid_enterprise', '=', "$keyword");
			})

			->addColumn('action', function ($enterprise) {
				return view('core::components.datatable.action_column')->with([
					// 'edit' 		=> route('backend.rampmanagement.enterprises.edit', 		["enterprise"	=> $enterprise->id]),
					'delete' 	=> route('backend.rampmanagement.enterprises.destroy', 	["enterprise" 	=> $enterprise->id]),
				])->render();
	
			})

			->rawColumns(['selector', 'is_valid', 'action']);
    }

    public function query()
    {
		$enterprise = Enterprise::select();
		return $this->applyScopes($enterprise);
    }

    public function html()
    {
		$table_id  = 'enterprises-table';
		$importer_route = route('backend.bulk.import.create', ['model' => 'enterprises']);

		$is_valid = [0 => 'Not Valid', 1 => 'Valid'];
		$valid_selector = view('core::components.datatable.select_filter', ['options' => $is_valid])->render();

		$districts = DistrictEnum::asArray();
		$districts_selector = view('core::components.datatable.select_filter', ['options' => $districts])->render();

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

									if(colDef.data === 'is_valid') {

										var select = `".$valid_selector."`

										$(select).appendTo($(column.footer()).empty())
										.on('click', function (e) {
											e.stopPropagation()
										})
										.on('change', function () {
											column.search($(this).val()).draw()
										})

									}

									if(colDef.data === 'district') {

										var select = `".$districts_selector."`

										$(select).appendTo($(column.footer()).empty())
										.on('click', function (e) {
											e.stopPropagation()
										})
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
				"title"					=> __('Name'),
				"data"					=> "name",
				"responsivePriority"	=> "1",
				"orderable"				=> true,
				"searchable"			=> true,
			],
			[
				"title"					=> __('UDYAM'),
				"data"					=> "udyam",
				"responsivePriority"	=> "1",
				"orderable"				=> true,
				"searchable"			=> true,
			],
			[
				"title"					=> __('Ent. District'),
				"data"					=> "district",
				"responsivePriority"	=> "1",
				"orderable"				=> true,
				"searchable"			=> true,
			],
			[
				"title"					=> __('Contact Name'),
				"data"					=> "contact_name",
				"responsivePriority"	=> "1",
				"orderable"				=> true,
				"searchable"			=> true,
			],
			[
				"title"					=> __('Contact Email'),
				"data"					=> "contact_email",
				"responsivePriority"	=> "1",
				"orderable"				=> true,
				"searchable"			=> true,
			],
			[
				"title"					=> __('Valid'),
				"data"					=> "is_valid",
				"responsivePriority"	=> "1",
				"orderable"				=> true,
				"searchable"			=> true,
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

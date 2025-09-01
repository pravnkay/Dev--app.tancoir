<?php

namespace Modules\Backend\Moderation\DataTables;

use Modules\Core\Core\Enums\ProfileTypeEnum;
use Modules\Registry\Profile\Entities\AssociationProfile;
use Modules\Registry\Profile\Entities\ClusterProfile;
use Modules\Registry\Profile\Entities\EnterpriseProfile;
use Modules\Registry\Profile\Entities\SocietyProfile;
use Yajra\DataTables\Services\DataTable;

class ProfilesDatatable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->of($query)
            ->addIndexColumn()	

			->addColumn('type', function($profile) {
				return $profile->profile_type_enum->label();
			})		

			->addColumn('status', function($profile) {
				return "<span class='uk-badge uk-badge-secondary'>{$profile->status->label()}</span>";
			})			

			->addColumn('action', function ($profile) {
				return view('core::components.datatable.action_column')->with([
					'show'=> route('backend.moderation.profile.edit', [
						'profile_type'	=> $profile->profile_type_enum, 
						'profile_id' 	=> $profile->id
					]),					
				])->render();	
			})
			
			->rawColumns(['status', 'action']);
    }

    public function query()
    {
		$status = 'submitted'; // or ProfileStatusEnum::SUBMITTED->value

		// Get all profiles of each type with the specified status and assign profile type
		$enterpriseProfiles = EnterpriseProfile::where('status', $status)
		->with('user')
		->get()
		->each(function ($profile) {
			$profile->profile_type_enum = ProfileTypeEnum::ENTERPRISE;
			return $profile;
		});

		$clusterProfiles = ClusterProfile::where('status', $status)
		->with('user')
		->get()
		->each(function ($profile) {
			$profile->profile_type_enum = ProfileTypeEnum::CLUSTER;
			return $profile;
		});

		$societyProfiles = SocietyProfile::where('status', $status)
		->with('user')
		->get()
		->each(function ($profile) {
			$profile->profile_type_enum = ProfileTypeEnum::SOCIETY;
			return $profile;
		});

		$associationProfiles = AssociationProfile::where('status', $status)
		->with('user')
		->get()
		->each(function ($profile) {
			$profile->profile_type_enum = ProfileTypeEnum::ASSOCIATION;
			return $profile;
		});

		// Combine all profiles into a single collection
		$allSubmittedProfiles = $enterpriseProfiles
			->concat($clusterProfiles)
			->concat($societyProfiles)
			->concat($associationProfiles);


		clock($allSubmittedProfiles);

		return $allSubmittedProfiles;
    }

    public function html()
    {
		$table_id  = 'profiles-table';

        return $this->builder()
                    ->columns($this->getColumns())
					->responsive(true)
					->autoWidth(false)
					->stateSave(true)
					->setTableId($table_id)
					
					->orderBy(2, 'asc')
					
					->parameters([          
						'searchDelay' => 1000,
						'pageLength' => 5,
						'initComplete' => "						
						
						function (profile, json) {

							var tableId  = '#{$table_id}';

							this.api().columns().every(function (index) {

								var r = $('tfoot tr');
								$('thead').append(r);

								var column = this;
								var colDef = profile['aoColumns'][index];

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

						'drawCallback' => "function (profile) {
							
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
									'menu' => [1, 2, 5],
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
				"title"					=> __('Type'),
				"data"					=> "type",
				"responsivePriority"	=> "1",
				"orderable"				=> true,
				"searchable"			=> true,
			],
			[
				"title"					=> __('Status'),
				"data"					=> "status",
				"responsivePriority"	=> "1",
				"orderable"				=> true,
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

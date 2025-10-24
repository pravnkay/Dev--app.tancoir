@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.moderation.profile'))

@section('main-content')

<div class="row">


	<div class="col w-full md:w-2/4">
		<select id="profile-status-picker" name="profile-status" class="uk-select" _="on change set type_value to #profile-type-picker.value then go to url `{{route('backend.moderation.profile.index')}}/${me.value}/${type_value}`">
			<option value="all">All Profile Statuses</option>
			@foreach ($all_profile_statuses as $key => $value)
				<option value="{{$key}}" @selected($filtered_profile_status ? $key === $filtered_profile_status : false) : >{{$value}}</option>
			@endforeach
		</select>
	</div>

	<div class="col w-full md:w-2/4">
		<select id="profile-type-picker" name="profile-type" class="uk-select" _="on change set status_value to #profile-status-picker.value then go to url `{{route('backend.moderation.profile.index')}}/${status_value}/${me.value}`">
			<option value="all">All Profile Types</option>
			@foreach ($all_profile_types as $key => $value)
				<option value="{{$key}}" @selected($filtered_profile_type ? $key === $filtered_profile_type : false) : >{{$value}}</option>
			@endforeach
		</select>
	</div>

	<div class="col w-full border-border border-t mt-6 mb-6"></div>

</div>

	<div class="row">
		<div class="col w-full">
			<h4 class="uk-h4 mb-6">List of submitted profiles</h4>
			{!! $dataTable->table([], true) !!}
		</div>
	</div>

@endsection

@push('page-scripts')

{!! $dataTable->scripts() !!}

@endpush

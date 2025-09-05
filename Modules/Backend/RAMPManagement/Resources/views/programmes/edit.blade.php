@extends('core::layouts.backend.index')

@section('main-content')

<div class="uk-container uk-container-lg">

	<x-core::form put action="{{route('backend.rampmanagement.programmes.update', ['programme' => $programme['id']])}}" :model="$programme"> 

		<div class="row">
			<div class="col w-full">	
				<div class="row">
					<div class="col w-6/12 content-end">
						{{ Breadcrumbs::render('backend.rampmanagement.programmes.edit', $programme)}}				
					</div>
					<div class="col w-6/12 flex items-end justify-end">
						<button type="submit" class="uk-btn uk-btn-primary">{{__('Update Programme')}}</button>
					</div>
				</div>
			</div>
			<div class="col w-full border-border border-t my-6"></div>
		</div>

		<fieldset class="uk-fieldset space-y-4">
			<div class="row">
				<div class="col w-full xl:w-6/12 mb-4">
					<x-core::input name="name" :100/>
				</div>
				<div class="col w-full xl:w-6/12 mb-4">
					<x-core::select name="scheme" :enum="$schemes" :100> </x-core::select>
				</div>
			</div>
			<div class="row">
				<div class="col w-full">
					<x-core::select name="vertical_id" :options="$verticals" :100> </x-core::select>
				</div>
			</div>
		</fieldset>

	</x-core::form>

</div>

@endsection

@push('page-scripts')

@endpush
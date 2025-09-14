@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.rampmanagement.verticals.edit', $vertical))	

@section('action-button')
	<button type="submit" form="edit-vertical-form" class="uk-btn uk-btn-primary">{{__('Update Vertical')}}</button>
@endsection

@section('main-content')

	<div class="row">
		<div class="col w-full">

			<x-core::form put action="{{route('backend.rampmanagement.verticals.update', ['vertical' => $vertical['id']])}}" :model="$vertical" id="edit-vertical-form"> 

				<fieldset class="uk-fieldset space-y-4">
					<div class="row">
						<div class="col w-full xl:w-6/12 mb-4">
							<x-core::input name="name" :100/>
						</div>
					</div>
					<div class="row">
						<div class="col w-4/12">
							<x-core::input name="allocated_funds" type="number" :100/>
						</div>
						<div class="col w-4/12">
							<x-core::input name="utilised_funds" type="number" :100/>
						</div>
						<div class="col w-4/12">
							<x-core::input name="remaining_funds" type="number" :110/>
						</div>
					</div>
				</fieldset>

			</x-core::form>

		</div>
	</div>

@endsection

@push('page-scripts')
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const alloc = document.getElementById('form-input-allocated_funds');
		const util  = document.getElementById('form-input-utilised_funds');
		const rem   = document.getElementById('form-input-remaining_funds');
		
		function toNum(el){ return el && el.value !== '' ? parseFloat(el.value) : 0; }

		function update(){
			const v = toNum(alloc) - toNum(util);
			if (rem) rem.value = Number.isFinite(v) ? v : '';
		}
		
		if (alloc) alloc.addEventListener('input', update);
		if (util)  util.addEventListener('input', update);
		
		update(); // initial fill
	});
</script>
@endpush
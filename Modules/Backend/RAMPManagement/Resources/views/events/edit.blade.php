@extends('core::layouts.backend.index')

@section('main-content')

<div class="uk-container uk-container-lg">

	<x-core::form put action="{{route('backend.rampmanagement.events.update', ['event' => $event['id']])}}" :model="$event"> 

		<div class="row">
			<div class="col w-full">	
				<div class="row">
					<div class="col w-6/12 content-end">
						{{ Breadcrumbs::render('backend.rampmanagement.events.edit', $event)}}				
					</div>
					<div class="col w-6/12 flex items-end justify-end">
						<button type="submit" class="uk-btn uk-btn-primary">{{__('Update Event')}}</button>
					</div>
				</div>
			</div>
			<div class="col w-full border-border border-t my-6"></div>
		</div>

		<fieldset class="uk-fieldset space-y-4">

			<div class="row">
				<div class="col w-full xl:w-8/12 mb-4">
					<x-core::input name="title" :100/>
				</div>
				<div class="col w-full xl:w-4/12 mb-4">
					<div class="uk-form-element mt-4">
						<span class="uk-form-label uk-form-label-custom">Date</span>
						<uk-input-date name="date" jumpable cls-custom="uk-input-fake" value="{{$event['date'] ? $event['date']->format('Y-m-d') : ''}}" required></uk-input-date>
					</div>
				</div>
			</div>				

			<div class="row">					
				<div class="col w-full xl:w-4/12 mb-4">
					<x-core::input number name="days" :100/>
				</div>
				<div class="col w-full xl:w-4/12 mb-4">
					<x-core::input number name="cost" :100/>
				</div>
				<div class="col w-full xl:w-4/12 mb-4">
					<x-core::input number name="participant_count" :100/>
				</div>								
				<div class="col w-full">
					<x-core::select name="programme_id" label="Programme" empty_placeholder="Verticals missing. No valid programmes." :options="$programmes" :100> </x-core::select>
				</div>				
			</div>

		</fieldset>

	</x-core::form>

</div>

@endsection

@push('page-scripts')

@endpush
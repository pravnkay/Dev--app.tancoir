@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.rampmanagement.registrations.upload', $event))

@section('main-content')

	<div class="row">
		<div class="col w-full">
			
			@if (session()->has('upload_feedback'))

				@php($feedback = session('upload_feedback'))

				@php($statusClasses = ['success' => 'uk-alert-success', 'warning' => 'uk-alert-warning', 'error' => 'uk-alert-danger'])

				<div class="uk-alert {{ $statusClasses[$feedback['status']] ?? 'uk-alert-primary' }} mb-6" data-uk-alert>

					<a href="#" class="uk-alert-close" data-uk-close></a>
					<div class="uk-alert-title">{{ ucfirst($feedback['status']) }}</div>
					<p>{{ $feedback['message'] ?? __('Upload completed.') }}</p>

					@if (!empty($feedback['rows']))

						<ul class="uk-list uk-list-divider mt-4">
							@foreach ($feedback['rows'] as $rowFeedback)
								@php($rowStatusClass = [
									'success' => 'uk-text-success',
									'skipped' => 'uk-text-warning',
									'error' => 'uk-text-danger',
								][$rowFeedback['status']] ?? '')
								<li>
									<strong>{{ __('Row :number', ['number' => $rowFeedback['row']]) }}:</strong>
									<span class="{{ $rowStatusClass }}">{{ ucfirst($rowFeedback['status']) }}</span>
									@if (!empty($rowFeedback['message']))
										- {{ $rowFeedback['message'] }}
									@endif
								</li>
							@endforeach
						</ul>

					@endif

				</div>

			@endif

			<form class="uk-form-stacked" action="{{route('backend.rampmanagement.registrations.store_upload', ['filtered_event' => $event->id])}}" method="POST" autocomplete="off" enctype="multipart/form-data">
				@csrf
		
				<div class="row">
					<div class="col w-full">	
						<h3 class="uk-h3"> {{__('Importing records for event - '.$event->name)}} </h3>
					</div>
					<div class="col w-full border-border border-t mt-8 mb-6"></div>
				</div>
		
				<fieldset class="uk-fieldset space-y-4">
					<div class="row">

						<div class="col w-full mb-4">

							<div class="uk-form-element">
		
								<label class="uk-form-label uk-form-label-custom uk-form-label-required" for="form-stacked-file">
									{{__('Records file')}}
								</label>
		
								<input 
									class="uk-input uk-file @error('file') uk-form-destructive @enderror"
									id="form-stacked-file"
									name="file"
									type="file"
									value="{{old('file')}}"
									aria-describedby="file-help-block"
									required
								/>	
		
								<div class="uk-form-help text-muted-foreground">
									Upload the .xslx file containing the records to upload.
								</div>
		
								@error('file')
									<div class="uk-form-help mt-2 text-destructive" id="file-help-block">
										{{ $message }}
									</div>
								@enderror
		
							</div>
						</div>
								
						<div class="col w-full flex items-end justify-start">
							<button type="submit" class="uk-btn uk-btn-primary">{{__('Import')}}</button>
						</div>
		
					</div>
				</fieldset>
				
			</form>
		</div>
	</div>

@endsection

@push('page-scripts')

	
@endpush

@extends('core::layouts.backend.index')

@section('breadcrumbs', Breadcrumbs::render('backend.bulk.import.create', $model, $studly))

@section('main-content')

	<form class="uk-form-stacked" action="{{route('backend.bulk.import.store')}}" method="POST" autocomplete="off" enctype="multipart/form-data">
	@csrf

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

						<div class="uk-form-help text-muted-foreground mt-2">
							Upload the .xslx file containing the records to upload.
						</div>

						@error('file')
							<div class="uk-form-help mt-2 text-destructive" id="file-help-block">
								{{ $message }}
							</div>
						@enderror

					</div>
				</div>

				<div class="col w-full mb-4">
					<div class="uk-form-element">

						<label class="uk-form-label uk-form-label-custom uk-form-label-required" for="form-stacked-studly">
							{{__('Entity')}}
						</label>

						<input 
							class="uk-input @error('studly') uk-form-destructive @enderror"
							id="form-stacked-studly"
							type="text"
							value="{{$studly}}"
							aria-describedby="studly-help-block"
							required
							disabled
						/>	

						<input type="text" name="studly" value="{{$studly}}" hidden/>
						<input type="text" name="model_class" value="{{$model_class}}" hidden/>

						@error('studly')
							<div class="uk-form-help mt-2 text-destructive" id="studly-help-block">
								{{ $message }}
							</div>
						@enderror

						@error('model')
							<div class="uk-form-help mt-2 text-destructive" id="studly-help-block">
								{{ $message }}
							</div>
						@enderror

					</div>
				</div>

				<div class="col w-full xl:w-6/12 mt-4 mb-8">
					<div class="uk-form-element">

						<div class="flex items-center space-x-4">
							<input
							class="uk-toggle-switch uk-toggle-switch-primary"
							id="toggle-switch"
							type="checkbox"
							name="is_json"
							/>
							<label class="uk-form-label mb-0 ms-8" for="toggle-switch">Store as json ?</label>
						</div>

					</div>
				</div>

				<div class="col w-full flex items-end justify-start">
					<button type="submit" class="uk-btn uk-btn-primary">{{__('Import')}}</button>
				</div>

			</div>
			
		</fieldset>

	</form>

@endsection

@push('page-scripts')
	
@endpush
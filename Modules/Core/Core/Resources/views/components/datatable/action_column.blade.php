

@isset($show)
	<a 	href="{{ $show }}" class="uk-btn uk-btn-sm uk-btn-icon">
		<uk-icon icon="eye"></uk-icon>
	</a>
@endisset

@isset ($edit)
	<a href={{$edit}} class="uk-btn uk-btn-sm uk-btn-icon">
		<uk-icon icon="square-pen"></uk-icon>
	</a>
@endisset

@isset($list)
	<a href="{{ $list }}" class="uk-btn uk-btn-sm uk-btn-icon">
		<uk-icon icon="eye"></uk-icon>
	</a>
@endisset

@isset($create)
	<a href="{{ $create}}" class="uk-btn uk-btn-sm uk-btn-icon">
		<uk-icon icon="plus"></uk-icon>
	</a>
@endisset

@isset($proceed)
	<a href="{{ $proceed }}" class="uk-btn uk-btn-sm uk-btn-icon">
		<uk-icon icon="chevrons-right"></uk-icon>
	</a>
@endisset

@isset ($delete)
	<form action="{{ $delete }}" method="POST" class="d-inline">
		@csrf
		@method('DELETE')
		<button 
			type="submit"
			class="uk-btn uk-btn-sm uk-btn-icon delete-item-button"
			data-title="{{__('Are you sure?')}}"
			data-text="{{__('This action cannot be reversed!')}}"
			data-confirm_button="{{__('Yes, Delete!')}}"
			data-cancel_button="{{__('Cancel')}}"
		>
			<uk-icon icon="trash-2"></uk-icon>
	</button>
	</form>	
@endisset

@isset($registration)
	<a href="{{ $registration }}" class="uk-btn uk-btn-sm uk-btn-icon">
		<uk-icon icon="folder-up"></uk-icon>
	</a>
@endisset

<form action="{{ $activate }}" method="POST" class="d-inline">
	@csrf
	@method('PUT')
	<button 
		type="submit"
		class="uk-btn uk-btn-sm uk-btn-icon"		
	>
		<uk-icon icon="x"></uk-icon>
</button>
</form>	
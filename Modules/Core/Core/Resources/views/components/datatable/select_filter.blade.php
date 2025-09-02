<select class=\"uk-select uk-form-sm\">
		<option value=""></option>
	@foreach($options as $key => $value)
		<option value=\"{{$value}}\">{{$value}}</option>
	@endforeach
</select>


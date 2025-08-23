<?php

namespace Modules\Registry\Profile\Actions\Profiles;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Core\Core\Enums\ProfileTypeEnum;

class Store
{
	use AsAction;

	public function handle(ActionRequest $request)
	{
		$validated = $request->validated();

		$user = Auth::user();

		$profileEnum = ProfileTypeEnum::from($validated['profile_type']);
        $modelClass = $profileEnum->classDefinition();

        $profile = $modelClass::create([
			'user_id' 	=> $user['id'],
			'name' 		=> $validated['profile_name']
		]);		

		notify('Profile created successfully!', ['icon' => 'circle-check-big']);
		
    	return redirect()->route('app.profile.edit', [
			'profile_type'	=> $validated['profile_type'], 
			'profile_id' 	=> $profile->id
		]);
	}

	public function prepareForValidation(ActionRequest $request)
	{
		$input = array_filter($request->all(), function($val) { 
			return ($val || is_numeric($val));
		});
		
		$request->replace($input);

	}

	public function rules()
    {
        return [
			'profile_type'			=> ['required', 'string', Rule::enum(ProfileTypeEnum::class)],
			'profile_name'			=> ['required', 'string'],
        ];
    }

}
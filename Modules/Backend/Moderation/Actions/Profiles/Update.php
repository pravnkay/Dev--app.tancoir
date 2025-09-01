<?php

namespace Modules\Backend\Moderation\Actions\Profiles;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class Update
{
	use AsAction;

	public function handle(ActionRequest $request, string $profile_type, int $profile_id)
    {
		$user = Auth::user();
    
		// Validate profile type
		$profileEnum = ProfileTypeEnum::tryFrom($profile_type);
		if (!$profileEnum) {
			notify('Invalid profile type!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();
		}

		$modelClass = $profileEnum->classDefinition();
		
		// Find and ensure ownership
		$profile = $modelClass::where('id', $profile_id)->first();

		if (!$profile) {
			notify('Profile not found!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();
		}

		$profile->updateQuietly($request->validated());

		notify('Profile Updated!', ['icon' => 'circle-check-big']);
		return redirect()->route('backend.moderation.profile.index');

    }

	public function prepareForValidation(ActionRequest $request)
	{
		$input = array_filter($request->all(), function($val) { 
			return ($val || is_numeric($val));
		});

		$input['reviewed_by'] = Auth::user()->id;
		$input['reviewed_at'] = now();
		
		$request->replace($input);
	}

	public function rules()
    {
		return [
			'status' 			=> ['required', Rule::enum(ProfileStatusEnum::class)],
			'review_remarks' 	=> ['required', 'string'],
			'reviewed_by' 		=> ['required'],
			'reviewed_at' 		=> ['required'],
		];
	}
}
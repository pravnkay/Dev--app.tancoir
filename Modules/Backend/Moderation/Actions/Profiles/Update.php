<?php

namespace Modules\Backend\Moderation\Actions\Profiles;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\Profile\Entities\Profile;
use Modules\Core\Core\Enums\ProfileStatusEnum;

class Update
{
	use AsAction;

	public function handle(ActionRequest $request, Profile $profile)
    {
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
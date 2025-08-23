<?php

namespace Modules\Registry\Profile\Actions\Profiles\Update;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Core\Core\Enums\DistrictEnum;
use Modules\Core\Core\Enums\ProfileTypeEnum;
use Modules\Core\Core\Rules\AlphaDotSpace;
use Modules\Core\Core\Rules\AlphaNumDotSpaceSlash;

class Society
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
		$profile = $modelClass::where('id', $profile_id)
					->where('user_id', $user->id)
					->first();

		if (!$profile) {
			notify('Profile not found!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();
		}

		$profile->update($request->validated());

		notify('Profile Updated!', ['icon' => 'circle-check-big']);
		return redirect()->route('app.profile.index');

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
			'name'					=> ['required', 'string', 'max:255'] ,
			'udyam'					=> ['required', 'string', 'regex:/^UDYAM-TN-\d{2}-\d{7}$/', Rule::unique('profile_society_profiles', 'name')],
			'society_name'			=> ['required', 'string', 'max:255', new AlphaNumDotSpaceSlash],
			'society_place'			=> ['required', 'string', 'max:255', new AlphaNumDotSpaceSlash],
			'society_district'		=> ['required', Rule::enum(DistrictEnum::class)],
			'contact_person_name'	=> ['required', 'string', 'max:255', new AlphaDotSpace],
			'contact_email'			=> ['required', 'email', ],
			'contact_phone'			=> ['required', 'string', 'regex:/^\d{10}$/'],
			'contact_whatsapp'		=> ['required', 'string', 'regex:/^\d{10}$/' ],
		];
	}
}
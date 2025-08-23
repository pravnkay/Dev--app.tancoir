<?php

namespace Modules\Registry\Profile\Actions\Profiles;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Core\Core\Enums\DistrictEnum;
use Modules\Core\Core\Enums\ProfileTypeEnum;
use Modules\Core\Core\Helpers\ProfileHelper;
use Modules\Core\Core\Rules\AlphaDotSpace;
use Modules\Core\Core\Rules\AlphaNumDotSpaceSlash;
use Modules\Core\Core\Rules\UniqueAcrossProfileTables;

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

	public function rules(ActionRequest $request)
    {
		$profile_type = $request->route('profile_type');
        $profile_id = $request->route('profile_id');
        $currentTable = ProfileHelper::getTableName($profile_type);

        $baseRules = [
            'name' 						=> ['required', 'string', 'max:255'],
            'udyam' 					=> ['required', 'string', 'regex:/^UDYAM-TN-\d{2}-\d{7}$/', new UniqueAcrossProfileTables('udyam', $currentTable, $profile_id)],
            'contact_person_name' 		=> ['required', 'string', 'max:255', new AlphaDotSpace],
            'contact_email' 			=> ['required', 'email'],
            'contact_phone' 			=> ['required', 'string', 'regex:/^\d{10}$/'],
            'contact_whatsapp' 			=> ['required', 'string', 'regex:/^\d{10}$/'],
        ];

        $typeSpecificRules = match($profile_type) {
            'enterprise' => [
                'enterprise_name' 		=> ['required', 'string', 'max:255', new AlphaNumDotSpaceSlash],
                'enterprise_place' 		=> ['required', 'string', 'max:255', new AlphaNumDotSpaceSlash],
                'enterprise_district' 	=> ['required', Rule::enum(DistrictEnum::class)],
            ],
            'cluster' => [
                'cluster_name' 			=> ['required', 'string', 'max:255', new AlphaNumDotSpaceSlash],
                'cluster_place' 		=> ['required', 'string', 'max:255', new AlphaNumDotSpaceSlash],
                'cluster_district' 		=> ['required', Rule::enum(DistrictEnum::class)],
            ],
            'society' => [
                'society_name' 			=> ['required', 'string', 'max:255', new AlphaNumDotSpaceSlash],
                'society_place' 		=> ['required', 'string', 'max:255', new AlphaNumDotSpaceSlash],
                'society_district' 		=> ['required', Rule::enum(DistrictEnum::class)],
            ],
            'association' => [
                'association_name' 		=> ['required', 'string', 'max:255', new AlphaNumDotSpaceSlash],
                'association_place' 	=> ['required', 'string', 'max:255', new AlphaNumDotSpaceSlash],
                'association_district' 	=> ['required', Rule::enum(DistrictEnum::class)],
            ],
            default => []
        };

        return array_merge($baseRules, $typeSpecificRules);
    }

    private function getUniqueRule(string $profile_type, int $profile_id)
    {
        $tableName = match($profile_type) {
            'enterprise' 	=> 'profile_enterprise_profiles',
            'cluster' 		=> 'profile_cluster_profiles',
            'society' 		=> 'profile_society_profiles',
            'association' 	=> 'profile_association_profiles',
            default 		=> throw new \InvalidArgumentException('Invalid profile type')
        };

        return Rule::unique($tableName, 'udyam')->ignore($profile_id);
    }
}
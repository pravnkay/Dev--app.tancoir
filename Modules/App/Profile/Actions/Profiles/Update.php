<?php

namespace Modules\App\Profile\Actions\Profiles;

use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\Profile\Entities\Profile;
use Modules\Core\Core\Enums\DistrictEnum;
use Modules\Core\Core\Rules\AlphaDotSpace;
use Modules\Core\Core\Rules\AlphaNumDotSpaceSlash;
use Modules\Core\Core\Rules\UniqueAcrossProfileTables;

class Update
{
	use AsAction;

	public function handle(ActionRequest $request, Profile $profile)
    {    
		$validated = $request->validated();
		$profile->profile_data->update($validated);
		notify('Profile Updated!', ['icon' => 'circle-check-big']);
		return redirect()->route('app.profile.index');
    }

	private function updateProfileType(Profile $profile, string $type, array $data): void
    {
        switch ($type) {
            case 'enterprise':
                $profile->enterpriseProfile->update($data);
                break;
            case 'cluster':
                $profile->clusterProfile->update($data);
                break;
            case 'society':
                $profile->societyProfile->update($data);
                break;
            case 'association':
                $profile->associationProfile->update($data);
                break;
        }
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
		$profile = $request->route('profile');
		$profile_type = $profile->type->value;
        $profile_id = $profile['id'];

        $currentTable = $profile->profile_data->getTable();

		clock($currentTable);
		clock($profile_id);

        $baseRules = [
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
}
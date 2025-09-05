<?php

namespace Modules\App\Profile\Actions\Profiles;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\Profile\Entities\Profile;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class Store
{
	use AsAction;

	public function handle(ActionRequest $request)
	{
		$validated = $request->validated();

		try {

			\DB::transaction(function () use ($validated, &$profile) {

				$user = Auth::user();

				$profile = Profile::create([
					'user_id' 	=> $user['id'],
					'name' 		=> $validated['name'],
					'type' 		=> $validated['type']
				]);

				$this->createProfileType($profile, $validated['type']);

			}, 3);	

		} catch (\Throwable $e) {

			clock($e->getMessage());
			notify('DB Error. Contact Admin!', ['status'=> 'destructive', 'icon' => 'ban']);
			return redirect()->back();

		}	

		notify('Profile created successfully!', ['icon' => 'circle-check-big']);
		return redirect()->route('app.profile.edit', ['profile' => $profile->id]);

	}

	private function createProfileType(Profile $profile, string $type): void
    {
        switch ($type) {
            case 'enterprise':
                $profile->enterprise_profile()->create();
                break;
            case 'cluster':
                $profile->cluster_profile()->create();
                break;
            case 'society':
                $profile->society_profile()->create();
                break;
            case 'association':
                $profile->association_profile()->create();
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

	public function rules()
    {
        return [
			'name'			=> ['required', 'string'],
			'type'			=> ['required', 'string', Rule::enum(ProfileTypeEnum::class)],
        ];
    }

}
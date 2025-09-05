<?php

namespace Modules\App\Profile\Actions\Participants;

use Illuminate\Validation\Rule;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

use Modules\App\Profile\Entities\Participant;

use Modules\Core\Core\Enums\ParticipantDesignationEnum;
use Modules\Core\Core\Enums\ParticipantGenderEnum;
use Modules\Core\Core\Enums\ParticipantReligionEnum;
use Modules\Core\Core\Enums\ParticipantCommunityEnum;

class Store
{
	use AsAction;

	public function handle(ActionRequest $request)
	{
		$validated = $request->validated();
		Participant::create($validated);
		
		notify('Participant created successfully!', ['icon' => 'circle-check-big']);
		return redirect()->route('app.participant.index');

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
			'profile_id'	=> ['required', Rule::exists('profile_profiles', 'id')],
			'name'			=> ['required', 'string'],
			'age'			=> ['required', 'integer', 'min:18', 'max:100'],
			'designation'	=> ['required', 'string', Rule::enum(ParticipantDesignationEnum::class)],
			'gender'		=> ['required', 'string', Rule::enum(ParticipantGenderEnum::class)],
			'religion'		=> ['required', 'string', Rule::enum(ParticipantReligionEnum::class)],
			'community'		=> ['required', 'string', Rule::enum(ParticipantCommunityEnum::class)],
			'whatsapp'		=> ['required', 'string', 'regex:/^\d{10}$/'],
        ];
    }

}
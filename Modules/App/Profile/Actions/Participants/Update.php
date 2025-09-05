<?php

namespace Modules\App\Profile\Actions\Participants;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\App\Profile\Entities\Participant;

use Modules\Core\Core\Enums\ParticipantCommunityEnum;
use Modules\Core\Core\Enums\ParticipantDesignationEnum;
use Modules\Core\Core\Enums\ParticipantGenderEnum;
use Modules\Core\Core\Enums\ParticipantReligionEnum;

class Update
{
	use AsAction;

	public function handle(ActionRequest $request, Participant $participant)
    {
        $validated = $request->validated();
		$participant->update($validated);
		notify('Participant updated successfully!', ['icon' => 'circle-check-big']);
		return redirect()->route('app.participant.index');
    }

	public function prepareForValidation(ActionRequest $request)
	{
		$input = array_filter($request->all(), function($val) { 
			return ($val || is_numeric($val));
		});

		clock($input);

		$request->replace($input);
	}

	public function rules()
    {
		return [
			'profile_id'	=> ['required', Rule::exists('profile_profiles', 'id')],
			'name'			=> ['required', 'string'],
			'age'			=> ['required', 'integer', 'min:18', 'max:100'],
			'designation'	=> ['required', 'string', new Enum(ParticipantDesignationEnum::class)],
			'gender'		=> ['required', 'string', new Enum(ParticipantGenderEnum::class)],
			'religion'		=> ['required', 'string', new Enum(ParticipantReligionEnum::class)],
			'community'		=> ['required', 'string', new Enum(ParticipantCommunityEnum::class)],
			'whatsapp'		=> ['required', 'string', 'regex:/^\d{10}$/'],
        ];
    }
}
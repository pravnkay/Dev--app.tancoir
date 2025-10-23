<?php

namespace Modules\Core\Core\Enums;

enum ParticipantGenderEnum: string
{
    case MALE 				= 'male';
    case FEMALE 			= 'female';
    case TRANSGENDER 		= 'transgender';

    public function label(): string
    {
        return match ($this) {
            self::MALE 				=> 'Male',
			self::FEMALE 			=> 'Female',
			self::TRANSGENDER 		=> 'Transgender',
        };
    }

	public function label_for_uploader() :string
	{
		return match ($this) {
            self::MALE 				=> 'ஆண் / Male',
			self::FEMALE 			=> 'பெண் / Female',
			self::TRANSGENDER 		=> 'மாற்றுப் பாலினத்தவர் / Transgender',
        };
	}

	public static function asArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->label();
        }
        return $array;
    }
}

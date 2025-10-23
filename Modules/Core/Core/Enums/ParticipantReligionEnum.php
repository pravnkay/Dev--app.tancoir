<?php

namespace Modules\Core\Core\Enums;

enum ParticipantReligionEnum: string
{
    case HINDU 				= 'hindu';
    case MUSLIM 			= 'muslim';
    case CHRISTIANITY 		= 'christianity';
    case OTHERS 			= 'others';

    public function label(): string
    {
        return match ($this) {
            self::HINDU 			=> 'Hindu',
			self::MUSLIM 			=> 'Muslim',
			self::CHRISTIANITY 		=> 'Christianity',
			self::OTHERS 			=> 'Others',
        };
    }

	public function label_for_uploader() :string
	{
		return match ($this) {
            self::HINDU 			=> 'இந்து / Hindu',
			self::MUSLIM 			=> 'முஸ்லிம் / Muslim',
			self::CHRISTIANITY 		=> 'கிறிஸ்துவம் / Chiristianity',
			self::OTHERS 			=> 'Other',
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

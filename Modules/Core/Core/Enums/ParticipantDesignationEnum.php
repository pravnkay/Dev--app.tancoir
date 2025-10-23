<?php

namespace Modules\Core\Core\Enums;

enum ParticipantDesignationEnum: string
{
    case PROPRIETOR 		= 'proprietor';
    case PARTNER 			= 'partner';
    case DIRECTOR 			= 'director';
    case MANAGER 			= 'manager';
    case EMPLOYEE 			= 'employee';

    public function label(): string
    {
        return match ($this) {
            self::PROPRIETOR 		=> 'Proprietor',
			self::PARTNER 			=> 'Partner',
			self::DIRECTOR 			=> 'Director',
			self::MANAGER 			=> 'Manager',
			self::EMPLOYEE 			=> 'Employee',
        };
    }

	public function label_for_uploader() :string
	{
		return match ($this) {
            self::PROPRIETOR 		=> 'உரிமையாளர் / Owner / Proprietor',
			self::PARTNER 			=> 'பங்குதாரர் / Partner',
			self::DIRECTOR 			=> 'டைரக்டர் / Director',
			self::MANAGER 			=> 'மேலாளர் / Manager',
			self::EMPLOYEE 			=> 'பணியாளர் / Employee',
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

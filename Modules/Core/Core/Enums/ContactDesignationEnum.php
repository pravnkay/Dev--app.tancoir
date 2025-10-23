<?php

namespace Modules\Core\Core\Enums;

enum ContactDesignationEnum: string
{
   case OWNER 					= 'owner';
   case PARTNER 				= 'partner';

	public function label(): string
	{
		return match($this) 
		{
			self::OWNER 				=> 'Owner / Proprietor',
			self::PARTNER 				=> 'Partner',
		};
	}

	public function label_for_uploader() :string
	{
		return match ($this) {
            self::OWNER 				=> 'Owner / Proprietor',
			self::PARTNER 				=> 'Partner',
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

	public static function from_label(string $label): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->label() === $label) {
                return $case;
            }
        }
        return null; // Return null if no matching label is found
    }
}
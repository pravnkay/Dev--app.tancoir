<?php

namespace Modules\Core\Core\Enums;

enum ProgrammeSchemeEnum: string
{
   case NORMAL 					= 'normal';
   case ASPIRE 					= 'aspire';

	public function label(): string
	{
		return match($this) 
		{
			self::NORMAL 				=> 'Normal',
			self::ASPIRE 				=> 'ASPIRE',
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
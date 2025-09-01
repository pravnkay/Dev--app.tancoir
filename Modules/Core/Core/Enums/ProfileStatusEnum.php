<?php

namespace Modules\Core\Core\Enums;

enum ProfileStatusEnum: string
{
    case DRAFT 				= 'draft';
    case SUBMITTED 			= 'submitted';
    case APPROVED 			= 'approved';
    case RETURNED 			= 'returned';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT 	=> 'Draft',
            self::SUBMITTED => 'Submitted',
            self::APPROVED 	=> 'Approved',
            self::RETURNED 	=> 'Returned',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT 	=> 'gray',
            self::SUBMITTED => 'blue',
            self::APPROVED 	=> 'green',
            self::RETURNED 	=> 'red',
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

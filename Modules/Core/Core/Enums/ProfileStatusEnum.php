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

    public function canTransitionTo(self $status): bool
    {
        return match ($this) {
            self::DRAFT 	=> in_array($status, [self::SUBMITTED]),
            self::SUBMITTED => in_array($status, [self::APPROVED, self::RETURNED]),
            self::APPROVED 	=> in_array($status, [self::RETURNED]),
            self::RETURNED 	=> in_array($status, [self::SUBMITTED]),
        };
    }

    public static function adminVisibleStatuses(): array
    {
        return [self::SUBMITTED, self::APPROVED, self::RETURNED];
    }
}

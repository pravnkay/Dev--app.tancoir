<?php

namespace Modules\Core\Core\Enums;

enum ParticipantCommunityEnum: string
{
    case GENERAL 		= 'general';
    case OBC 			= 'obc';
    case SCST 			= 'scst';

    public function label(): string
    {
        return match ($this) {
            self::GENERAL 		=> 'General',
            self::OBC 			=> 'OBC',
            self::SCST 			=> 'SC/ST',
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

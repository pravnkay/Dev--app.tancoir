<?php

namespace Modules\Core\Core\Helpers;

class ProfileHelper
{
    public static function getTableName(string $profileType): string
    {
        return match($profileType) {
            'enterprise' => 'profile_enterprise_profiles',
            'cluster' => 'profile_cluster_profiles',
            'society' => 'profile_society_profiles',
            'association' => 'profile_association_profiles',
            default => throw new \InvalidArgumentException('Invalid profile type')
        };
    }

    public static function getAllProfileTables(): array
    {
        return [
            'profile_enterprise_profiles',
            'profile_cluster_profiles',
            'profile_society_profiles',
            'profile_association_profiles'
        ];
    }
}

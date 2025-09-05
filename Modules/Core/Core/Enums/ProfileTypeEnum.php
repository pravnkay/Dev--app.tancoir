<?php

namespace Modules\Core\Core\Enums;

use Modules\App\Profile\Entities\ClusterProfile;
use Modules\App\Profile\Entities\EnterpriseProfile;
use Modules\App\Profile\Entities\SocietyProfile;
use Modules\App\Profile\Entities\AssociationProfile;

enum ProfileTypeEnum: string
{
   case ENTERPRISE 				= 'enterprise';
   case CLUSTER 				= 'cluster';
   case SOCIETY 				= 'society';
   case ASSOCIATION				= 'association';

	public function label(): string
	{
		return match($this) 
		{
			self::ENTERPRISE 			=> 'Enterprise',
			self::CLUSTER 				=> 'Cluster',
			self::SOCIETY 				=> 'Society',
			self::ASSOCIATION			=> 'Association',
		};
	}

	public function classDefinition(): string
	{
		return match($this) 
		{
			self::ENTERPRISE 			=> EnterpriseProfile::class,
			self::CLUSTER 				=> ClusterProfile::class,
			self::SOCIETY 				=> SocietyProfile::class,
			self::ASSOCIATION 			=> AssociationProfile::class,
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
<?php

namespace Modules\App\Profile\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\App\Profile\Entities\AssociationProfile;
use Modules\App\Profile\Entities\ClusterProfile;
use Modules\App\Profile\Entities\EnterpriseProfile;
use Modules\App\Profile\Entities\Profile;
use Modules\App\Profile\Entities\SocietyProfile;
use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Enums\DistrictEnum;
use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class ProfileDatabaseSeeder extends Seeder
{

	private array $numberWords = [
		1 => 'One',
		2 => 'Two', 
		3 => 'Three',
		4 => 'Four',
		5 => 'Five'
	];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$faker = Factory::create('en_IN');

		$adminUser = User::where('email', 'admin@email.com')->first();

		for ($i = 1; $i <= 5; $i++) {

            $numberWord = $this->numberWords[$i];

			$user = User::create([
                'name' => "User {$numberWord}",
                'username' => "user{$numberWord}",
                'email' => "user{$numberWord}@email.com",
                'email_verified_at' => now(),
                'password' => Hash::make('userpass'),
            ])->assignRole(['user']);

			$this->createProfilesForUser($user, $adminUser);

		}
	}

	private function createProfilesForUser(User $user, User $adminUser): void
    {
        $profileCounter = 1;
        $districts = DistrictEnum::cases();

        foreach (ProfileTypeEnum::cases() as $profileType) {

            // Create 2-3 profiles per type for variety
            $profileCount = rand(2, 3);
            
            for ($j = 1; $j <= $profileCount; $j++) {
            
				$profileNumber = str_pad($profileCounter, 2, '0', STR_PAD_LEFT);
                $profileName = "{$profileType->label()} profile {$profileNumber}";
                
                // Randomly decide if this profile should be approved
                $shouldApprove = rand(0, 1) === 1;
                $status = $shouldApprove ? ProfileStatusEnum::APPROVED : ProfileStatusEnum::SUBMITTED;
                
                // Create main profile
                $profile = Profile::create([
                    'user_id' => $user->id,
                    'name' => $profileName,
                    'type' => $profileType->value,
                    'status' => $status->value,
                    'is_active' => $shouldApprove,
                    'submitted_at' => $shouldApprove ? now()->subDays(rand(1, 30)) : null,
                    'review_remarks' => $shouldApprove ? 'Approved' : null,
                    'reviewed_at' => $shouldApprove ? now()->subDays(rand(0, 10)) : null,
                    'reviewed_by' => $shouldApprove ? $adminUser->id : null,
                ]);

                // Create corresponding profile subtype
                $this->createProfileSubtype($profile, $profileType, $districts);
                
                $profileCounter++;
            }
        }
    }

	private function createProfileSubtype(Profile $profile, ProfileTypeEnum $profileType, array $districts): void
    {
        $randomDistrict = $districts[array_rand($districts)];
        $udyamNumber = 'UDYAM-TN-00-' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
        
        $baseData = [
            'profile_id' => $profile->id,
            'udyam' => $udyamNumber,
            'contact_person_name' => fake()->name(),
            'contact_email' => fake()->unique()->safeEmail(),
            'contact_phone' => fake()->phoneNumber(),
            'contact_whatsapp' => fake()->phoneNumber(),
        ];

        switch ($profileType) {
            case ProfileTypeEnum::ENTERPRISE:
                EnterpriseProfile::create(array_merge($baseData, [
                    'enterprise_name' => fake()->company() . ' Enterprise',
                    'enterprise_place' => fake()->city(),
                    'enterprise_district' => $randomDistrict->value,
                ]));
                break;

            case ProfileTypeEnum::CLUSTER:
                ClusterProfile::create(array_merge($baseData, [
                    'cluster_name' => fake()->company() . ' Cluster',
                    'cluster_place' => fake()->city(),
                    'cluster_district' => $randomDistrict->value,
                ]));
                break;

            case ProfileTypeEnum::SOCIETY:
                SocietyProfile::create(array_merge($baseData, [
                    'society_name' => fake()->company() . ' Society',
                    'society_place' => fake()->city(),
                    'society_district' => $randomDistrict->value,
                ]));
                break;

            case ProfileTypeEnum::ASSOCIATION:
                AssociationProfile::create(array_merge($baseData, [
                    'association_name' => fake()->company() . ' Association',
                    'association_place' => fake()->city(),
                    'association_district' => $randomDistrict->value,
                ]));
                break;
        }
    }

}
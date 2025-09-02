<?php

namespace Modules\Registry\Profile\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Modules\Core\Auth\Entities\User;

use Modules\Registry\Profile\Entities\AssociationProfile;
use Modules\Registry\Profile\Entities\ClusterProfile;
use Modules\Registry\Profile\Entities\EnterpriseProfile;
use Modules\Registry\Profile\Entities\SocietyProfile;

use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\Core\Core\Enums\ProfileTypeEnum;

class ProfileDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            'Ariyalur', 'Chengalpattu', 'Chennai', 'Coimbatore', 'Cuddalore',
            'Dharmapuri', 'Dindigul', 'Erode', 'Kallakurichi', 'Kanchipuram',
            'Kanyakumari', 'Karur', 'Krishnagiri', 'Madurai', 'Mayiladuthurai',
            'Nagapattinam', 'Namakkal', 'The Nilgiris', 'Perambalur', 'Pudukkottai',
            'Ramanathapuram', 'Ranipet', 'Salem', 'Sivaganga', 'Tenkasi',
            'Thanjavur', 'Theni', 'Tiruvallur', 'Thoothukudi', 'Tiruchirappalli',
            'Tirunelveli', 'Tirupathur', 'Tiruppur', 'Tiruvannamalai', 'Tiruvarur',
            'Vellore', 'Viluppuram', 'Virudhunagar'
        ];

        $enterpriseNames = [
            'Tech Solutions', 'Digital Innovations', 'Smart Manufacturing', 'Green Energy',
            'Advanced Logistics', 'Quality Systems', 'Modern Industries', 'Future Technologies',
            'Integrated Services', 'Precision Engineering', 'Dynamic Solutions', 'Elite Manufacturing',
            'Progressive Industries', 'Innovative Systems', 'Excellence Corporation', 'Prime Technologies',
            'Superior Solutions', 'Advanced Engineering', 'Premium Industries', 'Global Systems'
        ];

        $places = [
            'Industrial Estate', 'Tech Park', 'Business Hub', 'Commerce Center',
            'Manufacturing Zone', 'IT Corridor', 'Trade Center', 'Industrial Complex',
            'Business District', 'Technology Center', 'Export Zone', 'Commercial Area',
            'Industrial Park', 'Innovation Hub', 'Development Zone', 'Enterprise City'
        ];

        $personNames = [
            'Rajesh Kumar', 'Priya Sharma', 'Arun Patel', 'Deepika Singh', 'Vikram Reddy',
            'Kavitha Nair', 'Suresh Gupta', 'Meera Joshi', 'Ravi Krishnan', 'Pooja Agarwal',
            'Manoj Verma', 'Sita Rao', 'Kiran Das', 'Neha Pillai', 'Ashok Iyer',
            'Lakshmi Menon', 'Gopal Srinivas', 'Uma Devi', 'Prakash Bhat', 'Radha Kumari'
        ];

        $numberWords = ['one', 'two', 'three', 'four', 'five'];

        for ($i = 1; $i <= 5; $i++) {
            $userWord = $numberWords[$i - 1];
            
            // Create user
            $user = User::create([
                'name' => "Test User " . ucfirst($userWord),
                'username' => "user{$userWord}",
                'email' => "user{$userWord}@email.com",
                'email_verified_at' => now(),
                'password' => Hash::make('userpass'),
            ])->assignRole(['user']);

            $profiles = [];

            // Create Enterprise Profile
            $enterpriseProfile = EnterpriseProfile::create([
                'user_id' => $user->id,
                'name' => $personNames[array_rand($personNames)],
                'udyam' => 'UDYAM-TN-' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'enterprise_name' => 'Enterprise - ' . $enterpriseNames[array_rand($enterpriseNames)],
                'enterprise_place' => $places[array_rand($places)],
                'enterprise_district' => $districts[array_rand($districts)],
                'contact_person_name' => $personNames[array_rand($personNames)],
                'contact_email' => "contact.enterprise.user{$userWord}@email.com",
                'contact_phone' => '+91' . rand(7000000000, 9999999999),
                'contact_whatsapp' => '+91' . rand(7000000000, 9999999999),
                'status' => ProfileStatusEnum::SUBMITTED->value,
                'submitted_at' => now()->subDays(rand(1, 30)),
            ]);
            $profiles[] = [
                'type' => ProfileTypeEnum::ENTERPRISE, 
                'model' => $enterpriseProfile,
                'class' => 'Modules\\Registry\\Profile\\Entities\\EnterpriseProfile'
            ];

            // Create Cluster Profile
            $clusterProfile = ClusterProfile::create([
                'user_id' => $user->id,
                'name' => $personNames[array_rand($personNames)],
                'udyam' => 'UDYAM-TN-' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'cluster_name' => 'Cluster - ' . $enterpriseNames[array_rand($enterpriseNames)] . ' Hub',
                'cluster_place' => $places[array_rand($places)],
                'cluster_district' => $districts[array_rand($districts)],
                'contact_person_name' => $personNames[array_rand($personNames)],
                'contact_email' => "contact.cluster.user{$userWord}@email.com",
                'contact_phone' => '+91' . rand(7000000000, 9999999999),
                'contact_whatsapp' => '+91' . rand(7000000000, 9999999999),
                'status' => ProfileStatusEnum::SUBMITTED->value,
                'submitted_at' => now()->subDays(rand(1, 30)),
            ]);
            $profiles[] = [
                'type' => ProfileTypeEnum::CLUSTER, 
                'model' => $clusterProfile,
                'class' => 'Modules\\Registry\\Profile\\Entities\\ClusterProfile'
            ];

            // Create Society Profile
            $societyProfile = SocietyProfile::create([
                'user_id' => $user->id,
                'name' => $personNames[array_rand($personNames)],
                'udyam' => 'UDYAM-TN-' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'society_name' => 'Society - ' . $enterpriseNames[array_rand($enterpriseNames)] . ' Cooperative',
                'society_place' => $places[array_rand($places)],
                'society_district' => $districts[array_rand($districts)],
                'contact_person_name' => $personNames[array_rand($personNames)],
                'contact_email' => "contact.society.user{$userWord}@email.com",
                'contact_phone' => '+91' . rand(7000000000, 9999999999),
                'contact_whatsapp' => '+91' . rand(7000000000, 9999999999),
                'status' => ProfileStatusEnum::SUBMITTED->value,
                'submitted_at' => now()->subDays(rand(1, 30)),
            ]);
            $profiles[] = [
                'type' => ProfileTypeEnum::SOCIETY, 
                'model' => $societyProfile,
                'class' => 'Modules\\Registry\\Profile\\Entities\\SocietyProfile'
            ];

            // Create Association Profile
            $associationProfile = AssociationProfile::create([
                'user_id' => $user->id,
                'name' => $personNames[array_rand($personNames)],
                'udyam' => 'UDYAM-TN-' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                'association_name' => 'Association - ' . $enterpriseNames[array_rand($enterpriseNames)] . ' Alliance',
                'association_place' => $places[array_rand($places)],
                'association_district' => $districts[array_rand($districts)],
                'contact_person_name' => $personNames[array_rand($personNames)],
                'contact_email' => "contact.association.user{$userWord}@email.com",
                'contact_phone' => '+91' . rand(7000000000, 9999999999),
                'contact_whatsapp' => '+91' . rand(7000000000, 9999999999),
                'status' => ProfileStatusEnum::SUBMITTED->value,
                'submitted_at' => now()->subDays(rand(1, 30)),
            ]);
            $profiles[] = [
                'type' => ProfileTypeEnum::ASSOCIATION, 
                'model' => $associationProfile,
                'class' => 'Modules\\Registry\\Profile\\Entities\\AssociationProfile'
            ];

            // Select one random profile to approve and make active
            $randomProfileIndex = array_rand($profiles);
            $activeProfile = $profiles[$randomProfileIndex];
            
            // Approve the selected profile
            $activeProfile['model']->update([
                'status' => ProfileStatusEnum::APPROVED->value,
                'reviewed_at' => now()->subDays(rand(1, 15)),
                'review_remarks' => 'Profile approved after thorough verification.',
                'reviewed_by' => 1, // Assuming admin user with ID 1 exists
            ]);

            // Set the approved profile as active for the user using full namespaced class name
            $user->update([
                'active_profile_type' => $activeProfile['class'],
                'active_profile_id' => $activeProfile['model']->id,
            ]);

            $this->command->info("Created user {$user->email} with 4 profiles. Active profile: {$activeProfile['type']->label()}");
        }

        $this->command->info('Successfully created 5 users with 20 total profiles (1 approved per user)');
    }
}


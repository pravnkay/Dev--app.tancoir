<?php

namespace Modules\Registry\Profile\Entities\Services;

use Illuminate\Database\Eloquent\Model;

use Modules\Core\Auth\Entities\User;

use Modules\Registry\Profile\Entities\AssociationProfile;
use Modules\Registry\Profile\Entities\ClusterProfile;
use Modules\Registry\Profile\Entities\EnterpriseProfile;
use Modules\Registry\Profile\Entities\SocietyProfile;

class ProfileStatusService
{
    public function submitProfile(Model $profile): bool
    {
        if (!method_exists($profile, 'submit') || !$profile->canSubmit()) {
            return false;
        }

        return $profile->submit();
    }

    public function approveProfile(Model $profile, User $admin, ?string $remarks = null): bool
    {
        if (!method_exists($profile, 'approve') || !$profile->canApprove()) {
            return false;
        }

        return $profile->approve($admin, $remarks);
    }

    public function returnProfile(Model $profile, User $admin, string $remarks): bool
    {
        if (!method_exists($profile, 'returnProfile') || !$profile->canReturn()) {
            return false;
        }

        return $profile->returnProfile($admin, $remarks);
    }

    public function getProfilesForAdmin()
    {
        $profiles = collect();

        $enterprise_profiles 	= EnterpriseProfile::status('admin_visible')->with(['user', 'reviewedBy'])->get();
        $cluster_profiles 		= ClusterProfile::status('admin_visible')->with(['user', 'reviewedBy'])->get();
        $society_profiles 		= SocietyProfile::status('admin_visible')->with(['user', 'reviewedBy'])->get();
        $association_profiles 	= AssociationProfile::status('admin_visible')->with(['user', 'reviewedBy'])->get();

        return $profiles->concat($enterprise_profiles)
                       ->concat($cluster_profiles)
                       ->concat($society_profiles)
                       ->concat($association_profiles)
                       ->sortByDesc('submitted_at');
    }

    public function getPendingProfiles()
    {
        $profiles = collect();

        $enterprise_profiles 	= EnterpriseProfile::status('pending_review')->with(['user'])->get();
        $cluster_profiles 		= ClusterProfile::status('pending_review')->with(['user'])->get();
        $society_profiles 		= SocietyProfile::status('pending_review')->with(['user'])->get();
        $association_profiles 	= AssociationProfile::status('pending_review')->with(['user'])->get();

        return $profiles->concat($enterprise_profiles)
                       ->concat($cluster_profiles)
                       ->concat($society_profiles)
                       ->concat($association_profiles)
                       ->sortBy('submitted_at');
    }

    public function getProfilesByStatus(string $status)
    {
        $profiles = collect();

        $enterprise_profiles 	= EnterpriseProfile::status($status)->with(['user', 'reviewedBy'])->get();
        $cluster_profiles 		= ClusterProfile::status($status)->with(['user', 'reviewedBy'])->get();
        $society_profiles 		= SocietyProfile::status($status)->with(['user', 'reviewedBy'])->get();
        $association_profiles 	= AssociationProfile::status($status)->with(['user', 'reviewedBy'])->get();

        return $profiles->concat($enterprise_profiles)
                       ->concat($cluster_profiles)
                       ->concat($society_profiles)
                       ->concat($association_profiles);
    }
}

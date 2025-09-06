<?php

namespace Modules\Backend\RAMPManagement\Actions\EventRegistrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\EventRegistration;
use Modules\Backend\RAMPManagement\Entities\EventParticipation;

class CheckEligibilityToParticipate
{
    use AsAction;

    public function handle(EventRegistration $registration): bool
    {
        if (!$registration->profile->is_allowed_for_ramp) {
            return false;
        }

        $event = $registration->event;
        if (!$event || !$event->programme) {
            return false;
        }

        $has_already_participated_in_registered_events_programme = EventParticipation::whereHas('event_registration.event', function ($query) use ($event) {
            $query->where('programme_id', $event->programme_id);
        })->whereHas('event_registration', function ($query) use ($registration) {
            $query->where('profile_id', $registration->profile_id);
        })->exists();

        return !$has_already_participated_in_registered_events_programme;
    }
}

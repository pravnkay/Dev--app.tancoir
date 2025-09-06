<?php

namespace Modules\Backend\RAMPManagement\Actions\EventRegistrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\EventRegistration;
use Modules\Backend\RAMPManagement\Entities\EventParticipation;

class CreateParticipation
{
    use AsAction;

    public function handle(EventRegistration $registration): ?EventParticipation
    {
        if (!CheckEligibilityToParticipate::run($registration)) {
            return null;
        }

        $event = $registration->event;
        $current_participations = $event->participations()->count();
        $max_participants = $event->participant_count ?? 20;

        if ($current_participations >= $max_participants) {
            return null;
        }

        return EventParticipation::create([
            'event_registration_id' => $registration->id,
            'has_participated' => false,
            'has_feedbacked' => false,
        ]);
    }
}

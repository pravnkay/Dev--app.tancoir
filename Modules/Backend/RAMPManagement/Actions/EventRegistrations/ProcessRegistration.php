<?php

namespace Modules\Backend\RAMPManagement\Actions\EventRegistrations;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\Backend\RAMPManagement\Entities\EventRegistration;

class ProcessRegistration
{
    use AsAction;

    public function handle(EventRegistration $registration): array
    {
        $participation = CreateParticipation::run($registration);
        
        if ($participation) {
            return [
                'success' => true,
                'message' => 'You have been selected to participate in this event! Check your mail.',
                'icon' => 'circle-check-big',
                'participation' => $participation
            ];
        }

        $event = $registration->event;
        $waiting_count = $event->registrations()->count() - $event->participations()->count();
        
        return [
            'success' => false,
            'message' => "You are #{$waiting_count} on the waiting list. Check your mail.",
            'icon' => 'clock',
            'participation' => null
        ];
    }
}

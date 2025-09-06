<?php

namespace Modules\Core\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\Backend\RAMPManagement\Entities\EventParticipation;
use Modules\Backend\RAMPManagement\Entities\Event;

class NotParticipatedInProgramme implements ValidationRule
{
    protected $event_id;
    protected $profile_id;

    public function __construct($event_id, $profile_id)
    {
        $this->event_id = $event_id;
        $this->profile_id = $profile_id;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $event = Event::with('programme')->find($this->event_id);
        
        if (!$event || !$event->programme) {
            $fail('Event or programme not found.');
            return;
        }

        $has_already_participated_in_registered_events_programme = EventParticipation::whereHas('event_registration.event', function ($query) use ($event) {
            $query->where('programme_id', $event->programme_id);
        })->whereHas('event_registration', function ($query) {
            $query->where('profile_id', $this->profile_id);
        })->exists();

        if ($has_already_participated_in_registered_events_programme) {
            $fail('This profile has already participated in this programme.');
        }
    }
}

<?php
 
 namespace Modules\Backend\RAMPManagement\Observers;

use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\Programme;
use Modules\Backend\RAMPManagement\Entities\Vertical;

class EventObserver
{
    /**
     * Handle the Event "creating" event.
     */
    public function creating(Event $event): void
    {
		$cost = (float) $event->cost;
        $participant_count  = (float) $event->participant_count;
        $event->participant_cost = $cost / $participant_count;

		$maxIteration = Event::where('programme_id', $event->programme_id)->max('iteration');
		$event->iteration = ($maxIteration ?? 0) + 1;
		$formattedIteration = str_pad($event->iteration, 2, '0', STR_PAD_LEFT);

		$programme = Programme::find($event->programme_id);
		if(!$programme) return;

		$event->name = $programme->name . ' ' . $formattedIteration;
    }

    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event): void
    {
		$programme = Programme::find($event->programme_id);
		if(!$programme) return;
		
		$vertical = $event->programme->vertical;
		$this->updateVerticalFunds($vertical);
    }
 
    /**
     * Handle the Event "updating" event.
     */
    public function updating(Event $event): void
    {
        $cost = (float) $event->cost;
        $participant_count  = (float) $event->participant_count;
        $event->participant_cost = $cost / $participant_count;
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        if ($event->isDirty('cost')) {
            $vertical = $event->programme->vertical;
			$this->updateVerticalFunds($vertical);
        }
    }
 
    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        $vertical = $event->programme->vertical;
		$this->updateVerticalFunds($vertical);
    }

	/**
     * Recalculates and updates the funds for a given vertical.
     *
     * @param Vertical $vertical
     * @return void
     */
    protected function updateVerticalFunds(Vertical $vertical)
    {
        \DB::transaction(function () use ($vertical) {

            // Recalculate the total utilised funds from scratch to ensure accuracy
            $totalCost = Event::whereHas('programme', function ($query) use ($vertical) {
                $query->where('vertical_id', $vertical->id);
            })->sum('cost');

            // Update the vertical's funds
            $vertical->utilised_funds = $totalCost;
            $vertical->remaining_funds = $vertical->allocated_funds - $totalCost;
            $vertical->save();
        });
    }

}
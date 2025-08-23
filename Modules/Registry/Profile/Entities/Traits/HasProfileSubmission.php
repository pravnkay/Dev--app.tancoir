<?php

namespace Modules\Registry\Profile\Entities\Traits;

trait HasProfileSubmission
{
    public function getRequiredForSubmission(): array
    {
        return $this->requiredForSubmission;
    }

    public function isComplete(): bool
    {
        foreach ($this->getRequiredForSubmission() as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }
        return true;
    }

    public function getMissingFields(): array
    {
        $missing = [];
        foreach ($this->getRequiredForSubmission() as $field) {
            if (empty($this->$field)) {
                $missing[] = $field;
            }
        }
        return $missing;
    }

    public function getCompletionPercentage(): int
    {
        $total = count($this->getRequiredForSubmission());
        $completed = $total - count($this->getMissingFields());
        return $total > 0 ? round(($completed / $total) * 100) : 0;
    }

    public function isLocked(): bool
    {
        return in_array($this->status, [
            \App\Enums\ProfileStatusEnum::SUBMITTED,
            \App\Enums\ProfileStatusEnum::APPROVED
        ]);
    }
}

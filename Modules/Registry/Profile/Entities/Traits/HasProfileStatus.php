<?php

namespace Modules\Registry\Profile\Entities\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Enums\ProfileStatusEnum;

trait HasProfileStatus
{
    protected function initializeHasProfileStatus(): void
    {
        $this->casts = array_merge($this->casts ?? [], [
            'status' => ProfileStatusEnum::class,
            'submitted_at' => 'datetime',
            'reviewed_at' => 'datetime',
        ]);
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isDraft(): bool
    {
        return $this->status === ProfileStatusEnum::DRAFT;
    }

    public function isSubmitted(): bool
    {
        return $this->status === ProfileStatusEnum::SUBMITTED;
    }

    public function isApproved(): bool
    {
        return $this->status === ProfileStatusEnum::APPROVED;
    }

    public function isReturned(): bool
    {
        return $this->status === ProfileStatusEnum::RETURNED;
    }

    public function canSubmit(): bool
    {
        return $this->status->canTransitionTo(ProfileStatusEnum::SUBMITTED);
    }

    public function canApprove(): bool
    {
        return $this->status->canTransitionTo(ProfileStatusEnum::APPROVED);
    }

    public function canReturn(): bool
    {
        return $this->status->canTransitionTo(ProfileStatusEnum::RETURNED);
    }

    public function submit(): bool
    {
        if (!$this->canSubmit()) {
            return false;
        }

        return $this->update([
            'status' => ProfileStatusEnum::SUBMITTED,
            'submitted_at' => now(),
        ]);
    }

    public function approve(User $admin, ?string $remarks = null): bool
    {
        if (!$this->canApprove()) {
            return false;
        }

        return $this->update([
            'status' => ProfileStatusEnum::APPROVED,
            'admin_remarks' => $remarks,
            'reviewed_at' => now(),
            'reviewed_by' => $admin->id,
        ]);
    }

    public function returnProfile(User $admin, string $remarks): bool
    {
        if (!$this->canReturn()) {
            return false;
        }

        return $this->update([
            'status' => ProfileStatusEnum::RETURNED,
            'admin_remarks' => $remarks,
            'reviewed_at' => now(),
            'reviewed_by' => $admin->id,
        ]);
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status->label();
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status->color();
    }
}

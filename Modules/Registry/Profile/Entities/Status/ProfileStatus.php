<?php

namespace Modules\Registry\Profile\Entities\Status;

use Makeable\EloquentStatus\Status;
use Modules\Core\Core\Enums\ProfileStatusEnum;

class ProfileStatus extends Status
{
    protected $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function draft($query)
    {
        return $query->where('status', ProfileStatusEnum::DRAFT);
    }

    public function submitted($query)
    {
        return $query->where('status', ProfileStatusEnum::SUBMITTED);
    }

    public function approved($query)
    {
        return $query->where('status', ProfileStatusEnum::APPROVED);
    }

    public function returned($query)
    {
        return $query->where('status', ProfileStatusEnum::RETURNED);
    }

    public function admin_visible($query)
    {
        return $query->whereIn('status', ProfileStatusEnum::adminVisibleStatuses());
    }

    public function pending_review($query)
    {
        return $query->where('status', ProfileStatusEnum::SUBMITTED);
    }

    public function reviewed_by($query, $user_id)
    {
        return $query->where('reviewed_by', $user_id);
    }

    public function submitted_after($query, $date)
    {
        return $query->where('submitted_at', '>=', $date);
    }

    public function submitted_before($query, $date)
    {
        return $query->where('submitted_at', '<=', $date);
    }

    public static function all(): array
    {
        return [
            ProfileStatusEnum::DRAFT->value,
            ProfileStatusEnum::SUBMITTED->value,
            ProfileStatusEnum::APPROVED->value,
            ProfileStatusEnum::RETURNED->value,
        ];
    }
}

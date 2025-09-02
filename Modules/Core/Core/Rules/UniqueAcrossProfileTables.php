<?php

namespace Modules\Core\Core\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueAcrossProfileTables implements ValidationRule
{
    protected $excludeTable;
    protected $excludeId;
    protected $fieldName;

    public function __construct(string $fieldName, ?string $excludeTable = null, ?int $excludeId = null)
    {
        $this->fieldName = $fieldName;
        $this->excludeTable = $excludeTable;
        $this->excludeId = $excludeId;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tables = [
            'profile_enterprise_profiles',
            'profile_cluster_profiles',
            'profile_society_profiles',
            'profile_association_profiles'
        ];

        foreach ($tables as $table) {
            $query = DB::table($table)->where($this->fieldName, $value);
            
            // Skip the current record when updating
            if ($this->excludeTable === $table && $this->excludeId) {
                $query->where('id', '!=', $this->excludeId);
            }

            if ($query->exists()) {
                $fail("This {$attribute} is already taken by another profile.");
                return;
            }
        }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Enums\ProfileStatusEnum;
use Modules\Core\Core\Helpers\ProfileHelper;

return new class extends Migration
{
    public function up(): void
    {

		$tables = ProfileHelper::getAllProfileTables();

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('status')->default(ProfileStatusEnum::DRAFT->value)->after('contact_whatsapp');
                $table->dateTime('submitted_at')->nullable()->after('status');
                $table->text('review_remarks')->nullable()->after('submitted_at');
                $table->dateTime('reviewed_at')->nullable()->after('review_remarks');
				$table->foreignIdFor(User::class, 'reviewed_by')->nullable()->after('reviewed_at')->nullOnCascade();
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'profile_enterprise_profiles',
            'profile_cluster_profiles',
            'profile_society_profiles',
            'profile_association_profiles'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign(['reviewed_by']);
                $table->dropColumn([
                    'status', 
                    'review_remarks', 
                    'submitted_at', 
                    'reviewed_at', 
                    'reviewed_by'
                ]);
            });
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Core\Core\Enums\ProfileStatusEnum;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'profile_enterprise_profiles',
            'profile_cluster_profiles',
            'profile_society_profiles',
            'profile_association_profiles'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {

                $table->string('status')->default(ProfileStatusEnum::DRAFT->value)->after('contact_whatsapp');
                $table->text('admin_remarks')->nullable()->after('status');
                $table->timestamp('submitted_at')->nullable()->after('admin_remarks');
                $table->timestamp('reviewed_at')->nullable()->after('submitted_at');
                $table->unsignedBigInteger('reviewed_by')->nullable()->after('reviewed_at');
                
                $table->foreign('reviewed_by')->references('id')->on('acl_users')->onDelete('set null');
                $table->index(['status']);
                $table->index(['submitted_at']);
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
                $table->dropIndex(['status']);
                $table->dropIndex(['submitted_at']);
                $table->dropColumn([
                    'status', 
                    'admin_remarks', 
                    'submitted_at', 
                    'reviewed_at', 
                    'reviewed_by'
                ]);
            });
        }
    }
};

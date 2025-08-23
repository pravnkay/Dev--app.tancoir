<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('acl_users', function (Blueprint $table) {

    		$table->string('active_profile_type')->after('password')->nullable();
			$table->unsignedBigInteger('active_profile_id')->after('active_profile_type')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acl_users', function (Blueprint $table) {
            $table->dropColumn('active_profile_id');
            $table->dropColumn('active_profile_type');
        });
    }
};

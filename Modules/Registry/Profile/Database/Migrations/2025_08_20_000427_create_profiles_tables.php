<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Core\Auth\Entities\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profile_enterprise_profiles', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(User::class)->onDelete('cascade');
			$table->string('name')->nullable();
			$table->string('udyam')->nullable();
			$table->string('enterprise_name')->nullable();
			$table->string('enterprise_place')->nullable();
			$table->string('enterprise_district')->nullable();
			$table->string('contact_person_name')->nullable();
			$table->string('contact_email')->nullable();
			$table->string('contact_phone')->nullable();
			$table->string('contact_whatsapp')->nullable();
			$table->userTimeStamps();
		});
		
		Schema::create('profile_cluster_profiles', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(User::class)->onDelete('cascade');
			$table->string('name')->nullable();
			$table->string('udyam')->nullable();
			$table->string('cluster_name')->nullable();
			$table->string('cluster_place')->nullable();
			$table->string('cluster_district')->nullable();
			$table->string('contact_person_name')->nullable();
			$table->string('contact_email')->nullable();
			$table->string('contact_phone')->nullable();
			$table->string('contact_whatsapp')->nullable();
			$table->userTimeStamps();
		});
		
		Schema::create('profile_society_profiles', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(User::class)->onDelete('cascade');
			$table->string('name')->nullable();
			$table->string('udyam')->nullable();
			$table->string('society_name')->nullable();
			$table->string('society_place')->nullable();
			$table->string('society_district')->nullable();
			$table->string('contact_person_name')->nullable();
			$table->string('contact_email')->nullable();
			$table->string('contact_phone')->nullable();
			$table->string('contact_whatsapp')->nullable();
			$table->userTimeStamps();
		});

		Schema::create('profile_association_profiles', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(User::class)->onDelete('cascade');
			$table->string('name')->nullable();
			$table->string('udyam')->nullable();
			$table->string('association_name')->nullable();
			$table->string('association_place')->nullable();
			$table->string('association_district')->nullable();
			$table->string('contact_person_name')->nullable();
			$table->string('contact_email')->nullable();
			$table->string('contact_phone')->nullable();
			$table->string('contact_whatsapp')->nullable();
			$table->userTimeStamps();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('profile_enterprise_profiles');
        Schema::drop('profile_cluster_profiles');
        Schema::drop('profile_society_profiles');
        Schema::drop('profile_association_profiles');
    }
};

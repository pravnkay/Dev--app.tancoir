<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\App\Profile\Entities\Profile;
use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Enums\ProfileStatusEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            
			$table->string('name');
			$table->string('type');
            $table->string('status')->default(ProfileStatusEnum::DRAFT->value);
			$table->boolean('is_active')->default(0);

			$table->dateTime('submitted_at')->nullable();
			$table->text('review_remarks')->nullable();
			$table->dateTime('reviewed_at')->nullable();
			$table->foreignIdFor(User::class, 'reviewed_by')->nullable()->constrained()->nullOnDelete();

			$table->userTimeStamps();            
        });

        Schema::create('profile_enterprise_profiles', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Profile::class)->constrained()->cascadeOnDelete();
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
			$table->foreignIdFor(Profile::class)->constrained()->cascadeOnDelete();
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
			$table->foreignIdFor(Profile::class)->constrained()->cascadeOnDelete();
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
			$table->foreignIdFor(Profile::class)->constrained()->cascadeOnDelete();
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

		Schema::create('profile_participants', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(User::class)->constrained()->casacadeOnDelete();
			$table->foreignIdFor(Profile::class)->constrained()->casacadeOnDelete();
			$table->string('name')->nullable();
			$table->integer('age')->nullable();
			$table->string('designation')->nullable();
			$table->string('gender')->nullable();
			$table->string('religion')->nullable();
			$table->string('community')->nullable();
			$table->string('whatsapp')->nullable();
			$table->userTimeStamps();
		});
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_profiles');
        Schema::dropIfExists('profile_enterprise_profiles');
        Schema::dropIfExists('profile_cluster_profiles');
        Schema::dropIfExists('profile_society_profiles');
        Schema::dropIfExists('profile_association_profiles');
        Schema::dropIfExists('profile_participants');
    }
};

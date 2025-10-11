<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\App\Profile\Entities\Participant;
use Modules\App\Profile\Entities\Profile;
use Modules\Backend\RAMPManagement\Entities\Enterprise;
use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\Programme;
use Modules\Backend\RAMPManagement\Entities\Registration;
use Modules\Backend\RAMPManagement\Entities\Vertical;
use Modules\Core\Auth\Entities\User;
use Modules\Core\Core\Enums\ProgrammeSchemeEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ramp_verticals', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->decimal('allocated_funds', 12, 2)->default(0.00);
			$table->decimal('utilised_funds', 12, 2)->default(0.00);
			$table->decimal('remaining_funds', 12, 2)->default(0.00);
			$table->userTimeStamps();
		});

		Schema::create('ramp_programmes', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Vertical::class)->nullable()->constrained()->cascadeOnDelete();
			$table->string('name')->unique();
			$table->string('scheme')->default(ProgrammeSchemeEnum::NORMAL);
            $table->userTimeStamps();
		});

		Schema::create('ramp_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Programme::class)->nullable()->constrained()->cascadeOnDelete();
			$table->string('name')->nullable();
			$table->string('title')->nullable();
			$table->integer('iteration')->nullable();
			$table->date('date')->nullable();
			$table->integer('days')->nullable()->default(1);
			$table->decimal('cost', 12, 2)->default(0.00);
			$table->integer('participant_count')->default(20);
			$table->decimal('participant_cost', 12, 2)->default(0.00);
			$table->boolean('is_registration_open')->default(0);
            $table->userTimeStamps();
        });

		Schema::create('ramp_event_forms', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Event::class)->nullable()->constrained()->cascadeOnDelete();
			$table->boolean('collect_accomodation_requirement')->default(0);
			$table->boolean('collect_reach_by')->default(0);
			$table->boolean('collect_food_choice')->default(0);
			$table->userTimeStamps();
		});

		Schema::create('ramp_enterprises', function (Blueprint $table) {
			$table->id();
			$table->string('udyam')->unique();
			$table->string('name')->nullable();
			$table->string('place')->nullable();
			$table->string('district')->nullable();
			$table->string('contact_name')->nullable();
			$table->string('contact_designation')->nullable();
			$table->string('contact_email')->nullable();
			$table->boolean('is_a_valid_enterprise')->default(0);
			$table->userTimeStamps();
		});

		Schema::create('ramp_registrations', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
			$table->foreignIdFor(Event::class)->constrained()->cascadeOnDelete();
			$table->foreignIdFor(Profile::class)->constrained()->cascadeOnDelete();
			$table->foreignIdFor(Participant::class)->constrained()->cascadeOnDelete();
			$table->integer('registration_serial');
			$table->boolean('is_approved_to_participate')->default(0);
			$table->userTimeStamps();
		});

		Schema::create('ramp_participations', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Registration::class)->nullable()->constrained()->cascadeOnDelete();			
			$table->boolean('has_participated')->default(0);
			$table->userTimeStamps();
		});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('ramp_verticals');
        Schema::drop('ramp_programmes');
        Schema::drop('ramp_events');
        Schema::drop('ramp_event_forms');
        Schema::drop('ramp_registrations');
        Schema::drop('ramp_enterprises');
        Schema::drop('ramp_participations');
    }
};

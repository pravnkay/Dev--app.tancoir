<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\Programme;
use Modules\Backend\RAMPManagement\Entities\Vertical;
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
			$table->foreignIdFor(Vertical::class)->nullable()->constrained()->nullOnDelete();
			$table->string('name')->unique();
			$table->string('scheme')->default(ProgrammeSchemeEnum::NORMAL);
            $table->userTimeStamps();
		});

		Schema::create('ramp_events', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Programme::class)->nullable()->constrained()->nullOnDelete();
			$table->string('name')->nullable();
			$table->string('title')->nullable();
			$table->integer('iteration')->nullable();
			$table->date('date')->nullable();
			$table->integer('days')->nullable()->default(1);
			$table->decimal('cost', 12, 2)->default(0.00);
			$table->integer('participant_count')->default(20);
			$table->decimal('participant_cost', 12, 2)->default(0.00);
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

		Schema::create('ramp_event_registrations', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Event::class)->nullable()->constrained()->cascadeOnDelete();
			$table->json('registration_data')->nullable();
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
        Schema::drop('ramp_event_registrations');
    }
};

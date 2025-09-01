<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
			$table->increments('id');
			$table->foreignIdFor(Vertical::class)->nullable()->nullOnDelete();
			$table->string('name')->unique();
			$table->string('scheme')->default(ProgrammeSchemeEnum::NORMAL);
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
    }
};

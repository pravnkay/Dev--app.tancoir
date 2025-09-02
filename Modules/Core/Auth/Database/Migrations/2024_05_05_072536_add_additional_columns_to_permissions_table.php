<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
		$tableNames = config('permission.table_names');

		if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->string('display_name')->after('name')->nullable();   
            $table->string('module')->after('display_name')->nullable();
            $table->string('model')->after('module')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		$tableNames = config('permission.table_names');

		if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'display_name',
				'module',
				'model'
            ]));
        });
    }
};

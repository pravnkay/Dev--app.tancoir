<?php

namespace Modules\Backend\RAMPManagement\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Backend\RAMPManagement\Entities\Event;
use Modules\Backend\RAMPManagement\Entities\Programme;
use Modules\Backend\RAMPManagement\Entities\Vertical;
use Modules\Core\Core\Enums\ProgrammeSchemeEnum;

class RAMPManagementDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		// Seed verticals
		$vertical0 = Vertical::create([ 'name' => 'Certification Courses', 'allocated_funds' => 10900000 ]);
		$vertical1 = Vertical::create([ 'name' => 'New Product Development', 'allocated_funds' => 23400000 ]);
		$vertical2 = Vertical::create([ 'name' => 'Branding & Packaging', 'allocated_funds' => 93400000 ]);
		$vertical3 = Vertical::create([ 'name' => 'Marketing', 'allocated_funds' => 700000 ]);
		$vertical4 = Vertical::create([ 'name' => 'Export Promotion', 'allocated_funds' => 1250000 ]);
		$vertical5 = Vertical::create([ 'name' => 'PR Campaign', 'allocated_funds' => 11700000 ]);

		// Seed programmes
		$programme0 = Programme::create([ 'name' => 'Cocoponics', 'scheme' => ProgrammeSchemeEnum::NORMAL->value, 'vertical_id' => $vertical0->id ]);
		$programme1 = Programme::create([ 'name' => 'Packaging', 'scheme' => ProgrammeSchemeEnum::ASPIRE->value, 'vertical_id' => $vertical1->id ]);

		// Seed events
		Event::create([ 'programme_id' => $programme0->id, 'title' => 'Mfg. of AFPC', 'date' => Carbon::parse('2025-08-03'), 'days' => 2, 'cost' => 177000, 'participant_count' => 20 ]);
		Event::create([ 'programme_id' => $programme1->id, 'title' => 'Packaging trends', 'date' => Carbon::parse('2025-08-13'), 'days' => 2, 'cost' => 354000, 'participant_count' => 20 ]);
	}

}
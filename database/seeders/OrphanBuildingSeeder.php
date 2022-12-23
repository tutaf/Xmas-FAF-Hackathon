<?php

namespace Database\Seeders;

use App\Models\OrphanBuilding;
use Illuminate\Database\Seeder;

class OrphanBuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrphanBuilding::factory()->count(5)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Orphan;
use Illuminate\Database\Seeder;

class OrphanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Orphan::factory()->count(5)->create();
    }
}

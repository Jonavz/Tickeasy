<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Place;

class PlaceSeeder extends Seeder {
    public function run() {
        Place::create(['name' => 'Auditorio Nacional', 'location' => 'Ciudad de México', 'max_capacity' => 5000]);
        Place::create(['name' => 'Estadio Azteca', 'location' => 'Ciudad de México', 'max_capacity' => 87000]);
    }
}
